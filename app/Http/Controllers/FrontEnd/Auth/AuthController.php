<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function App\Http\Helpers\store;

class AuthController extends Controller
{
    public function index_register()
    {

        return view('Frontend.Templete.Register');

    }

    public function store(Request $request)
    {

        $user_status = Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        if (!$user_status) {
            $user = User::create([

                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            store()->users()->attach($user);
            Auth::guard('web')->login($user);
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addSuccess('Register SucessFully');
            return redirect('/');
        }
        $user = User::where('password', $request->password)->where('email', $request->email)->first();

        if (store()->users()->where('user_id', $user->id)->first()) {
            return redirect()->back()->withErrors('Already Register');
            Auth::guard('web')->login($user);
        }
        store()->users()->attach($user);
        Auth::guard('web')->login($user);

        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess('Register SucessFully');
        return redirect('/');
    }

    public function index_login()
    {


        return view('Frontend.Templete.Login');
    }

    public function login(Request $request)
    {

        $user_status = Auth::guard('web')->attempt([

            'email' => $request->email,
            'password' => $request->password
        ]);
        if (!$user_status) {
            return redirect()->back()->withErrors("User Not Found ");
        }
        $user = User::where('email', $request->email)->first();

        if (!(store()->users()->where('user_id', $user->id)->first())) {
            return redirect()->back()->withErrors('please Check Data Not Correct In store ');
        }

        Auth::guard('web')->login($user);
        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess('Login SucessFully');
        return redirect('/');
    }

    public function logout()
    {

        Auth::guard('web')->logout();
        return redirect()->back();
    }
}
