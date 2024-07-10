<?php

namespace App\Observers;

use App\Models\Cart;
use App\Models\OrderItem;

class OrderItemObserve
{
    /**
     * Handle the OrderItem "created" event.
     */
    public function created(OrderItem $orderItem): void
    {
        // Cart::Cookie()->delete();
    }


}
