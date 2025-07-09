<?php

namespace MerakiShop\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MerakiShop\Contracts\Repositories\ProductRepositoryInterface;
use MerakiShop\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /** @inheritDoc */
    public function list(Request $request): Builder
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', $request['name']);
        }

        if ($request->has('stock')) {
            $query->where('stock', $request['stock']);
        }

        return $query;
    }

    /** @inheritDoc */
    public function create(array $request): Product
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
                'sku' => $request['sku'] ?? null,
            ]);
        }, 3);
    }

    /** @inheritDoc */
    public function findById(string $id): ?Product
    {
        return Product::find($id);
    }

    /** @inheritDoc */
    public function update(string $id, array $data): ?Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->findById($id);

            if (! $product) {
                return null;
            }

            $product->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'cost_price' => $data['cost_price'] ?? $product->cost_price,
                'stock' => $data['stock'] ?? $product->stock,
                'thumbnail' => $data['thumbnail'],
                'images' => $data['images'] ?? $product->images,
                'short_description' => $data['short_description'],
                'description' => $data['description'] ?? $product->description,
                'rating' => $data['rating'],
                'sku' => $data['sku'] ?? $product->sku,
            ]);

            return $product->fresh();
        }, 3);
    }

    /** @inheritDoc */
    public function delete(string $id): ?bool
    {
        return DB::transaction(function () use ($id) {
            $product = $this->findById($id);

            if (! $product) {
                return false;
            }

            return $product->delete();
        }, 3);
    }
}
