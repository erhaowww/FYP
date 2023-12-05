<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;
use App\Repositories\OrderRepository;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $paymentRepository;
    protected $orderRepository;

    public function __construct(PaymentRepository $paymentRepository, OrderRepository $orderRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        // Define the time periods
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        $totalSalesThisWeek = $this->paymentRepository->getTotalPaymentsForPeriod($startOfWeek, $endOfWeek);
        $totalSalesLastWeek = $this->paymentRepository->getTotalPaymentsForPeriod($startOfLastWeek, $endOfLastWeek);
        $totalOrdersThisWeek = $this->orderRepository->getTotalOrdersForPeriod($startOfWeek, $endOfWeek);
        $totalOrdersLastWeek = $this->orderRepository->getTotalOrdersForPeriod($startOfLastWeek, $endOfLastWeek);

        $salesChange = $this->calculatePercentageChange($totalSalesThisWeek, $totalSalesLastWeek);
        $ordersChange = $this->calculatePercentageChange($totalOrdersThisWeek, $totalOrdersLastWeek);

        $statistics = $this->getSalesOrderStatistics();

        return view('admin.dashboard', compact(
            'totalSalesThisWeek', 
            'totalSalesLastWeek', 
            'salesChange', 
            'totalOrdersThisWeek', 
            'totalOrdersLastWeek', 
            'ordersChange', 
            'statistics'
        ));
    }
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : 100;
        }
        return (($current - $previous) / $previous) * 100;
    }
    private function getSalesOrderStatistics()
    {
        $paymentsData = $this->paymentRepository->getPaymentsForLastSevenDays();
        $ordersData = $this->orderRepository->getOrdersForLastSevenDays();
    
        $statistics = [
            'dates' => [],
            'sales' => [],
            'orders' => []
        ];
    
        for ($date = Carbon::now()->subDays(6); $date->lte(Carbon::now()); $date->addDay()) {
            $formattedDate = $date->format('d/m');
            $statistics['dates'][] = $formattedDate;
            $statistics['sales'][] = $paymentsData[$formattedDate]->total ?? 0;
            $statistics['orders'][] = $ordersData[$formattedDate]->total ?? 0;
        }
    
        return $statistics;
    }
    
}
