<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-client">
                    <div class="card">
                        <div class="card-header">
                            Client Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                
                                <!-- Personal Information -->
                                <div class="col-md-12">
                                    <h4>Personal Information</h4>
                                </div>

                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Full Name (First, Middle, Last)</label>
                                        <input type="text" class="form-control" name="full_name" required>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" required>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Gender (optional)</label>
                                        <select class="form-control" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nationality / Citizenship -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nationality / Citizenship</label>
                                        <input type="text" class="form-control" name="nationality" required>
                                    </div>
                                </div>

                                <!-- Marital Status -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Marital Status</label>
                                        <select class="form-control" name="marital_status" required>
                                            <option value="">Select Status</option>
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Dependents -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Identification Number</label>
                                        <input type="number" class="form-control" name="identification">
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="col-md-12">
                                    <h4>Contact Information</h4>
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" required>
                                    </div>
                                </div>

                                <!-- Secondary Phone Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Secondary Phone Number (Optional)</label>
                                        <input type="text" class="form-control" name="secondary_phone">
                                    </div>
                                </div>

                                <!-- Mailing Address -->
                                <div class="col-md-12">
                                    <h5>Mailing Address</h5>
                                </div>

                                <!-- Street Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Street Address</label>
                                        <input type="text" class="form-control" name="street_address" required>
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div>
                                </div>

                                <!-- State / Province -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">State / Province</label>
                                        <input type="text" class="form-control" name="state" required>
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Postal Code</label>
                                        <input type="text" class="form-control" name="postal_code" required>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <input type="text" class="form-control" name="country" required>
                                    </div>
                                </div>

                                <!-- Preferred Method of Contact -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Preferred Method of Contact</label>
                                        <select class="form-control" name="contact_method" required>
                                            <option value="email">Email</option>
                                            <option value="phone">Phone</option>
                                        </select>
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
    $('#manage-client').on('reset', function(e) {
        $('#msg').html('');
    });

    $('#manage-client').submit(function(e) {
    e.preventDefault();
    start_load();
    $('#msg').html('');
    $.ajax({
        url: 'ajax.php?action=save_client',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp.includes('1')) {
                alert_toast("Client successfully saved", 'success');
                setTimeout(function() {
                    location.href = 'index.php?page=clients';
                }, 1500);
            } else if (resp.includes('2')) {
                $('#msg').html('<div class="alert alert-danger">Client already exists.</div>');
                end_load();
            } else {
                $('#msg').html('<div class="alert alert-danger">Failed to save client.</div>');
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
