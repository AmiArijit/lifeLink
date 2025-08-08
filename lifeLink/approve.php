<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] != true) {
    header("location: admin_login.php");
    exit;
}

include 'partials/_dbconnect.php';
include 'partials/_admin_nav.php';

// Fetch pending organizations
$sql = "SELECT * FROM organizations_reg WHERE approvalStatus = 'pending'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Approve Organizations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f4f6;
        }
        .container {
            margin-top: 40px;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand, .nav-link, .navbar-text {
            color: #ffffff !important;
        }
    </style>
</head>
<body>



<div class="container">
    <h2 class="text-center mb-4">Pending Organization Registrations</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Organization Name</th>
                    <th>License No.</th>
                    <th>License Document</th>
                    <th>View Full Details</th>
                    <th>Action (Approve/Reject)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['orgName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['orgLicense']) . "</td>";
                        echo "<td><a href='uploads/" . htmlspecialchars($row['orgLicenseDoc']) . "' target='_blank'>View Document</a></td>";
                        echo "<td><button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#viewModal" . $row['sl_no'] . "'>View Details</button></td>";
                        echo "<td>
                                <form method='post' action='approve_action.php' class='d-flex flex-column gap-2'>
                                    <input type='hidden' name='org_id' value='" . $row['sl_no'] . "'>
                                    <textarea name='remarks' class='form-control' placeholder='Remarks (optional)'></textarea>
                                    <div class='d-flex gap-2'>
                                        <button type='submit' name='action' value='approve' class='btn btn-success btn-sm'>Approve</button>
                                        <button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>Reject</button>
                                    </div>
                                </form>
                            </td>";
                        echo "</tr>";

                        // Modal for full details
                        echo "
                        <div class='modal fade' id='viewModal" . $row['sl_no'] . "' tabindex='-1' aria-labelledby='viewModalLabel" . $row['sl_no'] . "' aria-hidden='true'>
                          <div class='modal-dialog'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h5 class='modal-title' id='viewModalLabel" . $row['sl_no'] . "'>Organization Full Details</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                              </div>
                              <div class='modal-body'>
                                <p><strong>Organization Type:</strong> " . htmlspecialchars($row['orgType']) . "</p>
                                <p><strong>Organization Name:</strong> " . htmlspecialchars($row['orgName']) . "</p>
                                <p><strong>License No.:</strong> " . htmlspecialchars($row['orgLicense']) . "</p>
                                <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
                                <p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>
                                <p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>
                                <p><strong>Contact Person:</strong> " . htmlspecialchars($row['contactPerson']) . "</p>
                                <p><strong>Website:</strong> " . htmlspecialchars($row['website']) . "</p>
                                <p><strong>Submitted At:</strong> " . htmlspecialchars($row['timestamp']) . "</p>
                              </div>
                            </div>
                          </div>
                        </div>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No pending registrations</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'partials/_footer.php' ?>

</body>
</html>
