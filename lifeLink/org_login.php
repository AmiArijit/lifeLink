<?php
include 'partials/_nav.php';
session_start();
include 'partials/_dbconnect.php';

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists and is approved
    $sql = "SELECT * FROM organizations_reg WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['approvalStatus'] !== 'approved') {
            if ($row['approvalStatus'] == 'rejected') {
                $loginError = "Your account is rejected.";
            }
            else{
            $loginError = "Your account is pending approval.";
            }
        } 
        elseif (password_verify($password, $row['password'])) {
            // Login success, set session
            $_SESSION['loggedin'] = true;
            $_SESSION['org_email'] = $row['email'];
            $_SESSION['org_name'] = $row['orgName'];
            $_SESSION['last_login'] = date('Y-m-d H:i:s');
            header("location: org_dashboard.php");
            exit();
        } else {
            $loginError = "Invalid credentials.";
        }
    } else {
        $loginError = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organization Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        

        .container {
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 10px;
        }

        .error-msg {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Organization Login</h2>
    <?php if ($loginError): ?>
        <div class="error-msg"><?php echo $loginError; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>
<?php include 'partials/_footer.php' ?>

</body>
</html>

