<?php

namespace App\Controllers\Admin;

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

    public function create()
    {
        $menuModel  = new MenuModel();
        $data       = $this->request->getJSON();

        if(!$menuModel->insert($data)) {
            return $this->respond([
                'errors' => $userModel->errors()
            ], 400);
        };

        return $this->respondCreated([
            'message'   => 'Menu item created successfully',
            'item'      => $data
        ]);
    }

    public function update($id = null)
    {
        $menuModel  = new MenuModel();
        $menu       = $menuModel->find($id);

        if(!$menu) {
            return $this->failNotFound('Menu not found');
        }

        $data = $this->request->getJSON(true);

        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($menuModel->update($id, $data)) {
            $updatedMenu = $menuModel->find($id);
            return $this->respond([
                'message'       => 'Menu updated successfully',
                'updated_menu'  => [
                    'name'          => $updatedMenu['name'],
                    'description'   => $updatedMenu['description'],
                    'status'        => $updatedMenu['status'],
                    'updated_at'    => $updatedMenu['updated_at'],
                ]
                ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        $menuModel  = new MenuModel();
        $menu       = $menuModel->find($id);

        if (!$menu) {
            return $this->failNotFound('Menu not found');
        }
        if ($menuModel->delete($id)){
            return $this->respond([
                'message'   => "Menu '{$menu['name']}' has been removed.",
                'menu'      => $menu
            ]);
        } else {
            return $this->failServerError('Failed to remove a menu');
        }
    }

}

