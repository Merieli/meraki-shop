<?php

namespace MerakiShop\Services;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Contracts\Services\ProductServiceInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {}

    public function getProducts(Request $request): Builder
    {
        try {
            Logger::info('Get Products', [
                'request' => $request
            ]);
            
            return $this->repository->list($request);
        } catch  (Exception $e) {
            Logger::error('Get Products', [
                'exception' => $e,
                'request' => $request
            ]);

            return response()
                ->json(
                    [
                        'message' => 'Não foi possível obter os produtos'
                    ],
                    $e->getCode()
                );
        }
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
