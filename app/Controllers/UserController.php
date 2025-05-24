<?php

namespace App\Controllers;

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

    public function getUser($id)
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
        // // get user from the usermodel
        // $userModel = new UserModel();
        // // get data from the request (assuming JSON body)
        // $data = $this->request->getJSON();

        // if (!$data) {
        //     return $this->failValidationError('Invalid data provided');
        // }

        // //check if the user exists
        // $user = $userModel->find($id);
        // if (!$user) {
        //     return $this->failNotfound('User not found');
        // }


        // // if ($userModel->update($id, [
        // //     'name' => $data->name ?? $user['name'],
        // //     'email' => $data->email ?? $user['email'],
        // // ])) {
        // //     $updatedUser = $userModel->find($id);
        // //     return $this->respond([
        // //         'message' => 'User updated successfully',
        // //         'update_user' => $data,
        // //         'modified_at' => $updatedUser['modified_at'] ?? null,
        // //     ], 200);
        // // } 
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if(!$user) {
            return $this->failNotFound('User not found');
        }

        $data = $this->request->getJSON(true);

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
