<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PayMobFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'paymob';
    }
}
