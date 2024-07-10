<?php

namespace App\Services\ThirdPartyApi;

use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\Http;

class PayMob
{

    public $token;
    public $order_id;
    public $key;

    public function __construct()
    {
    }

    public function auth_token(string $api_key)
    {
        $token = Http::post(
            "https://accept.paymob.com/api/auth/tokens",
            ["api_key" => $api_key]
        )['token'];
        $this->token = $token;
        return $this;
    }
    public function create_order($jsonString)
    {
        $data = json_decode($jsonString, true);


        $datamerged =  array_merge($data, ["auth_token" => "$this->token"]);

        $order_id = Http::post("https://accept.paymob.com/api/ecommerce/orders", $datamerged)['id'];
        $this->order_id = $order_id;
        return array('object' => $this, 'order_id' => $this->order_id);
    }


    public function create_key($jsonString)
    {

        $data = json_decode($jsonString, true);

        $datamerged =  array_merge($data, ["auth_token" => "$this->token", "order_id" => "$this->order_id"]);


        $key = Http::post("https://accept.paymob.com/api/acceptance/payment_keys", $datamerged)['token'];
        $this->key = $key;
        return $this;
    }

    public function Paywith_card($id_frame = '836864')
    {

        return redirect()->to("https://accept.paymob.com/api/acceptance/iframes/$id_frame?payment_token=$this->key");
    }
    public function Paywith_wallet($user_phone)
    {

        $url =  Http::post(
            'https://accept.paymob.com/api/acceptance/payments/pay',

            [
                'source' => [
                    "identifier" => $user_phone,
                    'subtype' => "WALLET"
                ],
                "payment_token" => $this->key
            ]
        );

        return redirect($url['iframe_redirection_url']);
    }

    public function callback(Request $request)
    {

        return $request;
    }

    public function webhooke(Request $request)
    {

        return $request;
    }
    // to card ____________

    // PayMobFacade::auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_card();
    // return $paymob->auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_wallet('01010101010');

    // to Wallet ____________

    // PayMobFacade::auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_wallet('01010101010');
    // return $paymob->auth_token($api_key)->create_order($jsonString_order)->create_key($jsonString_key)->Paywith_card();
}
