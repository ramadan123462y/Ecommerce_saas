<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginSaller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (Auth::guard('saller')->check()) {

            $saller = Auth::guard('saller')->user();

            $domain = explode('.', $request->host());
            $sub_domain =  $domain[0];


            if ($sub_domain == $saller->store->sub_domain) {

                return $next($request);
            } else {




                return redirect('saller/login');
            }
        } else {


            return redirect('saller/login');
        }
    }
}
