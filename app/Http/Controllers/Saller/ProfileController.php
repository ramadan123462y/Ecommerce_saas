<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Traits\FileTrait;
use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\Saller;
use App\Models\Store;
use App\Models\Templete;

use function App\Http\Helpers\store;
use function App\Http\Helpers\store_saller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {


        $store = Store::find(store_saller()->id);
        $templetes = Templete::get();
        $payment_methods = PaymentMethod::all();




        return view('Backend.Saller.Setting', compact('store', 'templetes', 'payment_methods'));
    }

    public function update(ProfileRequest $request)
    {

        $paymentmethod_id = $request->paymentmethod_id;

        $api_key = null;
        if (isset($request->api_key[$paymentmethod_id])) {

            $api_key = $request->api_key[$paymentmethod_id];
        }

        $results =   store_saller()->paymentmethods()->syncWithPivotValues(
            $request->paymentmethod_id,
            [
                'api_key' => $api_key,
                'user_name' => $request->user_name,
                'password' => $request->password
            ]
        );
        $active = $this->check_active($request);
        $store = store_saller();
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->getClientOriginalName();
            FileTrait::save_file('logo', $request, 'Profiles', 'Images');
        } else {


            $logo = $store->logo;
        }
        $this->update_profile($request, $logo, $active);
        flash()->addSuccess('Data Updated Sucessfully');
        return redirect()->back();
    }

    public function view_store()
    {


        return redirect()->to('/');
    }

    private  function check_active($request)
    {

        if (isset($request->active)) {


            $active = true;
        } else {


            $active = false;
        }
        return $active;
    }
    private function update_profile($request, $logo, $active)
    {

        Store::find(store_saller()->id)->update([

            'title' => $request->title,
            'sub_domain' => $request->sub_domain,
            'logo' => $logo,
            'templete_id' => $request->templete_id,
            'active' => $active

        ]);
    }
}
