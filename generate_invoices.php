<?php
include('db_connect.php');
$today = date('j'); // Day of the month (1-31)

// Fetch leases where the invoice_day matches today's day
$query = "SELECT * FROM leases WHERE invoice_day = $today";
$result = $conn->query($query);

while ($lease = $result->fetch_assoc()) {
    // Check if an invoice for this lease has already been generated for this month
    $tenant_id = $lease['tenant_id'];
    $building_id = $lease['building_id'];
    $unit_id = $lease['unit_id'];
    $lease_id = $lease['id'];
    $monthly_total = $lease['monthly_total'];
    $invoice_date = date('Y-m-d');

    // Check if an invoice already exists for this lease for this month
    $checkInvoice = $conn->query("
        SELECT * FROM invoices 
        WHERE lease_id = $lease_id AND MONTH(invoice_date) = MONTH(NOW())
    ");

    if ($checkInvoice->num_rows == 0) {
        // Insert new invoice
        $insertInvoice = $conn->query("
            INSERT INTO invoices (lease_id, tenant_id, building_id, unit_id, invoice_date, total_amount, status)
            VALUES ($lease_id, $tenant_id, $building_id, $unit_id, '$invoice_date', $monthly_total, 'unpaid')
        ");

        if ($insertInvoice) {
            echo "Invoice generated for Lease ID: $lease_id\n";
        } else {
            echo "Error generating invoice for Lease ID: $lease_id\n";
        }
    } else {
        echo "Invoice already exists for Lease ID: $lease_id\n";
    }
}

?>
