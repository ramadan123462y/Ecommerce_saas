<?php

namespace App\StrategyPattern\Payments;

use Illuminate\Http\Request;

interface PaymentStrategyInterface
{


    function create_order($payment_method, $order, $request = null);
    function callback_sucess(Request $request, $id_order);
    function callback_error(Request $request, $id_order);
}
