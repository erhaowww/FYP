<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\CartItemStatus;
use App\Enums\OrderStatus;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
class DeliveryController extends Controller
{
    protected $deliveryRepository;
    protected $orderRepository;
    protected $cartItemRepository;
    public function __construct(DeliveryRepositoryInterface $deliveryRepository, OrderRepositoryInterface $orderRepository, CartItemRepositoryInterface $cartItemRepository) {
        $this->deliveryRepository = $deliveryRepository;
        $this->orderRepository = $orderRepository;
        $this->cartItemRepository = $cartItemRepository;
    }
    public function displayAllDeliveryData()
    {
        $ordersWithDeliveries = $this->orderRepository->getAllOrdersWithDeliveries();
        return view('/admin/all-delivery', ['ordersWithDeliveries' => $ordersWithDeliveries]);
        
    }

    public function edit($id)
    {
        $ordersWithDelivery = $this->orderRepository->getOrdersAndDeliveriesById($id);
        $cartItemIds = explode('|', $ordersWithDelivery->cartItemIds);

        $allGroupedCartItems = collect();
    
        $cartItems = $this->cartItemRepository->getByIds($cartItemIds, CartItemStatus::purchased);
        $groupedCartItems = $cartItems->groupBy('productId');
        $allGroupedCartItems[$ordersWithDelivery->id] = $groupedCartItems;
            
        return view('/admin/edit-delivery', [
            'ordersWithDelivery' => $ordersWithDelivery,
            'allGroupedCartItems' => $allGroupedCartItems,
        ]);
        
    }
    
    public function update(Request $request, $id)
    {
        $order = $this->orderRepository->updateStatus($id,$request->input('orderStatus'));
        $delivery = $this->deliveryRepository->getDeliveryByOrderId($order->id);

        if ($request->input('orderStatus') === OrderStatus::CourierPicked->value) {
            $deliveryData = [
                'deliveryManName' => $request->input('deliveryManName'),
                'deliveryManPhone' => $request->input('deliveryManPhone'),
                'deliveryCompany' => $request->input('deliveryCompany'),
            ];
            $this->deliveryRepository->updateDeliveryManData($delivery->id, $deliveryData);
        }else if($request->input('orderStatus') === OrderStatus::ReadyForPickup->value){
            $currentDateTime = Carbon::now();
            $this->deliveryRepository->updateActualDeliveryDate($delivery->id, $currentDateTime);
        }
        return redirect()->route('all-delivery')->with('success', 'Delivery  & Order updated successfully.');
    }
}
