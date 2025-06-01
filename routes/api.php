<?php

use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\{
    ProductController,
    UserController,
};


Route::apiResource('/users', UserController::class)->only(['index', 'store']);
// Route::middleware('auth:sanctum')->group(function () {
// });

Route::resource('/products', ProductController::class)->except(['create', 'edit']);
