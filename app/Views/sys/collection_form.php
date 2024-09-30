<main id="main" class="main">
    <section class="contact">
        <div class="container-fluid">
            <div class="section-title">
                <h2>Inventory Update</h2>
                <p>Update the inventory details after collection.</p>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action="<?= base_url('sys/submitInventoryUpdate') ?>" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?? '' ?>">

                        <div class="col-12">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="item_name" id="item_name" value="<?= set_value('item_name', $item['item_name'] ?? '') ?>" >
                        </div>

                        <div class="col-12">
                            <label for="item_type" class="form-label">Item Type</label>
                            <input type="text" class="form-control" name="item_type" id="item_type" value="<?= set_value('item_type', $item['item_type'] ?? '') ?>" readonly>
                        </div>

                        <div class="col-12">
                            <label for="item_image" class="form-label">Item Image</label>
                            <div>
                                <?php if (isset($item['item_image']) && $item['item_image']): ?>
                                    <img src="<?= base_url('public/images/uploads/' . $item['item_image']) ?>" alt="Item Image" style="max-width: 100%; height: auto;">
                                <?php else: ?>
                                    <p>No image available</p>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="item_image" value="<?= $item['item_image'] ?? '' ?>">
                        </div>


                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Purchasing Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" value="<?= set_value('quantity', $item['quantity'] ?? 0) ?>" >

                        </div>

                        <div class="col-md-4">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" name="weight" id="weight" value="<?= set_value('weight', $item['weight'] ?? 0) ?>" required step="0.01">

                        </div>

                        <div class="col-md-4">
                            <label for="weight_unit" class="form-label">Weight Unit</label>
                            <select class="form-select" name="weight_unit" id="weight_unit" required>
                                <option value="">-- Select Weight Unit --</option>
                                <option value="kg" <?= set_select('weight_unit', 'kg', isset($item['weight_unit']) && $item['weight_unit'] === 'kg') ?>>Kilograms (kg)</option>
                                <option value="g" <?= set_select('weight_unit', 'g', isset($item['weight_unit']) && $item['weight_unit'] === 'g') ?>>Grams (g)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" required><?= set_value('description', $item['description'] ?? '') ?></textarea>

                        </div>

                        <div class="col-12">
                            <label for="total_payment" class="form-label">Total Payment</label>
                            <input type="number" class="form-control" name="total_payment" id="total_payment" value="<?= set_value('bid_price_per_item', $item['bid_price_per_item'] ?? 0) ?>" >

                        </div>



                        <div class="col-md-4">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="bank_deposit" <?= set_select('payment_method', 'bank_deposit', isset($item['payment_method']) && $item['payment_method'] === 'bank_deposit') ?>>Bank Deposit </option>
                                <option value="cash" <?= set_select('payment_method', 'cash', isset($item['payment_method']) && $item['payment_method'] === 'cash') ?>>Cash</option>
                            </select>
                        </div>

                        <?php if (isset($item['payment_method']) && $item['payment_method'] === 'bank_deposit'): ?>
                            <div class="col-12">
                                <label for="bank_slip" class="form-label">Upload Bank Slip</label>
                                <input type="file" class="form-control" name="bank_slip" id="bank_slip" required>

                            </div>
                        <?php endif; ?>






                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Inventory</button>
                        </div>
                    </form>
                </div>

                <?php if (isset($item['payment_method']) && $item['payment_method'] === 'bank_deposit' && isset($bankInfo)): ?>
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                Bank Details for Payment
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Account Number:</strong> <?= $bankInfo['AccountNumber'] ?? 'N/A' ?></p>
                                <p class="card-text"><strong>Account Name:</strong> <?= $bankInfo['AccountName'] ?? 'N/A' ?></p>
                                <p class="card-text"><strong>Bank Name:</strong> <?= $bankInfo['BankName'] ?? 'N/A' ?></p>
                                <p class="card-text"><strong>Branch Name:</strong> <?= $bankInfo['BranchName'] ?? 'N/A' ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<!-- Custom CSS for additional styling -->
<style>
    .section-title h2 {
        color: #4e73df; /* Primary color */
        margin-bottom: 1rem;
    }

    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); /* subtle shadow for cards */
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        color: #5a5c69; /* Dark gray color */
    }

    .btn-primary {
        background-color: #4e73df; /* Primary color */
        border-color: #4e73df; /* Primary color */
    }

    .btn-primary:hover {
        background-color: #375a7f; /* Darker shade for hover state */
        border-color: #375a7f; /* Darker shade for hover state */
    }

    .form-control:focus {
        border-color: #bac8f3; /* Lighter shade of primary color */
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(78, 115, 223, 0.6); /* Glow effect on focus */
    }

    .invalid-feedback {
        display: none; /* Hide validation message */
    }

    .was-validated .form-control:invalid,
    .was-validated .form-control-file:invalid {
        border-color: #e74a3b; /* Alert color for invalid fields */
    }

    .was-validated .form-control:invalid:focus,
    .was-validated .form-control-file:invalid:focus {
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(231, 74, 59, 0.6); /* Glow effect on focus for invalid fields */
    }

    .was-validated .invalid-feedback {
        display: block; /* Show validation message when field is invalid */
    }
</style>
