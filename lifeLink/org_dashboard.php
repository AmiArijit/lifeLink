<?php
session_start();
include 'partials/_dbconnect.php';
include 'partials/_org_nav.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: org_login.php");
    exit();
}

$org_email = $_SESSION['org_email'];

// Fetch organization info
$sql_org = "SELECT * FROM organizations_reg WHERE email = '$org_email' LIMIT 1";
$result_org = mysqli_query($conn, $sql_org);
$org_info = mysqli_fetch_assoc($result_org);

// Fetch recent blood units
$sql_blood = "SELECT blood_group, units, status, timestamp FROM blood_units WHERE org_email = '$org_email' ORDER BY timestamp DESC LIMIT 5";
$result_blood = mysqli_query($conn, $sql_blood);

// Fetch available beds
$sql_beds = "SELECT bed_number, department, bed_type, status FROM bed_details WHERE org_email = '$org_email' AND status = 'Available'";
$result_beds = mysqli_query($conn, $sql_beds);

$last_login = isset($_SESSION['last_login']) ? $_SESSION['last_login'] : 'First login';
$_SESSION['last_login'] = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organization Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f9fc;
            font-family: 'Poppins', sans-serif;
        }
        .welcome-section {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .action-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .action-buttons a {
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 8px;
            background-color:rgb(200, 34, 28);
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        .action-buttons a:hover {
            background-color:rgb(242, 89, 89);
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #343a40;
        }
        table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f1f1f1;
        }
        footer {
            margin-top: 50px;
            padding: 20px;
            background: #343a40;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <h2>Welcome, <?php echo htmlspecialchars($org_info['orgName']); ?>!</h2>
        <p>License No: <strong><?php echo htmlspecialchars($org_info['orgLicense']); ?></strong></p>
        <p>Contact: <strong><?php echo htmlspecialchars($org_info['phone']); ?></strong></p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="action-buttons">
        <a href="addBloodform.php">✚ Add Blood</a>
        <a href="add_edit_bed_form.php">✚ Add Bed</a>
    </div>

    <!-- Recent Blood Additions Table -->
    <h4 class="section-title">Recent Blood Additions</h4>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Blood Group</th>
                    <th>Units</th>
                    <th>Status</th>
                    <th>Added On</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_blood) > 0) {
                    while($blood = mysqli_fetch_assoc($result_blood)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($blood['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($blood['units']); ?></td>
                            <td><?php echo htmlspecialchars($blood['status']); ?></td>
                            <td><?php echo htmlspecialchars(date('d M Y, H:i', strtotime($blood['timestamp']))); ?></td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr><td colspan="4">No blood records found.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Available Beds Table -->
    <h4 class="section-title">Available Beds</h4>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Bed Number</th>
                    <th>Department</th>
                    <th>Bed Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_beds) > 0) {
                    while($bed = mysqli_fetch_assoc($result_beds)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bed['bed_number']); ?></td>
                            <td><?php echo htmlspecialchars($bed['department']); ?></td>
                            <td><?php echo htmlspecialchars($bed['bed_type']); ?></td>
                            <td><span class="badge bg-success"><?php echo htmlspecialchars($bed['status']); ?></span></td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr><td colspan="4">No available beds at the moment.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Footer -->
<footer>
    <p><strong>Last Login:</strong> <?php echo $last_login; ?></p>
    <p>Dashboard v1.0 | Blood & Bed Management</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'partials/_footer.php' ?>

</body>
</html>
