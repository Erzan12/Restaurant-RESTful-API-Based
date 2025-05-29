<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\MenuModel;

class CategoryController extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $menuModel = 'App\Models\MenuModel';
    protected $format    = 'json';

    public function index()
    {
        $categoryModel = new CategoryModel();
        return $this->respond([
            'status'    => 200,
            'message'   => ' Here are the Menu Categories!',
            'data'      => $categoryModel->findAll()
        ]);
    }

    public function show($id = null)
    {
        $categoryModel = new CategoryModel();
        $menuModel = new MenuModel();

        $category = $categoryModel->find($id);

        if (!$category) {
            return $this->failNotFound('Category not found.');
        }

        $menuItems = $menuModel->where('category_id', $id)->findAll();

        return $this->respond([
            'category' => $category,
            'menu_items' => $menuItems
        ]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $category_id = $data->category_id;

        //validate if category name has an input
        if (!isset($data->name) || empty($data->name)) {
            return $this->failValidationError('Category name is required.');
        }if (!isset($data->description) || empty($data->description)) {
            return $this->failValidationError('Category description is required.');
        }

        $this->model->insert([
            'name' => $data->name,
            'description' => $data->description ?? null,
            'category_id' => $category_id,
        ]);

        return $this->respondCreated(['status' => 'Category has been added!']);
    }

    
    public function delete($id = null)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            return $this->failNotFound('Category not found');
        }
        if ($categoryModel->delete($id)) {
            return $this->respond([
                'message' => "Category '{$category['name']}' has been deleted.",
                'category'    => $category
            ]);
        } else {
            return $this->failServerError('Failed to delete a user');
        }
    }

}

