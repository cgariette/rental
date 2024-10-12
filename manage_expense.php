<form action="" id="manage-expense">
    <div class="form-group">
        <label for="expense_type" class="control-label">Expense Type</label>
        <select name="expense_type" class="form-control" required>
            <option value="General Expense">General Expense</option>
            <option value="Unit Expense">Unit Expense</option>
        </select>
    </div>
    <div class="form-group">
        <label for="expense_date" class="control-label">Expense Date</label>
        <input type="date" class="form-control" name="expense_date" required>
    </div>
    <div class="form-group">
        <label for="payment_method" class="control-label">Payment Method</label>
        <select name="payment_method" class="form-control" required>
            <option value="Mpesa">Mpesa</option>
            <option value="Cash">Cash</option>
            <option value="Visa/Mastercard">Visa/Mastercard</option>
            <option value="Credit">Credit</option>
            <option value="Cheque">Cheque</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="note" class="control-label">Note</label>
        <textarea name="note" class="form-control" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="signature" class="control-label">Signature</label>
        <input type="text" class="form-control" name="signature" required>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-primary" id="create_expense_type">Create Expense Type</button>
    </div>

    <!-- Expense Type Modal -->
    <div id="expenseTypeModal" style="display:none;">
        <div class="form-group">
            <label for="new_expense_type" class="control-label">Expense Type</label>
            <input type="text" class="form-control" name="new_expense_type" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <input type="text" class="form-control" name="description" required>
        </div>
        <div class="form-group">
            <label for="quantity" class="control-label">Quantity</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="price" class="control-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
        </div>
        <button type="button" class="btn btn-danger" id="delete_expense_type">Delete</button>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Expense</button>
    </div>
</form>

<script>
    // Show the Create Expense Type Modal
    $('#create_expense_type').click(function() {
        $('#expenseTypeModal').toggle();
    });

    $('#delete_expense_type').click(function() {
        $('#expenseTypeModal input').val(''); // Clear inputs
        $('#expenseTypeModal').hide();
    });

    $('#manage-expense').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_expense',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Expense successfully added", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>
