<?php

namespace MerakiShop\Repositories;

use Illuminate\Support\Facades\DB;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(ProductFormRequest $request): Product
    {
        return DB::transaction(function () use ($request) {
            return Product::create([
                'name' => $request['name'],
                'price' => $request['price'],
                'cost_price' => $request['cost_price'],
                'stock' => $request['stock'] ?? null,
                'thumbnail' => $request['thumbnail'],
                'images' => $request['images'] ?? null,
                'short_description' => $request['short_description'],
                'description' => $request['description'] ?? null,
                'rating' => $request['rating'],
                'sku' => $request['sku'] ?? null
            ]);
        }, 3);
    }
}
