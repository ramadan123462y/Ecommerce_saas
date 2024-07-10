<?php

namespace App\Services\ThirdPartyApi;

use Illuminate\Http\Request;

class Stripe
{


    public function create_order()
    {


        $stripeSecretKey = 'sk_test_51OGFp7Evd2hjvArxE2bYitZGI4UncbETPHZR4OmXzaK59U4cV4g0AJx4TCAkN423uy7wspSBq7DKDOuAygkWRnlp00qAACJiRA';
        \Stripe\Stripe::setApiKey($stripeSecretKey);


        $stripeProduct = \Stripe\Product::create([
            'name' => 'jdfgj',
            'description' => 'dkafhja',
        ]);

        // إنشاء السعر للمنتج في Stripe
        $stripePrice = \Stripe\Price::create([
            'product' => $stripeProduct->id,
            'unit_amount' => 10000 * 100, // تحويل السعر إلى سنتات
            'currency' => 'EGP',
        ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [

                [
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' =>  $stripePrice->id,
                    'quantity' => 1,
                ]

            ],
            'mode' => 'payment',
            'success_url' => 'https://www.google.com.eg/?hl=ar',
            'cancel_url' => 'https://www.google.com.eg/?hl=ar',
        ]);

        return redirect()->to($checkout_session->url);
    }

    public function stripe_callback_success(Request $request)
    {


        return $request;
    }
    public function stripe_callback_faild(Request $request)
    {


        return $request;
    }
}
