<?php


namespace App\StrategyPattern\Payments;

use App\Facades\PaypalFacade;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

use function App\Http\Helpers\store;

class PaypalStrategy implements PaymentStrategyInterface
{


    public function create_order($payment_method, $order, $request = null)
    {

        $user_name = $payment_method->pivot['user_name'];
        $password = $payment_method->pivot['password'];
        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total
                    ]
                ]
            ],
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "brand_name" => "EXAMPLE INC",
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        "user_action" => "PAY_NOW",
                        "return_url" => url('api/callback_sucess', $order->id),
                        "cancel_url" => url('api/callback_error', $order->id)
                    ]
                ]
            ]
        ];
        $response = PaypalFacade::auth_token($user_name, $password)->scope()->create_order($data);

        $transaction = Transaction::create([
            'store_id' => store()->id,
            'order_id' => $order->id,
            'total' => $order->total,
            'id_payment' => $response['id']
        ]);

        return redirect()->to($response['links'][1]['href']);
    }
    public function callback_sucess(Request $request, $id_order)
    {



        $order = Order::find($id_order);
        //    ['pending','sucess','rejicted']
        $order->update([
            'status' => 'sucess',
        ]);

        Transaction::create([

            'store_id' => store()->id,
            'order_id' => $order->id,
            'total' => $order->total,
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
            'status' => 'failed'
        ]);

          sweetalert()->addError('Error To paid');
          return redirect()->back();
    }
}
