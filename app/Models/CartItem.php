<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtotal',
        'quantity',
        'cart_id',
        'product_id',
        'product_name'
    ];


    public function cart()
    {

        return $this->belongsTo(Cart::class);
    }

    public function product()
    {

        return $this->belongsTo(Product::class);
    }
}
