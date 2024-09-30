<?php

namespace App\Controllers;

use Config\Services;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
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

    public function monthlyListings($year, $month = null) {
      $sql = "
          SELECT
          item_type,
          COUNT(item_id) AS nooflist
           FROM 
        ewaste_listings
    WHERE 
        YEAR(date_added) = $year"; 
    if ($month !== null) {
        $sql .= " AND MONTH(date_added) = $month";
    }  
      $sql .= " GROUP BY item_type";
    $query = $this->db->query($sql);
    return $query->getResultArray();
        
    }
    
        public function monthlyListings() {

       
        $query = $this->query("SELECT 


        $result = $query->getResultArray();
        return $result;
    }

}
