<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MyFatoorahFacade extends facade
{





    protected static function getFacadeAccessor()
    {
        return 'myfatoorah';
    }
}
