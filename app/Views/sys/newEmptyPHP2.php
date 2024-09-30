

<?php
// Start by initializing an empty array to hold grouped listings.
$groupedListings = [];
// Iterate through each listing retrieved from the database.
foreach ($listings as $listing) {
    // Check if the group for the current listing's set has already been initialized.
    if (!isset($groupedListings[$listing['listing_set']])) {
        // If not, initialize the group with relevant data from the first listing in this set.
        $groupedListings[$listing['listing_set']] = [
            'details' => [],  // Array to store individual listing details for aggregation.
            'collector_name' => $listing['collector_name'],  // The name of the collector of the items.
            'type' => $listing['item_type'],  // The type of items in this listing set.
            'price' => $listing['selling_price'],  // The selling price for items in this listing.
            'date_added' => $listing['date_added'],  // The date when the listing was added.
            'time_added' => $listing['time_added'],  // The time when the listing was added.
        ];
    }
    // Add each listing to the 'details' array of its corresponding set.
    $groupedListings[$listing['listing_set']]['details'][] = $listing;
}
?>



<!-- Main content wrapper -->
<main id="main" class="main">
    <div class="container">
        <!-- Title for the listings page -->
        <div class="pagetitle">
            <h1>Latest Listings</h1>
        </div>

        <!-- Loop through each grouped listing set -->
        <?php foreach ($groupedListings as $listingSet => $group): ?>
            <!-- Calculate the total quantity and weight of items in the current group -->
            <?php
            $totalQuantity = array_sum(array_column($group['details'], 'quantity'));
            $totalWeight = array_sum(array_column($group['details'], 'weight'));
            // Use the status of the first item in the group as the status for the entire set, defaulting to 'unknown' if not set.
            $status = $group['details'][0]['list_status_c'] ?? 'unknown';
            ?>
            <!-- Card container for each listing set -->
            <div class="col-12 mt-4">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <!-- Display the listing set number and title along with the date and time added -->
                        <h5 class="card-title">
                            Listing Set: <?= esc($listingSet) ?> - <?= esc($group['details'][0]['ewc_listing_title']) ?>
                            <span>| Posted on <?= esc($group['date_added']) ?> at <?= esc($group['time_added']) ?></span>
                        </h5>

                        <!-- Table for displaying details of the items in the set -->
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <!-- Check if the group has any details before displaying headers for totals and actions -->
                                    <?php if (!empty($group['details'])): ?>
                                        <th>Total Quantity</th>
                                        <th>Total Weight</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through each item in the group to display individual details -->
                                <?php foreach ($group['details'] as $index => $detail): ?>
                                    <tr>
                                        <td>
                                            <!-- Show a preview image for each item -->
                                            <img src="<?= base_url('public/images/uploads/' . esc($detail['item_image'])) ?>" alt="Item Image" style="width: 50px; height: auto;">
                                        </td>
                                        <td><?= esc($detail['item_name']) ?></td>
                                        <td><?= esc($detail['item_type']) ?></td>
                                        <!-- Display total quantity and weight only once for the entire group -->
                                        <?php if ($index === 0): ?>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalQuantity ?></td>
                                            <td rowspan="<?= count($group['details']) ?>"><?= $totalWeight ?> <?= esc($group['details'][0]['weight_unit']) ?></td>
                                            <td>
                                                <!-- Display status for the listing set, potentially highlighting different conditions like available, requested, etc. -->
                                                <?php
                                                // Depending on availability, adjust the display of the request state based on additional business logic.
                                                $requeststate = "";
                                                if ($detail['list_status_r'] == 'available') {
                                                    // Dynamically fetch and display the status of the requests associated with this set.
                                                    $status = $ewasterequestModel->where('UserId', $userId)->where('listing_set', $listingSet)->get()->getResult();
                                                    foreach ($status as $status) {
                                                        $requeststate = $status->req_status_r;
                                                    }
                                                }
                                                ?>

                                                <!-- Display badges according to the request state -->
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
                                            <!-- Link to view more details of the entire set -->
                                            <td rowspan="<?= count($group['details']) ?>">
                                                <a href="<?= base_url('sys/viewListingSetItemsEwr/' . $listingSet) ?>" class="btn btn-primary">View Set</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- Display a message if there are no details available for a listing set -->
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
