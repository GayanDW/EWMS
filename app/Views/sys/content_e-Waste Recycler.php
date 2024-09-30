<main id="main" class="main">
    <div class="container">
        <div class="pagetitle">
            <h1>Latest Listings</h1>
        </div>

        <?php if (session()->has('message')): ?>
            <div class="alert alert-success">
                <?= session('message'); ?>
            </div>
        <?php endif; ?>


        <?php
        // Initialize and group listings
        $groupedListings = [];
        foreach ($listings as $listing) {
            $listingSet = $listing['listing_set'];
            if (!isset($groupedListings[$listingSet])) {
                $groupedListings[$listingSet] = [
                    'details' => [],
                    'collector_name' => $listing['collector_name'],
                    'type' => $listing['item_type'],
                    'price' => $listing['selling_price'],
                    'date_added' => $listing['date_added'],
                    'time_added' => $listing['time_added'],
                ];
            }
            $groupedListings[$listingSet]['details'][] = $listing;
        }
        ?>



        <?php foreach ($groupedListings as $listingSet => $group): ?>
            <?php
            $totalQuantity = array_sum(array_column($group['details'], 'quantity'));
            $totalWeight = array_sum(array_column($group['details'], 'weight'));

            $status = $group['details'][0]['final_status'] ?? 'Available';
            ?>

            <div class="col-12 mt-4">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">
                            Listing Set: <?= esc($listingSet) ?> - <?= esc($group['details'][0]['ewc_listing_title']) ?>
                            <span>| Posted on <?= esc($group['date_added']) ?> at <?= esc($group['time_added']) ?></span>
                        </h5>

                        <table class="table table-borderless">
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
                                <?php foreach ($group['details'] as $index => $detail): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('public/images/uploads/' . esc($detail['item_image'])) ?>" alt="Item Image" style="width: 50px; height: auto;">
                                        </td>
                                        <td><?= esc($detail['item_name']) ?></td>
                                        <td><?= esc($detail['item_type']) ?></td>
                                        <?php if ($index === 0): ?>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalQuantity ?></td>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalWeight ?> <?= esc($group['details'][0]['weight_unit']) ?></td>
                                            <td rowspan="<?= count($group['details']) ?>">
                                                <span class="badge bg-success"><?= $status ?></span>
                                            </td>

                                            <td rowspan="<?= count($group['details']) ?>">
                                                <a href="<?= base_url('sys/viewListingSetItemsEwr/' . $listingSet) ?>" class="btn btn-primary">View Set</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($group['details'])): ?>
                                    <tr>
                                        <td colspan="7">No details available for this listing.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
