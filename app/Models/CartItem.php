<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_item';
    protected $fillable = [
        'productId',
        'userId',
        'color',
        'size',
        'quantity',
        'subPrice'
    ];
}
