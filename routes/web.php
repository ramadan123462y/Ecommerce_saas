<?php


use App\Exports\UsersExport;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\FrontEnd\Auth\AuthController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\CheckoutController;
use App\Http\Controllers\Frontend\FilterContoller;
use App\Http\Controllers\FrontEnd\TempleteController;
use App\Http\Controllers\FrontEnd\WishlistController;
use App\Imports\UsersImport;
use App\Models\Admin;
use App\Models\Store;
use App\Models\User;
use App\Notifications\Verificationcode;
use App\Services\ThirdPartyApi\Whatsapp;
use function App\Http\Helpers\store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


use Laravel\Socialite\Facades\Socialite;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;





Route::get('user_export', function () {



  return  Excel::store(new UsersExport(),'users.csv','Files',\Maatwebsite\Excel\Excel::CSV);
});

Route::get('user_import', function () {



     Excel::import(new UsersImport(),public_path('storage\Files\users.csv'));
});

Route::prefix('templete')->controller(Dashboardcontroller::class)->group(function () {

    Route::view('/index', 'Frontend.Templetes.Templete2.index');
    Route::view('/productdetails', 'Frontend.Templetes.Templete2.productdetails');
    Route::view('/cart', 'Frontend.Templetes.Templete2.cart');
    Route::view('/checkout', 'Frontend.Templetes.Templete2.checkout');
    Route::view('/filters', 'Frontend.Templetes.Templete2.filters');
});



// ________________________________Frontend_______________________________
Route::controller(TempleteController::class)->middleware('CheckStore')->group(function () {

    Route::get('/', 'index');

    Route::middleware('CheckStore')->controller(AuthController::class)->group(function () {
        Route::get('register', 'index_register');
        Route::get('login', 'index_login');
        Route::post('store/{payment_method_id?}', 'store');
        Route::post('login', 'login');
        Route::get('logout', 'logout')->middleware('CheckAuthCustomer');
    });
    // ________________________________ Cart _______________________________

    Route::prefix('/cart')->middleware('CheckAuthCustomer')->controller(CartController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/store/{id}', 'store');
        Route::get('/increase_item/{id}/{quenty}', 'increase_item');
    });


    Route::get('product_details/{id}', 'product_details');
    // ________________________________ Categorie _______________________________
    Route::prefix('categorie')->controller(FilterContoller::class)->group(function () {
        Route::get('/{id_categorei?}', 'show_products');
    });
    Route::prefix('checkout')->middleware('CheckStore', 'CheckAuthCustomer')->controller(CheckoutController::class)->group(function () {

        Route::get('/', 'index');
        Route::post('/store_order', 'store_order');;
    });

    Route::prefix('wishlist')->middleware('CheckAuthCustomer')->controller(WishlistController::class)->group(function () {

        Route::get('/', 'index');
        Route::get('/store/{id_product}', 'store');
        Route::get('/delete/{id}', 'delete');
    });
});
