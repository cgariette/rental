<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12 mt-5">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-12">
                <form action="" id="manage-property">
                    <div class="card">
                        <div class="card-header">
                            Property Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label class="control-label">Property Name</label>
                                        <input type="text" class="form-control" name="property_name" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Property Category</label>
                                        <select name="category_id" class="custom-select" required>
                                            <?php 
                                            $categories = $conn->query("SELECT * FROM categories order by name asc");
                                            if($categories->num_rows > 0):
                                            while($row= $categories->fetch_assoc()) :
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                            <?php endwhile; ?>
                                            <?php else: ?>
                                            <option selected="" value="" disabled="">Please check the category list.</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Developer</label>
                                        <input type="text" class="form-control" name="developer" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Location</label>
                                        <input type="text" class="form-control" name="location" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Building Street</label>
                                        <input type="text" class="form-control" name="building_street" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Number of Units</label>
                                        <input type="number" class="form-control" name="number_of_units" step="0.01" required="">
                                    </div>
                                </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="reset"> Cancel</button>
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
    $('#manage-property').submit(function(e) {
    e.preventDefault();
    start_load();
    $('#msg').html('');
    $.ajax({
        url: 'ajax.php?action=save_property',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            // $('#msg').html(resp);
            // console.log(resp);
            //     //end_load();
            //     return;
            if (resp.includes('1')) {
                alert_toast("Data successfully saved", 'success');
                setTimeout(function() {
                    location.href = 'index.php?page=properties';
                }, 1500);
            } else if (resp.includes('2')) {
                $('#msg').html('<div class="alert alert-danger">Property already exists.</div>');
                // end_load();
            } else {
                $('#msg').html('<div class="alert alert-danger">Failed to save data.</div>');
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
