<?php

namespace App\Http\Controllers\Saller;

use App\Facades\PayMobFacade;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\Saller;
use App\Models\Store;
use App\Models\Subscrubtion;
use App\Models\Transactionsubscription;
use App\Notifications\CreateStoreNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function index_login()
    {


        return view('Backend.Saller.login');
    }
    public function create_store()
    {


        return view('Backend.Saller.register');
    }

    public function store(Request $request)
    {


        $store =   Store::create([

            'title' => $request->title,
            'sub_domain' => "$request->sub_domain",
            'active' => 1,


        ]);



        $saller = Saller::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'store_id' => $store->id

        ]);

        $admins = Admin::get();
        $store= $store->with('saller')->first();
        Notification::sendNow($admins, new CreateStoreNotification($store));

        return redirect("saller/register_plan/$store->id");
    }

    public function register_plan($store_id)
    {


        $plans = Plan::all();
        $store_id = $store_id;



        return view('Backend.Saller.register_plan', compact('plans', 'store_id'));
    }


    public function go_to_pay(Request $request,  $store_id, $plan_id)
    {

        //   "type": "Pay With Card"

        $api_key = env('paymob_api_key');


        $plan = Plan::find($plan_id);

        $jsonString_order = '{

                                    "delivery_needed": "false",
                                    "amount_cents": "' . $plan->price . '",
                                    "currency": "EGP",
                                    "items": [
                                    ]
                                    }';
        $jsonString_key = '{
                                        "amount_cents": "' . $plan->price . '",
                                        "expiration": 3600,
                                        "billing_data": {
                                        "apartment": "803",
                                        "email": "eee@exa.com",
                                        "floor": "52",
                                        "first_name": "dsf",
                                        "street": "ee Laasfand",
                                        "building": "asf",
                                        "phone_number": "+86(8)9135210487",
                                        "shipping_method": "PKG",
                                        "postal_code": "01898",
                                        "city": "Jaskolskiburgh",
                                        "country": "CR",
                                        "last_name": "Nicolas",
                                        "state": "Utah"
                                        },
                                        "currency": "EGP",
                                        "integration_id": 4599196

                                    }';
        // $paymob = new PayMob();

        $paymob = PayMobFacade::auth_token($api_key)->create_order($jsonString_order);
        $payment_id = $paymob['order_id'];

        $subscrube =  Subscrubtion::create([
            'plan_id' => $plan_id,

        ]);

        Store::find($store_id)->update([

            'plan_id' => $plan_id,
            'subscrubtion_id' => $subscrube->id,
            'active' => 0,

        ]);

        Transactionsubscription::create([


            'store_id' => $store_id,
            'subscrubtion_id' => $subscrube->id,
            'payment_id' => $payment_id,
        ]);

        if ($request->type == 'Pay With Card') {


            return $paymob['object']->create_key($jsonString_key)->Paywith_card();
        }
        return $paymob['object']->create_key($jsonString_key)->Paywith_wallet('01010101010');
    }

    public function store_subscrubtion(Request $request)
    {


        // $payment_id = $request['obj']['order']['id'];
        $payment_id = '221101343';
        $tranaction = Transactionsubscription::where('payment_id', $payment_id)->first();

        Store::find($tranaction->store_id)->update([
            'active' => 1,

        ]);
        $tranaction->update([

            'status_pay' => 'pay'
        ]);
        return "ok SubScrubtion";
    }

    public function login(Request $request)
    {
        $saller = Auth::guard('saller')->attempt([

            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($saller == true) {

            $saller = Saller::where('email', $request->email)->first();

            $result = Auth::guard('saller')->login($saller);

            $sub_domain = $saller->store->sub_domain;

            return redirect()->to("http://$sub_domain." . env('Domain') . "/saller/dashboard");
        } else {

            flash()->addError('Data Not Found To Store');

            return redirect()->back();
        }
    }

    public function logout()
    {

        Auth::guard('saller')->logout();
        return redirect('saller/login');
    }
}
