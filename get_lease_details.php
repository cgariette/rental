<?php 
include 'db_connect.php';

if (isset($_GET['tenant_id'])) {
    $tenant_id = $_GET['tenant_id'];

    // Query to fetch lease details for the selected tenant
    $lease = $conn->query("SELECT l.*, b.property_name, u.unit_no 
                            FROM leases l 
                            JOIN apartments u ON u.id = l.unit_id 
                            JOIN buildings b ON u.building_id = b.id 
                            WHERE l.tenant_id = $tenant_id");

    if ($lease->num_rows > 0) {
        $lease_data = $lease->fetch_assoc();
        // Return lease details as JSON
        echo json_encode($lease_data);
    } else {
        echo json_encode(['error' => 'No lease found for this tenant']);
    }
}
?>