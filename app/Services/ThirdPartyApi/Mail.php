<?php

namespace App\Services\ThirdPartyApi;

use Illuminate\Support\Facades\Http;



class Mail
{

    public function send_mail($json)
    {


        $json = '{"from":{"email":"mailtrap@example.com","name":"Mailtrap Test"},"to":[{"email":"ramadanmohamedasd82@gmail.com"}],
                "subject":"You are awesome!",
                "text":"Congrats for sending test email with Mailtrap!",
                ,"category":"Integration Test"}';



        $response =   Http::withToken('46b02e9c8acc602093de257f25e3f1e4')->post(
            'https://sandbox.api.mailtrap.io/api/send/2994426',
            json_decode($json)
        );
        return $response;
    }
}
