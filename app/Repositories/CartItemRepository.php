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

}
