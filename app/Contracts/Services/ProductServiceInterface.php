<?php

namespace MerakiShop\Contracts\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Models\Product;

interface ProductServiceInterface
{
    public function getProducts(Request $request): Builder;

    public function findProduct(string $id): Product|null|array;

    public function createProduct(array $request): Product;

    public function updateProduct(array $request, string $id): ?Product;

    public function deleteProduct(string $id): ?bool;
}
