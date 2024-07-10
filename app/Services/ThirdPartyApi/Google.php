<?php

namespace App\Services\ThirdPartyApi;

use App\Services\ThirdPartyApi\Intefaces\SocailLoginInterface;
use Illuminate\Support\Facades\Http;

class Google implements SocailLoginInterface
{

    function authorize()
    {


        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI');


        return  redirect("https://accounts.google.com/o/oauth2/auth?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=email profile");
    }
    function callback($request)
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
                'redirect_uri' => $redirectUri

            ]

        );

        return json_decode($response, true)['access_token'];
    }
}
