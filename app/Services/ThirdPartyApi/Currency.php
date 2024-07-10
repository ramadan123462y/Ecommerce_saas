<?php


namespace App\Services\ThirdPartyApi;

use Illuminate\Support\Facades\Http;


class Currency
{

    private $url;
    private $api_key;

    public function __construct()
    {

        $this->url = env('Url_currency');
        $this->api_key = env('Apikey_currency');
    }

    public function get_currency($currency)
    {
        $response =  Http::get($this->url . '?apikey=' . $this->api_key);
        return $response['data'][$currency];
    }
}
