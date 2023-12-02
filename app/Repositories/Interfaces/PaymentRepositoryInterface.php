<?php
namespace App\Repositories\Interfaces;
interface PaymentRepositoryInterface
{
    public function create(array $data);
    public function getPaymentById($paymentId);
    public function getPaymentByOrderId($orderId);
    public function getAllPaymentsWithOrdersByUserId($userId);
    public function getAllPayments();
    public function getAllPaymentsWithOrders();
}
