<?php

namespace App\Models;

use App\Observers\OrderItemObserve;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [

        'order_id',
        'product_id',
        'product_name',
        'price',
        'quintitie',

    ];

    public function order()
    {

        return $this->belongsTo(Order::class);
    }

    public static function booted()
    {

        static::observe(new OrderItemObserve());
    }
}
