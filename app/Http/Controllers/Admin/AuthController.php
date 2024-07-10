<?php

namespace App\Http\Controllers\Admin;

use App\Charts\StoresChart;
use App\Events\Vertification;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Store;
use App\Models\User;
use App\Notifications\Verificationcode;
use App\Services\ThirdPartyApi\Whatsapp;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function index_login()
    {

        return view('Backend.Admin.login');
    }

    public function dashboard(StoresChart $chart)
    {

       
        // return $unreadNotifications;




        // die;

        $store = Store::select('active', DB::raw('count(*)  as count'))->groupBy('active')->get();
        $unactive = $store[0]['count'];
        $active = $store[1]['count'];

        return view('Backend.Admin.index', ['chart' => $chart->build($unactive, $active), 'active' => $active, 'unactive' => $unactive]);
    }

    public function login(Request $request)
    {

        // validation

        $request->validate([

            'email' => 'required',
            'password' => 'required',
        ]);
        $status = Auth::guard('admin')->attempt([

            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$status) {

            flash()->addError('Data Not Found To Admin');
            return redirect()->back();
        }

        $admin = Admin::where('email', $request->email)->first();
        $code_rand = rand(1000, 9999);
        $admin->verificationcode()->updateOrCreate([

            'admin_id'   => $admin->id,
        ], [

            'otp' => $code_rand,
            'expire_at' => Carbon::now()->addMinutes(10),
        ]);


        // $admin->notify(new Verificationcode($code_rand));
        event(new Vertification($admin, $code_rand));
        // $whatsapp = new Whatsapp();
        // $whatsapp->send_message($code_rand);
        return redirect('admin/verificationcode')->with('admin_id_to_code', $admin->id);
    }

    public function verificationcode()
    {
        $admin_id_to_code = Session::get('admin_id_to_code');

        return view('Backend.Admin.verificationcode', compact('admin_id_to_code'));
    }

    public function check_verificationcode(Request $request)
    {
        if (isset($request->code)) {

            $code = $request->code;
        } else {

            $code = implode('', $request->number);
        }
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $verificationcode = $admin->verificationcode()->latest()->first();

        if ($code != $verificationcode->otp) {
            flash()->addError('Your OTP is not correct');
            return redirect()->back();
        }
        $verificationcode->update([

            'otp' => null
        ]);

        return redirect('admin/dashboard');
    }

    // login with socail
    public function redirect($driver)
    {

        return Socialite::driver("$driver")->redirect();
    }

    public function callback($driver)
    {

        $user = Socialite::driver($driver)->user();

        $admin = Admin::where('email', $user->email)->first();

        if (!isset($admin)) {
            flash()->addError('Data Not Found To Admin');
            return redirect('admin/login');
        }

        Auth::guard('admin')->login($admin);

        return redirect('admin/dashboard');
    }

    public function logout()
    {

        Auth::guard('admin')->logout();
        flash()->addSuccess('Logout SucessFully');
        return redirect('admin/login');
    }
}
