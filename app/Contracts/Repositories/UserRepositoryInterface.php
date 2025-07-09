<?php

namespace MerakiShop\Contracts\Repositories;

use MerakiShop\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get a address of user
     */
    // public function list(Request $request): Builder;
    // public function create(array $request): User;
    /**
     * Get addres byId
     */
    public function findById(int $id): ?User;
    // public function update(string $id, array $data): ?User;
}
