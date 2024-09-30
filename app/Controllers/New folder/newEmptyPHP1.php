<?php

namespace App\Controllers;

use Config\Services;
use App\Models\EwasteListModel;
use App\Models\BiddingModel;
use App\Models\UserModel;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }

    public function login() {
        helper('form');
        echo view('sys/login');
    }

    public function dashboard() {
        $user_type = strtolower(session()->get('UserType'));
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/content_' . $user_type);
        echo view('sys/footer');
    }

    public function addEwasteView() {
        helper('form');
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        echo view('sys/content_addEwaste');
        echo view('sys/footer');
    }

    public function thank_you() {
        helper('form');
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        echo view('sys/thank_you');
        echo view('sys/footer');
    }

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
        $ewasteModel = new EwasteListModel();
        $data['listings'] = $ewasteModel->findAll();
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/content_' . $user_type, $data);
        echo view('sys/footer');
    }

    public function detailedView($item_id) {
        $ewasteModel = new EwasteListModel();
        $data['item'] = $ewasteModel->find($item_id);
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('detailed_view', $data);
        echo view('sys/footer');
    }

    public function displayBiddingForm($item_id) {
        echo view('sys/header');
        echo view('bidding_form', ['item_id' => $item_id]);
        echo view('sys/footer');
    }

    public function saveBid() {
        $biddingModel = new BiddingModel();
        $data = $this->request->getPost();
        if ($biddingModel->insert($data)) {
            echo view('sys/header');
            echo view('bid_success');
            echo view('sys/footer');
        } else {
            echo view('sys/header');
            echo view('bid_error');
            echo view('sys/footer');
        }
    }

    public function showBids($item_id) {
        // Your logic to show bids here
    }

}
