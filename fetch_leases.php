<?php
include('db_connect.php');

if (isset($_POST['tenant_id'])) {
    $tenant_id = $_POST['tenant_id'];

    // Fetch leases associated with the tenant
    $leases = $conn->query("SELECT id, lease_name FROM leases WHERE tenant_id = '$tenant_id'");

    if ($leases->num_rows > 0) {
        echo '<option value="">Select Lease</option>';
        while ($row = $leases->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['lease_name']}</option>";
        }
    } else {
        echo '<option value="">No leases available</option>';
    }
}
?>
