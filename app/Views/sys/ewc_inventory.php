 

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
                    <button type="button" name="filter_action" value="remove_filters" class="btn btn-secondary" onclick="window.location.href = '<?= base_url('sys/ViewEwcInventory') ?>'">Remove Filters</button>

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
                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

            </div>
    </section>
</main>
