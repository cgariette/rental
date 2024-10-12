<form action="" id="manage-property">
    <div class="form-group">
        <label for="property_category" class="control-label">Property Category</label>
        <input type="text" class="form-control" name="property_category" required>
    </div>
    <div class="form-group">
        <label for="property_name" class="control-label">Property Name</label>
        <input type="text" class="form-control" name="property_name" required>
    </div>
    <div class="form-group">
        <label for="landlord" class="control-label">Landlord</label>
        <input type="text" class="form-control" name="landlord" required>
    </div>
    <div class="form-group">
        <label for="location" class="control-label">Location</label>
        <input type="text" class="form-control" name="location" required>
    </div>
    <div class="form-group">
        <label for="building_street" class="control-label">Building Street</label>
        <input type="text" class="form-control" name="building_street" required>
    </div>
    <div class="form-group">
        <label for="unit_price" class="control-label">Unit Price</label>
        <input type="number" class="form-control" name="unit_price" required>
    </div>
    <div class="form-group">
        <label for="rent_amount" class="control-label">Rent Amount</label>
        <input type="number" class="form-control" name="rent_amount" required>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

<script>
    $('#manage-property').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_property',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Property successfully added", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>