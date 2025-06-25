<?php

namespace MerakiShop\Contracts\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

interface ProductServiceInterface
{
    public function getProducts(Request $request): Builder;
    public function findProduct(string $id):  Product | null;
    public function createProduct(array $request): Product;
    public function updateProduct(array $request, string $id): Product | null;
    public function deleteProduct(string $id): bool;
}
