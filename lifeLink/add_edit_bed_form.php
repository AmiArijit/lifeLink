<?php
// Start the session
session_start();

// Include database connection
include 'partials/_dbconnect.php';
include 'partials/_org_nav.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure org_email is available from the session
    if (isset($_SESSION['org_email'])) {
        $org_email = $_SESSION['org_email'];  // Make sure the org email is retrieved from the session
    } else {
        echo "<div class='alert alert-danger'>Session expired, please login again.</div>";
        exit();
    }
    
    // Sanitize the input data
    $bed_number = mysqli_real_escape_string($conn, $_POST['bed_number']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $bed_type = mysqli_real_escape_string($conn, $_POST['bed_type']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Insert data into the database
    $sql = "INSERT INTO `bed_details` (`bed_number`, `org_email`, `department`, `bed_type`, `capacity`, `status`, `location`) 
            VALUES ('$bed_number', '$org_email', '$department', '$bed_type', '$capacity', '$status', '$location')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Bed details added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bed Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #ff4d4d;
            color: white;
        }
        .btn-custom:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add Bed Details</h2>
    <div class="form-container">
        <form method="POST" action="">  <!-- Action points to current page -->
            <div class="mb-3">
                <label for="bed_number" class="form-label">Bed Number</label>
                <input type="text" name="bed_number" class="form-control" id="bed_number" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department" class="form-select" id="department" required>
                    <option value="Optometry">Optometry</option>
                    <option value="Maternity">Maternity</option>
                    <option value="Surgery">Surgery</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bed_type" class="form-label">Bed Type</label>
                <select name="bed_type" class="form-select" id="bed_type" required>
                    <option value="ICU Bed">ICU Bed</option>
                    <option value="General Bed">General Bed</option>
                    <option value="Oxygen Bed">Oxygen Bed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control" id="capacity" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" id="status" required>
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                    <option value="Out of Service">Out of Service</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location (Optional)</label>
                <input type="text" name="location" class="form-control" id="location">
            </div>
            <button type="submit" class="btn btn-custom">Add Bed Details</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'partials/_footer.php' ?>

</body>
</html>
