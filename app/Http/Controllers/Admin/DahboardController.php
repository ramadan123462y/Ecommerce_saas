<?php

namespace App\Http\Controllers\Admin;

use App\Charts\StoresChart;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Transactionsubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DahboardController extends Controller
{
    public function dashboard(StoresChart $chart)
    {




        $store = Store::select('active', DB::raw('count(*)  as count'))->groupBy('active')->get();
        $unactive = $store[0]['count'];
        $active = $store[1]['count'];

        return view('Backend.Admin.index', ['chart' => $chart->build($unactive, $active), 'active' => $active, 'unactive' => $unactive]);
    }

    public function stores()
    {


        $stores = Store::all();
        return view('Backend.Admin.stores', compact('stores'));
    }

    public function transaction_subscrubtion()
    {

        $transactions = Transactionsubscription::all();

        return view('Backend.Admin.tranactions_subacribtion', compact('transactions'));
    }
}
