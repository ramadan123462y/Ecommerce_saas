<?php

namespace App\StrategyPattern\Payments;

use App\Events\MakeOrder;
use App\Facades\MyFatoorahFacade;
use App\Models\Order;
use App\Models\Transaction;
use Error;

use function App\Http\Helpers\store;
use function Laravel\Prompts\error;

use Illuminate\Http\Request;

class MyfatoorahStrategy implements PaymentStrategyInterface
{


    public function create_order($payment_method, $order, $request = null)
    {

        $token = $payment_method->pivot['api_key'];
        $data = [
            'InvoiceValue' => $order->total,
            'PaymentMethodId' => $request->payment_method_id,
            'CallBackUrl' => url('api/callback_sucess',$order->id),
            'ErrorUrl' => url('api/callback_error',$order->id),
        ];
        $response = MyFatoorahFacade::myfatoorah_ExecutePayment($data, $token);
        $tranaction =  Transaction::create([
            'store_id' => store()->id,
            'order_id' => $order->id,
            'total' => $order->total,

        ]);

        $url = $response['PaymentURL'];
        return redirect()->to($url);
    }

    public function callback_sucess(Request $request, $id_order)
    {

        $order = Order::find($id_order);
        //    ['pending','sucess','rejicted']
        $order->update([
            'status' => 'sucess',
        ]);

        Transaction::create([

            'store_id' => $order->store_id,
            'order_id' => $order->id,
            'total' => $order->total,
            'id_payment' => $request['paymentId'],
            'status' => 'complete'
        ]);

        sweetalert()->addSuccess('Paid Sucessfully');
        return redirect()->back();

    }
    public function callback_error(Request $request, $id_order)
    {

        $order = Order::find($id_order);
        //    ['pending','sucess','rejicted']
        $order->update([
            'status' => 'rejicted',
        ]);
        // ['pending', 'complete', 'failed']
        Transaction::create([

            'store_id' => $order->store_id,
            'order_id' => $order->id,
            'total' => $order->total,
            'id_payment' => $request['paymentId'],
            'status' => 'failed'
        ]);

        sweetalert()->addError('Error To paid');
        return redirect()->back();
    }
}
