<?php

namespace MerakiShop\Contracts\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * List all products
     * @param Request $request
     * @return Builder<Product>
     */
    public function list(Request $request): Builder;

    /**
     * Create a Product
     * @param array<string, mixed> $request
     * @return Product
     */
    public function create(array $request): Product;

    /**
     * Find Product by ID
     * @param string $id
     * @return ?Product
     */
    public function findById(string $id): ?Product;

    /**
     * Update a product
     * @param string $id
     * @param array<string, mixed> $data
     * @return ?Product
     */
    public function update(string $id, array $data): ?Product;

    /**
     * Delete a product
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
