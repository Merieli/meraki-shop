<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\{
    ProductController,
    UserController,
    AuthController
};

// Route::post('/tokens/create', AuthController::class);

Route::apiResource('/users', UserController::class)->only(['index', 'store']);
// Route::middleware('auth:sanctum')->group(function () {
// });

Route::resource('/products', ProductController::class);
