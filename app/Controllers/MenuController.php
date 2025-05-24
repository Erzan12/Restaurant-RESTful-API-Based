<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MenuModel;

class MenuController extends ResourceController 
{
    public function index()
    {
        $menuModel = new MenuModel();
        return $this->respond([
            'status' => 200,
            'data' => $menuModel->findAll()
        ]);
    }

    public function create()
    {
        $menuModel = new MenuModel();
        $data = $this->request->getJSON();

        if(!$menuModel->insert($data)) {
            return $this->respond([
                'errors' => $userModel->errors()
            ], 400);
        };

        return $this->respondCreated([
            'message' => 'Menu item created successfully',
            'item' => $data
        ]);
    }

}

