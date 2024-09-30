<?php

namespace App\Controllers;

use Config\Services;


class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }


public function monthly_listings() {
    // Initialize the EwasteListModel for querying the database
    $model = new EwasteListModel();

    // Retrieve the year from the form submission, default to the current year if not provided
    $year = $this->request->getPost('year') ?? date('Y');

    // Retrieve the month from the form submission, can be null to indicate an annual report
    $month = $this->request->getPost('month');

    // Prepare the data to pass to the view
    $data = [
        'selectedYear' => $year, // Year selected by the user or the current year
        'selectedMonth' => $month, // Month selected by the user or null for annual
        'listings' => $model->monthlyListings($year, $month), // Fetch monthly listings grouped by type
        'summary' => $model->getSummary($year, $month) // Fetch the summary data
    ];

    // Render the header, menu, and pass data to the main report view, then the footer
    echo view('sys/header');
    echo view('sys/menu_' . strtolower(session()->get('UserType')));
    echo view('sys/ewg_monthly_listings', $data);
    echo view('sys/footer');
}

public function monthlyListings($year, $month = null) {
    // Begin constructing the base SQL query for counting listings by item type
    $sql = "
    SELECT 
        item_type, 
        COUNT(item_id) AS nooflist
    FROM 
        ewaste_listings
    WHERE 
        YEAR(date_added) = $year"; // Filter by the specified year

    // If a specific month is provided, add the month condition to the query
    if ($month !== null) {
        $sql .= " AND MONTH(date_added) = $month";
    }

    // Group the results by item type to count the listings for each category
    $sql .= " GROUP BY item_type";

    // Execute the SQL query directly and fetch all rows as an associative array
    $query = $this->db->query($sql);
    return $query->getResultArray();
}

}





