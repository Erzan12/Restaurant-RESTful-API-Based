<!-- 
    // public function update($id = null)
    // {

    //     $userModel = new UserModel();
    //     $user = $userModel->find($id);

    //     if(!$user) {
    //         return $this->failNotFound('User not found');
    //     }

    //     $data = $this->request->getJSON(true);

    //     //working validation but only email is_unique i want to make it both name and email
    //     $rules = [
    //         'name'  => 'required|min_length[3]',
    //     ];

    //     if ($this->request->getPost('email') !== $user['email']) {
    //         $rules['email'] = "required|valid_email|is_unique[users.email,id,{$id}]";
    //     } else {
    //         $rules['email'] = 'required|valid_email';
    //     }

    //     if (!$this->validate($rules)) {
    //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     $data['modified_at'] = date('Y-m-d H:i:s');

    //     if ($userModel->update($id, $data)) {
    //         $updatedUser = $userModel->find($id);
    //         return $this->respond([
    //             'message'   => 'User updated successfully',
    //             'update_user' => [
    //                 'name'          => $updatedUser['name'],
    //                 'email'         => $updatedUser['email'],
    //                 'modified_at'   => $updatedUser['modified_at'],
    //             ]
    //         ], 200);
    //     } else{
    //         return $this->fail([
    //             'error' => 'Update failed',
    //             'details' => $userModel->errors()
    //         ]);
    //     }
    // } -->