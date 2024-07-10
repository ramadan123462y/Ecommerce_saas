<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PaypalFacade extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'paypal';
    }
}
