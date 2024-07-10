<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $guards = ['web', 'admin', 'saller'];

        foreach ($guards as $guard) {

            if ($guard == 'saller'  && Auth::guard($guard)->check()) {


                return redirect('saller/dashboard');
            } elseif ($guard == 'admin'  && Auth::guard($guard)->check()) {

                $admin = Admin::find(Auth::guard('admin')->user()->id)->first();

                if ($admin->verificationcode()->latest()->first()->otp == null) {

                    return redirect('admin/dashboard');
                }
                return $next($request);
            }
        }
        return $next($request);
    }
}
