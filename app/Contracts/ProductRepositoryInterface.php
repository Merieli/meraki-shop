<?php

namespace MerakiShop\Contracts;

use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    public function create(ProductFormRequest $request): Product;
    public function findById(string $id): ?Product;
    public function update(string $id, array $data): ?Product;
    public function delete(string $id): bool;
}
