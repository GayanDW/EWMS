 

<main id="main" class="main">
    <section class="section">
        <div class="container-fluid">
            <div class="section-title">
                <h2>My EWC Inventory</h2>

            </div>


            <!-- Filter Form -->
            <form action="<?= site_url('sys/filter') ?>" method="POST" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <div class="form-group">
                            <label for="item_type">Item Type</label>
                            <select name="item_type" class="form-control" id="item_type" required>
                                <option value="">--Select Item Type--</option>
                                <option value="Mobile & Personal Devices" <?= set_select('item_type', 'Mobile & Personal Devices') ?>>Mobile & Personal Devices</option>
                                <option value="Computing Equipment" <?= set_select('item_type', 'Computing Equipment') ?>>Computing Equipment</option>
                                <option value="Storage & Media Devices" <?= set_select('item_type', 'Storage & Media Devices') ?>>Storage & Media Devices</option>
                                <option value="Audio & Video Equipment" <?= set_select('item_type', 'Audio & Video Equipment') ?>>Audio & Video Equipment</option>
                                <option value="Gaming & Entertainment Systems" <?= set_select('item_type', 'Gaming & Entertainment Systems') ?>>Gaming & Entertainment Systems</option>
                                <option value="Office Electronics" <?= set_select('item_type', 'Office Electronics') ?>>Office Electronics</option>
                                <option value="Networking Equipment" <?= set_select('item_type', 'Networking Equipment') ?>>Networking Equipment</option>
                                <option value="Batteries" <?= set_select('item_type', 'Batteries') ?>>Batteries</option>
                                <option value="Household Appliances" <?= set_select('item_type', 'Household Appliances') ?>>Household Appliances</option>
                                <option value="Lighting" <?= set_select('item_type', 'Lighting') ?>>Lighting</option>
                                <option value="Cables & Connectors" <?= set_select('item_type', 'Cables & Connectors') ?>>Cables & Connectors</option>
                                <option value="Miscellaneous Electronics" <?= set_select('item_type', 'Miscellaneous Electronics') ?>>Miscellaneous Electronics</option>
                            </select>
                            <span class="text-danger"><?= service('validation')->getError('item_type') ?></span>
                        </div>
                    </div>

                </div>
                <div class="col-auto">
                    <input type="number" name="min_cost" class="form-control" placeholder="Min Cost">
                </div>

                <div class="col-auto">
                    <input type="number" name="max_cost" class="form-control" placeholder="Max Cost">
                </div>

                <div class="col-auto">
                    <button type="submit" name="filter_action" value="filter" class="btn btn-primary">Filter</button>
                </div>

                <div class="col-auto">
                    <a href="<?= base_url('sys/listToEwcInventory') ?>" class="btn btn-secondary">Remove Filters</a>
                </div>
        </div>
        </form>



        <!-- Inventory Table -->
        <div class="row">
            <div class="col-lg-12">
                <form action="<?= base_url('sys/calculateSellingPrice') ?>" method="POST">
                    <table class="table datatable datatable-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Weight Unit</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Define $selectedItemIDs as an empty array if it's not set to prevent undefined variable error
                            $selectedItemIDs = $selectedItemIDs ?? [];
                            foreach ($inventoryItems as $item):
                                ?>
                                <tr>
                                    <td><?= esc($item['item_name']) ?></td>
                                    <td><?= esc($item['item_type']) ?></td>
                                    <td><img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" alt="Item Image" width="50"></td>
                                    <td><?= esc($item['quantity']) ?></td>
                                    <td><?= esc($item['weight']) ?></td>
                                    <td><?= esc($item['weight_unit']) ?></td>
                                    <td><?= esc($item['description']) ?></td>
                                    <td><?= esc($item['total_payment']) ?></td>
                                    <td><?= esc($item['list_status_c']) ?></td>
                                    <td>
                                        <?php if ($item['list_status_c'] === 'not published'): ?>
                                            <input type="checkbox" name="selected_items[]" value="<?= $item['inventory_number'] ?>"
                                                   <?= in_array($item['inventory_number'], $selectedItemIDs) ? 'checked' : '' ?>>
                                               <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                    <!-- Profit Percentage and Calculate Selling Price Form -->
                    <form action="<?= base_url('sys/calculateSellingPrice') ?>" method="POST">




                        <div class="row mt-3">
                            <div class="col-md-4">
                                <input type="number" name="profit_percentage" class="form-control" placeholder="Profit Percentage" >
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="calculate_action" value="calculate_price" class="btn btn-info">Calculate Selling Price</button>
                            </div>
                        </div>

                        <!-- Listing Title and Calculated Selling Price -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <input type="text" name="listing_title" class="form-control" placeholder="Listing Title" >
                            </div>
                            <?php if (isset($calculatedSellingPrice)): ?>
                                <div class="col-md-4">
                                    <p class="font-weight-bold">Total Selling Price: <span class="text-success"><?= $calculatedSellingPrice ?></span></p>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label for="pickup_location">Pickup Location (Address)</label>
                                        <textarea class="form-control" name="pickup_location" id="pickup_location" ><?= set_value('pickup_location') ?></textarea>
                                        <span class="text-danger"><?= service('validation')->getError('pickup_location') ?></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label for="google_location">Google Location Link</label>
                                        <input type="text" class="form-control" name="google_location" id="google_location" placeholder="Paste Google location link here">
                                        <span class="text-danger"><?= service('validation')->getError('google_location') ?></span>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label for="contact_name">Contact Name (preferred)</label>
                                        <input type="text" class="form-control" name="contact_name" id="contact_name" value="<?= set_value('contact_name') ?>" >
                                        <span class="text-danger"><?= service('validation')->getError('contact_name') ?></span>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label for="contact_number">Contact Number (preferred)</label>
                                        <input type="text" class="form-control" name="contact_number" id="contact_number" value="<?= set_value('contact_number') ?>" >
                                        <span class="text-danger"><?= service('validation')->getError('contact_number') ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" formaction="<?= base_url('sys/publishSet') ?>" class="btn btn-success">Publish Selected Items</button>
                                </div>

                            <?php endif; ?>

                        </div>
                    </form>
            </div>
    </section>
</main>
