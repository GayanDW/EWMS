    


public function login() {
        helper('form');
        $data = [];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required',
                'password' => 'required'
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $userModel = new UserModel();
                $user = $userModel->where('UserName', $username)->first();

                if ($user) {
                    if ($user['is_verified'] == 0) {
// User is not verified
                        $data['error'] = 'Your account is not verified. Please check your email for the verification link.';
                    } else if (password_verify($password, $user['Password'])) {
// Valid user and password
// Perform login actions here (e.g., setting session data)
// Assuming you set user data in session after successful login
                        session()->set([
                            'UserId' => $user['UserId'],
                            'UserName' => $user['UserName'],
                            'UserType' => $user['UserType'],
                            'isLoggedIn' => true
                        ]);
                        return redirect()->to('/dashboard'); // Redirect to dashboard or relevant page
                    } else {
// Invalid password
                        $data['error'] = 'Invalid login credentials. Please try again.';
                    }
                } else {
// User not found
                    $data['error'] = 'User does not exist.';
                }
            } else {
// Validation failed
                $data['error'] = 'Please enter both username and password.';
            }
        }

// Load the view with or without error messages
        echo view('sys/login', $data);
    }
    
