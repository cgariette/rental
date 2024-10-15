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
                                    <th class="">Building</th>
                                    <th class="">Tenant</th>
                                    <th class="">Rent</th>
                                    <th class="">Start Date</th>
                                    <th class="">Due On</th>
                                    <th class="">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // SQL query to fetch the necessary data
                                $query = "SELECT 
                                            l.id AS lease_no, 
                                            u.unit_no, 
                                            b.property_name, 
                                            c.full_name AS tenant_name, 
                                            l.rent_amount, 
                                            l.start_date, 
                                            l.due_on, 
                                            IF(l.terms = 1, 'Active', 'Inactive') AS status
                                          FROM leases l
                                          JOIN buildings b ON l.building_id = b.id
                                          JOIN apartments u ON l.unit_id = u.id
                                          JOIN clients c ON l.tenant_id = c.id";
                                
                                $result = $conn->query($query);
                                while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['lease_no']; ?></td>
                                    <td><?php echo $row['unit_no']; ?></td>
                                    <td><?php echo $row['property_name']; ?></td>
                                    <td><?php echo $row['tenant_name']; ?></td>
                                    <td><?php echo $row['rent_amount']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($row['start_date'])); ?></td>
                                    <td><?php echo $row['due_on']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td class="text-center">
                                        <!-- Action buttons -->
                                        <button class="btn btn-sm btn-primary view_payment" data-id="<?php echo $row['lease_no']; ?>">View Payment</button>
                                        <button class="btn btn-sm btn-primary view_lease" data-id="<?php echo $row['lease_no']; ?>">View Lease</button>
                                        <button class="btn btn-sm btn-warning edit_tenant" data-id="<?php echo $row['lease_no']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger delete_tenant" data-id="<?php echo $row['lease_no']; ?>">Delete</button>
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
        uni_modal("Tenant's Payments", "view_payment.php?id=" + $(this).attr('data-id'), "large");
    });

    $('.view_lease').click(function() {
        uni_modal("Tenant's Lease", "view_lease.php?id=" + $(this).attr('data-id'), "large");
    });

    $('.edit_tenant').click(function() {
        uni_modal("Manage Tenant Details", "manage_tenant.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_tenant').click(function() {
        _conf("Are you sure you want to delete this lease?", "delete_tenant", [$(this).attr('data-id')]);
    });

    function delete_tenant(id) {
        if (confirm("Are you sure you want to delete this lease?")) {
            $.ajax({
                url: 'ajax.php?action=delete_tenant',
                method: 'GET',
                data: { id: id },
                success: function(resp) {
                    if (resp.includes('1')) {
                        alert('Lease deleted successfully.');
                        location.reload(); // Refresh the page to see changes
                    } else {
                        alert('Failed to delete lease.');
                    }
                }
            });
        }
    }
</script>

