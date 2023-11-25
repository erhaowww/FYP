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
            'orderStatus' => OrderStatus::Pending,
            'orderDate' => $data['orderDate'],
        ]);
    }

    public function getOrderById($orderId)
    {
        return Order::findOrFail($orderId);
    }
}
