<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use MerakiShop\Http\Controllers\Api\{
    ProductController,
    UserController
};

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class)->only(['index', 'store']);
});

Route::resource('/products', ProductController::class);
