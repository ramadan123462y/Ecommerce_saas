<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Saller\AuthController;
use App\Http\Controllers\Saller\CategorieController;
use App\Http\Controllers\Saller\DashbordController;
use App\Http\Controllers\Saller\OrderController;
use App\Http\Controllers\Saller\ProductController;
use App\Http\Controllers\Saller\ProfileController;
use App\Http\Controllers\Saller\TransactionController;
use Illuminate\Support\Facades\Route;


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



Route::prefix('saller')->group(function () {



    // Auth__________________________________________________________

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index_login')->middleware(['CheckStore', 'guest:saller'])->name('login_saller');
        Route::get('/create_store', 'create_store');
        Route::post('/store', 'store');
        Route::post('/go_to_pay/{store_id}/{plan_id}', 'go_to_pay');
        Route::get('/register_plan/{id}', 'register_plan');
        Route::get('/store_subscrubtion', 'store_subscrubtion');
        Route::post('/login', 'login')->middleware('CheckStore');
        Route::get('logout', 'logout')->middleware('CheckStore');
    });
    // End Auth________________________________________________________

    // Dashboard_______________________________________________________

    Route::prefix('dashboard')->middleware(['CheckStore', 'checksaller'])->controller(DashbordController::class)->group(function () {


        Route::get('/', 'index');
        Route::get('/viewall_notification', 'viewall_notification');
        //  Categorie___________________________________________________
        Route::prefix('categories')->controller(CategorieController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::get('/delete/{id}', 'delete');
            Route::post('/update', 'update');
            // strat_Archive ____________________________________________
            Route::get('/archive', 'archive');
            Route::get('/retrive_archive/{id}', 'retrive_archive');
            Route::get('/force_delete_archive/{id}', 'force_delete_archive');
            // strat_Archive ____________________________________________

        });
        // End_Categorie_______________________________________________
        // Start_Product ______________________________________________
        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update', 'update');
            Route::get('/delete/{id}', 'delete');
            Route::get('/export', 'export');
            Route::post('/import', 'import');
        });
        // End_Product ________________________________________________
        // start profile ______________________________________________

        Route::prefix('setting')->controller(ProfileController::class)->group(function () {

            Route::get('/', 'index');
            Route::post('/update', 'update');
            Route::get('/view_store', 'view_store');
        });

        // end profile ________________________________________________
        //  Order ________________________________________________



        Route::prefix('order')->controller(OrderController::class)->group(function () {

            Route::get('/', 'index');
            Route::get('/{order_id}', 'order');
        });

        Route::prefix('customer')->controller(CustomerController::class)->group(function () {

            Route::get('/', 'index');
        });
        Route::prefix('transaction')->controller(TransactionController::class)->group(function () {

            Route::get('/', 'index');
        });
        // end Order _____________________________________________


    });
    // End Dashboard___________________________________________________

});
