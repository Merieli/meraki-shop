<?php

namespace MerakiShop\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use MerakiShop\Contracts\Repositories\AddressRepositoryInterface;
use MerakiShop\Repositories\AddressRepository;

class AddressRepositoryProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        AddressRepositoryInterface::class => AddressRepository::class,
    ];
}
