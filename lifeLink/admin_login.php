<?php
$showAlert = false;
$showError = false;
$login = false;
include 'partials/_nav.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `admin` WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $login = true;
        session_start();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header("location: approve.php"); // redirect after setting session
        exit();
    } else {
        $showError = "Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Admin Login</h2>

    <?php
    if ($showError) {
        echo "<div class='alert alert-danger' role='alert'>
            $showError
        </div>";
    }
    ?>

    <form method="POST" action="admin_login.php">
        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
<?php include 'partials/_footer.php' ?>

</body>
</html>
