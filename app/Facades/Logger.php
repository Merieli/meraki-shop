<?php

namespace MerakiShop\Facades;

use Illuminate\Support\Facades\Facade;

class Logger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Logger';
    }
}
