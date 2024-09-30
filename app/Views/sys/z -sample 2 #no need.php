<main id="main" class="main">
    <section class="section">
        <div class="container-fluid">
            <div class="section-title">
                <h2>My Inventory for Sale</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table datatable datatable-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventoryItems as $item): ?>
                                <tr>
                                    <td><?= esc($item['item_name']) ?></td>
                                    <td><?= esc($item['item_type']) ?></td>
                                    <td><img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" width="50"></td>
                                    <td><?= esc($item['quantity']) ?></td>
                                    <td><?= esc($item['weight']) . ' ' . esc($item['weight_unit']) ?></td>
                                    <td><?= esc($item['status']) ?></td>
                                    <td>
                                        <?php if ($item['status'] === 'Open For Bidding'): ?>
                                            <!-- Form to set selling price and publish -->
                                            <?= form_open('sys/publishInventoryItem/' . $item['inventory_number']); ?>
                                                <input type="number" name="selling_price" placeholder="Set Price" required>
                                                <button type="submit" class="btn btn-primary">Publish for Selling</button>
                                            <?= form_close() ?>
                                        <?php elseif ($item['status'] === 'published'): ?>
                                            <!-- Link to unpublish the item -->
                                            <a href="<?= site_url('sys/unpublishInventoryItem/' . $item['inventory_number']) ?>" class="btn btn-warning">Cancel Publish</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
