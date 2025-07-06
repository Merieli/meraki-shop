<?php

namespace MerakiShop\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MerakiShop\Contracts\Repositories\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\Product;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    /**
     * Summary of getProducts
     * @param Request $request
     * @return Collection<int, Product>
     */
    public function getProducts(Request $request): Collection
    {
        Logger::info('Get Products', [
            'request' => $request,
        ]);

        return $this->repository->list($request);
    }

    public function createProduct(array $request): Product
    {
        return $this->repository
            ->create($request);
    }

    public function findProduct(string $id): ?Product
    {
        return $this->repository->findById($id);
    }

    public function updateProduct(array $request, string $id): ?Product
    {
        return $this->repository
            ->update($id, $request);
    }

    public function deleteProduct(string $id): ?bool
    {
        return $this->repository->delete($id);
    }
}
