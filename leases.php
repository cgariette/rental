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
                        <b>Leases</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_lease">
                                <i class="fa fa-plus"></i> New Lease
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Lease No.</th>
                                    <th class="">Unit Code</th>
                                    <th class="">Unit</th>
                                    <th class="">Tenant</th>
                                    <th class="">Rent</th>
                                    <th class="">Last Billing</th>
                                    <th class="">Due</th>
                                    <th class="">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Your existing table data code goes here -->
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

    // Other existing event handlers for payments, tenant actions, etc.

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
