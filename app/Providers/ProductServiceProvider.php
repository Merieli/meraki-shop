<?php

namespace MerakiShop\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use MerakiShop\Contracts\Repositories\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
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
            function (Container $app) {
                return new ProductService(
                    $app->make(ProductRepositoryInterface::class)
                );
            }
        );
    }
}
