<?php
namespace App\Repositories;
use App\Models\Delivery;
use Illuminate\Support\Facades\Log;

use App\Repositories\Interfaces\DeliveryRepositoryInterface;
class DeliveryRepository implements DeliveryRepositoryInterface
{
    public function create(array $data)
    {
        return Delivery::create([
            'orderId' => $data['orderId'],
            'estimatedDeliveryDate' => $data['estimatedDeliveryDate'],
            'deliveryManName' => null,
            'deliveryManPhone' => null,
            'deliveryCompany' => null,
            'actualDeliveryDate' => null,
        ]);
    }

    public function getDeliveryById($deliveryId)
    {
        return Delivery::findOrFail($deliveryId);
    }

    public function getDeliveryByOrderId($orderId)
    {
        return Delivery::where('orderId', $orderId)->first();
    }

}
