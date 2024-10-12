<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-apartment">
                    <div class="card">
                        <div class="card-header">
                            Apartment Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <!-- Select Building -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Building</label>
                                        <select class="form-control" name="building_id" required>
                                            <option value="">Select Building</option>
                                            <!--  -->
                                            
                                            <?php
                                            // Fetch buildings from the database
                                            $result = $conn->query("SELECT id, property_name FROM buildings");
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['property_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Unit No. -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Unit No.</label>
                                        <input type="text" class="form-control" name="unit_no" required>
                                    </div>
                                </div>

                                <!-- No. of Bedrooms -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">No. of Bedrooms</label>
                                        <select class="form-control" name="num_bedrooms" required>
                                            <option value="">Select Number of Bedrooms</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Landlord -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Landlord</label>
                                        <input type="text" class="form-control" name="landlord" required>
                                    </div>
                                </div>

                                <!-- Unit Price -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Unit Price</label>
                                        <input type="number" class="form-control" name="unit_price" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Rent Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Rent Amount</label>
                                        <input type="number" class="form-control" name="rent_amount" step="0.01" required>
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
    $('#manage-apartment').on('reset', function(e) {
        $('#msg').html('');
    });

    $('#manage-apartment').submit(function(e) {
    e.preventDefault();
    start_load();
    $('#msg').html('');
    $.ajax({
        url: 'ajax.php?action=save_apartment',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp.includes('1')) {
                alert_toast("Apartment successfully saved", 'success');
                setTimeout(function() {
                    location.href = 'index.php?page=apartments';
                }, 1500);
            } else if (resp.includes('2')) {
                $('#msg').html('<div class="alert alert-danger">Apartment already exists.</div>');
                end_load();
            } else {
                $('#msg').html('<div class="alert alert-danger">Failed to save apartment.</div>');
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
