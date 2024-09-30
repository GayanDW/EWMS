 <?php

namespace App\Controllers;

use Config\Services;
use App\Models\EwasteListModel;
use App\Models\BiddingModel;
use App\Models\UserModel;
use App\Models\PickupModel;
use App\Models\EwcInventoryModel;
use App\Models\EwcSalesListModel;
use App\Models\EwrBiddingModel;
use App\Models\NotificationModel;
use App\Models\EwcListingsModel;
use App\Models\EwrRequestModel;
use App\Models\EwasteCollectorModel;
use App\Models\EwrInventoryModel;
use App\Models\RecyclingSummaryModel;
use App\Models\RecycledMaterialsModel;
use App\Models\CategoryModel;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }

    public function dashboard() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new EwasteListModel();
        $ewcModel = new EwcListingsModel();
        $reqModel = new EwrRequestModel();
        $data['userId'] = $userId;

        if ($user_type === 'e-waste collector') {
            $data['listings'] = $ewasteModel->getColDash($userId);
            $data['pending'] = $ewasteModel->getListingsForPendingBids($userId);
        } elseif ($user_type === 'e-waste recycler') {
            $data['listings'] = $ewcModel->orderBy('listing_set', 'DESC')->findAll();
            $data['ewasterequestModel'] = $reqModel;
        } elseif ($user_type === 'gov-agency') {
            $data['govAgencyData'] = "Data specific to gov-agency users";
            return $this->viewUserReview();
        } elseif ($user_type === 'admin') {
            $data['adminData'] = "Data specific to admin users";
            return $this->viewUserMgt();
        } else {
            $data['listings'] = $ewasteModel->where('UserId', $userId)->get()->getResult();
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/content_' . $user_type, $data);
        echo view('sys/footer');
    }
 
  // Prepare an array to group listings by their 'listing_set'.
$groupedListings = [];
foreach ($listings as $listing) {
    // Extract the 'listing_set' value from each listing, which serves as a unique identifier for a group of listings.
    $listingSet = $listing['listing_set'];

    // Check if an entry for this listing set already exists in the grouping array.
    if (!isset($groupedListings[$listingSet])) {
        // If this listing set does not already exist in the groupedListings array, initialize it.
        // This is the first encounter with this particular listing set.
        $groupedListings[$listingSet] = [
            'details' => [],  // An array to store individual listings that belong to this set.
            'collector_name' => $listing['collector_name'],  // Record the name of the collector associated with this listing.
            'date_added' => $listing['date_added'],  // Record the date when the listing was added.
            'time_added' => $listing['time_added'],  // Record the time when the listing was added.
            'ewc_listing_title' => $listing['ewc_listing_title'],  // Store the title of the listing for display purposes.
            'item_count' => 0,  // Initialize a counter to track the number of listings in this set.
        ];
    }

    // Add the current listing to the 'details' array of the appropriate listing set.
    // This organizes all listings under their respective sets.
    $groupedListings[$listingSet]['details'][] = $listing;
    // Increment the count of listings in this set, providing a tally of how many items are in this particular group.
    $groupedListings[$listingSet]['item_count']++;

    // Fetch the status of any requests that have been made against this listing set.
    // This could include status like 'pending', 'approved', 'rejected', etc.
    $requestStatus = $ewasterequestModel->where('listing_set', $listingSet)->findAll();
    // Store these statuses within the grouping structure, allowing easy access to request information when viewing the listing set.
    $groupedListings[$listingSet]['request_status'] = $requestStatus;
}



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
