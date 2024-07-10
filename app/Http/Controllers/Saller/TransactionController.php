<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{


    public function index(){


        $transactions = Transaction::get();

        return view('Backend.Saller.Transaction',compact('transactions'));

    }
}
