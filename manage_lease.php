<form action="" id="manage-lease">
    <div class="form-group">
        <label for="building" class="control-label">Select Building</label>
        <select class="form-control" name="building" required>
            <!-- Dynamically populate building options from the database -->
            <option value="">Select Building</option>
        </select>
    </div>
    <div class="form-group">
        <label for="unit" class="control-label">Select Unit</label>
        <select class="form-control" name="unit" required>
            <!-- Dynamically populate unit options based on selected building -->
            <option value="">Select Unit</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tenant" class="control-label">Assign Tenant</label>
        <select class="form-control" name="tenant" required>
            <!-- Dynamically populate tenant options from the database -->
            <option value="">Select Tenant</option>
        </select>
    </div>
    <div class="form-group">
        <label for="rent_amount" class="control-label">Rent Amount</label>
        <input type="number" class="form-control" name="rent_amount" required>
    </div>
    <div class="form-group">
        <label for="start_date" class="control-label">Start Date</label>
        <input type="date" class="form-control" name="start_date" required>
    </div>
    <div class="form-group">
        <label for="due_on" class="control-label">Due On (Day of every Month)</label>
        <input type="number" class="form-control" name="due_on" min="1" max="31" required>
    </div>
    <div class="form-group">
        <label for="deposit_amount" class="control-label">Rent Deposit Amount</label>
        <input type="number" class="form-control" name="deposit_amount" required>
    </div>
    <div class="form-group">
        <label for="processing_fee" class="control-label">Processing Fee</label>
        <input type="number" class="form-control" name="processing_fee" required>
    </div>
    <div class="form-group">
        <label for="service_fee" class="control-label">Service Fee</label>
        <input type="number" class="form-control" name="service_fee" required>
    </div>
    <div class="form-group">
        <label for="late_fee" class="control-label">Late/Penalty Fee</label>
        <input type="number" class="form-control" name="late_fee" required>
    </div>
    <div class="form-group">
        <label for="grace_period" class="control-label">Grace Period (Days)</label>
        <input type="number" class="form-control" name="grace_period" required>
    </div>
    <div class="form-group">
        <label for="invoice_day" class="control-label">Generate Invoice On (Day of Month)</label>
        <input type="number" class="form-control" name="invoice_day" min="1" max="31" required>
    </div>
    <div class="form-group">
        <label for="tenant_signature" class="control-label">Tenant Signature</label>
        <input type="file" class="form-control" name="tenant_signature" required>
    </div>
    <div class="form-group">
        <label for="landlord_signature" class="control-label">Landlord Signature</label>
        <input type="file" class="form-control" name="landlord_signature" required>
    </div>
    <div class="form-group">
        <label for="terms" class="control-label">Terms and Conditions</label>
        <textarea class="form-control" name="terms" rows="4" required></textarea>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Lease</button>
    </div>
</form>

<script>
    $('#manage-lease').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_lease',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Lease successfully added", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>
