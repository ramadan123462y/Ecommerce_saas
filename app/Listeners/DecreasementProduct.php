<?php

namespace App\Listeners;

use App\Events\MakeOrder;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecreasementProduct
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MakeOrder $event): void
    {
        foreach ($event->cart->cart_items as $item) {

            $product =  Product::find($item->product_id);

            $product->update([
                'quantity' => ($product->quantity) - ($item->quantity)
            ]);
        }
    }
}
