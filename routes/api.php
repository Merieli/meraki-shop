<?php

use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\AddressController;
use MerakiShop\Http\Controllers\Api\AuthTokenController;
use MerakiShop\Http\Controllers\Api\CustomerCardController;
use MerakiShop\Http\Controllers\Api\OrderController;
use MerakiShop\Http\Controllers\Api\ProductController;
use MerakiShop\Http\Controllers\Api\UserController;

Route::middleware('auth')->post('token', [AuthTokenController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)->only(['index', 'store']);

    Route::apiResource(
        'address',
        AddressController::class,
    )->except(['create', 'edit', 'destroy', 'show']);
    Route::apiResource(
        'credit-card',
        CustomerCardController::class,
    )->except(['create', 'edit', 'destroy', 'show']);
    Route::apiResource(
        'order',
        OrderController::class,
    )->except(['create', 'edit', 'destroy', 'show']);

    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
