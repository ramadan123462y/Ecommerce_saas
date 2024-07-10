<?php

namespace App\Services\ThirdPartyApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paypal
{

    public $token;

    public function auth_token($user_name, $password)
    {


        $token = Http::asForm()->withBasicAuth(
            $user_name,
            $password
        )->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ])['access_token'];
        $this->token = $token;
        return $this;
    }

    public function scope()
    {


        $token2 = Http::withToken(
            $this->token
        )->get('https://api-m.sandbox.paypal.com/v1/oauth2/token');

        return $this;
    }

    public function create_order($data)
    {


        $response = Http::withToken($this->token)->withHeaders([
            'Content-Type' => 'application/json',

        ])->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $data);



        return $response->json();


    }



    public function paypal_getstatus($user_name, $password, $id_order = '63444382M2599673V')
    {
        $this->auth_token($user_name, $password);
        $this->scope();
        $response = Http::withToken($this->token)->get(
            "https://api-m.sandbox.paypal.com/v2/checkout/orders/$id_order",
        );

        
        return $response->json();
    }


    public function paypal_callback(Request $request)
    {

        return $request;
    }
}
