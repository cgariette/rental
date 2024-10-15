<?php include('db_connect.php'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lease_id = $_POST['lease_id'];  // The lease ID associated with the payment
    $amount = $_POST['amount'];        // The payment amount
    $payment_type = $_POST['payment_type']; // The type of payment (Rent, Deposit, etc.)

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Record the payment in the payments table
        $stmt = $conn->prepare("INSERT INTO payments (lease_id, payment_date, amount, payment_type) VALUES (?, NOW(), ?, ?)");
        $stmt->bind_param("ids", $lease_id, $amount, $payment_type);
        $stmt->execute();

        // Check if payment type is Rent and deduct from the balance
        if ($payment_type == 'Rent') {
            // Update the lease table to deduct the rent amount
            $updateStmt = $conn->prepare("UPDATE leases SET balance = balance - ? WHERE id = ?");
            $updateStmt->bind_param("di", $amount, $lease_id);
            $updateStmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Payment recorded successfully.']);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Failed to record payment: ' . $e->getMessage()]);
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="add_payments.php" method="POST" id="manage-payment">
                    <div class="card">
                        <div class="card-header">
                            Payment Form
                            <div class="float-right">
                                <strong>Total: KES<span id="total-amount">0.00</span></strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <!-- Select Lease -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="lease_id">Select Lease</label>
                                        <select class="form-control" name="lease_id" required>
                                            <option value="">Select Lease</option>
                                            <?php
                                            $result = $conn->query("SELECT id, tenant_id FROM leases"); // Assuming tenant_name is a field
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['tenant_id']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" name="amount" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Payment Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_type">Payment Type</label>
                                        <select class="form-control" name="payment_type" required>
                                            <option value="Rent">Rent</option>
                                            <option value="Deposit">Deposit</option>
                                            <option value="Processing Fee">Processing Fee</option>
                                            <option value="Service Fee">Service Fee</option>
                                            <option value="Garbage Fee">Garbage Fee</option>
                                            <option value="Late Penalty">Late Penalty</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3" type="submit">Submit Payment</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="reset">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Calculate total on input change (if applicable)
        $('input[name="amount"]').on('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            let amount = parseFloat($('input[name="amount"]').val()) || 0;
            $('#total-amount').text(amount.toFixed(2)); // Adjust to display the amount instead
        }
    });

    $('#manage-payment').submit(function(e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'add_payments.php', // Update to your PHP handler
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp.includes('1')) {
                    alert_toast("Payment successfully saved", 'success');
                    setTimeout(function() {
                        location.href = 'index.php?page=payments';
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger">Failed to save payment.</div>');
                    end_load();
                }
            }
        });
    });
</script>
