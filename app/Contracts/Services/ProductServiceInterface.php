<?php

namespace MerakiShop\Contracts\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Models\Product;

interface ProductServiceInterface
{
    /**
     * Get all products
     * @param Request $request
     * @return Builder<Product>
     */
    public function getProducts(Request $request): Builder;

    /**
     * Create a product
     * @param array<string, mixed> $request
     * @return Product
     */
    public function createProduct(array $request): Product;

    /**
     * Find product by id
     * @param string $id
     * @return ?Product
     */
    public function findProduct(string $id): ?Product;

    /**
     * Update register of preoduct
     * @param array<string, mixed> $request
     * @param string $id
     * @return Product|null
     */
    public function updateProduct(array $request, string $id): ?Product;

    /**
     * Delete a product
     * @param string $id
     * @return ?bool
     */
    public function deleteProduct(string $id): ?bool;
}
