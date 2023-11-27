<?php
namespace App\Repositories\Interfaces;
interface OrderRepositoryInterface
{
    public function create(array $data);
    public function getOrderById($orderId);
    public function markOrderAsCompleted($orderId);
}
