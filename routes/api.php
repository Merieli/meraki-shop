<?php

use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\{
    ProductController,
    UserController,
    AddressController,
    AuthTokenController
};


Route::middleware('auth')->post('/token', [AuthTokenController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class)->only(['index', 'store']);

    Route::resource('/address', AddressController::class)
        ->except(['create', 'edit', 'destroy', 'show']);
});

Route::resource('/products', ProductController::class)->except(['create', 'edit']);


