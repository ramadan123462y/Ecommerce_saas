<?php

namespace App\Services\ThirdPartyApi;

use App\Services\ThirdPartyApi\Intefaces\SocailLoginInterface;
use Illuminate\Support\Facades\Http;

class Github implements SocailLoginInterface
{

    
    public function authorize()
    {

        $client_id = env('GITHUB_CLIENT_ID');
        $redirect_uri = env('GITHUB_REDIRECT_URI');

        return Http::get("https://github.com/login/oauth/authorize?scope=user:email&client_id=$client_id&response_type=code&redirect_uri=$redirect_uri");
    }

    public function callback($request)
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
}
