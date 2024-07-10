<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

use function App\Http\Helpers\store_saller;

class CustomerController extends Controller
{

    public function index()
    {

        $customers =  store_saller()->users;


        return view('Backend.Saller.customers', compact('customers'));
    }

}
