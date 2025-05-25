<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    

    public function index()
    {
        $userModel = new UserModel();
        $user = $userModel->findAll();
        if (!empty($user)) {
            return $this->respond($user);
        }else{
            return $this->respond([
                'message' => 'No users found',
                'errors' => '204 (No Content)'
            ]);
        }
    }

    public function getUser($id = null)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if(!$user) {
            return $this->failNotFound('User not found');
        }

        return $this->respond($user);
    }

    public function update($id = null)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if(!$user) {
            return $this->failNotFound('User not found');
        }

        $data = $this->request->getJSON(true);

        // // to be fix error in validation | BUGGY code
        // $rules = [
        //     'name' => 'required|min_length[3]',
        //     'email' => 'required|valid_email',
        // ];

        // // Check if name has changed → apply `is_unique` rule
        // if ($this->request->getPost('name') !== $user['name']) {
        //     $rules['name'] .= "|is_unique[users.name,id,{$id}]";
        // }

        // // Check if email has changed → apply `is_unique` rule
        // if ($this->request->getPost('email') !== $user['email']) {
        //     $rules['email'] .= "|is_unique[users.email,id,{$id}]";
        // }

        // // Validate
        // if (!$this->validate($rules)) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

        // 

        $data['modified_at'] = date('Y-m-d H:i:s');

        if ($userModel->update($id, $data)) {
            $updatedUser = $userModel->find($id);
            return $this->respond([
                'message'   => 'User updated successfully',
                'update_user' => [
                    'name'          => $updatedUser['name'],
                    'email'         => $updatedUser['email'],
                    'modified_at'   => $updatedUser['modified_at'],
                ]
            ], 200);
        } else{
            return $this->fail([
                'error' => 'Update failed',
                'details' => $userModel->errors()
            ]);
        }
    }
    public function delete($id = null)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }
        if ($userModel->delete($id)){
            return $this->respond([
                'message' => "User '{$user['name']}' has been deleted.",
                'user' => $user
            ]);
        } else {
            return $this->failServerError('Failed to delete user');
        }
    }

}
