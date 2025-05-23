<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;

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
    $data = $this->request->getPost();
    $menuModel = new MenuModel();
    $menuModel->insert($data);

    return $this->respondCreated([
        'message' => 'Menu item created successfully',
        'item' => $data
    ]);
}

