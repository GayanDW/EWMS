<?php

namespace App\Controllers;

use App\Models\EwasteListModel;
use App\Models\PickupModel;
use CodeIgniter\Controller;

class Sys extends Controller {

    public function submitEwaste() {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'item_title' => ['label' => 'Item Title', 'rules' => 'required'],
                'item_name' => ['label' => 'Item Name', 'rules' => 'required'],
                'item_type' => ['label' => 'Item Type', 'rules' => 'required'],
                'item_description' => ['label' => 'Description', 'rules' => 'required'],
                'item_image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[item_image]|is_image[item_image]|max_size[item_image,2048]'
                ],
                'quantity' => ['label' => 'Quantity', 'rules' => 'required|is_numeric'],
                'weight' => ['label' => 'Weight', 'rules' => 'required|is_numeric'],
                'weight_unit' => ['label' => 'Weight Unit', 'rules' => 'required|in_list[g,kg]'],
                'price_option' => ['label' => 'Price Option', 'rules' => 'required|in_list[free,expected]'],
                'amount' => ['label' => 'Amount', 'rules' => 'permit_empty|is_numeric'],
                'pickup_location' => ['label' => 'Pickup Location', 'rules' => 'required'],
                'google_location' => ['label' => 'Google Location Link', 'rules' => 'required'],
                'contact_name' => ['label' => 'Contact Name', 'rules' => 'required'],
                'contact_number' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[15]'],
                // Add your rules for pickup details here
                'pref_day' => ['label' => 'Preferred Day', 'rules' => 'required'],
                'slot_start' => ['label' => 'Slot Start Time', 'rules' => 'required'],
                'slot_end' => ['label' => 'Slot End Time', 'rules' => 'required'],
                'alt_day1' => ['label' => 'Alternative Day 1', 'rules' => 'permit_empty'],
                'alt_start1' => ['label' => 'Alternative Start Time 1', 'rules' => 'permit_empty'],
                'alt_end1' => ['label' => 'Alternative End Time 1', 'rules' => 'permit_empty'],
                'alt_day2' => ['label' => 'Alternative Day 2', 'rules' => 'permit_empty'],
                'alt_start2' => ['label' => 'Alternative Start Time 2', 'rules' => 'permit_empty'],
                'alt_end2' => ['label' => 'Alternative End Time 2', 'rules' => 'permit_empty'],
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $item_image = $this->request->getFile('item_image');
                $newName = $item_image->getRandomName();
                $item_image->move('public/images/' . 'uploads', $newName);

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
                $itemId = $ewasteModel->getInsertID();

                $pickupModel = new PickupModel();
                $pickupData = [
                    'item_id' => $itemId, // This is obtained after inserting ewaste data
                    'pref_day' => $this->request->getPost('pref_day'),
                    'slot_start' => $this->request->getPost('slot_start'),
                    'slot_end' => $this->request->getPost('slot_end'),
                    'alt_day1' => $this->request->getPost('alt_day1'),
                    'alt_start1' => $this->request->getPost('alt_start1'),
                    'alt_end1' => $this->request->getPost('alt_end1'),
                    'alt_day2' => $this->request->getPost('alt_day2'),
                    'alt_start2' => $this->request->getPost('alt_start2'),
                    'alt_end2' => $this->request->getPost('alt_end2'),
                ];

                $pickupModel->save($pickupData);

                // Redirect to the thank you page
                return redirect()->to('/thank-you')->with('message', 'E-waste submitted successfully.');
            }
        }

        // Load views with data
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        echo view('sys/content_addEwaste', $data);
    echo view('sys/footer');
    }

}
