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
    form input, form button, form textarea {
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
    .item-details {
        margin-top: 20px;
    }
    .item-details p {
        margin: 5px 0;
    }
    .item-details img {
        max-width: 400px;
        margin-top: 10px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Bidding Form</h1>

            <!-- Display Messages -->
            <?php if (isset($message)): ?>
                <p class="text-success"><?= esc($message) ?></p>
            <?php endif; ?>

            <!-- Bidding Form -->
            <?php if (isset($item_id)): ?>
                <form method="post" action="<?= base_url('sys/ewrSubmitBid/' . $item_id) ?>">
                    <label for="bid_price_per_item">Bid Price Per Item:</label>
                    <input type="number" name="bid_price_per_item" id="bid_price_per_item" value="<?= set_value('bid_price_per_item') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('bid_price_per_item') ?></span>

                    <label for="requested_quantity">Requested Quantity:</label>
                    <input type="number" name="requested_quantity" id="requested_quantity" value="<?= set_value('requested_quantity') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('requested_quantity') ?></span>

                    <label for="your_note">Your Note:</label>
                    <textarea name="your_note" id="your_note"><?= set_value('your_note') ?></textarea>
                    <span class="text-danger"><?= service('validation')->getError('your_note') ?></span>

                    <h3>Pickup Details</h3>
                    <label for="pref_day">Preferred Pickup Day:</label>
                    <input type="date" name="pref_day" id="pref_day" value="<?= set_value('pref_day') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('pref_day') ?></span>

                    <label for="slot_start">Time Slot Start:</label>
                    <input type="time" name="slot_start" id="slot_start" value="<?= set_value('slot_start') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('slot_start') ?></span>

                    <label for="slot_end">Time Slot End:</label>
                    <input type="time" name="slot_end" id="slot_end" value="<?= set_value('slot_end') ?>" required>
                    <span class="text-danger"><?= service('validation')->getError('slot_end') ?></span>

                    <label for="alt_day1">Alternative Pickup Day:</label>
                    <input type="date" name="alt_day1" id="alt_day1" value="<?= set_value('alt_day1') ?>">
                    <span class="text-danger"><?= service('validation')->getError('alt_day1') ?></span>

                    <label for="alt_start1">Alternative Time Slot Start:</label>
                    <input type="time" name="alt_start1" id="alt_start1" value="<?= set_value('alt_start1') ?>">
                    <span class="text-danger"><?= service('validation')->getError('alt_start1') ?></span>

                    <label for="alt_end1">Alternative Time Slot End:</label>
                    <input type="time" name="alt_end1" id="alt_end1" value="<?= set_value('alt_end1') ?>">
                    <span class="text-danger"><?= service('validation')->getError('alt_end1') ?></span>

                    <button type="submit" class="btn btn-primary">Submit Bid</button>
                </form>
            <?php else: ?>
                <p>Error: Item ID is not set.</p>
            <?php endif; ?>
        </div>

        <div class="col-md-6 item-details">
            <p><strong>Item Name:</strong> <?= $listingDetails['item_name'] ?></p>
            <img src="<?= base_url('public/images/uploads/' . $listingDetails['item_image']) ?>" alt="Item Image" class="img-fluid rounded">
            <p><strong>Type:</strong> <?= $listingDetails['item_type'] ?></p>
            <p><strong>Description:</strong> <?= $listingDetails['description'] ?></p>
            <p><strong>Quantity:</strong> <?= $listingDetails['quantity'] ?></p>
            <p><strong>Weight:</strong> <?= $listingDetails['weight'] . " " . $listingDetails['weight_unit'] ?></p>
            <p><strong>Selling Price:</strong> <?= $listingDetails['selling_price'] ?></p>
            <p><strong>Status:</strong> <?= $listingDetails['status'] ?></p>
            <!-- Additional details as needed -->
        </div>
    </div>
</div>
