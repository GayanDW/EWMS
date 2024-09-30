<main id="main" class="main">
    <?php foreach ($groupedListings as $listingSet => $group): ?>
        <div class="col-12 mt-4">
            <div class="card recent-sales">
                <div class="card-body">
                    <h5 class="card-title">
                        Listing Set: <?= esc($listingSet) ?> - <?= esc($group['ewc_listing_title']) ?>
                        <span>| Posted on <?= esc($group['date_added']) ?> at <?= esc($group['time_added']) ?></span>
                    </h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Item</th>
                                <th>Type</th>
                                <th>Total Quantity</th>
                                <th>Total Weight</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 0;
                            $totalDetails = count($group['details']);  // Total items in the details
                            ?>
                            <?php foreach ($group['details'] as $detail): ?>
                                <tr>
                                    <td><img src="<?= base_url('public/images/uploads/' . esc($detail['item_image'])) ?>" style="width: 50px; height: auto;"></td>
                                    <td><?= esc($detail['item_name']) ?></td>
                                    <td><?= esc($detail['item_type']) ?></td>
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= $totalDetails ?>"><?= array_sum(array_column($group['details'], 'quantity')) ?></td>
                                        <td rowspan="<?= $totalDetails ?>"><?= array_sum(array_column($group['details'], 'weight')) ?> kg</td>
                                        <td rowspan="<?= $totalDetails ?>">
                                            <?php if ($group['status'] == 'Collected'): ?>
                                                <span class="badge bg-success">Collected</span>
                                            <?php elseif ($group['status'] == 'Accepted'): ?>
                                                <span class="badge bg-warning">Accepted</span>
                                            <?php elseif ($group['status'] == 'Requested'): ?>
                                                <span class="badge bg-success">Requested</span>
                                            <?php elseif ($group['status'] == 'Published'): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php endif; ?>
                                        </td>
                                        <td rowspan="<?= $totalDetails ?>"><a href="<?= base_url('sys/viewListingSetItemsEwc/' . $listingSet) ?>" class="btn btn-primary">View Complete Set</a></td>
                                    <?php endif; ?>


                                </tr>
                                <?php $index++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</main>
