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

    public function findProduct(string $id): Product | null | array
    {
        try {
            $product = $this->repository
                ->findById($id);

            return $product;
        } catch (Throwable $e) {
            Logger::error('Falha ao buscar produto ->', [$e]);

            return [
                'message' => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
            ];
        }
    }

    public function updateProduct(array $request, string $id): Product | null
    {
        try {
            $product = $this->repository
                ->update($id, $request);

            if (!$product) {
                return response()->json([
                    'message' => 'Produto não encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($product);
        } catch (Throwable $e) {
            Logger::error('Falha ao atualizar produto', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function deleteProduct(string $id): bool | null
    {
        try {
            return $this->repository
                ->delete($id);
        } catch (Throwable $e) {
            Logger::error('Falha ao excluir produto', [$e]);

            return null;
        }
    }
}
