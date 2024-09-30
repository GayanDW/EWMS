<?php

namespace App\Controllers;

use App\Models\DistrictModel;
use App\Models\EwasteGeneratorModel;
use App\Models\EwasteCollectorModel;
use App\Models\EwasteRecyclerModel;
use App\Models\UserModel;
use App\Models\CustomerModel;

class Web extends BaseController {

    public function index() {
        return view('web/index');
    }

    public function register() {
        helper('form');
        return view('web/register');
    }

    public function make_register() {
        helper('form');
        $data = array();
        if ($this->request->getMethod() == 'post') {

            $rules = [
                'FirstName' => ['label' => 'First Name', 'rules' => 'required'],
                'LastName' => ['label' => 'Last Name', 'rules' => 'required'],
                'Email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                'UserName' => ['label' => 'User Name', 'rules' => 'required|min_length[4]'],
                'Password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
                'profile_image' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[profile_image]'
                    . '|is_image[profile_image]'
                    . '|mime_in[profile_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[profile_image,100]'
                    . '|max_dims[profile_image,1024,768]',
                ],
            ];
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('web/register', $data);
            } else {
                $profile_image = $this->request->getFile('profile_image');
                $newName = $profile_image->getRandomName();
                $profile_image->move('public/images/' . 'uploads', $newName);

                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('UserName'),
                    'Password' => $this->request->getPost('Password'),
                    'profile_image' => $newName,
                    'UserType' => 'Customer',
                ]);

                $userid = $user->getInsertID();

                $customer = new CustomerModel();
                $customer->save([
                    'FirstName' => $this->request->getPost('FirstName'),
                    'LastName' => $this->request->getPost('LastName'),
                    'Email' => $this->request->getPost('Email'),
                    'UserId' => $userid,
                ]);
                echo 'Saved...!';
            }
        }
    }

    public function register_ewastegenerator() {
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewastegenerator', $data);
    }

    public function register_ewastecollector() {
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewastecollector', $data);
    }

    public function register_ewasterecycler() {
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewasterecycler', $data);
    }

    public function save_ewaste_generator() {
        helper('form');
        $data = [];
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstName' => ['label' => 'First Name', 'rules' => 'required'],
                'lastName' => ['label' => 'Last Name', 'rules' => 'required'],
                'contactNumber' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[10]'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                'streetAddress' => ['label' => 'Street Address', 'rules' => 'required'],
                'city' => ['label' => 'City', 'rules' => 'required'],
                'district' => ['label' => 'District', 'rules' => 'required'],
                'username' => ['label' => 'Username', 'rules' => 'required'],
                'password' => ['label' => 'Password', 'rules' => 'required']
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $user = new UserModel();
                $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $hashedPassword,
                    'UserType' => 'e-Waste Generator'
                ]);
                $userId = $user->getInsertID();

                $generator = new EwasteGeneratorModel();
                $generator->save([
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'email' => $this->request->getPost('email'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'UserId' => $userId
                ]);
                $data['msg'] = "Successfully saved! You will receive a verification email shortly.";
            }
        }
        return view('web/registerewastegenerator', $data);
    }

    public function save_ewaste_collector() {
        helper('form');
        $data = [];
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'businessName' => ['label' => 'Business Name', 'rules' => 'required'],
                'contactNumber' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[10]'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                'licenseNumber' => ['label' => 'License Number', 'rules' => 'required'],
                'licenseExpiry' => ['label' => 'License Expiry', 'rules' => 'required'],
                'streetAddress' => ['label' => 'Street Address', 'rules' => 'required'],
                'city' => ['label' => 'City', 'rules' => 'required'],
                'district' => ['label' => 'District', 'rules' => 'required'],
                'username' => ['label' => 'Username', 'rules' => 'required'],
                'password' => ['label' => 'Password', 'rules' => 'required']
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'UserType' => 'e-Waste Collector'  // Specify the type of user
                ]);
                $user_id = $user->getInsertID();  // Get the ID of the newly created user

                $collector = new EwasteCollectorModel();
                $collector->save([
                    'businessName' => $this->request->getPost('businessName'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'email' => $this->request->getPost('email'),
                    'licenseNumber' => $this->request->getPost('licenseNumber'),
                    'licenseExpiry' => $this->request->getPost('licenseExpiry'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'user_id' => $user_id  // Link the collector to the user
                ]);
                $data['msg'] = "Collector Data Saved!";
            }
        }

        return view('web/registerewastecollector', $data);
    }

    public function save_ewaste_recycler() {
        helper('form');
        $data = [];
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'businessName' => ['label' => 'Business Name', 'rules' => 'required'],
                'contactNumber' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[10]'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                'licenseNumber' => ['label' => 'License Number', 'rules' => 'required'],
                'licenseExpiry' => ['label' => 'License Expiry', 'rules' => 'required'],
                'streetAddress' => ['label' => 'Street Address', 'rules' => 'required'],
                'city' => ['label' => 'City', 'rules' => 'required'],
                'district' => ['label' => 'District', 'rules' => 'required'],
                'username' => ['label' => 'Username', 'rules' => 'required'],
                'password' => ['label' => 'Password', 'rules' => 'required']
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'UserType' => 'e-Waste Recycler'  // Specify the type of user
                ]);
                $user_id = $user->getInsertID();  // Get the ID of the newly created user

                $recycler = new EwasteRecyclerModel();
                $recycler->save([
                    'businessName' => $this->request->getPost('businessName'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'email' => $this->request->getPost('email'),
                    'licenseNumber' => $this->request->getPost('licenseNumber'),
                    'licenseExpiry' => $this->request->getPost('licenseExpiry'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'user_id' => $user_id  // Link the recycler to the user
                ]);
                $data['msg'] = "Recycler Data Saved!";
            }
        }

        return view('web/registerewasterecycler', $data);
    }

}
