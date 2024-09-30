<?php

namespace App\Controllers;

use App\Models\EwcSalesListModel;
use App\Models\UserModel;

class DashboardController extends BaseController {

    public function dashboardSummary() {
        $salesListModel = new EwcSalesListModel();
        $userModel = new UserModel();

        // Join with user table to get seller names
        $sales_listings = $salesListModel
            ->select('ewc_sales_listings.*, user.UserName as seller_name')
            ->join('user', 'user.UserId = ewc_sales_listings.collector_id', 'left')
            ->findAll();

        $data['sales_listings'] = $sales_listings;

        echo view('sys/header');
        echo view('sys/content_e-Waste Recycler', $data);
        echo view('sys/footer');
    }
}

