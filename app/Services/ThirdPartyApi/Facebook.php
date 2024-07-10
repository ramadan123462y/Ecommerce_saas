<?php

namespace App\Services\ThirdPartyApi;

use App\Services\ThirdPartyApi\Intefaces\SocailLoginInterface;
use Illuminate\Support\Facades\Http;

class Facebook implements SocailLoginInterface
{


    function authorize()
    {

        $clientId = env('FACEBOOK_CLIENT_ID');
        $clientSecret = env('FACEBOOK_CLIENT_SECRET');
        $redirectUri = env('FACEBOOK_REDIRECT_URI');
        return redirect("https://www.facebook.com/v14.0/dialog/oauth?client_id=$clientId&redirect_uri=$redirectUri&scope=email&response_type=code");
    }
    function callback($request)
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
}
