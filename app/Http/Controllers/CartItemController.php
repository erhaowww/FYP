<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
use Auth;
use App\Models\Product;

class CartItemController extends Controller
{
    protected $cartItemRepository;

    public function __construct(CartItemRepositoryInterface $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'productId' => 'required|exists:product,id',
            'color' => 'required',
            'size' => 'required',
            'num-product' => 'required|integer|min:1'
        ]);
        
        $product = Product::find($validatedData['productId']);
        if (!$product) {
            return back()->withErrors(['Product not found.']);
        }

        // Calculate the subPrice
        $subPrice = number_format($product->price * $validatedData['num-product'], 2, '.', '');

        $existingCartItem = $this->cartItemRepository->findExistingCartItem(
            $validatedData['productId'], 
            Auth::id(), 
            $validatedData['color'], 
            $validatedData['size']
        );
    
        $newQuantity = $validatedData['num-product'];
    
        if ($existingCartItem) {
            $totalQuantity = $existingCartItem->quantity + $newQuantity;
            
            $maxQuantityAllowed = $request->maxProductQuantity;

            if ($totalQuantity > $maxQuantityAllowed) {
                return response()->json(['error' => 'The item in your cart already reaches the maximum of stock.'], 422);
            }else{
                $subPrice = number_format($product->price * $totalQuantity, 2, '.', '');
                // Update existing cart item quantity
                $existingCartItem->quantity = $totalQuantity;
                $existingCartItem->save();
            }
        } else {
            // Create new cart item if not already exists
            $subPrice = number_format($product->price * $newQuantity, 2, '.', '');
    
            $data = [
                'productId' => $validatedData['productId'],
                'userId' => Auth::id(),
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'quantity' => $newQuantity,
            ];
    
            $this->cartItemRepository->addToCart($data);
        }
        $cartItems = $this->cartItemRepository->getByUserId(Auth::id());
        $totalPrice =  $this->cartItemRepository->updateTotal(Auth::id());

        // Render the cart items view with the necessary data
        $cartItemsHtml = view('user.partials.cart_items', [
            'cartItems' => $cartItems,
            'totalPrice' => number_format($totalPrice, 2)
        ])->render();

        return response()->json([
            'cartItemsHtml' => $cartItemsHtml,
            'newTotalPrice' => number_format($totalPrice, 2)
        ]);
    }

    public function removeItem(Request $request)
    {
        $itemId = $request->input('itemId');
        $userId = auth()->id(); // Or however you get the user's ID

        $newTotal = $this->cartItemRepository->removeItemAndUpdateTotal($itemId, $userId);

        return response()->json(['success' => 'Item removed successfully', 'newTotal' => $newTotal]);
    }
    
    public function showCart()
    {
        // Assuming the user is authenticated and cart items are associated with the user.
        $userId = Auth::id();

        // Fetch cart items for the user
        $cartItems = $this->cartItemRepository->getByUserId($userId);
        // Calculate the total price
        $totalPrice = $cartItems->reduce(function ($total, $cartItem) {
            return $total + ($cartItem->quantity * $cartItem->product->price);
        }, 0);

        // Return the cart view with cart items and total price
        return view('/user/cart', [
            'cartItems' => $cartItems,
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    }

    public function updateItem(Request $request)
    {
        $cartItem = $this->cartItemRepository->updateQuantity($request->itemId, $request->quantity);
        $newSubPrice = number_format($cartItem->quantity * $cartItem->product->price, 2);
        $itemTotalPrice =  $this->cartItemRepository->updateTotal(Auth::id());
        $shippingCost = 5;
        $discount = 10;
        $totalPrice = $itemTotalPrice + $shippingCost - $discount;
        return response()->json([
            'success' => true,
            'newSubPrice' => number_format($newSubPrice, 2),
            'itemTotalPrice' => number_format($itemTotalPrice, 2),
            'shippingCost' => number_format($shippingCost, 2),
            'discount' => number_format($discount, 2),
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    }

}

