<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use function App\Http\Helpers\store;

class OrderRepo
{

    public function find($id)
    {

        return Order::findorfail($id);
    }

    public function store($cart, $adress)
    {

        $order = Order::create([
            'user_id' =>Auth::guard('web')->user()->id,
            'adress_id' => $adress->id,
            'store_id' => store()->id,
            'total' => $cart->subtotal
        ]);
        return $order;
    }

    public  function order_item($order,$item)
    {


        OrderItem::create([

            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'product_name' => $item->product_name,
            'price' => $item->subtotal,
            'quintitie' => $item->quantity,

        ]);
    }
}
