<style>
    .container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .form-section, .info-section {
        flex: 1;
        padding: 10px;
    }
    .list-group-item {
        display: flex;
        align-items: center;
    }
    .list-group-item img {
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Request Form</li>
            </ol>
        </nav>
    </div>
<div class="container">

    <!-- Form Section -->
    <div class="form-section">
        <h2>Request Form</h2>

        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>


        <form action="<?= base_url('sys/submitRequest') ?>" method="POST">
            <input type="hidden" name="listing_set" value="<?= $listingSet; ?>">

            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="">-- Select Payment Method --</option>
                    <option value="cash" <?= set_select('payment_method', 'cash'); ?>>Cash</option>
                    <option value="bank_transfer" <?= set_select('payment_method', 'bank_transfer'); ?>>Bank Transfer</option>
                </select>
                <span class="text-danger"><?= service('validation')->getError('payment_method') ?></span>
            </div>
            <div class="form-group">
                <label for="your_note">Your Note:</label>
                <textarea name="your_note" id="your_note" class="form-control"><?= set_value('your_note') ?></textarea>
                <span class="text-danger"><?= service('validation')->getError('your_note') ?></span>
            </div>

            <div class="form-group">
                <label for="pref_day">Preferred Pickup Day:</label>
                <input type="date" name="pref_day" id="pref_day" class="form-control" value="<?= set_value('pref_day') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('pref_day') ?></span>
            </div>

            <div class="form-group">
                <label for="slot_start">Time Slot Start:</label>
                <input type="time" name="slot_start" id="slot_start" class="form-control" value="<?= set_value('slot_start') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('slot_start') ?></span>
            </div>

            <div class="form-group">
                <label for="slot_end">Time Slot End:</label>
                <input type="time" name="slot_end" id="slot_end" class="form-control" value="<?= set_value('slot_end') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('slot_end') ?></span>
            </div>

            <div class="form-group">
                <label for="alt_day">Alternative Pickup Day:</label>
                <input type="date" name="alt_day" id=""alt_day" class="form-control" value="<?= set_value('alt_day') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('alt_day') ?></span>
            </div>


            <div class="form-group">
                <label for="alt_start">Alternative Time Slot Start:</label>
                <input type="time" name="alt_start" id="alt_start" class="form-control" value="<?= set_value('alt_start') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('alt_start') ?></span>
            </div>

            <div class="form-group">
                <label for="alt_end">Alternative Time Slot End:</label>
                <input type="time" name="alt_end" id="alt_end" class="form-control" value="<?= set_value('alt_end') ?>"required>
                <span class="text-danger"><?= service('validation')->getError('alt_end') ?></span>
            </div>

            <div class="form-group text-right mt-3">
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
        </form>
    </div>

    <!-- Information Section -->
    <div class="info-section">
        <h2>Listing Set Information</h2>
        <!-- Assuming $ListingSet and $Items are passed to the view -->
        <p><strong>Collector:</strong> <?= esc($ListingSet['collector_name']) ?></p>
        <p><strong>Total Quantity in Set:</strong> <?= array_sum(array_column($Items, 'quantity')) ?></p>
        <p><strong>Total Weight:</strong> <?= array_sum(array_column($Items, 'weight')) ?> <?= esc($Items[0]['weight_unit']) ?></p>
        <p><strong>Price:</strong> <?= esc($ListingSet['selling_price']) ?></p>

        <div class="list-group">
            <?php foreach ($Items as $item): ?>
                <div class="list-group-item">
                    <img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" alt="Item Image">
                    <div>
                        <h5 class="mb-1"><?= esc($item['item_name']) ?> (<?= esc($item['item_type']) ?>)</h5>
                        <p class="mb-1"><?= esc($item['description']) ?></p>
                        <small>Quantity: <?= esc($item['quantity']) ?>, Weight: <?= esc($item['weight']) ?> <?= esc($item['weight_unit']) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
