<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DahboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('admin')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index_login')->middleware('guest');
        Route::post('/login', 'login');
        Route::get('/logout', 'logout');



        Route::get('/auth/redirect/{driver?}', 'redirect');
        Route::get('/auth/callback/{driver?}', 'callback');

        Route::get('/verificationcode', 'verificationcode');
        Route::any('/check_verificationcode', 'check_verificationcode');
    });

    Route::prefix('dashboard')->middleware('CheckAuthAdmin')->controller(DahboardController::class)->group(function () {

        Route::get('/', 'dashboard');
        Route::get('/stores', 'stores');
        Route::get('transaction_subscrubtion','transaction_subscrubtion');
        
    });
});
