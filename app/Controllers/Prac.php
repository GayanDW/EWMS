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

class Prac extends BaseController {

    public function welcome() {
        $session = session();
        $userType = strtolower($session->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/prac/welcome_message');
        echo view('sys/footer');
    }

    public function demoStat() {
        $session = session();
        $userType = strtolower($session->get('UserType'));

        // Logic to demonstrate static variable behavior
        static $x = 0;
        $output = $x++ . "<br>";  // Increment and prepare the output

        $output .= $x++ . "<br>";  // Concatenate for demonstration

        $output .= $x++;  // Concatenate for demonstration
        // Prepare data array to pass to the view
        $data = [
            'output' => $output,
            'userType' => $userType // Assuming you'll use this for something meaningful in the views
        ];

        // Load views with data
        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/prac/demo_view', $data); // Pass $data to the view
        echo view('sys/footer');
    }

    public function editCategory($id) {
        helper('form');
        $model = new CategoryModel();
        $data['category'] = $model->find($id);

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/edit_category', $data); // You need to create this view
        echo view('sys/footer');
    }

    public function viwInputForm() {
        helper('form');
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/prac/input_form');
        echo view('sys/footer');
    }
##modified into practice4
    public function practice3() {
        helper('form');
        $session = session();
        $userType = strtolower($session->get('UserType'));

        // Example logic
        $data = []; // Initialize data array to pass to views
        // Example 1: Simple if statement
        if (5 > 3) {
            $data['message1'] = "Have a good day1";
        }

        // Example 2: Using variables in if statement
        $t = 14;
        if ($t < 20) {
            $data['message2'] = "Have a good day2!";
        }

        // Exercise: Output "Hello World" if $a is greater than $b.
        $a = 50;
        $b = 10;
        if ($a > $b) {
            $data['exerciseOutput'] = "Hello World2";
        }

        // Load views with data
        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/prac/example_view', $data); // This will be your view file for the output
        echo view('sys/footer');
    }

    public function practice4() {
        helper(['form', 'url']);
        $session = session();
        $userType = strtolower($session->get('UserType'));

        // Check if form data was submitted
        if ($this->request->getMethod() === 'post') {
            $data = []; // Initialize data array to pass to views
            // Retrieve form data
            $a = $this->request->getPost('a');
            $b = $this->request->getPost('b');
            $t = $this->request->getPost('t');

            // Perform comparisons
            if ($b > $a) {
                $data['message1'] = "B greater than A!";
            }

            if ($t < 20) {
                $data['message2'] = "T is less than 20";
            }

            if ($a > $b) {
                $data['exerciseOutput'] = "A greater than B!";
            }

            // Load result view
            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/prac/example_view', $data); // Displays the comparison results
            echo view('sys/footer');
        } else {
            // Display the form if no form data is submitted
            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/prac/input_form'); // Change to your form view's actual path if different
            echo view('sys/footer');
        }
    }

}
