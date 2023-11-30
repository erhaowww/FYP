<?php
namespace App\Repositories;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Log;

use App\Repositories\Interfaces\OrderRepositoryInterface;
class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data)
    {
        return Order::create([
            'cartItemIds' => $data['cartItemIds'],
            'userId' => $data['userId'],
            'deliveryAddress' => $data['deliveryAddress'],
            'orderStatus' => OrderStatus::Confirmed,
            'orderDate' => $data['orderDate'],
        ]);
    }

    public function getOrderById($orderId)
    {
        return Order::findOrFail($orderId);
    }

    public function updateStatus($orderId, $status)
    {
        $order = $this->getOrderById($orderId);
        $order->orderStatus = $status;
        $order->save();

        return $order;
    }

    public function getAllOrdersWithDeliveries()
    {
        $orders = Order::with('delivery')->get();
        return $orders;
    }
    public function getOrdersAndDeliveriesById($id)
    {
        $order = Order::whereHas('delivery', function ($query) use ($id) {
            $query->where('id', $id);
        })->with('delivery')->first();
        return $order;
    }
    
}
