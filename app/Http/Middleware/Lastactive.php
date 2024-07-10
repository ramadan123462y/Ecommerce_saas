<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Lastactive
{


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // _____________________________________     action      _______________
    public function handle(Request $request, Closure $next): Response
    {


        if (Auth::guard('web')->check()) {

            User::find(Auth::guard('web')->user()->id)->update([



                'last_active' => Carbon::now()
            ]);
        }


        return $next($request);
    }
}
