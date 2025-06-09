<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use MerakiShop\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        $factory = new ProductFactory();
        $products = $factory->getProducts();
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
