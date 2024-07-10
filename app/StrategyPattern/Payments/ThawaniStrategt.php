<?php

namespace App\StrategyPattern\Payments;

use App\Facades\ThawaniFacade;
use App\Models\Order;
use App\Models\Transaction;
use App\Notifications\MakeOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Http\Helpers\store;

class ThawaniStrategt implements PaymentStrategyInterface
{

    public function create_order($payment_method, $order, $request = null)
    {
        $json_success_url = url('api/callback_sucess', $order->id);

        $json_cancel_url = url('api/callback_error', $order->id);
        $token = $payment_method->pivot['api_key'];

        $json_data = '{
            "client_reference_id": "123412",
            "mode": "payment",
            "products": [
              {
                "name": "product 1",
                "quantity": 1,
                "unit_amount": "' . $order->total . '"
              }
            ],
            "success_url": "' . $json_success_url . '",
            "cancel_url": "' . $json_cancel_url . '",
            "metadata": {
              "Customer name": "somename",
              "order id": 0
            }
          }';

        $response = ThawaniFacade::create_order($json_data);


        if (($response->json())['success'] == false) {

            sweetalert()->addError($response->json()['description']);
            return redirect()->back();
        }
        $response = $response->json();

        $transaction = Transaction::create([
            'store_id' => store()->id,
            'order_id' => $order->id,
            'total' => $order->total,
            'id_payment' => $response['data']['session_id']
        ]);
        $session_id = $response['data']['session_id'];
        return redirect()->to("https://uatcheckout.thawani.om/pay/$session_id?key=HGvTMLDssJghr9tlN9gr4DVYt0qyBy");
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
        $user = $order->user;


        $user->notify(new MakeOrderNotification($order));
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
