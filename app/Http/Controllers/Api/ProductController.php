<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use MerakiShop\Models\Product;
use MerakiShop\Facades\Logger;
use MerakiShop\Facades\ProductService;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Http\Requests\ProductFormRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @unauthenticated
     * @return JsonResponse|LengthAwarePaginator<int, Product>
     * @throws Throwable
     */
    public function index(Request $request): JsonResponse|LengthAwarePaginator
    {
        try {
            $query = ProductService::getProducts($request);

            $size = 25;
            if ($request->has('size')) {
                /** @var int $size */
                $size = $request->size;
            }

            return $query->paginate($size);
        } catch (Throwable $e) {
            Logger::error('Get Products', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()
                ->json(
                    [
                        'message' => 'Não foi possível obter os produtos',
                    ],
                    $e->getCode()
                );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(ProductFormRequest $request): JsonResponse
    {
        try {
            $newProduct = ProductService::createProduct($request->validated());

            return response()->json($newProduct, Response::HTTP_CREATED);
        } catch (Throwable $e) {
            Logger::error('Falha ao salvar o produto', [$e]);

            $statusText = Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY];

            return response()
                ->json([
                    'message' => $statusText,
                ], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     *
     * @unauthenticated
     * @throws Throwable
     */
    public function show(string $id): JsonResponse
    {
        try {
            $product = ProductService::findProduct($id);

            if (! $product) {
                return response()->json([
                    'message' => 'Produto não encontrado',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($product);
        } catch (Throwable $e) {
            Logger::error('Falha ao buscar produto ->', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(ProductFormRequest $request, string $id): JsonResponse
    {
        try {
            $product = ProductService::updateProduct($request->validated(), $id);

            if (! $product) {
                return response()->json([
                    'message' => 'Produto não encontrado',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($product);
        } catch (Throwable $e) {
            Logger::error('Falha ao atualizar produto', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(string $id): JsonResponse|Response
    {
        try {
            $deleted = ProductService::deleteProduct($id);

            if (! $deleted) {
                return response()->json([
                    'message' => 'Produto não encontrado',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->noContent();
        } catch (Throwable $e) {
            Logger::error('Falha ao excluir produto', [$e]);

            return response()->json([
                'message' => Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
