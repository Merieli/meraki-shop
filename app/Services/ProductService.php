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
        } catch (Exception $e) {
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

    public function createProduct(array $request): Product
    {   
        try {   
            $newProduct = $this->repository
                ->create($request);
            
                return response()->json($newProduct, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Logger::error('Falha ao salvar o produto', [$e]);
            
            $statusText = Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY];

            return response()
                ->json([
                    'message' => $statusText
                ], status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
    }

    public function findProduct(string $id): Product | null
    {
        try {
            $product = $this->repository
                ->findById($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Produto não encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($product);
        } catch (Exception $e) {
            Logger::error('Falha ao buscar produto ->', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        } catch (Exception $e) {
            Logger::error('Falha ao atualizar produto', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function deleteProduct(string $id): bool
    {
        try {
            $deleted = $this->repository
                ->delete($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Produto não encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Logger::error('Falha ao excluir produto', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
