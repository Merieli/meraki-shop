<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', function () {
    return Inertia::render('Products');
})->name('index');

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('products/create', function () {
        return Inertia::render('products/Create');
    })->name('products.create');

    Route::get('addresses/create', function () {
        return Inertia::render('addresses/CreateAddress');
    })->name('addresses.create');

    Route::get('cards/create', function () {
        return Inertia::render('cards/CreateCard');
    })->name('cards.create');

    Route::get('orders', function () {
        return Inertia::render('orders/OrdersIndex');
    })->name('orders.index');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
