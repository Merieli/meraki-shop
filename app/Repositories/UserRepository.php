<?php

namespace MerakiShop\Repositories;

use MerakiShop\Contracts\Repositories\UserRepositoryInterface;
use MerakiShop\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
