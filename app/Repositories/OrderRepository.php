<?php
namespace App\Repositories;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
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
    
    public function getAllOrders()
    {
        return Order::all();
    }
    public function getTotalOrdersForPeriod($start, $end)
    {
        return Order::whereBetween('created_at', [$start, $end])->count();
    }
    public function getOrdersForLastSevenDays()
    {
        return Order::select(\DB::raw("DATE_FORMAT(created_at, '%d/%m') as date"), \DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('created_at')
            ->get()
            ->keyBy('date');
    }
}
