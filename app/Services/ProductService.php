<?php

namespace MerakiShop\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {}

    public function getProducts(Request $request): Builder
    {
        return $this->repository->list($request);
        
    }

    public function findProduct(string $id): Product | null
    {
        return $this->repository
            ->findById($id);
    }

    public function createProduct(ProductFormRequest $request): Product
    {
        $validated = $request->validated();

        return $this->repository
            ->create($validated);
    }

    public function updateProduct(ProductFormRequest $request, string $id): Product | null
    {
        $validated = $request->validated();

        return $this->repository
            ->update($id, $validated);
    }

    public function deleteProduct(string $id): bool
    {
        return $this->repository
            ->delete($id);
    }
}
