<?php

namespace App\Services\ThirdPartyApi;

use Twilio\Rest\Client;


class Whatsapp
{


    public function send_message($code)
    {

        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                "whatsapp:+201091087457", // to
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => "Your verification code is".$code
                )
            );

        // print($message->sid);
    }
}
