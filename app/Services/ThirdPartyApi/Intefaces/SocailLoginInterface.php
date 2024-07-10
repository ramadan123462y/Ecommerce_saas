<?php

namespace App\Services\ThirdPartyApi\Intefaces;


interface SocailLoginInterface
{
    function authorize();
    function callback($request);
}
