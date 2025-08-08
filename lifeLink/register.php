<?php
$showAlert = false;
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';

    // Fetch form data
    $orgType = $_POST["orgType"];  // This will store the organization type (either "hospital" or "bloodbank")
    $orgName = $_POST["orgName"];
    $orgLicense = $_POST["orgLicense"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $contactPerson = $_POST["contactPerson"];
    $website = $_POST["website"];

    // Handle file upload for the license document
    $orgLicenseDoc = $_FILES["orgLicenseDoc"];
    $orgLicenseDocName = $_FILES["orgLicenseDoc"]["name"];
    $orgLicenseDocTmpName = $_FILES["orgLicenseDoc"]["tmp_name"];
    $orgLicenseDocSize = $_FILES["orgLicenseDoc"]["size"];
    $orgLicenseDocError = $_FILES["orgLicenseDoc"]["error"];

    // Define allowed file types
    $allowed = ['pdf', 'jpg'];
    $fileExt = strtolower(pathinfo($orgLicenseDocName, PATHINFO_EXTENSION));

    // Check if the file type is allowed
    if (in_array($fileExt, $allowed)) {

        // Check for upload errors
        if ($orgLicenseDocError === 0) {
            if ($orgLicenseDocSize < 10000000) {  // Max file size 10MB
                // Generate unique file name
                $orgLicenseDocNewName = uniqid('', true) . "." . $fileExt;
                $orgLicenseDocDestination = 'uploads/' . $orgLicenseDocNewName;

                // Move uploaded file
                if (!move_uploaded_file($orgLicenseDocTmpName, $orgLicenseDocDestination)) {
                    die("Error uploading the file.");
                }

            } else {
                die("The file is too large.");
            }
        } else {
            die("There was an error uploading the file.");
        }
    } else {
        die("This file type is not allowed.");
    }

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO `organizations_reg` (`orgType`, `orgName`, `orgLicense`, `orgLicenseDoc`, `email`, `phone`, `address`, `password`, `contactPerson`, `website`, `timestamp`,`approvalStatus`)
            VALUES ('$orgType', '$orgName', '$orgLicense', '$orgLicenseDocNewName', '$email', '$phone', '$address', '$hashedPassword', '$contactPerson', '$website', current_timestamp(), 'pending')";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $showAlert = true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LifeLink</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 16px;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            outline: none;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 14px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

             margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php require 'partials/_nav.php' ?>
    <!-- Register Form Section -->
    <div class="container">
        <h2>Register Your Organization</h2>
        <?php
        if ($showAlert) {
            echo "<div class='alert alert-success' role='alert'>
            Registration successful! Approval status: Pending. We'll email shortly !
          </div>";
            }
        ?>

        <!-- Form Fields -->
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="orgType" class="form-label">Select Organization Type:</label>
                <select name="orgType" id="orgType" class="form-select" required>
                    <option value="Govt Hospital">Govt Hospital</option>
                    <option value="Private Hospital">Private Hospital</option>
                    <option value="Govt Bloodbank">Govt Bloodbank</option>
                    <option value="Private Bloodbank">Private Bloodbank</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="orgName" class="form-label">Organisation Name</label>
                <input type="text" class="form-control" id="orgName" name="orgName" required>
            </div>
            <div class="mb-3">
                <label for="orgLicense" class="form-label">Organisation License Number</label>
                <input type="text" class="form-control" id="orgLicense" name="orgLicense" required>
            </div>
            <div class="mb-3">
                <label for="orgLicenseDoc" class="form-label">Organisation License Document</label>
                <input type="file" class="form-control" id="orgLicenseDoc" name="orgLicenseDoc" required>
                <p style="color: red; font">( PDF , JPG is allowed - Max file size is 10mb )</p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="contactPerson" class="form-label">Point of Contact Name & Designation</label>
                <input type="text" class="form-control" id="contactPerson" name="contactPerson" required>
            </div>
            <div class="mb-3">
                <label for="website" class="form-label">Website or Social Media Links</label>
                <input type="text" class="form-control" id="website" name="website">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                <label class="form-check-label" for="flexCheckDefault">
                I accept the <a href="#">Terms and Conditions</a>
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3F2wJfA5hYdoRQ8jG3r6kQ5n77RUc7tDqGaaYtmBd2rrM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0xq2+jr59Mw7f5gBubosvq9T1/M2V30y3z3g/Bc8wyz0xVb4" crossorigin="anonymous"></script>
    

</body>
</html>
