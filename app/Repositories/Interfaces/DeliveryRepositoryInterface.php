<?php
namespace App\Repositories\Interfaces;
interface DeliveryRepositoryInterface
{
    public function create(array $data);
    public function getDeliveryById($deliveryId);
    public function getDeliveryByOrderId($orderId);
}
