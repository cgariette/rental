<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <!-- FORM Panel -->
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Invoices</b>
                        <span class="float-right">
                            <!-- Generate Invoices Button -->
                            <a class="btn btn-secondary btn-sm float-left mr-2" href="#" id="generate_invoices">
                                <i class="fa fa-file"></i> Generate Invoices
                            </a>
                            <!-- New Invoice Button -->
                            <a class="btn btn-primary btn-sm float-right" href="index.php?page=add_invoice" id="new_invoice">
                                <i class="fa fa-plus"></i> New Invoice
                            </a>
                        </span>
                    </div>

                    <!-- Filter Row -->
                    <div class="row mb-3 mt-2 pl-3 pr-3">
                        <div class="col-md-4">
                            <!-- Dropdown Menu for Payment Status -->
                            <div class="input-group">
                                <select class="form-control form-control-sm" id="payment_status">
                                    <option value="" selected>Payment Status</option>
                                    <option value="paid">Paid</option>
                                    <option value="partially_paid">Partially Paid</option>
                                    <option value="pending">Pending</option>
                                </select>
                                <div class="input-group-append">
                                    <!-- Export PDF Button -->
                                    <a class="btn btn-danger btn-sm" href="#" id="export_pdf">
                                        <i class="fa fa-file-pdf-o"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Date Filter -->
                            <div class="form-inline float-right">
                                <label for="from_date" class="mr-2">From:</label>
                                <input type="date" id="from_date" class="form-control form-control-sm mr-3" />
                                <label for="to_date" class="mr-2">To:</label>
                                <input type="date" id="to_date" class="form-control form-control-sm" />
                            </div>
                        </div>
                    </div>
                    <!-- End of Filter Row -->

                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Invoice No.</th>
                                    <th class="">Tenant</th>
                                    <th class="">Total</th>
                                    <th class="">Paid</th>
                                    <th class="">Owed</th>
                                    <th class="">Status</th>
                                    <th class="">Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        <tbody>
            <!-- The filtered invoice rows will be inserted here dynamically -->
        </tbody>
    </table>
</div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('table').dataTable();

        // Function to load invoices based on filter
        function load_invoices(payment_status = '', from_date = '', to_date = '') {
            $.ajax({
                url: 'get_filtered_invoices.php',
                method: 'POST',
                data: {
                    payment_status: payment_status,
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        // When the "Generate Invoices" button is clicked
        $('#generate_invoices').click(function(e) {
            e.preventDefault();
            var payment_status = $('#payment_status').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            
            // Load invoices based on the selected filters
            load_invoices(payment_status, from_date, to_date);
        });

    });
</script>


<script>
    $(document).ready(function() {
        $('table').dataTable();
    });

    // Removed the uni_modal call for new_invoice button
    // The href in the <a> tag now points to add_invoice.php directly

    $('.view_payment').click(function() {
        uni_modal("Tenant's Payments", "view_payment.php?id=" + $(this).attr('data-id'), "large");
    });

    $('.edit_tenant').click(function() {
        uni_modal("Manage Tenant Details", "manage_tenant.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_tenant').click(function() {
        _conf("Are you sure to delete this Tenant?", "delete_tenant", [$(this).attr('data-id')]);
    });

    function delete_tenant($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_tenant',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
