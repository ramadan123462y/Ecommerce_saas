<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\error;

class CheckStore
{

    public function handle(Request $request, Closure $next): Response
    {


        $domain = explode('.', $request->host());
        $sub_domain =  $domain[0];



        $store = Store::where('sub_domain', $sub_domain)->first();
        if (isset($store)) {
            App::instance('store', $store);
            return $next($request);
        } else {
            return abort(500, 'Server Erorr');
        }
    }
}
