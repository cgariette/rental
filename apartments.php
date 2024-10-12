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
                        <b>Apartments</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_apartment">
                                <i class="fa fa-plus"></i> New Apartment
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Unit Number</th>
                                    <th class="text-center">Building Name</th>
                                    <th class="">Number of Bedrooms</th>
                                    <th class="">Landlord</th>
                                    <th class="">Unit Price</th>
                                    <th class="">Rent Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch apartments from the database
                                $sql = "SELECT a.unit_no, b.property_name, a.num_bedrooms, a.landlord, a.unit_price, a.rent_amount 
                                        FROM apartments a 
                                        JOIN buildings b ON a.building_id = b.id";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>{$row['unit_no']}</td>";
                                        echo "<td class='text-center'>{$row['property_name']}</td>";
                                        echo "<td>{$row['num_bedrooms']}</td>";
                                        echo "<td>{$row['landlord']}</td>";
                                        echo "<td>{$row['unit_price']}</td>";
                                        echo "<td>{$row['rent_amount']}</td>";
                                        echo "<td class='text-center'>
                                                <a class='btn btn-sm btn-primary' href='index.php?page=edit_apartment&id={$row['unit_no']}'>Edit</a>
                                                <a class='btn btn-sm btn-danger' href='ajax.php?action=delete_apartment&id={$row['unit_no']}' onclick='return confirm(\"Are you sure you want to delete this apartment?\")'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No Apartments Found</td></tr>";
                                }
                                ?>
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
</script>
<script>
function deleteApartment(id) {
        if (confirm("Are you sure you want to delete this Apartment?")) {
            $.ajax({
                url: 'ajax.php?action=delete_apartment',
                method: 'POST',
                data: { id: id },
                success: function(resp) {
                    if (resp.includes('1')) {
                        alert('Apartment deleted successfully.');
                        location.reload(); // Refresh the page to see changes
                    } else {
                        alert('Failed to delete Apartment.');
                    }
                }
            });
        }
    }
    </script>