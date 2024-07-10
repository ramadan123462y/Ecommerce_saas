<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\ReturnTypePass;

use function App\Http\Helpers\store;
use function App\Http\Helpers\store_saller;

class OrderController extends Controller
{

    public function index()
    {

        $orders =  Order::with('user')->get();


        return view('Backend.Saller.orders', compact('orders'));
    }

    public function order($order_id)
    {
        $order=Order::where('id',$order_id)->with('user', 'orderitems')->first();

        $order_sum = $order->orderitems()->selectraw('SUM(price * quintitie) as sum_price')->first();

        return view('Backend.Saller.Orderdetails', compact('order','order_sum'));
    }
}
