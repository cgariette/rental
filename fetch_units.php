<?php
include('db_connect.php'); // Include your database connection

if (isset($_POST['building_id'])) {
    $building_id = $_POST['building_id'];

    // Fetch units that belong to the selected building
    $result = $conn->query("SELECT id, unit_no FROM apartments WHERE building_id = $building_id");

    if ($result->num_rows > 0) {
        // Output each unit as an option
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['unit_no']}</option>";
        }
    } else {
        // No units found
        echo "<option value=''>No units available</option>";
    }
} else {
    echo "<option value=''>Select Unit</option>";
}
?>