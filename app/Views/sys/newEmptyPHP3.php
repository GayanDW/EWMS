<?php

namespace App\Controllers;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }



public function viewListingSetItemsEwc($listingSetId) {
    // Load helper functions for form and URL manipulation
    helper(['form', 'url']);
    
    // Create a new instance of the EwcListingsModel model
    $ListModel = new \App\Models\EwcListingsModel();
    
    // Get the current user's ID from the session
    $userId = session()->get('UserId');
    
    // Get the current user's type from the session and convert it to lowercase
    $user_type = strtolower(session()->get('UserType'));
    
    // Fetch the details of the listing set with the provided listingSetId for the current user
    $listingSetDetails = $ListModel->where('UserId', $userId)
        ->where('listing_set', $listingSetId)
        ->first();

    // Fetch all items associated with the listing set for the current user
    $items = $ListModel->where('UserId', $userId)
        ->where('listing_set', $listingSetId)
        ->findAll();

    // Load views to display the header, menu, listing set details, and footer
    echo view('sys/header'); // Load the header view
    echo view('sys/menu_' . $user_type); // Load the menu view based on the user's type
    echo view('sys/view_SetEwc', [
        'Items' => $items, // Pass the fetched items to the view
        'ListingSet' => $listingSetDetails // Pass the fetched listing set details to the view
    ]);
    echo view('sys/footer'); // Load the footer view
}

}
