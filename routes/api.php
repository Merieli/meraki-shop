<?php

use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\{
    CustomerCardController,
    UserController,
    ProductController,
    OrderController,
    AddressController,
    AuthTokenController
};


Route::middleware('auth')->post('token', [AuthTokenController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)->only(['index', 'store']);

    Route::apiResource(
        'address', AddressController::class,
    )->except(['create', 'edit', 'destroy', 'show']);;
    Route::apiResource(
        'credit-card', CustomerCardController::class,
    )->except(['create', 'edit', 'destroy', 'show']);
    Route::apiResource(
        'order', OrderController::class,
    )->except(['create', 'edit', 'destroy', 'show']);
});

Route::apiResource('products', ProductController::class)->except(['create', 'edit']);


