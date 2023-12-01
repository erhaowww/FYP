<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Enums\CartItemStatus;
use App\Enums\OrderStatus;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\MembershipRepositoryInterface;
use Session;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $deliveryRepository;
    protected $paymentRepository;
    protected $cartItemRepository;
    private $userRepository;
    private $membershipRepository;
    protected $productRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OrderRepositoryInterface $orderRepository, 
        DeliveryRepositoryInterface $deliveryRepository, 
        PaymentRepositoryInterface $paymentRepository,
        CartItemRepositoryInterface $cartItemRepository,
        ProductRepositoryInterface $productRepository,
        MembershipRepositoryInterface $membershipRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->paymentRepository = $paymentRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->userRepository = $userRepository;
        $this->membershipRepository = $membershipRepository;
        $this->productRepository = $productRepository;
    }

    public function store(Request $request, PaymentController $paymentController)
    {
        $validatedData = $request->validate([
            'transactionId' => 'required|string',
            'cartItemIds' => 'required|string',
            'deliveryAddress' => 'required|string',
        ]);
        
        if ($request->input('paymentType') == 'creditCard') {
            $paymentResponse = $paymentController->processPayment($request);
            $paymentResult = json_decode($paymentResponse->getContent(), true);
            if (!$paymentResult['success']) {
                return response()->json(['success' => false, 'message' => $paymentResult['message']]);
            }
        }
        $validatedData['userId'] = Auth::id();

        // Set order date to current date and time
        $validatedData['orderDate'] = Carbon::now();

        // Calculate estimated delivery date
        $eastMalaysiaStates = ['Sabah', 'Sarawak', 'Labuan']; // Define East Malaysia states
        $isEastMalaysia = in_array($request->input('state'), $eastMalaysiaStates);
        $estimatedDeliveryDays = $isEastMalaysia ? 14 : 7;
        $validatedData['estiDeliveryDate'] = Carbon::now()->addDays($estimatedDeliveryDays);

        try {
            $order = $this->orderRepository->create($validatedData);
            Log::info('Order created successfully:', ['orderId' => $order->id]);

            $deliveryData = [
                'orderId' => $order->id,
                'estimatedDeliveryDate' => Carbon::now()->addDays($estimatedDeliveryDays),
            ];
            $paymentData = [
                'orderId' => $order->id,
                'userId' => Auth::id(),
                'transactionId' => $validatedData['transactionId'],
                'paymentMethod' => $request->input('paymentType'),
                'paymentDate' => Carbon::now(),
                'totalPaymentFee' => $request->input('totalPrice')
            ];

            $cartItemIds = explode('|', $request->input('cartItemIds'));
            foreach ($cartItemIds as $cartItemId) {
                // Update cart item status
                $this->cartItemRepository->updateStatus($cartItemId, CartItemStatus::purchased->value);

                // Retrieve the cart item to get product details
                $cartItem = $this->cartItemRepository->getById($cartItemId);
                if ($cartItem) {
                    // Deduct product stock
                    $this->productRepository->updateStock($cartItem->productId, $cartItem->color, $cartItem->size, $cartItem->quantity);
                }
            }

            $this->deliveryRepository->create($deliveryData);
            $this->paymentRepository->create($paymentData);
            $this->userRepository->updateUserTotalSpent($request->input('totalPrice'), auth()->user()->id);
            
            return response()->json([
                'success' => true,
                'orderId' => $order->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating order'
            ], 500);
        }
    }

    public function track($orderId)
    {
        $order = $this->orderRepository->getOrderById($orderId);
        $delivery = $this->deliveryRepository->getDeliveryByOrderId($orderId);
        $payment = $this->paymentRepository->getPaymentByOrderId($orderId);

        $cartItemIds = explode('|', $order->cartItemIds);

        $cartItems = $this->cartItemRepository->getByIds($cartItemIds, CartItemStatus::purchased->value);

        $memberships = $this->membershipRepository->allMembership();
        $membership_level = '';
        foreach ($memberships as $membership) {
            if (auth()->user()->total_spent >= $membership->totalAmount_spent) {
                $membership_level = $membership->level;
            } 
        }
        if(auth()->user()->membership_level != $membership_level) {
            //upgrade membership level
            $this->userRepository->updateUserMembership($membership_level, auth()->user()->id);
            Session::flash('membership_upgrade_message', 'Congratulations, you have been upgraded to '.$membership_level.' membership level!');
        }

        // Pass all data to the view
        return view('user.tracking', [
            'order' => $order,
            'delivery' => $delivery,
            'payment' => $payment,
            'cartItems' => $cartItems,
            'orderStatus' => OrderStatus::cases()
        ]);
    }

    public function markOrderReceived($orderId)
    {
        $this->orderRepository->markOrderAsCompleted($orderId);

        return redirect()->back()->with('success', 'Order marked as received.');
    }

}

