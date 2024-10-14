<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Properties</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_building">
                                <i class="fa fa-plus"></i> New Property
                            </a>
                            <!-- Print Button -->
                            <a class="btn btn-secondary btn-block btn-sm col-sm-2 float-right mr-2" href="print_properties.php" target="_blank">
                                <i class="fa fa-print"></i> Print
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
                                    <th class="">Developer</th>
                                    <th class="">Location</th>
                                    <th class="">No. of Units</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT b.*, c.name AS category_name FROM buildings b JOIN categories c ON b.category_id = c.id");
                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count++; ?></td>
                                            <td><?php echo $row['property_name']; ?></td>
                                            <td><?php echo $row['category_name']; ?></td>
                                            <td><?php echo $row['developer']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo $row['number_of_units']; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-danger" href="#" onclick="editBuilding(<?php echo $row['id']; ?>)">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteBuilding(<?php echo $row['id']; ?>)">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No properties found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>
</div>

<!-- Modal for Editing Property -->
<div class="modal fade" id="editPropertyModal" tabindex="-1" role="dialog" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPropertyModalLabel">Edit Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPropertyForm">
                    <input type="hidden" id="editPropertyId" name="id">
                    <div class="form-group">
                        <label for="propertyName">Property Name</label>
                        <input type="text" class="form-control" id="editPropertyName" name="property_name" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category_id" required>
                    </div>
                    <div class="form-group">
                        <label for="developer">Developer</label>
                        <input type="text" class="form-control" id="editDeveloper" name="developer" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="editLocation" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="units">No. of Units</label>
                        <input type="number" class="form-control" id="editUnits" name="number_of_units" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateProperty()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
function editBuilding(id) {
    // Fetch current data
    $.ajax({
        url: 'ajax.php?action=fetch_property',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            if (data) {
                $('#editPropertyId').val(data.id);
                $('#editPropertyName').val(data.property_name);
                $('#editCategory').val(data.category_id);
                $('#editDeveloper').val(data.developer);
                $('#editLocation').val(data.location);
                $('#editUnits').val(data.number_of_units);
                $('#editPropertyModal').modal('show');
            }
        }
    });
}

function updateProperty() {
    var formData = $('#editPropertyForm').serialize();

    $.ajax({
        url: 'ajax.php?action=update_property',
        method: 'POST',
        data: formData,
        success: function(resp) {
            if (resp == 1) {
                alert('Property updated successfully.');
                $('#editPropertyModal').modal('hide');
                location.reload(); // Reload the page to see changes
            } else {
                alert('Failed to update property.');
            }
        }
    });
}
</script>


<script>
    $(document).ready(function() {
        $('table').dataTable();
    });

    function toggleActive(id, currentStatus) {
        $.ajax({
            url: 'ajax.php?action=toggle_active',
            method: 'POST',
            data: { id: id, active: currentStatus ? 0 : 1 },
            success: function(resp) {
                if (resp == 1) {
                    alert('Status updated successfully.');
                    location.reload(); // Refresh the page to see changes
                } else {
                    alert('Failed to update status.');
                }
            }
        });
    }

    function deleteBuilding(id) {
        if (confirm("Are you sure you want to delete this building?")) {
            $.ajax({
                url: 'ajax.php?action=delete_building',
                method: 'POST',
                data: { id: id },
                success: function(resp) {
                    if (resp.includes('1')) {
                        alert('Building deleted successfully.');
                        location.reload(); // Refresh the page to see changes
                    } else {
                        alert('Failed to delete building.');
                    }
                }
            });
        }
    }
</script>
