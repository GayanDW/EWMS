<?php

namespace App\Controllers;

use Config\Services;
use App\Models\EwasteListModel;
use App\Models\UserModel;
use App\Models\BiddingModel;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }

    public function login() {
        helper('form');
        echo view('sys/login');
    }

    // version 27/10/23
    public function dashboard() {
        $user_type = strtolower(session()->get('UserType'));

        $ewasteModel = new \App\Models\EwasteListModel();
        $data['listings'] = $ewasteModel->findAll();
        $data['summary'] = $ewasteModel->getDashboardSummary();  // New Line

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/content_' . $user_type, $data);
        echo view('sys/footer');
    }

    public function e_waste_registration_form() {
        // Load the e-waste registration form view
        echo view('sys/e_waste_registration_form');
    }

    public function addEwasteView() {
        // Load the common views
        helper('form');
        echo view('sys/header');
        echo view('sys/menu_addEwaste');

        // Load the content for the add e-waste page
        echo view('sys/content_addEwaste');

        echo view('sys/footer');
    }

    public function thank_you() {
        helper('form');
        // Load the common views
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        //echo view('sys/content_addEwaste');
        echo view('sys/thank_you');
        // Display a success message
        //echo "Thank you for submitting the e-waste details!";
        echo view('sys/footer');
    }

    /* public function thank_you() {
      return view('sys/thank_you');
      } */

    public function submitEwaste() {
        helper('form');
        $data = array();

        if ($this->request->getMethod() == 'post') {
            // Define validation rules and messages
            $rules = [
                'item_title' => ['label' => 'Item Title', 'rules' => 'required'],
                'item_name' => ['label' => 'Item Name', 'rules' => 'required'],
                'item_type' => ['label' => 'Item Type', 'rules' => 'required'],
                'item_description' => ['label' => 'Description', 'rules' => 'required'],
                'item_image' => ['label' => 'Image', 'rules' => 'uploaded[item_image]|is_image[item_image]|max_size[item_image,2048]'],
                'quantity' => ['label' => 'Quantity', 'rules' => 'required|is_numeric'],
                'weight' => ['label' => 'Weight', 'rules' => 'required|is_numeric'],
                'weight_unit' => ['label' => 'Weight Unit', 'rules' => 'required|in_list[g,kg]'],
                'price_option' => ['label' => 'Price Option', 'rules' => 'required|in_list[free,expected]'],
                'amount' => ['label' => 'Amount', 'rules' => 'permit_empty|is_numeric'],
                'pickup_location' => ['label' => 'Pickup Location', 'rules' => 'required'],
                'google_location' => ['label' => 'Google Location Link', 'rules' => 'required'],
                'contact_name' => ['label' => 'Contact Name', 'rules' => 'required'],
                'contact_number' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[15]'],
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $item_image = $this->request->getFile('item_image');
                $newName = $item_image->getRandomName();
                $item_image->move('public/images/' . 'uploads', $newName);

                $ewasteModel = new EwasteListModel();

                $ewasteData = [
                    'UserId' => session()->get('UserId'),
                    'item_title' => $this->request->getPost('item_title'),
                    'item_name' => $this->request->getPost('item_name'),
                    'item_type' => $this->request->getPost('item_type'),
                    'item_description' => $this->request->getPost('item_description'),
                    'item_image' => $newName,
                    'quantity' => $this->request->getPost('quantity'),
                    'weight' => $this->request->getPost('weight'),
                    'weight_unit' => $this->request->getPost('weight_unit'),
                    'price_option' => $this->request->getPost('price_option'),
                    'amount' => $this->request->getPost('amount'),
                    'pickup_location' => $this->request->getPost('pickup_location'),
                    'google_location' => $this->request->getPost('google_location'),
                    'contact_name' => $this->request->getPost('contact_name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                    'item_status' => 'Pending Pickup',
                    'date_added' => date("Y-m-d"),
                ];

                $ewasteModel->save($ewasteData);

                return view('web/thank_you');
            }
            echo view('sys/header');
            echo view('sys/menu_addEwaste');

            // Load the content for the add e-waste page
            echo view('sys/content_addEwaste', $data);

            echo view('sys/footer');
        }

        //return view('sys/content_addEwaste', $data);
    }

    public function displayEwasteListings() {
        $model = new \App\Models\EwasteListModel();
        $data['listings'] = $model->findAll();

        echo view('sys/header');
        echo view('sys/menu_e-Waste Collector');
        echo view('sys/content_e-Waste Collector', $data);
        echo view('sys/footer');
    }

    // detailedView of one listing
    public function detailedView($item_id) {
        $ewasteModel = new \App\Models\EwasteListModel();
        $data['item_details'] = $ewasteModel->find($item_id);

        echo view('sys/header');
        echo view('sys/detailed_view', $data);
        echo view('sys/footer');
    }

    public function biddingForm() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));
        $biddingModel = new \App\Models\BiddingModel();
        $data = [];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'item_name' => 'required|min_length[3]|max_length[255]',
                'bid_price_per_item' => 'required|numeric',
                'requested_quantity' => 'required|numeric',
            ];

            if ($this->validate($rules)) {
                $newBid = [
                    'item_name' => $this->request->getPost('item_name'),
                    'bid_price_per_item' => $this->request->getPost('bid_price_per_item'),
                    'requested_quantity' => $this->request->getPost('requested_quantity'),
                    'user_type' => $user_type,
                ];

                $biddingModel->save($newBid);
                $data['message'] = "Bid successfully submitted.";
            } else {
                $data['validation'] = $this->validator;
            }
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/bidding_form', $data);
        echo view('sys/footer');
    }

    public function saveBid() {
        $model = new EwasteListModel();
        $bidData = [
            'item_id' => $this->request->getPost('item_id'),
            'item_name' => $this->request->getPost('item_name'),
            'bid_price_per_item' => $this->request->getPost('bid_price_per_item'),
            'requested_quantity' => $this->request->getPost('requested_quantity'),
                // Add other fields if necessary
        ];

        $model->saveBid($bidData);

        // Redirect or load a view

        $success = $model->saveBid($bidData);

        if ($success) {
            $this->session->setFlashdata('success', 'Your bid has been successfully placed.');
            return redirect()->to('sys/dashboard'); // Redirect to dashboard or any specific route
        } else {
            $this->session->setFlashdata('error', 'Failed to place your bid. Please try again.');
            return redirect()->to('sys/biddingForm'); // Redirect back to the bidding form
        }
    }

    public function showBids($item_id) {
        $ewasteModel = new EwasteListModel();

        $data['bids'] = $ewasteModel->fetchBidsByItemId($item_id);

        echo view('sys/header');
        echo view('sys/show_bids', $data);
        echo view('sys/footer');
    }

}
