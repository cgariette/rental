<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-invoice">
                    <div class="card">
                        <div class="card-header">
                            Invoice Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <!-- Invoice Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Invoice Date</label>
                                        <input type="date" class="form-control" name="invoice_date" required>
                                    </div>
                                </div>

                                <!-- Terms -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Terms</label>
                                        <input type="text" class="form-control" name="terms" required>
                                    </div>
                                </div>

                                <!-- Due Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Due Date</label>
                                        <input type="date" class="form-control" name="due_date" required>
                                    </div>
                                </div>

                                <!-- P.O. No -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">P.O. No</label>
                                        <input type="text" class="form-control" name="po_no" required>
                                    </div>
                                </div>

                                <!-- Item & Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Item & Description</label>
                                        <textarea class="form-control" name="item_description" rows="4" required></textarea>
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Rate -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Rate</label>
                                        <input type="number" class="form-control" name="rate" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Amount</label>
                                        <input type="number" class="form-control" name="amount" step="0.01" required readonly>
                                    </div>
                                </div>

                                <!-- Payment Made -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Made</label>
                                        <input type="number" class="form-control" name="payment_made" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Balance Due -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Balance Due</label>
                                        <input type="number" class="form-control" name="balance_due" step="0.01" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3">Save</button>
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

<style>
    td {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
        padding: unset;
        line-height: 1em;
    }
</style>

<script>
    $('#manage-invoice').on('reset', function(e) {
        $('#msg').html('');
    });

    $('#manage-invoice').submit(function(e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'ajax.php?action=save_invoice',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved", 'success');
                    setTimeout(function() {
                        location.href = 'index.php?page=manage_invoices';
                    }, 1500);
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger">Invoice already exists.</div>');
                    end_load();
                }
            }
        });
    });

    $('table').dataTable();
</script>

<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">Copyright © 2024 
        <a href="https://www.alifhomesltd.com" target="_blank">Apartment Management System Software</a> - 
        Design By Cliffton Afande
    </p>
</footer>
