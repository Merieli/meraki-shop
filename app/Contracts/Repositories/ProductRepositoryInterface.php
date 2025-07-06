<?php

namespace MerakiShop\Contracts\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    public function list(Request $request): Builder;

    public function create(array $request): Product;

    public function findById(string $id): ?Product;

    public function update(string $id, array $data): ?Product;

    public function delete(string $id): bool;
}
