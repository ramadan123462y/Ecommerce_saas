<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (!Auth::guard('admin')->check()) {
            flash()->addError('Data Not Found To Admin');
            return redirect('admin/login');
        }

        $admin = Admin::find(Auth::guard('admin')->user()->id)->first();
        if (!$admin->verificationcode()->latest()->first()->otp == null) {

            flash()->addError('Enter Code To Login');
            return redirect('admin/verificationcode');
        }

        return $next($request);
    }
}
