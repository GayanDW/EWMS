<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <form action="<?= site_url('sys/updateRecyclingStatus') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card recent-sales overflow-auto">
                    <div class="card-header">
                        <h4>Inventory Listings</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Item Name</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Weight</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inventoryItems as $item): ?>
                                    <tr>
                                        <td>
                                            <?php if ($item['status'] !== 'recycled'): ?>
                                                <input type="checkbox" name="selected_items[]" value="<?= $item['ewr_inv_id'] ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($item['item_name']) ?></td>
                                        <td><?= esc($item['item_type']) ?></td>
                                        <td><?= esc($item['quantity']) ?></td>
                                        <td><?= esc($item['weight']) ?> <?= esc($item['weight_unit']) ?></td>
                                        <td><?= esc($item['description']) ?></td>
                                        <td>$<?= number_format(esc($item['set_buying_price']), 2) ?></td>
                                        <td><?= esc($item['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Mark as Recycled</button>
                        <a href="<?= site_url('sys/showMonthlySummaryForm') ?>" class="btn btn-primary">Submit Monthly Summary</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
