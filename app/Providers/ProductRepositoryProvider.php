<?php

namespace MerakiShop\Providers;

use Illuminate\Support\ServiceProvider;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Repositories\ProductRepository;

class ProductRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        ProductRepositoryInterface::class => ProductRepository::class,
    ];
}
