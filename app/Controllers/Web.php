<?php

namespace App\Controllers;

use App\Models\DistrictModel;
use App\Models\EwasteGeneratorModel;
use App\Models\EwasteCollectorModel;
use App\Models\EwasteRecyclerModel;
use App\Models\UserModel;
use App\Models\CustomerModel;
use App\Models\FaqModel;
use App\Models\EwasteLicenseModel;

class Web extends BaseController {

    public function index() {
        $faq = new FaqModel();
        $data['f_list'] = $faq->findAll();
        return view('web/index', $data);
    }

    public function addFaq() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/add_faq');
        echo view('sys/footer');
    }

    public function saveFAQ() {
        helper('form');
        $model = new FaqModel();

        $data = [
            'subject' => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
        ];

        $model->save($data);
        return redirect()->to('web/addFaq')->with('success', 'FAQ added successfully');
    }

    public function register_ewastegenerator() {
        helper('form');
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewastegenerator', $data);
    }

    public function register_ewastecollector() {
        helper('form');
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewastecollector', $data);
    }

    public function register_ewasterecycler() {
        helper('form');
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registerewasterecycler', $data);
    }

    public function register_govagency() {
        helper(['form']); // Load the form helper
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/registergovagency', $data);
    }

    public function save_ewaste_generator() {
        helper('form');
        $data = array();
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstName' => 'required',
                'lastName' => 'required',
                'contactNumber' => 'required',
                'email' => 'required',
                'streetAddress' => 'required',
                'city' => 'required',
                'district' => 'required',
                'username' => 'required',
                'password' => 'required',
                'profile_image' => 'uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'AccountNumber' => 'required',
                'AccountName' => 'required',
                'BankName' => 'required',
                'BranchName' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $profile_image = $this->request->getFile('profile_image');
                $newName = $profile_image->getRandomName();
                $profile_image->move('public/images/' . 'uploads', $newName);
                // Generate a unique verification code
                $verificationCode = bin2hex(random_bytes(16));

                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'profile_image' => $newName,
                    'UserType' => 'e-Waste Generator',
                    'is_verified' => 0,
                    'verification_code' => $verificationCode,
                    'email' => $this->request->getPost('email'),
                ]);

                $UserId = $user->getInsertID();

                $generator = new EwasteGeneratorModel();
                $generator->save([
                    'UserId' => $UserId,
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'email' => $this->request->getPost('email'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'AccountNumber' => $this->request->getPost('AccountNumber'),
                    'AccountName' => $this->request->getPost('AccountName'),
                    'BankName' => $this->request->getPost('BankName'),
                    'BranchName' => $this->request->getPost('BranchName'),
                ]);
                // Send verification email
                $email = \Config\Services::email();
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('your_email@gmail.com', 'EWMS');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<a href="http://localhost/ems/web/verifymyaccount/' . $verificationCode . '">Click here to verify your account</a>';
                $email->setMessage($message);
                $email->send();

                return view('web/thank_you');
            }
        }

        return view('web/registerewastegenerator', $data);
    }

    public function verifymyaccount($verificationCode = null) {
        if (!$verificationCode) {
            // Handle the case where no verification code is provided
            // For example, show an error message or redirect to a specific page
            echo "Verification code is missing.";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->where('verification_code', $verificationCode)->first();

        if ($user) {
            // User found, verify the account
            $userModel->update($user['UserId'], ['is_verified' => 1, 'verification_code' => null]); 
            // Display a success message or redirect to a success page
            echo "Your account has been successfully verified.";
            session()->setFlashdata('message', 'Your account has been successfully verified.');
            return redirect()->to('sys/success');
        } else {
            // No user found with the provided verification code
            // Handle this case appropriately, such as showing an error message
            echo "Invalid or expired verification code.";
        }
    }

    public function save_ewaste_collector() {
        helper(['form', 'url']);
        $data = [];
        $districtModel = new \App\Models\DistrictModel();
        $data['district_list'] = $districtModel->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'businessName' => 'required',
                'contactNumber' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required',
                'profile_image' => 'uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'license_certificate' => 'required|uploaded[license_certificate]|max_size[license_certificate,2048]|ext_in[license_certificate,pdf,jpg,jpeg,png]',
                'licenseNumber' => 'required',
                'licenseExpiry' => 'required',
                'AccountNumber' => 'required',
                'AccountName' => 'required',
                'BankName' => 'required',
                'BranchName' => 'required',
                // Additional fields for address details
                'streetAddress' => 'required',
                'city' => 'required',
                'district' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                // Profile image handling
                $profileImage = $this->request->getFile('profile_image');
                $profileImagePath = '';
                if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                    $newName = $profileImage->getRandomName();
                    $profileImage->move('public/images/' . 'uploads', $newName);
                    $profileImagePath = $newName;
                }

                // License certificate handling
                $licenseCertificate = $this->request->getFile('license_certificate');
                $licenseCertificatePath = '';
                if ($licenseCertificate->isValid() && !$licenseCertificate->hasMoved()) {
                    $newName = $licenseCertificate->getRandomName();
                    $licenseCertificate->move('public/licenses', $newName);
                    $licenseCertificatePath = $newName;
                }
                $verificationCode = bin2hex(random_bytes(16));
                $userData = [
                    'email' => $this->request->getPost('email'),
                    'UserName' => $this->request->getPost('username'),
                    'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'profile_image' => $profileImagePath,
                    'UserType' => 'e-Waste Collector',
                    'is_verified' => 0,
                    'verification_code' => $verificationCode
                ];

                // Inserting user data and retrieving the inserted ID
                $userModel = new \App\Models\UserModel();
                $userModel->save($userData);
                $userId = $userModel->getInsertID();

                // Inserting collector data
                $collectorData = [
                    'UserId' => $userId,
                    'businessName' => $this->request->getPost('businessName'),
                    'email' => $this->request->getPost('email'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'AccountNumber' => $this->request->getPost('AccountNumber'),
                    'AccountName' => $this->request->getPost('AccountName'),
                    'BankName' => $this->request->getPost('BankName'),
                    'BranchName' => $this->request->getPost('BranchName'),
                ];
                $collectorModel = new \App\Models\EwasteCollectorModel();
                $collectorModel->save($collectorData);

                // Inserting license data
                $licenseData = [
                    'UserId' => $userId,
                    'UserType' => 'e-Waste Collector',
                    'licenseNumber' => $this->request->getPost('licenseNumber'),
                    'licenseExpiry' => $this->request->getPost('licenseExpiry'),
                    'license_certificate_path' => $licenseCertificatePath,
                    'licenseStatus' => 'active', // Assuming active status
                ];
                $licenseModel = new \App\Models\EwasteLicenseModel();
                $licenseModel->save($licenseData);

                $data['msg'] = "Collector Data and License Saved Successfully!";

                // Send verification email
                $email = \Config\Services::email();
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('your_email@gmail.com', 'EWMS');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<a href="http://localhost/ewms/web/verifymyaccount/' . $verificationCode . '">Click here to verify your account</a>';
                $email->setMessage($message);
                $email->send();

                return view('web/thank_you');
            }
        }
        return view('web/registerewastecollector', $data);
    }

    public function save_ewaste_recycler() {
        helper(['form', 'url']);
        $data = [];
        $districtModel = new \App\Models\DistrictModel();
        $data['district_list'] = $districtModel->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'businessName' => 'required',
                'contactNumber' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required',
                'profile_image' => 'uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'license_certificate' => 'uploaded[license_certificate]|max_size[license_certificate,2048]|ext_in[license_certificate,pdf,jpg,jpeg,png]',
                'licenseNumber' => 'required',
                'licenseExpiry' => 'required',
                // Additional fields for address details
                'streetAddress' => 'required',
                'city' => 'required',
                'district' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                // Profile image handling
                $profileImage = $this->request->getFile('profile_image');
                $profileImagePath = '';
                if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                    $newName = $profileImage->getRandomName();
                    $profileImage->move('public/images/' . 'uploads', $newName);
                    $profileImagePath = $newName;
                }

                // License certificate handling
                $licenseCertificate = $this->request->getFile('license_certificate');
                $licenseCertificatePath = '';
                if ($licenseCertificate->isValid() && !$licenseCertificate->hasMoved()) {
                    $newName = $licenseCertificate->getRandomName();
                    $licenseCertificate->move('public/licenses', $newName);
                    $licenseCertificatePath = $newName;
                }
                $verificationCode = bin2hex(random_bytes(16));
                $userData = [
                    'email' => $this->request->getPost('email'),
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'profile_image' => $profileImagePath,
                    'UserType' => 'e-Waste Recycler',
                    'is_verified' => 0,
                    'verification_code' => $verificationCode
                ];

                // Inserting user data and retrieving the inserted ID
                $userModel = new \App\Models\UserModel();
                $userModel->save($userData);
                $userId = $userModel->getInsertID();

                // Inserting recycler data
                $recyclerData = [
                    'user_id' => $userId,
                    'businessName' => $this->request->getPost('businessName'),
                    'email' => $this->request->getPost('email'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                ];
                $recyclerModel = new \App\Models\EwasteRecyclerModel();
                $recyclerModel->save($recyclerData);

                // Inserting license data
                $licenseData = [
                    'UserId' => $userId,
                    'UserType' => 'e-Waste Recycler',
                    'licenseNumber' => $this->request->getPost('licenseNumber'),
                    'licenseExpiry' => $this->request->getPost('licenseExpiry'),
                    'license_certificate_path' => $licenseCertificatePath,
                    'licenseStatus' => 'active', // Assuming active status
                ];
                $licenseModel = new \App\Models\EwasteLicenseModel();
                $licenseModel->save($licenseData);

                $data['msg'] = "recycler Data and License Saved Successfully!";

                // Send verification email
                $email = \Config\Services::email();
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('your_email@gmail.com', 'EWMS');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<a href="http://localhost/ewms/web/verifymyaccount/' . $verificationCode . '">Click here to verify your account</a>';
                $email->setMessage($message);
                $email->send();

                return view('web/thank_you');
            }
        }

        return view('web/registerewasterecycler', $data);
    }

    public function save_gov_agency() {
        helper(['form', 'url']);
        $data = [];
        $districtModel = new \App\Models\DistrictModel();
        $data['district_list'] = $districtModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'branchName' => 'required',
                'branchCode' => 'required',
                'email' => 'required',
                'contactNumber' => 'required',
                'streetAddress' => 'required',
                'city' => 'required',
                'district' => 'required',
                'username' => 'required',
                'password' => 'required',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $userModel = new \App\Models\UserModel();
                $govAgencyModel = new \App\Models\GovAgencyModel();

                // Insert user credentials
                $userData = [
                    'UserName' => $this->request->getPost('username'),
                    'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'UserType' => 'gov-agency',
                    'email' => $this->request->getPost('email'),
                    'is_verified' => 0,
                    'verification_code' => bin2hex(random_bytes(16)),
                ];
                $userModel->save($userData);
                $userId = $userModel->insertID();

                // Insert government agency details
                $govAgencyData = [
                    'UserId' => $userId,
                    'branch_name' => $this->request->getPost('branchName'),
                    'branch_code' => $this->request->getPost('branchCode'),
                    'email_address' => $this->request->getPost('email'),
                    'contact_number' => $this->request->getPost('contactNumber'),
                    'street_address' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                ];
                $govAgencyModel->save($govAgencyData);

                // Send verification email
                $email = service('email');
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('info@ewms.com', 'E-Waste Management System');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<p>Please click the following link to verify your account:</p>';
                $message .= '<a href="' . base_url() . '/web/verifymyaccount/' . $userData['verification_code'] . '">Verify Account</a>';
                $email->setMessage($message);

                return view('web/thank_you');
                //if ($email->send()) {
                //return redirect()->to('web/thank_you')->with('message', 'Registration successful. Please check your email to verify your account.');
                //} else {
                //$data['emailError'] = 'Failed to send verification email. Please try again later.';
                //}
            }
        }

        // If validation fails or it's the first time accessing the page, show the registration form again.
        return view('web/registergovagency', $data);
    }

    public function thank_you() {
        return view('web/thank_you');
    }

    public function web2() {
        return view('web/p/web2');
    }

    public function reg_ewg() {
        helper('form');
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();
        return view('web/reg_ewg', $data);
    }

    public function save_reg_ewg() {
        helper('form');
        $data = array();
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
                'username' => 'required|is_unique[user.UserName]|alpha_dash|min_length[4]',
                'password' => ['label' => 'Password', 'rules' => 'required'],
                'profile_image' => 'uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'AccountNumber' => ['label' => 'Account Number', 'rules' => 'required'],
                'AccountName' => ['label' => 'Account Name', 'rules' => 'required'],
                'BankName' => ['label' => 'Bank Name', 'rules' => 'required'],
                'BranchName' => ['label' => 'Branch Name', 'rules' => 'required'],
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $profile_image = $this->request->getFile('profile_image');
                $newName = $profile_image->getRandomName();
                $profile_image->move('public/images/' . 'uploads', $newName);
                $verificationCode = bin2hex(random_bytes(16));

                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'profile_image' => $newName,
                    'UserType' => 'e-Waste Generator',
                    'is_verified' => 0,
                    'verification_code' => $verificationCode,
                    'email' => $this->request->getPost('email'),
                ]);

                $UserId = $user->getInsertID();

                $generator = new EwasteGeneratorModel();
                $generator->save([
                    'UserId' => $UserId,
                    'firstName' => $this->request->getPost('firstName'),
                    'lastName' => $this->request->getPost('lastName'),
                    'contactNumber' => $this->request->getPost('contactNumber'),
                    'email' => $this->request->getPost('email'),
                    'streetAddress' => $this->request->getPost('streetAddress'),
                    'city' => $this->request->getPost('city'),
                    'district' => $this->request->getPost('district'),
                    'AccountNumber' => $this->request->getPost('AccountNumber'),
                    'AccountName' => $this->request->getPost('AccountName'),
                    'BankName' => $this->request->getPost('BankName'),
                    'BranchName' => $this->request->getPost('BranchName'),
                ]);
                // Send verification email
                $email = \Config\Services::email();
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('ewmslk@gmail.com', 'EWMS');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<a href="http://localhost/ewms/web/verifymyaccount/' . $verificationCode . '">Click here to verify your account</a>';
                $email->setMessage($message);
                $email->send();

                return view('web/thank_you');
            }
        }

        return view('web/reg_ewg', $data);
    }

    public function save_reg_aaa() {
        helper('form');
        $data = array();
        $district = new DistrictModel();
        $data['district_list'] = $district->findAll();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstName' => ['label' => 'First Name', 'rules' => 'required'],
                'email' => ['label' => 'Email', 'rules' => 'required|is_unique[user.email]|valid_email', 'errors' => [
                        'is_unique' => 'Your email has already been registered. Please try with a new one or reset your password.']],
                'district' => ['label' => 'District', 'rules' => 'required'],
                'username' => ['label' => 'User Name', 'rules' => 'required|is_unique[user.UserName]|alpha_dash|min_length[4]',
                    'errors' => [
                        'is_unique' => 'Your User Name has already been registered. Please try with a new one']],
                'password' => ['label' => 'Password', 'rules' => 'required'],
                'profile_image' => 'uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'AccountNumber' => ['label' => 'Account Number', 'rules' => 'required'],
                'profile_image' => [
                    'label' => 'Profile Image',
                    'rules' => 'required|uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'required' => 'The profile image is required.',
                        'uploaded' => 'You must upload a file.',
                        'max_size' => 'The image size should not exceed 2MB.',
                        'is_image' => 'You must upload an image.',
                        'mime_in' => 'The image must be in jpg, jpeg, or png format.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $profile_image = $this->request->getFile('profile_image');
                $newName = $profile_image->getRandomName();
                $profile_image->move('public/images/' . 'uploads', $newName);
                $verificationCode = bin2hex(random_bytes(16));

                $user = new UserModel();
                $user->save([
                    'UserName' => $this->request->getPost('username'),
                    'Password' => $this->request->getPost('password'),
                    'profile_image' => $newName,
                    'UserType' => 'e-Waste Generator',
                    'is_verified' => 0,
                    'verification_code' => $verificationCode,
                    'email' => $this->request->getPost('email'),
                ]);
                $UserId = $user->getInsertID();
                $ewg = new EwasteGeneratorModel();
                $ewg->save([
                    'UserId' => $UserId,
                    'firstName' => $this->request->getPost('firstName'),
                    'email' => $this->request->getPost('email'),
                    'district' => $this->request->getPost('district'),
                    'AccountNumber' => $this->request->getPost('AccountNumber'),
                ]);

                $email = \Config\Services::email();
                $email->setTo($this->request->getPost('email'));
                $email->setFrom('ewmslk@gmail.com', 'EWMS');
                $email->setSubject('Account Verification');
                $message = '<h1>Account Verification</h1>';
                $message .= '<a href="http://localhost/practice_ewms/web/verifymyaccount/' . $verificationCode . '">Click here to verify your account</a>';
                $email->setMessage($message);
                $email->send();

                if ($email) {

                    session()->setFlashdata('message', 'You have registered successfully.');
                    return redirect()->to('sys/thankYou');
                }
            }

            return view('web/reg_ewg', $data);
        }
    }

}
