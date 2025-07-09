<?php

namespace MerakiShop\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use MerakiShop\Contracts\Repositories\UserRepositoryInterface;
use MerakiShop\Repositories\UserRepository;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];
}
