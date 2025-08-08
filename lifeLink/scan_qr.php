<?php
include 'partials/_dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT b.*, o.orgName FROM blood_units b JOIN organizations_reg o ON b.org_email = o.email WHERE b.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo "<h3>Blood Unit Details</h3>";
        echo "<p><strong>Org Email:</strong> " . $row['org_email'] . "</p>";
        echo "<p><strong>Org Name:</strong> " . $row['orgName'] . "</p>";
        echo "<p><strong>Blood Group:</strong> " . $row['blood_group'] . "</p>";
        echo "<p><strong>Storage Area:</strong> " . $row['storage_area'] . "</p>";
        echo "<p><strong>Timestamp:</strong> " . $row['timestamp'] . "</p>";
        echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
?>

        <form method="POST" action="update_status.php">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="status">Update Status:</label>
            <select name="status">
                <option value="available">Available</option>
                <option value="expired">Expired</option>
                <option value="delivered">Delivered</option>
            </select>
            <button type="submit">Update</button>
        </form>

<?php
    } else {
        echo "Blood unit not found.";
    }
}
?>
