<!-- Main container for the content within the webpage -->
<main id="main" class="main">
    <!-- Title section of the page -->
    <div class="pagetitle">
        <!-- Navigation breadcrumbs for easy navigation and indication of current page -->
        <nav>
            <ol class="breadcrumb">
                <!-- Link to the user's main listing page -->
                <li class="breadcrumb-item"><a href="<?= base_url('Your Listings'); ?>"></a></li>
                <!-- Indicates the current page as an active breadcrumb item -->
                <li class="breadcrumb-item active"></li>
            </ol>
        </nav>
    </div>

    <!-- Loop through each listing set that has been grouped in the controller -->
    <?php foreach ($groupedListings as $listingSet => $group): ?>

        <!-- Calculate the total quantity and total weight from all details in the current group -->
        <?php
        $totalQuantity = array_sum(array_column($group['details'], 'quantity'));
        $totalWeight = array_sum(array_column($group['details'], 'weight'));
        // Get the status of the first item in the group, assuming all items in a set share the same status
        $status = $group['details'][0]['list_status_c'] ?? 'unknown';
        ?>
        <!-- Container for the listing set details -->
        <div class="col-12 mt-4">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <!-- Title for the listing set, showing the set number and title, and posting date/time -->
                    <h5 class="card-title">
                        Listing Set: <?= esc($listingSet) ?> - <?= esc($group['details'][0]['ewc_listing_title']) ?>
                        <span>| Posted on <?= esc($group['date_added']) ?> at <?= esc($group['time_added']) ?></span>
                    </h5>

                    <!-- Table to display details of the items in the listing set -->
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Item</th>
                                <th>Type</th>
                                <!-- Check if there are details to display before rendering the table headers -->
                                <?php if (!empty($group['details'])): ?>
                                    <th>Total Quantity</th>
                                    <th>Total Weight</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through each detail in the current listing group -->
                            <?php foreach ($group['details'] as $index => $detail): ?>
                                <tr>
                                    <td>
                                        <!-- Show an image preview of the item -->
                                        <img src="<?= base_url('public/images/uploads/' . esc($detail['item_image'])) ?>" alt="Item Image" style="width: 50px; height: auto;">
                                    </td>
                                    <td><?= esc($detail['item_name']) ?></td>
                                    <td><?= esc($detail['item_type']) ?></td>
                                    <!-- Merge cells for total quantity and weight if this is the first row in the group -->
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= count($group['details']) ?>"><?= $totalQuantity ?></td>
                                        <td rowspan="<?= count($group['details']) ?>"><?= $totalWeight ?> <?= esc($group['details'][0]['weight_unit']) ?></td>
                                        <td rowspan="<?= count($group['details']) ?>">
                                            <!-- Display the status as a badge -->
                                            <span class="badge <?= $status == 'available' ? 'bg-success' : ($status == 'requested' ? 'bg-warning' : 'bg-info') ?>">
                                                <?= ucfirst(esc($status)) ?>
                                            </span>
                                            <!-- Additional badges for request statuses -->
                                            <?php foreach ($group['request_status'] as $rstatus): ?>
                                                <span class="badge bg-warning"><?= str_replace('accepted', '', $rstatus['req_status_r']); ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <!-- Link to view the complete set -->
                                        <td rowspan="<?= count($group['details']) ?>">
                                            <a href="<?= base_url('sys/viewListingSetItemsEwc/' . $listingSet) ?>" class="btn btn-primary">View Complete Set</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Display a message if no details are available -->
                            <?php if (empty($group['details'])): ?>
                                <tr>
                                    <td colspan="7">No details available for this listing.</td>
                                </tr>
 
                                
                                
                                