<?php

namespace MerakiShop\Services;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {}

    public function getProducts(Request $request): Builder
    {
        Logger::info('Get Products', [
            'request' => $request
        ]);
        
        return $this->repository->list($request);
    }

    public function createProduct(array $request): Product
    {   
        return $this->repository
            ->create($request);
    }

    public function findProduct(string $id): Product | null
    {
        return $this->repository->findById($id);
    }

    public function updateProduct(array $request, string $id): Product | null
    {
        return $this->repository
            ->update($id, $request);
    }

    public function deleteProduct(string $id): bool | null
    {
        return $this->repository->delete($id);
    }
}
