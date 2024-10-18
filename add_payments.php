<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-payment">
                    <div class="card">
                        <div class="card-header">
                            Payment Form
                            <div class="float-right">
                                <strong>Total: KES<span id="total-amount">0.00</span></strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                
                                <!-- Display Building (Auto-filled) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="building_name" class="control-label">Building</label>
                                        <input type="text" class="form-control" name="building_name" id="building_name" readonly>
                                    </div>
                                </div>

                                <!-- Display Unit (Auto-filled) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Unit</label>
                                        <input type="text" class="form-control" name="unit_no" id="unit_no" readonly>
                                    </div>
                                </div>

                                <!-- Select Tenant -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Select Tenant</label>
                                        <select class="form-control" name="tenant_id" requiredid="tenant" name="tenant" onchange="fetchLeaseDetails()">
                                        <option value="">Select Tenant</option>
                                        <?php
                                        // Fetch tenant list from the database
                                        $tenants = $conn->query("SELECT id, full_name FROM clients");
                                        while ($row = $tenants->fetch_assoc()) {
                                                echo "<option value='" . $row['id'] . "'>" . ucwords($row['full_name']) . "</option>";
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

                                <!-- Payment Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Payment Date</label>
                                        <input type="date" class="form-control" name="payment_date" required>
                                    </div>
                                </div>

                                <!-- Late Penalty Fee -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Late Penalty Fee</label>
                                        <input type="number" class="form-control" name="late_fee" step="0.01" readonly>
                                    </div>
                                </div>

                                <!-- Additional Fees -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Processing Fees</label>
                                        <input type="number" class="form-control" name="processing_fee" step="0.01">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Service Fee</label>
                                        <input type="number" class="form-control" name="service_fee" step="0.01">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Garbage Collection Fee</label>
                                        <input type="number" class="form-control" name="garbage_fee" step="0.01">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Water Fee</label>
                                        <input type="number" class="form-control" name="water_fee" step="0.01">
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

        // When the tenant is selected
        $('#tenant_id').change(function() {
            var tenantId = $(this).val(); // Get selected tenant ID

            if (tenantId != '') {
                // Send AJAX request to fetch lease details for the selected tenant
                $.ajax({
                    url: 'fetch_lease_details.php',
                    method: 'POST',
                    data: { tenant_id: tenantId },
                    success: function(response) {
                        var leaseDetails = JSON.parse(response);
                        if (leaseDetails) {
                            // Populate building and unit fields
                            $('#building_name').val(leaseDetails.building_name);
                            $('#unit_name').val(leaseDetails.unit_name);
                        } else {
                            $('#building_name').val(''); // Reset if no lease found
                            $('#unit_name').val('');
                        }
                    },
                    error: function() {
                        // If an error occurs
                        $('#building_name').val('');
                        $('#unit_name').val('');
                    }
                });
            } else {
                // Reset the Building and Unit fields if no tenant is selected
                $('#building_name').val('');
                $('#unit_name').val('');
            }
        });

        // Other logic for calculating totals and handling fees
        $('input[name="rent_amount"], input[name="processing_fee"], input[name="service_fee"], input[name="garbage_fee"], input[name="water_fee"]').on('input', function() {
            calculateTotal();
        });

        function calculateTotal() {
            let rent = parseFloat($('input[name="rent_amount"]').val()) || 0;
            let processingFee = parseFloat($('input[name="processing_fee"]').val()) || 0;
            let serviceFee = parseFloat($('input[name="service_fee"]').val()) || 0;
            let garbageFee = parseFloat($('input[name="garbage_fee"]').val()) || 0;
            let waterFee = parseFloat($('input[name="water_fee"]').val()) || 0;
            let lateFee = parseFloat($('input[name="late_fee"]').val()) || 0;

            let total = rent + processingFee + serviceFee + garbageFee + waterFee + lateFee;
            $('#total-amount').text(total.toFixed(2));
        }

        // Late penalty logic can go here (as described earlier)
    });
</script>

<script>
    $('#manage-payment').submit(function(e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'ajax.php?action=save_payment',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp.includes('1')) {
                    alert_toast("Payment successfully saved", 'success');
                    setTimeout(function() {
                        location.href = 'index.php?page=payments';
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger">Failed to save payment.</div>');
                    end_load();
                }
            }
        });
    });
</script>

<script>
function fetchLeaseDetails() {
    var tenantId = document.getElementById("tenant").value;
    
    if (tenantId != "") {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_lease_details.php?tenant_id=" + tenantId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                var leaseDetails = JSON.parse(xhr.responseText);

                // Set the values of the text fields
                document.getElementById("building_name").value = leaseDetails.property_name;
                document.getElementById("unit_no").value = leaseDetails.unit_no;
            }
        };
        xhr.send();
    } else {
        // Clear the fields if no tenant is selected
        document.getElementById("building_name").value = "";
        document.getElementById("unit_no").value = "";
    }
}
</script>



<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">Copyright © 2024 
        <a href="https://www.alifhomesltd.com" target="_blank">Apartment Management System Software</a> - 
        Design By Cliffton Afande
    </p>
</footer>
