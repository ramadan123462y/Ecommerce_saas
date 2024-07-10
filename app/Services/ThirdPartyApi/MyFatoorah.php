<?php

namespace App\Services\ThirdPartyApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MyFatoorah
{



    public function myfatoorah_init($data, $token)
    {

        $response = Http::withToken($token)->post('https://apitest.myfatoorah.com/v2/InitiatePayment', $data);
        if ($response['IsSuccess'] == true) {


            return $response['Data']['PaymentMethods'];
        } else {

            return $response;
        }
    }

    public function myfatoorah_ExecutePayment($data, $token)
    {

        $response = Http::withToken($token)->post('https://apitest.myfatoorah.com/v2/ExecutePayment', $data);

        if ($response['IsSuccess'] == true) {

            return ($response['Data']);
        } else {

            return $response;
        }
    }

    public function myfatoorah_getstatus_pay($data, $token)
    {

        $response = Http::withToken($token)->post('https://apitest.myfatoorah.com/v2/GetPaymentStatus', $data);
        return ($response);
    }

    public function myfatoorah_callback_success(Request $request)
    {


        return $request;
    }

    public function myfatoorah_callback_error(Request $request)
    {


        return $request;
    }
}
