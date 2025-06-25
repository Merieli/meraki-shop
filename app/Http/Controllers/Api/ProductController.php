<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use MerakiShop\Facades\Logger;
use MerakiShop\Facades\ProductService;
use Symfony\Component\HttpFoundation\Response;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @response User[]
     */
    public function index(Request $request)
    {
        $query = ProductService::getProducts($request);

        $size = 25;
        if ($request->has('size')) {
            $size = $request->size;
        }

        return $query->paginate($size);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        return ProductService::createProduct($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ProductService::findProduct($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, string $id)
    {
        return ProductService::updateProduct( $request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ProductService::deleteProduct($id);
    }
}
