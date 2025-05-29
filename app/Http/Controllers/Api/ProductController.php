<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

class ProductController extends Controller
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }


    /**
     * Display a listing of the resource.
     *
     * @response User[]
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($query->has('name')) {
            $query->where('name', $request->name);
        }

        if ($query->has('stock')) {
            $query->where('stock', $request->stock);
        }

        $size = 25;
        if ($query->has('size')) {
            $size = $request->size;
        }

        return $query->paginate($size);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        try {
            $validated = $request->validated();

            $product = $this->repository->create($validated);

            return response()->json($product, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            Log::error('Falha ao salvar o produto ->', [$e]);

            $statusText = Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY];

            return response()
                ->json([
                    'message' => $statusText
                ], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
