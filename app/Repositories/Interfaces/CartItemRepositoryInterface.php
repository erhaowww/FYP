<?php
namespace App\Repositories\Interfaces;
interface CartItemRepositoryInterface
{
    public function addToCart(array $data);
    public function findExistingCartItem($productId, $userId, $color, $size);
    public function getByUserId($userId);
    public function deleteById($itemId);
    public function removeItemAndUpdateTotal($itemId, $userId);
    public function updateTotal($userId);
    public function updateQuantity($itemId, $quantity);
}
