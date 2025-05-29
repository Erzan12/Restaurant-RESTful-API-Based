<?php

namespace App\Controllers;

use App\Controllers\ResourceController;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class OrdersController extends BaseController
{
    public function showMenu()
    {
        $menuModel = new MenuModel();
        $menuItems = $menuModel->findAll();

        return $this->respondCreated()->setJSON([
            'status' => 200,
            'message' => 'Operation Successful',
            'data' => $menuItems,
        ]);
        //
    }

    public function showOrders()
    {
        $orderModel = new OrderModel();
        $orderData = $orderModel->findAll();

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Operation Successful',
            'data' => $orderData
        ]);
    }

    public function createOrder()
    {
        $request = service('request');
        $data = $request->getJSON(true);//for raw JSON input

        //validate input
        if (!isset($data['items']) || !is_array($data['items'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid or missing items in request.'
            ]);
        }

        $customerId = uniqid('cust__', true); //simulate a customer id
        $orderModel = new OrderModel();

        $orderData = [
            'customer_id' => $customerId,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $orderId = $orderModel->insert($orderData, true);

        //save order items(assuming OrderItemMOdel)
        $orderItemModel = new OrderItemModel();
        foreach ($data['items'] as $item) {
            $orderItemModel->insert([
                'order_id' => $orderId,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity']
            ]);
        }

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'customer_id' => $customerId,
            'order_id' => $orderId
        ]);
    }
}
