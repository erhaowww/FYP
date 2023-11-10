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
            \Log::info("Total Quantity: {$totalQuantity}, Max Allowed: {$request->maxProductQuantity}");

            if ($totalQuantity > $maxQuantityAllowed) {
                return response()->json(['error' => 'The item in your cart already reaches the maximum of stock.'], 422);
            }else{
                $subPrice = number_format($product->price * $totalQuantity, 2, '.', '');
                // Update existing cart item quantity
                $existingCartItem->quantity = $totalQuantity;
                $existingCartItem->subPrice = $subPrice;
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
                'subPrice' => $subPrice,
            ];
    
            $this->cartItemRepository->addToCart($data);
        }
    
        return back()->with('success', 'Product added to cart.');
    }
}

