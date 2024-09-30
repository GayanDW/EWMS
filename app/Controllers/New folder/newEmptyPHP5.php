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