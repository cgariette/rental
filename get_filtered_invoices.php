<?php
include('db_connect.php');

$payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';

$query = "SELECT i.id, c.full_name AS tenant, i.total_amount, i.paid_amount, i.owed_amount, i.status, i.invoice_date 
          FROM invoices i
          JOIN leases l ON i.lease_id = l.id
          JOIN clients c ON l.tenant_id = c.id 
          WHERE 1=1";

if ($payment_status != '') {
    $query .= " AND i.status = '$payment_status'";
}
if ($from_date != '' && $to_date != '') {
    $query .= " AND i.invoice_date BETWEEN '$from_date' AND '$to_date'";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='text-center'>{$row['id']}</td>
                <td>{$row['tenant']}</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['paid_amount']}</td>
                <td>{$row['owed_amount']}</td>
                <td>{$row['status']}</td>
                <td>{$row['invoice_date']}</td>
                <td class='text-center'>
                    <a href='#' class='btn btn-sm btn-info view_invoice' data-id='{$row['id']}'>View</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No invoices found</td></tr>";
}
?>
