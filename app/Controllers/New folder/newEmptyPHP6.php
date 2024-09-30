<?php

namespace App\Controllers;

use Config\Services;


class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }

public function monthlyListings($year, $month) {
    return $this->db->query("
        SELECT 
            item_type, 
            COUNT(item_id) AS nooflist
        FROM 
            ewaste_listings
        WHERE 
            YEAR(date_added) = $year AND MONTH(date_added) = $month
        GROUP BY item_type
    ")->getResultArray();
}

    public function monthly_listings() {
        $model = new EwasteListModel();
        $year = $this->request->getPost('year') ?? date('Y'); 
        $month = $this->request->getPost('month'); 
        
        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'listings' => $model->monthlyListings($year, $month),
            'summary' => $model->getSummary($year, $month)
        ];


        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewg_monthly_listings', $data);
        echo view('sys/footer');
    }
    
        <section>
        <div class="container">
            <h3>Listing Status Insights</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Listed</td>
                            <td><?= $summary['totalListed'] ?? '0'; ?></td>
                        </tr>
                        <tr>
                            <td>Active (Not Sold Out or Not Deleted)</td>
                            <td><?= $summary['active'] ?? '0'; ?></td>
                        </tr>
                        <tr>
                            <td>Sold Out</td>
                            <td><?= $summary['soldOut'] ?? '0'; ?></td>
                        </tr>
                        <tr>
                            <td>Deleted</td>
                            <td><?= $summary['deleted'] ?? '0'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
}



