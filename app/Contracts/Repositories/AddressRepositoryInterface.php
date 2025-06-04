<?php

namespace MerakiShop\Contracts\Repositories;

use MerakiShop\Models\Address;

interface AddressRepositoryInterface
{
    /**
     * Get a address of user
     */
    public function list(Request $request): Builder;
    public function create(array $request): Address;
    /**
     * Get addres byId
     */
    public function findById(string $id): ?Address;
    public function update(string $id, array $data): ?Address;
}
