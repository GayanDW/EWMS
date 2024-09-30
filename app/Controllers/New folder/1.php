        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstName' => ['label' => 'First Name', 'rules' => 'required'],
                'lastName' => ['label' => 'Last Name', 'rules' => 'required'],
                'contactNumber' => ['label' => 'Contact Number', 'rules' => 'required|exact_length[10]|numeric'],
                'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                'streetAddress' => ['label' => 'Street Address', 'rules' => 'required'],
                'city' => ['label' => 'City', 'rules' => 'required'],
                'district' => ['label' => 'District', 'rules' => 'required'],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[user.UserName]|alpha_dash|min_length[4]'],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[^ ]+$/]',
                    'errors' => [
                        'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                    ]
                ],
                'confirm_password' => ['label' => 'Confirm Password', 'rules' => 'required|matches[password]'],
                'profile_image' => ['label' => 'Profile Image', 'rules' => 'required|uploaded[profile_image]|max_size[profile_image,2048]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png]'],
                'AccountNumber' => ['label' => 'Account Number', 'rules' => 'required'],
                'AccountName' => ['label' => 'Account Name', 'rules' => 'required'],
                'BankName' => ['label' => 'Bank Name', 'rules' => 'required'],
                'BranchName' => ['label' => 'Branch Name', 'rules' => 'required'],
            ];
            
            
            