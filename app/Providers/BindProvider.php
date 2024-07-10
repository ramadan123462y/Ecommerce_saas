<?php

namespace App\Providers;

use App\Services\Cart\CartCookies;
use App\Services\Cart\CartUserLogin;
use App\Services\ThirdPartyApi\Currency;
use App\Services\ThirdPartyApi\MyFatoorah;
use App\Services\ThirdPartyApi\PayMob;
use App\Services\ThirdPartyApi\Paypal;
use App\Services\ThirdPartyApi\Stripe;
use App\Services\ThirdPartyApi\Thawani;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BindProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // App::bind('cart', new CartService());

        $this->app->bind('cart', function () {
            return new CartUserLogin();
        });
        $this->app->bind('currency', function () {
            return new Currency();
        });
        $this->app->bind('paymob', function () {
            return new PayMob();
        });
        $this->app->bind('myfatoorah', function () {
            return new MyFatoorah();
        });
        $this->app->bind('paypal', function () {
            return new Paypal();
        });
        $this->app->bind('thawani', function () {
            return new Thawani();
        });
        $this->app->bind('stripe', function () {
            return new Stripe();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
