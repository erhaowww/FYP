<?php
namespace App\Repositories;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
class PaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $data)
    {
        return Payment::create([
            'orderId' => $data['orderId'],
            'userId' => $data['userId'],
            'paymentMethod' => $data['paymentMethod'],
            'paymentDate' => $data['paymentDate'],
            'totalPaymentFee' => $data['totalPaymentFee'],
            'transactionId' => $data['transactionId'],
        ]);
    }

    public function getPaymentById($paymentId)
    {
        return Payment::findOrFail($paymentId);
    }

    public function getPaymentByOrderId($orderId)
    {
        return Payment::where('orderId', $orderId)->first();
    }

}
