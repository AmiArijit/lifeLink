<?php
session_start();
include 'partials/_dbconnect.php';
include 'partials/_nav.php';

$results = [];
$search_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $search_type = $_POST['search_type'];

    if ($search_type == 'blood') {
        $blood_group = $_POST['blood_group'];
        $volume_needed = intval($_POST['volume_needed']);

        $sql = "SELECT b.*, o.orgName, o.Phone, o.address 
                FROM blood_units b
                JOIN organizations_reg o ON b.org_email = o.email
                WHERE b.blood_group = '$blood_group' 
                AND b.status = 'Available'
                AND b.total_volume >= $volume_needed";

        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }

    } elseif ($search_type == 'bed') {
        $department = mysqli_real_escape_string($conn, $_POST['department']);
    
        $sql = "SELECT b.bed_id, b.bed_number, b.department, b.bed_type, b.status, o.orgName, o.Phone, o.address 
                FROM bed_details b
                JOIN organizations_reg o ON b.org_email = o.email
                WHERE b.department = '$department' 
                AND b.status = 'Available'";
    
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - Blood or Beds</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f2f6fa; font-family: 'Poppins', sans-serif; }
        .hero { margin-top: 80px; }
        .card-option { transition: all 0.3s; cursor: pointer; }
        .card-option:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .search-form { background: #fff; padding: 30px; border-radius: 10px; margin-top: 30px; }
        table { background: white; border-radius: 10px; margin-top: 30px; }
        th { background: #eee; }
    </style>
</head>
<body>

<div class="container hero text-center">
    <h2>Welcome to Blood & Bed Search</h2>
    <p class="lead">Choose what you want to search below</p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-4">
            <div class="card card-option" onclick="showBloodSearch()">
                <div class="card-body">
                    <h5 class="card-title">🔴 Blood Search</h5>
                    <p class="card-text">Find available blood units</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-option" onclick="showBedSearch()">
                <div class="card-body">
                    <h5 class="card-title">🛏️ Bed Search</h5>
                    <p class="card-text">Check available beds</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Search Form -->
    <form method="POST" action="" id="bloodForm" class="search-form" style="display:none;">
        <input type="hidden" name="search_type" value="blood">
        <h4>Blood Search</h4>
        <div class="mb-3">
            <label>Blood Group:</label>
            <select class="form-select" name="blood_group" required>
                <option value="">Choose Blood Group</option>
                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Volume Needed (ml):</label>
            <input type="number" name="volume_needed" class="form-control" placeholder="Enter volume" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Search Blood</button>
    </form>

    <!-- Bed Search Form -->
    <form method="POST" action="" id="bedForm" class="search-form" style="display:none;">
        <input type="hidden" name="search_type" value="bed">
        <h4>Bed Search</h4>
        <div class="mb-3">
            <label>Department:</label>
            <select class="form-select" name="department" required>
                <option value="">Choose Department</option>
                <option>Optometry</option>
                <option>Maternity</option>
                <option>Surgery</option>
            </select>
            
        </div>
        <button type="submit" class="btn btn-primary w-100">Search Beds</button>
    </form>

    <!-- Display Results -->
    <?php if (!empty($results)) { ?>
        <h3 class="mt-5">Search Results:</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <?php if ($search_type == 'blood') { ?>
                        <th>Blood Group</th>
                        <th>Units Available</th>
                        <th>Status</th>
                        <?php } else { ?>
                <th>Department</th>
                <th>Bed Number</th>
                      <th>Bed Type</th>
                        <th>Status</th>
<?php } ?>


                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['orgName']); ?></td>
                    <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <?php if ($search_type == 'blood') { ?>
                        <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($row['units']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <?php } else { ?>
    <td><?php echo htmlspecialchars($row['department']); ?></td>
    <td><?php echo htmlspecialchars($row['bed_number']); ?></td>
    <td><?php echo htmlspecialchars($row['bed_type']); ?></td>
    <td><?php echo htmlspecialchars($row['status']); ?></td>
<?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

</div>

<script>
function showBloodSearch() {
    document.getElementById('bloodForm').style.display = 'block';
    document.getElementById('bedForm').style.display = 'none';
}
function showBedSearch() {
    document.getElementById('bedForm').style.display = 'block';
    document.getElementById('bloodForm').style.display = 'none';
}
</script>
</body>
</html>
