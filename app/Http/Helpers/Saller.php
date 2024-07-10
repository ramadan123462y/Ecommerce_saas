<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

// get store Saller

if (!function_exists('store_saller')) {
    function store_saller()
    {
        $user = Auth::guard('saller')->user();
        $store = $user->store;
        return $store;
    }
}
if (!function_exists('saller')) {
    function saller()
    {
        $saller = Auth::guard('saller')->user();

        return $saller;
    }
}

// get store
if (!function_exists('store')) {
    function store()
    {

        $store = App::make('store');
        return $store;
    }
}
// get customer
if (!function_exists('user_auth')) {
    function user_auth()
    {

        $user = Auth::guard('web')->user();
        return $user;
    }
}
