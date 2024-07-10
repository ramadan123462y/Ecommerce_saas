<?php

namespace App\StrategyPattern\Payments;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

use function App\Http\Helpers\store;

class StripeStrategy implements PaymentStrategyInterface
{


    public function create_order($payment_method, $order, $request = null)
    {


        // $stripeSecretKey = 'sk_test_51OGFp7Evd2hjvArxE2bYitZGI4UncbETPHZR4OmXzaK59U4cV4g0AJx4TCAkN423uy7wspSBq7DKDOuAygkWRnlp00qAACJiRA';
        $stripeSecretKey = $payment_method->pivot['api_key'];
        \Stripe\Stripe::setApiKey($stripeSecretKey);


        $stripeProduct = \Stripe\Product::create([
            'name' => 'Payment',
            'description' => 'Payment',
        ]);

        // إنشاء السعر للمنتج في Stripe
        $stripePrice = \Stripe\Price::create([
            'product' => $stripeProduct->id,
            'unit_amount' => $order->total * 1000, // تحويل السعر إلى سنتات
            'currency' => 'EGP',
        ]);

        $response = \Stripe\Checkout\Session::create([
            'line_items' => [

                [
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' =>  $stripePrice->id,
                    'quantity' => 1,
                ]

            ],
            'mode' => 'payment',
            'success_url' => url('api/callback_sucess', $order->id),
            'cancel_url' => url('api/callback_error', $order->id),
        ]);


        $transaction = Transaction::create([
            'store_id' => store()->id,
            'order_id' => $order->id,
            'total' => $order->total,
            'id_payment' => $response->id
        ]);
        return redirect()->to($response->url);
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
        dd(false);
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
