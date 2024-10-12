<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-expense">
                    <div class="card">
                        <div class="card-header">
                            Expense Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <!-- Expense Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Expense Type</label>
                                        <select name="expense_type" class="custom-select" id="expense_type" required>
                                            <option value="General Expense">General Expense</option>
                                            <option value="Unit Expense">Unit Expense</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-secondary" type="button" id="create_expense_type">Create Expense Type</button>
                                </div>

                                <!-- Expense Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Expense Date</label>
                                        <input type="date" class="form-control" name="expense_date" required>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Method</label>
                                        <select name="payment_method" class="custom-select" required>
                                            <option value="Mpesa">Mpesa</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Visa/Mastercard">Visa/Mastercard</option>
                                            <option value="Credit">Credit</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Note -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Note</label>
                                        <textarea class="form-control" name="note" rows="4"></textarea>
                                    </div>
                                </div>

                                <!-- Signature -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Signature</label>
                                        <input type="text" class="form-control" name="signature" required>
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

<!-- Modal for Create Expense Type -->
<div class="modal fade" id="expenseTypeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Expense Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create-expense-type-form">
                    <div class="form-group">
                        <label for="expense_type_name">Expense Type</label>
                        <input type="text" class="form-control" id="expense_type_name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" step="0.01" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_expense_type">Save</button>
            </div>
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
    // Open Create Expense Type Modal
    $('#create_expense_type').click(function() {
        $('#expenseTypeModal').modal('show');
    });

    // Save new expense type
    $('#save_expense_type').click(function() {
        let expenseType = $('#expense_type_name').val();
        let description = $('#description').val();
        let quantity = $('#quantity').val();
        let price = $('#price').val();

        if (expenseType) {
            // Add the new expense type to the dropdown
            $('#expense_type').append(new Option(expenseType, expenseType));

            // Close modal
            $('#expenseTypeModal').modal('hide');

            // Optionally, clear the modal fields
            $('#create-expense-type-form')[0].reset();
        } else {
            alert('Please fill in the expense type.');
        }
    });

    // Handle form submission
    $('#manage-expense').submit(function(e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'ajax.php?action=save_expense',
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
                        location.href = 'index.php?page=manage_expenses';
                    }, 1500);
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger">Expense already exists.</div>');
                    end_load();
                }
            }
        });
    });
</script>

<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">Copyright © 2024 
        <a href="https://www.alifhomesltd.com" target="_blank">Apartment Management System Software</a> - 
        Design By Cliffton Afande
    </p>
</footer>
