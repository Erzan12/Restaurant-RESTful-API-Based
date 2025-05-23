<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class AuthController extends ResourceController
{
    public function userLogin()
    {
        $data = (array) $this->request->getJSON();
        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->failUnauthorized('Invalid email or password');
        }

        $issuedAt = time();
        $expiration = $issuedAt + 3600;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiration,
            'uid' => $user['id'],
            'email' => $user['email']
        ];

        $token = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
    
        unset($user['password']);
        unset($user['created_at'], $user['updated_at'], $user['modified_at']);

        return $this->respond([
            'message' => 'login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function registerUser()
    {
        $userModel = new UserModel();   
        $data = (array) $this->request->getJSON();

        if (!$userModel->insert($data)) {
            return $this->respond([
                'errors' => $userModel->errors()
            ], 400);
        }

        $user = $userModel->where('email', $data['email'])->first();
        unset($user['password']);

        return $this->respondCreated([
            'message' => 'User created successfully',
            'save_user' => $user
        ]);
    // $userId = $userModel->getInsertID();
        // $user = $userModel->find($userId);
        // unset($user['password']);
        // //hide password from showing in api respond
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
}
