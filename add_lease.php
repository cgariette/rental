<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-lease">
                    <div class="card">
                        <div class="card-header">
                            Lease Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <!-- Select Building -->
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Select Building</label>
                                    <select class="form-control" name="building_id" id="building_id" required>
                                        <option value="">Select Building</option>
                                        <?php
                                        $result = $conn->query("SELECT id, property_name FROM buildings");
                                        while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['property_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            </div>

                                <!-- Select Unit -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Unit</label>
                                        <select class="form-control" name="unit_id" id="unit_id" required>
                                            <option value="">Select Unit</option>
                                        <!-- Units will be loaded dynamically here -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Assign Tenant -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Assign Tenant</label>
                                        <select class="form-control" name="tenant_id" required>
                                            <option value="">Select Tenant</option>
                                            <?php
                                            $result = $conn->query("SELECT id, full_name FROM clients");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['full_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Rent Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Rent Amount</label>
                                        <input type="number" class="form-control" name="rent_amount" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                </div>

                                <!-- Due on (Day of the month) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Due on (Day of the month)</label>
                                        <input type="number" class="form-control" name="due_on" min="1" max="31" required>
                                    </div>
                                </div>

                                <!-- Rent Deposit Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Rent Deposit Amount</label>
                                        <input type="number" class="form-control" name="deposit_amount" step="0.01" required>
                                    </div>
                                </div>

                                <!-- Processing Fees -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Processing Fees</label>
                                        <input type="number" class="form-control" name="processing_fee" step="0.01">
                                    </div>
                                </div>

                                <!-- Service Fee -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Service Fee</label>
                                        <input type="number" class="form-control" name="service_fee" step="0.01">
                                    </div>
                                </div>

                                <!-- Garbage Collection Fee -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Garbage Collection Fee</label>
                                        <input type="number" class="form-control" name="garbage_fee" step="0.01">
                                    </div>
                                </div>

                                <!-- Water Fee -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Water Fee</label>
                                        <input type="number" class="form-control" name="water_fee" step="0.01">
                                    </div>
                                </div>

                                <!-- Late Penalty Fee -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Late Penalty Fee</label>
                                        <input type="number" class="form-control" name="late_fee" step="0.01">
                                    </div>
                                </div>

                                <!-- Generate Invoice on (Day of the month) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Generate Invoice on (Day of the month)</label>
                                        <input type="number" class="form-control" name="invoice_day" min="1" max="31">
                                    </div>
                                </div>

                                <!-- Tenant Signature -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tenant Signature</label>
                                        <input type="text" class="form-control" name="tenant_signature" required>
                                    </div>
                                </div>

                                <!-- Landlord Signature -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Landlord Signature</label>
                                        <input type="text" class="form-control" name="landlord_signature" required>
                                    </div>
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" name="terms" required>
                                        <label class="control-label">I agree to the <a href="terms.php">Terms & Conditions</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3">Submit</button>
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
    $(document).ready(function() {
        // When the building is selected
        $('#building_id').change(function() {
            var buildingId = $(this).val(); // Get selected building ID

            // Clear the Unit dropdown and show a loading message
            $('#unit_id').html('<option value="">Loading units...</option>');

            if (buildingId != '') {
                // Send AJAX request to fetch units for the selected building
                $.ajax({
                    url: 'fetch_units.php',
                    method: 'POST',
                    data: { building_id: buildingId },
                    success: function(response) {
                        // Populate the units dropdown with the response
                        $('#unit_id').html(response);
                    },
                    error: function() {
                        // If an error occurs
                        $('#unit_id').html('<option value="">Failed to load units</option>');
                    }
                });
            } else {
                // If no building is selected, reset the Unit dropdown
                $('#unit_id').html('<option value="">Select Unit</option>');
            }
        });
    });
</script>


<script>
    $('#manage-lease').on('reset', function(e) {
        $('#msg').html('');
    });

    $('#manage-lease').submit(function(e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'ajax.php?action=save_lease',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp.includes('1')) {
                    alert_toast("Lease successfully saved", 'success');
                    setTimeout(function() {
                        location.href = 'index.php?page=leases';
                    }, 1500);
                } else if (resp.includes('2')) {
                    $('#msg').html('<div class="alert alert-danger">Lease already exists.</div>');
                    end_load();
                } else {
                    $('#msg').html('<div class="alert alert-danger">Failed to save lease.</div>');
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
