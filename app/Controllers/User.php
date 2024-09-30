<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ResettokenModel;

class User extends BaseController {

    public function index() {
        helper(['form']);
        echo view('sys/login');
    }

    public function login() {
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => ['label' => 'Username', 'rules' => 'required'],
                'password' => ['label' => 'Password', 'rules' => 'required|validateUser[username,password]'],
            ];
            $errors = [
                'password' => [
                    'validateUser' => 'You are entering the wrong username or Password'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
                return view('sys/login', $data);
            } else {
                $model = new UserModel();
                $user = $model->where(['UserName' => $this->request->getVar('username'), 'is_verified' => 1])->first();

                // Check if $user is not null before accessing its properties
                if ($user !== null && $user['account_status'] == 'Suspended') {
                    return view('sys/suspended');
                } else {
                    // Since $user might be null, also check it before comparing 'UserType'
                    if ($user !== null && $user['UserType'] == 'admin') {
                        $this->setUserSession($user);
                        return redirect()->to('sys/dashboard');
                    }

                    // Other checks follow here
                    if ($user && $user['is_admin_verified'] == 1) {
                        $this->setUserSession($user);
                        return redirect()->to('sys/dashboard');
                    } elseif ($user && $user['is_admin_verified'] == 0) {
                        // User is verified but not verified by admin
                        return redirect()->to('sys/adminNotAuthorised');
                    } else {
                        // User is not verified or does not exist
                        return redirect()->to('sys/notAuthorised');
                    }
                }
            }
        }
        return view('sys/login');
    }

    private function setUserSession($user) {
        $data = [
            'UserId' => $user['UserId'],
            'UserName' => $user['UserName'],
            'UserType' => $user['UserType'],
            'ProfileImage' => $user['profile_image'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('sys');
    }

    public function resetpassword() {
        helper(['form']);
        echo view('web/resetpassword');
    }

    public function sendResetLink() {

        helper('form');
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|valid_email',
            ];
            if (!$this->validate($rules)) {
                return view('web/resetpassword');
            }
            $email = $this->request->getPost('email');
            $usermodel = new UserModel();
            $user = $usermodel->where('email', $email)->get()->getRow();
            if (!$user) {
                //return redirect()->to('web/resetpassword')->with('error', 'Email not found.');
                $data['error'] = 'Email not found.';
                return view('web/resetpassword', $data);
            }
            $token = bin2hex(random_bytes(16)); // Generate a random token
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $resettoken = new ResettokenModel();
            $resettoken->save([
                'user_id' => $user->UserId,
                'token' => $token,
                'created_at' => $expiry,
            ]);

            $resetLink = site_url("user/reset_password/$token");
            $email = \Config\Services::email();
            $email->setTo($this->request->getPost('email'));
            $email->setFrom('myemail@gmail.com', 'EWMS');
            $email->setSubject('Password Reset Link');

            $email->setMessage("Click the following link to reset your password: $resetLink");
            $email->send();
        }
        $data['error'] = 'Email has been sent.';
        return view('web/resetpassword', $data);
    }

    public function reset_password($token) {
        helper('form');
        $resettokenmodel = new ResettokenModel();
        $resetToken = $resettokenmodel->where('token', $token)->get()->getRow();

        if (!$resetToken) {
            //return redirect()->to('user/resetpassword')->with('error', 'Invalid reset token.');
            $data['error'] = 'Invalid token.';
            return view('web/resetpassword', $data);
        }

        $expiryTime = strtotime($resetToken->created_at);
        if ($expiryTime < time()) {
            $data['error'] = 'Token has been expired.';
            return view('web/resetpassword', $data);
        }
        $data['token'] = $token;
        return view('web/reset_password_form', $data);
    }

    public function save_reset_password() {
        helper('form');
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'token' => 'required',
                'new_password' => 'required|min_length[6]', // Adjust validation rules as needed
            ];
            $token = $this->request->getPost('token');
            $data['token'] = $token;
            if (!$this->validate($rules)) {
                return view('web/reset_password_form', $data); // Reload the form with validation errors
            }

            $resettokenmodel = new ResettokenModel();
            $resetToken = $resettokenmodel->where('token', $token)->get()->getRow();

            if (!$resetToken) {
                $data['error'] = 'Invalid reset token.';
                return view('user/reset_password_form', $data);
            }

            $expiryTime = strtotime($resetToken->created_at);
            if ($expiryTime < time()) {
                $data['error'] = 'Reset token has expired.';
                return view('user/reset_password_form', $data);
            }
            $newPassword = $this->request->getPost('new_password');
            $usermodel = new UserModel();
            $usermodel->update(['UserId' => $resetToken->user_id], ['Password' => $newPassword]);
            $resettokenmodel->where('token', $token)->delete();
            //return redirect()->to('user/login')->with('success', 'Password reset successfully.');
            $data['error'] = 'Password reset successfully.';
            return view('sys/login', $data);
            //return view('sys/login', $data);
        }
    }

    public function adminSendResetLink() {
        helper(['form', 'url']);

        $data = []; // Initialize an array to hold data to be passed to views

        if ($this->request->getMethod() == 'post') {
            $userId = $this->request->getPost('userId');

            $userModel = new UserModel();
            $user = $userModel->find($userId);

            if (!$user) {
                $data['error'] = 'User not found.';
                return view('sys/reset_password', $data); // Assume 'sys/reset_password' is your admin reset password view
            }

            $token = bin2hex(random_bytes(16)); // Generate a random token
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $resetTokenModel = new ResettokenModel();
            $resetTokenSaved = $resetTokenModel->save([
                'user_id' => $user['UserId'], // Ensure this matches your column name
                'token' => $token,
                'created_at' => $expiry,
            ]);

            if (!$resetTokenSaved) {
                $data['error'] = 'Failed to generate reset token.';
                return view('sys/reset_password', $data);
            }

            $resetLink = site_url("user/reset_password/$token");

            $email = \Config\Services::email();
            $email->setTo($user['email']); // Adjust according to your column names
            $email->setFrom('myemail@gmail.com', 'Admin');
            $email->setSubject('Admin-Initiated Password Reset Request');
            $email->setMessage("An admin has initiated a password reset request for your account. Click the following link to reset your password within the next hour: $resetLink");

            if ($email->send()) {
                $data['success'] = 'Reset link sent successfully.';
            } else {
                $data['error'] = 'Failed to send reset link.';
            }
        }

        // Assuming 'sys/reset_password' is your view for admin to send reset links
        //return view('sys/reset_password', $data);
        //return redirect()->to('sys/viewUserMgt')->with('success', 'Password reset successfully.');


        session()->setFlashdata('success', 'Password reset successfully.');
        return redirect()->to('sys/viewUserMgt');
    }

}
