<?php
namespace App\Repositories\Interfaces;
interface CartItemRepositoryInterface
{
    public function addToCart(array $data);
    public function findExistingCartItem($productId, $userId, $color, $size);
}
