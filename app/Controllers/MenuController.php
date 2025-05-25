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
            'status'    => 200,
            'message'   => 'Here is the Menu for Today!',
            'data'      => $menuModel->findAll()
        ]);
    }

}

