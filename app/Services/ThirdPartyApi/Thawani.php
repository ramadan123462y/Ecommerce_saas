<?php

namespace App\Services\ThirdPartyApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Thawani
{



    public function create_order($json_data, $api_key = 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et', $publish_key = 'HGvTMLDssJghr9tlN9gr4DVYt0qyBy')
    {

        $data = json_decode($json_data, true);

        $response = Http::withHeaders(['thawani-api-key' => $api_key])
            ->post('https://uatcheckout.thawani.om/api/v1/checkout/session', $data);


        return $response;
    }

    public function checkout($session_id, $publish_key)
    {
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
}
