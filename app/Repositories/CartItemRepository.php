<?php
namespace App\Repositories;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
class CartItemRepository implements CartItemRepositoryInterface
{
    
    public function addToCart(array $data)
    {
        return CartItem::create($data);
    }

    public function findExistingCartItem($productId, $userId, $color, $size)
    {
        return CartItem::where([
            'productId' => $productId,
            'userId' => $userId,
            'color' => $color,
            'size' => $size
        ])->first();
    }
    
    public function getByUserId($userId)
    {
        return CartItem::with('product')
                   ->where('userId', $userId)
                   ->get();
    }

    public function deleteById($itemId)
    {
        return CartItem::destroy($itemId);
    }

    public function removeItemAndUpdateTotal($itemId, $userId)
    {
        CartItem::destroy($itemId);

        return $this->updateTotal($userId);
    }
    public function updateTotal($userId){
        $newTotal = CartItem::where('userId', $userId)
                            ->join('product', 'cart_item.productId', '=', 'product.id')
                            ->sum(\DB::raw('cart_item.quantity * product.price'));

        return $newTotal;
    }
    public function updateQuantity($itemId, $quantity)
    {
        $cartItem = CartItem::find($itemId);
        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $cartItem;
    }
}
