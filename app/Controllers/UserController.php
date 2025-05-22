<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    public function getAllUsers()
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

    public function getUser()
    {
        $userModel = new UserModel();
        $user = $userModel->find($uId);

        return $this->respond($user);
    }

    public function create()
    {
        $userModel = new UserModel();   //load the user model
        $data = $this->request->getJSON(true);

        // Model Based Validation
        if ($userModel->save($data)) {
            $userId = $userModel->getInsertID();
            $user = $userModel->find($userId);
            return $this->respondCreated([
                'message' => 'User created successfully',
                'save_user' => $user
            ]);
            }else{
                return $this->respond([
                    'errors' => $userModel->errors(),
                ], 400);
            }

                    // controller based validation
        // $rules = [
        //             'name'     => 'required|is_unique[users.name]',
        //             'email'    => 'required|valid_email|is_unique[users.email]',
        //             'password' => 'required|min_length[6]',
        //         ];


        // if ($this->validateData($data, $rules)) {
        //     $userModel->save($data);
        //     return $this->respondCreated([
        //         'message' => 'User created successfully',
        //         'user' => $data
        //     ]);
        // }else{
        //     return $this->respond([
        //         'errors' => $userModel->getErrors(),
        //     ], 400);
        // }

    }

    public function put()
    {
        $data = [
            'name' => $name,
            'email' => $email,
        ];
        $builder->where('id', $id);
        $builder->update($data);
    }

}
