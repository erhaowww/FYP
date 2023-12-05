<?php
namespace App\Repositories;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
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
    
    public function getAllPaymentsWithOrdersByUserId($userId)
    {
        return Payment::with('order')
                  ->where('userId', $userId)
                  ->orderBy('paymentDate', 'desc')
                  ->get();
    }

    public function getAllPayments()
    {
        return Payment::all();
    }

    public function getAllPaymentsWithOrders()
    {
        return Payment::with('order')
                  ->get();
    }
    public function getTotalPaymentsForPeriod($start, $end)
    {
        return Payment::whereBetween('paymentDate', [$start, $end])->sum('totalPaymentFee');
    }
    
    public function getPaymentsForLastSevenDays()
    {
        return Payment::select(\DB::raw("DATE_FORMAT(paymentDate, '%d/%m') as date"), \DB::raw('SUM(totalPaymentFee) as total'))
            ->whereBetween('paymentDate', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('paymentDate')
            ->get()
            ->keyBy('date');
    }
}
