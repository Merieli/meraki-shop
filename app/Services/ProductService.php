<?php

namespace MerakiShop\Services;

use Illuminate\Database\Eloquent\Builder;
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

    /** @inheritDoc */
    public function getProducts(Request $request): Builder
    {
        Logger::info('Get Products', [
            'request' => $request,
        ]);

        return $this->repository->list($request);
    }

    /** @inheritDoc */
    public function createProduct(array $request): Product
    {
        return $this->repository
            ->create($request);
    }

    /** @inheritDoc */
    public function findProduct(string $id): ?Product
    {
        return $this->repository->findById($id);
    }

    /** @inheritDoc */
    public function updateProduct(array $request, string $id): ?Product
    {
        return $this->repository
            ->update($id, $request);
    }

    /** @inheritDoc */
    public function deleteProduct(string $id): ?bool
    {
        return $this->repository->delete($id);
    }
}
