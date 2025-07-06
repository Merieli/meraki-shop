<?php

namespace MerakiShop\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Summary of list
     * @param Request $request
     * @return Collection<int, Product>
     */
    public function list(Request $request): Collection;

    /**
     * Summary of create
     * @param array $request
     * @return Product
     */
    public function create(array $request): Product;

    /**
     * Summary of findById
     * @param string $id
     * @return ?Product
     */
    public function findById(string $id): ?Product;

    public function update(string $id, array $data): ?Product;

    public function delete(string $id): bool;
}
