<?php

use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\FrontEnd\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// payments callback;

Route::any('/callback_sucess/{id_order}', [CheckoutController::class, 'callback_sucess'])->middleware('CheckStore');
Route::any('/callback_error/{id_order}', [CheckoutController::class, 'callback_error'])->middleware('CheckStore');


// roures

