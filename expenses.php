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
                        <b>Expenses</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_expense" id="new_expense">
                                <i class="fa fa-plus"></i> New Expense
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Name</th>
                                    <th class="">Category</th>
                                    <th class="">Units</th>
                                    <th class="">Location</th>
                                    <th class="">Value(KES)</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Your existing table data goes here -->
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
    });

    // Load the New Expense Modal
    $('#new_expense').click(function() {
        uni_modal("New Expense", "manage_expense.php", "mid-large");
    });

    $('.view_payment').click(function() {
        uni_modal("Tenants Payments", "view_payment.php?id=" + $(this).attr('data-id'), "large");
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
