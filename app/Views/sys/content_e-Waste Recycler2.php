<?php
// Group listings by listing_set
$groupedListings = [];
foreach ($listings as $listing) {
    if (!isset($groupedListings[$listing['listing_set']])) {
        $groupedListings[$listing['listing_set']] = [
            'details' => [],
            'collector_name' => $listing['collector_name'],
            'type' => $listing['item_type'],
            'price' => $listing['selling_price'],
            // Assuming 'date_added' and 'time_added' are part of your listings
            'date_added' => $listing['date_added'],
            'time_added' => $listing['time_added'],
        ];
    }
    $groupedListings[$listing['listing_set']]['details'][] = $listing;
}
?>

<main id="main" class="main">
    <div class="container">
        <div class="pagetitle">

            <h1>Latest Listings</h1>
        </div>

        <?php foreach ($groupedListings as $listingSet => $group): ?>
            <?php
            $totalQuantity = array_sum(array_column($group['details'], 'quantity'));
            $totalWeight = array_sum(array_column($group['details'], 'weight'));
            $status = $group['details'][0]['list_status_c'] ?? 'unknown'; // Get the status of the first item as the status for the whole set
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
                                    <?php if (!empty($group['details'])): ?>
                                        <th>Total Quantity</th>
                                        <th>Total Weight</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    <?php endif; ?>
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
                                        <?php if ($index === 0): // Display total quantity, weight, status, and action only once ?>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalQuantity ?></td>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalWeight ?> <?= esc($group['details'][0]['weight_unit']) ?></td>
                                            <td>
                                                <?php
                                                $requeststate = "";
                                                if ($detail['list_status_r'] == 'available') {

                                                    $ewasterequestModel = $ewasterequestModel; 
                                                    
                                                    $status = $ewasterequestModel->where('UserId', $userId)->where('listing_set', $listingSet)->get()->getResult();

                                                    foreach ($status as $status) {
                                                        $requeststate = $status->req_status_r;
                                                    }
                                                }
                                                ?>

                                                <?php if ($requeststate == "requested"): ?>
                                                    <span class="badge bg-warning">
                                                        Requested
                                                    </span>
                                                <?php elseif ($requeststate == "accepted"): ?>
                                                    <span class="badge bg-warning">
                                                        Accepted
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge <?= $detail['list_status_r'] == 'available' ? 'bg-success' : ($detail['list_status_r'] == 'requested' ? 'bg-warning' : 'bg-info') ?>">
                                                        <?= ucfirst(esc($detail['list_status_r'])) ?>
                                                    </span>
                                                <?php endif; ?>

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
