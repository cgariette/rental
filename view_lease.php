<?php include 'db_connect.php'; ?>

<?php 
// Fetch lease details from the database
$lease = $conn->query("SELECT l.*, CONCAT(c.full_name) as tenant_name, u.unit_no, b.property_name, l.start_date 
                        FROM leases l 
                        JOIN clients c ON l.tenant_id = c.id 
                        JOIN apartments u ON u.id = l.unit_id 
                        JOIN buildings b ON u.building_id = b.id 
                        WHERE l.id = {$_GET['id']}");

if ($lease->num_rows > 0) {
    $lease_data = $lease->fetch_assoc();
    foreach($lease_data as $k => $v) {
        if (!is_numeric($k)) {
            $$k = $v;
        }
    }
} else {
    // Handle the case where lease data is not found
    echo "Lease not found.";
    exit();
}

// Calculate total charges
$total_rent = $rent_amount;
$additional_fees = $deposit_amount + $processing_fee + $service_fee + $garbage_fee + $water_fee + $late_fee;
$total_due = $total_rent + $additional_fees;

?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <div id="lease-details">
                    <large><b>Lease Details</b></large>
                    <hr>
                    <p>Tenant: <b><?php echo ucwords($tenant_name) ?></b></p>
                    <p>Building: <b><?php echo ucwords($property_name) ?></b></p>
                    <p>Unit Number: <b><?php echo $unit_no ?></b></p>
                    <p>Monthly Rent: <b>KES <?php echo number_format($rent_amount, 2) ?></b></p>
                    <p>Rent Start Date: <b><?php echo date("M d, Y", strtotime($start_date)) ?></b></p>
                    <p>Deposit Amount: <b>KES <?php echo number_format($deposit_amount, 2) ?></b></p>
                    <p>Additional Fees: <b>KES <?php echo number_format($additional_fees, 2) ?></b></p>
                    <p>Total Due: <b>KES <?php echo number_format($total_due, 2) ?></b></p>
                </div>
            </div>

            <div class="col-md-8">
                <large><b>Additional Lease Details</b></large>
                <hr>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Fee Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Processing Fee</td>
                            <td>KES <?php echo number_format($processing_fee, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Service Fee</td>
                            <td>KES <?php echo number_format($service_fee, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Garbage Collection Fee</td>
                            <td>KES <?php echo number_format($garbage_fee, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Water Fee</td>
                            <td>KES <?php echo number_format($water_fee, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Late Payment Fee</td>
                            <td>KES <?php echo number_format($late_fee, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    #lease-details p {
        margin: unset;
        padding: unset;
        line-height: 1.3em;
    }
    td, th {
        padding: 3px !important;
    }
</style>
