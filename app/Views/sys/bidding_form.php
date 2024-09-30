
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }
    .container {
        width: 100%;

        margin-top: 100px;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    form {
        display: flex;
        flex-direction: column;
    }
    form label {
        margin-top: 10px;
    }
    form input, form button {
        padding: 10px;
        margin-top: 5px;
    }
    form button {
        margin-top: 20px;
        cursor: pointer;
    }
    h3 {
        margin-top: 20px;
    }
</style>



<div class="container">
    <div class="row" >
        <div class="col-md-6">
            <h1>Bidding Form</h1>

            <!-- Display error message if user has already submitted a bid for this item -->
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>


            <!-- Bidding Form -->
            <?= form_open('sys/saveBid', ['novalidate' => 'novalidate']) ?>

            <input type="hidden" name="free" value="<?= $free ?>">
            <input type="hidden" name="item_id" value="<?= $item_id ?>">
            <?php if (!$free): ?>
                <div class="form-group">
                    <label for="bid_price_per_item">Bid Price Per Item:(Rs)</label>
                    <input type="number" class="form-control" name="bid_price_per_item" id="bid_price_per_item" value="<?= set_value('bid_price_per_item') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('bid_price_per_item') ?></span>
                </div>
            <?php else: ?>
                <input type="hidden" name="bid_price_per_item" value="0">
            <?php endif; ?>

            <?php if (!$free): ?>

                <!-- Group for payment method selection. -->
                <div class="form-group">
                    <h3>Payment Method</h3>
                    <!-- Radio buttons for selecting the payment method. -->
                    <label>
                        <input type="radio" name="payment_method" value="cash" <?= set_radio('payment_method', 'cash'); ?>> Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="bank_deposit" <?= set_radio('payment_method', 'bank_deposit'); ?>> Bank Deposit
                    </label>
                    <!-- Display validation error message for 'payment_method' if any. -->
                    <span class="text-danger"><?= service('validation')->getError('payment_method') ?></span>
                </div>

            <?php else: ?>
                <!-- If the item is free, include a hidden input with the Payment Method set to free item. -->
                <input type="hidden" name="payment_method" value="free item">
            <?php endif; ?>



            <div class="form-group">
                <label for="your_note">Your Note:</label>
                <textarea class="form-control" name="your_note" id="your_note"><?= set_value('your_note') ?></textarea>
                <span class="text-danger"><?= service('validation')->getError('your_note') ?></span>
            </div>

            <h3>Pickup Details</h3>
            <div class="form-group">
                <label for="pref_day">Preferred Pickup Day:</label>
                <input type="date" class="form-control" name="pref_day" id="pref_day" value="<?= set_value('pref_day') ?>" required>
                <span class="text-danger"><?= service('validation')->getError('pref_day') ?></span>
            </div>

            <div class="form-group">
                <label for="slot_start">Time Slot Start:</label>
                <input type="time" class="form-control" name="slot_start" id="slot_start" value="<?= set_value('slot_start') ?>" required>
                <span class="text-danger"><?= service('validation')->getError('slot_start') ?></span>
            </div>

            <div class="form-group">
                <label for="slot_end">Time Slot End:</label>
                <input type="time" class="form-control" name="slot_end" id="slot_end" value="<?= set_value('slot_end') ?>" required>
                <span class="text-danger"><?= service('validation')->getError('slot_end') ?></span>
            </div>

            <div class="form-group">
                <label for="alt_day1">Alternative Pickup Day:</label>
                <input type="date" class="form-control" name="alt_day1" id="alt_day1" value="<?= set_value('alt_day1') ?>">
                <span class="text-danger"><?= service('validation')->getError('alt_day1') ?></span>
            </div>

            <div class="form-group">
                <label for="alt_start1">Alternative Time Slot Start:</label>
                <input type="time" class="form-control" name="alt_start1" id="alt_start1" value="<?= set_value('alt_start1') ?>">
                <span class="text-danger"><?= service('validation')->getError('alt_start1') ?></span>
            </div>

            <div class="form-group">
                <label for="alt_end1">Alternative Time Slot End:</label>
                <input type="time" class="form-control" name="alt_end1" id="alt_end1" value="<?= set_value('alt_end1') ?>">
                <span class="text-danger"><?= service('validation')->getError('alt_end1') ?></span>
            </div>

            <button type="submit" class="btn btn-primary">Submit Bid</button>
            </form>


        </div>
        <div class="col-md-6">
            <p><strong>Item Title:</strong> <?= $itemDetails['item_title'] ?></p>
            <img src="<?= base_url('public/images/uploads/' . $itemDetails['item_image']) ?>" alt="Item Image" class="img-fluid rounded" style="max-width: 400px;">
            <p><strong>Item Name:</strong> <?= $itemDetails['item_name'] ?></p>
            <p><strong>Item Type:</strong> <?= $itemDetails['item_type'] ?></p>
            <p><strong>Quantity:</strong> <?= $itemDetails['quantity'] ?></p>
            <p><strong>Item Description:</strong> <?= $itemDetails['item_description'] ?></p>
            <p><strong>Weight:</strong> <?= $itemDetails['weight'] . " " . $itemDetails['weight_unit'] ?></p>
            <p><strong>Amount:</strong> <?= $itemDetails['amount'] ?></p>
            <p><strong>Pickup Location:</strong> <?= $itemDetails['pickup_location'] ?></p>
            <p><strong>Google Location Link:</strong> <a href="<?= htmlspecialchars($itemDetails['google_location']) ?>" target="_blank">View Location</a></p>
            <p><strong>Contact Name:</strong> <?= $itemDetails['contact_name'] ?></p>
            <p><strong>Contact Number:</strong> <?= $itemDetails['contact_number'] ?></p>
            <p><strong>Item Status:</strong> <?= $itemDetails['item_status_c'] ?></p>
            <p><strong>Date Added:</strong> <?= $itemDetails['date_added'] ?></p>

        </div>

    </div>


</div>
