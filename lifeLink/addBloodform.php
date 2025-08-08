<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: org_login.php");
    exit;
}

include 'partials/_dbconnect.php';
include 'partials/_org_nav.php';
require_once 'includes/phpqrcode/qrlib.php'; // Add this once


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $org_email = $_SESSION['org_email'];
    $blood_group = $_POST['blood_group'];
    $units = $_POST['units'];
    $volume_per_unit = $_POST['volume_per_unit'];
    $total_volume = $units * $volume_per_unit;
    $storage_area = $_POST['storage_area'] ?? NULL;
    $donor_id = $_POST['donor_id'] ?? NULL;
    $note = $_POST['note'] ?? NULL;
    $status = "available"; // default

    $sql = "INSERT INTO blood_units (org_email, blood_group, units, volume_per_unit, total_volume, storage_area, donor_id, note, status) 
            VALUES ('$org_email', '$blood_group', '$units', '$volume_per_unit', '$total_volume', '$storage_area', '$donor_id', '$note', '$status')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $last_id = mysqli_insert_id($conn); // Get inserted blood unit ID
    
        // Get organization name from org_email
        $orgQuery = "SELECT orgName FROM organizations_reg WHERE email = '$org_email'";
        $orgResult = mysqli_query($conn, $orgQuery);
        $orgName = "";
        if ($orgRow = mysqli_fetch_assoc($orgResult)) {
            $orgName = $orgRow['orgName'];
        }
    
        // Sanitize for ID: replace spaces with underscores
        $orgNameSanitized = preg_replace('/\s+/', '_', $orgName);
        $blood_group_sanitized = str_replace(['+', '-'], ['plus', 'minus'], $blood_group); // optional if you want safer IDs
    
        // Create custom ID
        $custom_id = $orgNameSanitized . '_' . $blood_group_sanitized . '_' . $last_id;
    
        // Update the record with the custom_id
        $updateSql = "UPDATE blood_units SET custom_id = '$custom_id' WHERE id = $last_id";
        mysqli_query($conn, $updateSql);
    
        // Generate QR data
        $qr_data = json_encode([
            'custom_id' => $custom_id,
            'org_email' => $org_email,
            'orgName' => $orgName,
            'blood_group' => $blood_group,
            'storage_area' => $storage_area,
            'timestamp' => date('Y-m-d H:i:s'),
            'status' => $status
        ]);
    
        // Create QR code
        $qr_dir = 'uploads/qrcodes/';
        if (!is_dir($qr_dir)) {
            mkdir($qr_dir, 0755, true); // Create directory if not exists
        }
        $qr_file = $qr_dir . $custom_id . '.png';
        QRcode::png($qr_data, $qr_file, QR_ECLEVEL_L, 4);
    
        echo "<script>alert('Blood unit added successfully! QR Code generated.'); window.location.href='org_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding blood unit');</script>";
    }
}
$expiry_query = "UPDATE blood_units 
                 SET status = 'expired' 
                 WHERE status = 'available' AND TIMESTAMPDIFF(SECOND, timestamp, NOW()) > 60";
mysqli_query($conn, $expiry_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Blood Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function calculateTotalVolume() {
            let units = document.getElementById('units').value;
            let volumePerUnit = document.getElementById('volume_per_unit').value;
            let totalVolume = units * volumePerUnit;
            document.getElementById('total_volume').value = totalVolume;
        }
    </script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Add Blood Unit</h2>
    <form method="POST" action="">

        <div class="mb-3">
            <label for="blood_group">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-select" required>
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Units</label>
            <input type="number" name="units" id="units" class="form-control" oninput="calculateTotalVolume()" required>
        </div>

        <div class="mb-3">
        <label for="volume_per_unit">Volume per Unit (ml)</label>
    <select name="volume_per_unit" id="volume_per_unit" class="form-select" onchange="calculateTotalVolume()" required>
        <option value="">Select Volume</option>
        <option value="250">250 ml</option>
        <option value="450">450 ml</option>
    </select>
        </div>

        <div class="mb-3">
            <label>Total Volume (ml)</label>
            <input type="number" id="total_volume" class="form-control" readonly>
        </div>

        <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#optionalFields" aria-expanded="false" aria-controls="optionalFields">
            Show Optional Fields
        </button>

        <div class="collapse" id="optionalFields">
            <div class="mb-3">
                <label>Storage Area</label>
                <input type="text" name="storage_area" class="form-control">
            </div>

            <div class="mb-3">
                <label>Donor ID</label>
                <input type="text" name="donor_id" class="form-control">
            </div>

            <div class="mb-3">
                <label>Note</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'partials/_footer.php' ?>

</body>
</html>
