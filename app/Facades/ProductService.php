<?php

namespace MerakiShop\Facades;

use Illuminate\Support\Facades\Facade;
use MerakiShop\Contracts\Services\ProductServiceInterface;

class ProductService extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return ProductServiceInterface::class;
    }
}
