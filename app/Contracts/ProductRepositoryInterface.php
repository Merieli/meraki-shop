<?php

namespace MerakiShop\Contracts;

use MerakiShop\Http\Requests\ProductFormRequest;
use MerakiShop\Models\Product;

interface ProductRepositoryInterface
{
    public function create(ProductFormRequest $request): Product;
}
