<?php

namespace App\Controllers;

use App\Controllers\ResourceController;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class CustomerController extends BaseController
{
    public function checkOrderStatus($customer_id = null)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->where('customer_id',$customer_id)->find();

        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'No orders found for this customer.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Here is the status of your order!',
            'data' => $order
        ]);
        //
    }
    public function checkSpecificOrderStatus($order_id = null)
    {
        //validated order id if it exist
        if (!$order_id) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Order ID is required.'
            ]);
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($order_id);

        //validate order if it exist
        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Order not found.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'order_id' => $order_id,
                'message' => $order['status']
            ]
            ]);
        //
    }
    public function updateOrder($customer_id = null)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($customer_id);

        if(!$order) {
            return $this->failNotFound('Order not found');
        }

        $data = $this->request->getJSON(true);
        $firstItem = $data['items'][0];
        $firstItem['updated_at'] = date('Y-m-d H:i:s');

        $orderItemModel = new OrderItemModel();
        $updated = $orderItemModel
            ->where('customer_id', $customer_id)
            ->set($data)
            ->update();

        if ($updated) {
            $updatedOrder = $orderItemModel->where('customer_id', $customer_id)->first();
            return $this->respond([
                'message' => 'Order updated successfully',
                'update_order' => [
                    'customer_id' => $customer_id,
                    'menu_item_id' => $updatedOrder['menu_item_id'],
                    'quantity' => $updatedOrder['quantity'],
                    'updated_at' => $updatedOrder['updated_at'],
                ]
            ]);
        } else {
            return $this->failValidationErrors($orderItemModel->errors());
        }
    }
}
