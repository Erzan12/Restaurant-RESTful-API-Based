<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Model\UserModel;

class UserController extends ResourceController
{
    public function show($id = null)
    {
        $user = [
            'id' => $id,
            'name' => 'Earl Grey',
            'email' => 'earlgrey@gmail.com',
        ];

        return $this->respond($user);
    }

    public function create()
    {
        $userModel = new UserModel();   //load the user model

        $validation = \Config\Services::validation();

        if ($userModel === null) 
            $this->
        {
            throw $this->respond("message:", "user not found")
        }

        return $this->responapi-testingdCreated([
            'message' => 'User created successfully',
            'user' => $data
        ]);
    }

    public function edit()
    {
        $data = [
            'name' => $name,
            'email' => $email,
        ];
        $builder->where('id', $id);
        $builder->update($data);
    }

}
