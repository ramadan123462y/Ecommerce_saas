<?php

namespace App\Http\Controllers;

use App\Facades\CurrencyFacade;
use App\Facades\MyFatoorahFacade;
use App\Facades\PayMobFacade;
use App\Facades\PaypalFacade;
use App\Facades\ThawaniFacade;
use App\Jobs\ImportProducts;
use App\Models\Categorie;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Store;
use App\Models\Subscrubtion;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\MakeOrderNotification;
use App\Services\ThirdPartyApi\Currency;
use App\Services\ThirdPartyApi\MyFatoorah;
use App\Services\ThirdPartyApi\PayMob;
use App\Services\ThirdPartyApi\Thawani;
use Carbon\Carbon;
use COM;
use GrahamCampbell\ResultType\Success;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Str;

use function App\Http\Helpers\store;
use function App\Http\Helpers\store_saller;
use function Laravel\Prompts\error;

class Dashboardcontroller extends Controller
{



    // _____________________________________________ My paymob _______________________________

    public function testing()
    {
        $api_key = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2T1RZNU5qZ3lMQ0p1WVcxbElqb2lNVGN4T1RFek5USTVPQzR6TXpVNU1pSjkuRWlCcm95aExnQUgxSWowQzJWU2V0ejNNOTMzeDk0LTF5b01fSy1oQUdqeFpSeDh5RkhVNmpnYkpOalBkLWJQWS1Lbm5kbG1NUVZOQ3QtaldHR09xa2c=";


        $plan = Plan::find(1);

        $jsonString_order = '{

                                    "delivery_needed": "false",
                                    "amount_cents": "' . $plan->price . '",
                                    "currency": "EGP",
                                    "items": [
                                    ]
                                    }';
        $jsonString_key = '{
                                        "amount_cents": "' . $plan->price . '",
                                        "expiration": 3600,
                                        "billing_data": {
                                        "apartment": "803",
                                        "email": "eee@exa.com",
                                        "floor": "42",
                                        "first_name": "ee",
                                        "street": "ee Land",
                                        "building": "8028",
                                        "phone_number": "+86(8)9135210487",
                                        "shipping_method": "PKG",
                                        "postal_code": "01898",
                                        "city": "Jaskolskiburgh",
                                        "country": "CR",
                                        "last_name": "Nicolas",
                                        "state": "Utah"
                                        },
                                        "currency": "EGP",
                                        "integration_id": 4599196

                                    }';
        // $paymob = new PayMob();

        $paymob = PayMobFacade::auth_token($api_key)->create_order($jsonString_order);
        $payment_id = $paymob['order_id'];
        return $paymob['object']->create_key($jsonString_key)->Paywith_card();
        die;

        //    ->create_key($jsonString_key)->Paywith_card();
        return  PayMobFacade::auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_wallet('01010101010');
        // return $paymob->auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_wallet('01010101010');
        // return $paymob->auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_card();

    }

































    public function callback(Request $request)
    {

        $data = [

            'success' => $request->success,
            'integration_id' => $request->integration_id
        ];
        return $data;
    }

    public function webhooke_baymob(request $request)
    {

        return $request;
    }
    // _____________________________________________ My Fatoorah_______________________________

    public function myfatoorah_init()
    {
        $data = [
            'InvoiceAmount' => 200,
            'CurrencyIso' => 'EGP'
        ];
        $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

        return MyFatoorahFacade::myfatoorah_init($data, $token);
    }

    public function myfatoorah_ExecutePayment()
    {

        $data = [
            'InvoiceValue' => 200,
            'PaymentMethodId' => 2,
            'CallBackUrl' => url('api/callback_sucess(Request $request)'),
            'ErrorUrl' => url('api/callback_error'),
        ];
        $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        return MyFatoorahFacade::myfatoorah_ExecutePayment($data, $token);
    }


    public function myfatoorah_getstatus_pay()
    {
        $data = [

            'Key' => '07074066962206330872',
            'KeyType' => 'PaymentId',
        ];
        $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

        return MyFatoorahFacade::myfatoorah_getstatus_pay($data, $token);
    }

    public function myfatoorah_callback_success(Request $request)
    {


        return MyFatoorahFacade::myfatoorah_callback_success();
    }

    public function myfatoorah_callback_error(Request $request)
    {


        return MyFatoorahFacade::myfatoorah_callback_error($request);
    }

    // _____________________________________________ My Fatoorah _______________________________


    public function paypal()
    {

        $user_name = 'AYanSFgrSuLORPAsaIqhvsKe_Eib1wSbMxy4FXbRDDBIPqAyIspa1g3JkmZIKxnAz5jcg5O3hhBq9OBn';
        $password = 'EOb-lfyBE9VnLU5ztZA46A0JrB64k23MsqHayFcDKmPfm03SNhThRRipNfRmXlx1G8O_ghOGjxgtMEVm';
        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
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
                        "return_url" => "http://localhost:8000/api/paypal_callback",
                        "cancel_url" => "https://example.com/cancelUrl"
                    ]
                ]
            ]
        ];

        $data = PaypalFacade::auth_token($user_name, $password)->scope()->create_order($data);
        return $data['links'][1]['href'];


        return PaypalFacade::paypal_getstatus();


        die;


        $token1 = Http::asForm()->withBasicAuth(
            'AYanSFgrSuLORPAsaIqhvsKe_Eib1wSbMxy4FXbRDDBIPqAyIspa1g3JkmZIKxnAz5jcg5O3hhBq9OBn',
            'EOb-lfyBE9VnLU5ztZA46A0JrB64k23MsqHayFcDKmPfm03SNhThRRipNfRmXlx1G8O_ghOGjxgtMEVm'
        )->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ])['access_token'];

        // _______________________________

        $token2 = Http::withToken(
            $token1
        )->get('https://api-m.sandbox.paypal.com/v1/oauth2/token');
        // return $token2;
        // ________________________________



        $url = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
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
                        "return_url" => "http://localhost:8000/api/paypal_callback",
                        "cancel_url" => "https://example.com/cancelUrl"
                    ]
                ]
            ]
        ];

        $response = Http::withToken($token1)->withHeaders([
            'Content-Type' => 'application/json',

        ])->post($url, $data);



        return $response->json();
    }


    public function paypal_callback(Request $request)
    {

        return $request;
    }

    public function paypal_getstatus()
    {

        // 63444382M2599673V

        $token1 = Http::asForm()->withBasicAuth(
            'AYanSFgrSuLORPAsaIqhvsKe_Eib1wSbMxy4FXbRDDBIPqAyIspa1g3JkmZIKxnAz5jcg5O3hhBq9OBn',
            'EOb-lfyBE9VnLU5ztZA46A0JrB64k23MsqHayFcDKmPfm03SNhThRRipNfRmXlx1G8O_ghOGjxgtMEVm'
        )->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ])['access_token'];


        // _______________________________

        $token2 = Http::withToken(
            $token1
        )->get('https://api-m.sandbox.paypal.com/v1/oauth2/token');

        $response = Http::withToken($token1)->get(
            'https://api-m.sandbox.paypal.com/v2/checkout/orders/63444382M2599673V',
        );

        // إعادة الاستجابة كـ JSON
        return $response->json();
    }

    public function thawani()
    {

        $json_data = '{
  "client_reference_id": "123412",
  "mode": "payment",
  "products": [
    {
      "name": "product 1",
      "quantity": 1,
      "unit_amount": 100
    }
  ],
  "success_url": "http://localhost:8000/api/thawani_callback__success",
  "cancel_url": "http://localhost:8000/api/thawani_callback__error",
  "metadata": {
    "Customer name": "somename",
    "order id": 0
  }
}';

        // $thawani = new Thawani();
        // $results = $thawani->create_order($json_data);
        // return $results;

        return ThawaniFacade::create_order($json_data);
        die;

        $data = json_decode($json_data, true);

        $response = Http::withHeaders(['thawani-api-key' => 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et'])
            ->post('https://uatcheckout.thawani.om/api/v1/checkout/session', $data);
        $session_id = ($response->json())['data']['session_id'];
        // return $session_id;


        return redirect()->to("https://uatcheckout.thawani.om/pay/$session_id?key=HGvTMLDssJghr9tlN9gr4DVYt0qyBy");
    }

    public function thawani_callback__success(Request $request)
    {

        return $request;
    }
    public function thawani_callback__error(Request $request)
    {
        return $request;
    }


    public function stripe()
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
    public function stripe_callback_error(Request $request)
    {

        return $request;
    }

    // github auth
    public function login_withgithub()
    {
        $client_id = env('GITHUB_CLIENT_ID');
        $redirect_uri = env('GITHUB_REDIRECT_URI');

        return redirect("https://github.com/login/oauth/authorize?scope=user:email&client_id=$client_id&response_type=code&redirect_uri=$redirect_uri");
    }

    public function callback_loginsocial(Request $request)
    {

        $client_id = env('GITHUB_CLIENT_ID');
        $client_secret = env('GITHUB_CLIENT_SECRET');
        $redirect_uri = env('GITHUB_REDIRECT_URI');
        $response = Http::accept('application/json')->post('https://github.com/login/oauth/access_token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $request->code,
            'redirect_uri' => $redirect_uri,
            'state' => $request->state,
        ]);

        $accessToken = json_decode($response, true)['access_token'];
        return $accessToken;
    }

    public function login_withfacebook()
    {
        $clientId = env('FACEBOOK_CLIENT_ID');
        $clientSecret = env('FACEBOOK_CLIENT_SECRET');
        $redirectUri = env('FACEBOOK_REDIRECT_URI');
        return redirect("https://www.facebook.com/v14.0/dialog/oauth?client_id=$clientId&redirect_uri=$redirectUri&scope=email&response_type=code");
    }

    public function callback_login_facebook(Request $request)
    {
        $clientId = env('FACEBOOK_CLIENT_ID');
        $clientSecret = env('FACEBOOK_CLIENT_SECRET');
        $redirectUri = env('FACEBOOK_REDIRECT_URI');
        $response =   Http::acceptJson()->post(
            'https://graph.facebook.com/v14.0/oauth/access_token',
            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $request->code,
                'redirect_uri' => $redirectUri,
            ]
        );
        return json_decode($response, true)['access_token'];
    }



    public function login_with_google()
    {

        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI');


        return  redirect("https://accounts.google.com/o/oauth2/auth?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=email profile");
    }
    public function callback_with_google(Request $request)
    {

        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI');
        $response =   Http::acceptJson()->post(
            'https://oauth2.googleapis.com/token',

            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $request->code,
                'grant_type' => 'authorization_code',
                'redirect_uri'=>$redirectUri

            ]

        );

        return json_decode($response,true)['access_token'];
    }
}
