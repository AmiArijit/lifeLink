<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location: admin_login.php");
    exit;
}

include 'partials/_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $org_id = $_POST['org_id'];
    $action = $_POST['action'];
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks'] ?? '');

    // Determine new status
    if ($action === 'approve') {
        $newStatus = 'approved';
    } elseif ($action === 'reject') {
        $newStatus = 'rejected';
    } else {
        // Invalid action
        header("location: approve.php");
        exit;
    }

    // Update organization status
    $sql = "UPDATE organizations_reg 
            SET approvalStatus = ?, remarks = ? 
            WHERE sl_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $newStatus, $remarks, $org_id);
    $stmt->execute();

    // Optional: You could add admin logging or email notification here.

    // Redirect back to approval page
    header("location: approve.php");
    exit;
}
?>
