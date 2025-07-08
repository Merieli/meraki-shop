<?php

namespace MerakiShop\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * List all products
     * @param Request $request
     * @return Collection<int, Product>
     */
    public function list(Request $request): Collection;

    /**
     * Create a Product
     * @param ProductFormRequest $request
     * @return Product
     */
    public function create(ProductFormRequest $request): Product;

    /**
     * Find Product by ID
     * @param string $id
     * @return ?Product
     */
    public function findById(string $id): ?Product;

    /**
     * Update a product
     * @param string $id
     * @param ProductFormRequest $data
     * @return ?Product
     */
    public function update(string $id, ProductFormRequest $data): ?Product;

    /**
     * Delete a product
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
