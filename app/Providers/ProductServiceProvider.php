<?php

namespace MerakiShop\Providers;

use Illuminate\Support\ServiceProvider;
use MerakiShop\Contracts\Repositories\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ProductServiceInterface::class => ProductService::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductServiceInterface::class,
            function ($app) {
                return new ProductService(
                    $app->make(ProductRepositoryInterface::class)
                );
            }
        );
    }
}
