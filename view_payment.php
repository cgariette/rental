<?php include 'db_connect.php'; ?>

<?php 
// Fetch tenant data from the correct table (clients instead of tenants)
$tenant = $conn->query("SELECT c.*, CONCAT(c.full_name) as name, u.unit_no, l.rent_amount AS price, l.start_date AS date_in 
                        FROM clients c 
                        JOIN leases l ON l.tenant_id = c.id 
                        JOIN apartments u ON u.id = l.unit_id 
                        WHERE l.id = {$_GET['id']}");

if ($tenant->num_rows > 0) {
    $tenant_data = $tenant->fetch_assoc();
    foreach($tenant_data as $k => $v) {
        if (!is_numeric($k)) {
            $$k = $v;
        }
    }
} else {
    // Handle the case where tenant data is not found
    echo "Tenant not found.";
    exit();
}

// Calculate months of lease and payments
$months = abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($date_in." 23:59:59"));
$months = floor($months / (30*60*60*24));
$payable = $price * $months;
$paid = $conn->query("SELECT SUM(amount) as paid FROM payments WHERE lease_id = {$tenant_data['id']}");
$last_payment = $conn->query("SELECT * FROM payments WHERE lease_id = {$tenant_data['id']} ORDER BY unix_timestamp(created_at) DESC LIMIT 1");
$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
$last_payment = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['created_at'])) : 'N/A';
$outstanding = $payable - $paid;

?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-4">
				<div id="details">
					<large><b>Details</b></large>
					<hr>
					<p>Tenant: <b><?php echo ucwords($name) ?></b></p>
					<p>Monthly Rental Rate: <b><?php echo number_format($price, 2) ?></b></p>
					<p>Outstanding Balance: <b><?php echo number_format($outstanding, 2) ?></b></p>
					<p>Total Paid: <b><?php echo number_format($paid, 2) ?></b></p>
					<p>Rent Started: <b><?php echo date("M d, Y", strtotime($date_in)) ?></b></p>
					<p>Payable Months: <b><?php echo $months ?></b></p>
				</div>
			</div>
			<div class="col-md-8">
				<large><b>Payment List</b></large>
				<hr>
				<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$payments = $conn->query("SELECT * FROM payments WHERE lease_id = {$tenant_data['id']}");
						if($payments->num_rows > 0):
							while($row = $payments->fetch_assoc()):
						?>
						<tr>
							<td><?php echo date("M d, Y", strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['invoice'] ?></td>
							<td class='text-right'><?php echo number_format($row['amount'], 2) ?></td>
						</tr>
						<?php endwhile; ?>
						<?php else: ?>
						<tr><td colspan="3">No payments found.</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	#details p {
		margin: unset;
		padding: unset;
		line-height: 1.3em;
	}
	td, th {
		padding: 3px !important;
	}
</style>
