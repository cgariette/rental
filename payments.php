<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Payments</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_payments">
                                <i class="fa fa-plus"></i> New Payment
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Payment ID</th>
                                    <th class="">Tenant ID</th>
                                    <th class="">Unit ID</th>
                                    <th class="">Rent Amount</th>
                                    <th class="">Garbage Fee</th>
                                    <th class="">Water Fee</th>
                                    <th class="">Late Fee</th>
                                    <th class="">Total</th>
                                    <th class="">Payment Date</th>
                                    <th class="">Due Date</th>
                                    <th class="">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // SQL query to fetch the necessary data from the payments table
                                $query = "SELECT 
                                            p.id AS payment_id, 
                                            p.tenant_id, 
                                            p.unit_id, 
                                            p.rent_amount, 
                                            p.garbage_fee, 
                                            p.water_fee, 
                                            p.late_fee, 
                                            p.total, 
                                            p.payment_date, 
                                            p.due_date, 
                                            p.status 
                                          FROM payments p";
                                
                                $result = $conn->query($query);
                                while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['payment_id']; ?></td>
                                    <td><?php echo $row['tenant_id']; ?></td>
                                    <td><?php echo $row['unit_id']; ?></td>
                                    <td><?php echo number_format($row['rent_amount'], 2); ?></td>
                                    <td><?php echo number_format($row['garbage_fee'], 2); ?></td>
                                    <td><?php echo number_format($row['water_fee'], 2); ?></td>
                                    <td><?php echo number_format($row['late_fee'], 2); ?></td>
                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($row['payment_date'])); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($row['due_date'])); ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td class="text-center">
                                        <!-- Action buttons -->
                                        <button class="btn btn-sm btn-primary view_payment" data-id="<?php echo $row['payment_id']; ?>">View Payment</button>
                                        <button class="btn btn-sm btn-warning edit_payment" data-id="<?php echo $row['payment_id']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger delete_payment" data-id="<?php echo $row['payment_id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('table').dataTable();
    });

    $('.view_payment').click(function() {
        uni_modal("Payment Details", "view_payment.php?id=" + $(this).attr('data-id'), "large");
    });

    $('.edit_payment').click(function() {
        uni_modal("Edit Payment", "edit_payment.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_payment').click(function() {
        _conf("Are you sure you want to delete this payment?", "delete_payment", [$(this).attr('data-id')]);
    });

    function delete_payment(id) {
        if (confirm("Are you sure you want to delete this payment?")) {
            $.ajax({
                url: 'ajax.php?action=delete_payment',
                method: 'GET',
                data: { id: id },
                success: function(resp) {
                    if (resp.includes('1')) {
                        alert('Payment deleted successfully.');
                        location.reload(); // Refresh the page to see changes
                    } else {
                        alert('Failed to delete payment.');
                    }
                }
            });
        }
    }
</script>
