<?php

namespace MerakiShop\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

interface ProductServiceInterface
{
    /**
     * Get all products
     * @param Request $request
     * @return Collection<int, Product>
     */
    public function getProducts(Request $request): Collection;

    /**
     * Create a product
     * @param ProductFormRequest $request
     * @return Product
     */
    public function createProduct(ProductFormRequest $request): Product;

    /**
     * Find product by id
     * @param string $id
     * @return Product|null
     */
    public function findProduct(string $id): Product|null|array;

    /**
     * Update register of preoduct
     * @param ProductFormRequest $request
     * @param string $id
     * @return Product|null
     */
    public function updateProduct(ProductFormRequest $request, string $id): ?Product;

    /**
     * Delete a product
     * @param string $id
     * @return bool
     */
    public function deleteProduct(string $id): bool;
}
