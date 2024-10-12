<form action="" id="manage-invoice">
    <div class="form-group">
        <label for="invoice_date" class="control-label">Invoice Date</label>
        <input type="date" class="form-control" name="invoice_date" required>
    </div>
    <div class="form-group">
        <label for="terms" class="control-label">Terms</label>
        <input type="text" class="form-control" name="terms" required>
    </div>
    <div class="form-group">
        <label for="due_date" class="control-label">Due Date</label>
        <input type="date" class="form-control" name="due_date" required>
    </div>
    <div class="form-group">
        <label for="po_no" class="control-label">P.O No</label>
        <input type="text" class="form-control" name="po_no" required>
    </div>
    <div class="form-group">
        <label for="item_description" class="control-label">Item & Description</label>
        <input type="text" class="form-control" name="item_description" required>
    </div>
    <div class="form-group">
        <label for="quantity" class="control-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" required>
    </div>
    <div class="form-group">
        <label for="rate" class="control-label">Rate</label>
        <input type="number" class="form-control" name="rate" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="amount" class="control-label">Amount</label>
        <input type="number" class="form-control" name="amount" step="0.01" required readonly>
    </div>
    <div class="form-group">
        <label for="payment_made" class="control-label">Payment Made</label>
        <input type="number" class="form-control" name="payment_made" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="balance_due" class="control-label">Balance Due</label>
        <input type="number" class="form-control" name="balance_due" step="0.01" required readonly>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </div>
</form>

<script>
    $('[name="quantity"], [name="rate"]').on('input', function() {
        let quantity = parseFloat($('[name="quantity"]').val()) || 0;
        let rate = parseFloat($('[name="rate"]').val()) || 0;
        $('[name="amount"]').val((quantity * rate).toFixed(2));
    });

    $('[name="amount"], [name="payment_made"]').on('input', function() {
        let amount = parseFloat($('[name="amount"]').val()) || 0;
        let payment_made = parseFloat($('[name="payment_made"]').val()) || 0;
        $('[name="balance_due"]').val((amount - payment_made).toFixed(2));
    });

    $('#manage-invoice').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_invoice',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Invoice successfully added", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>
