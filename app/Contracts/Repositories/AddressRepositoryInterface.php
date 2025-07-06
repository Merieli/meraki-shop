<?php

namespace MerakiShop\Contracts\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use MerakiShop\Models\Address;

interface AddressRepositoryInterface
{
    public function create(Request $request, Authenticatable $user): Address;

    public function update(Request $request, string $id, Authenticatable $user): ?Address;

    public function findById(string $id): ?Address;
}
