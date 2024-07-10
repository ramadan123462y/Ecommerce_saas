<?php

namespace App\Listeners;

use App\Events\MakeOrder;
use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class DeletCart
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

        Cart::where('user_id', Auth::guard('web')->user()->id)->delete();
    }
}
