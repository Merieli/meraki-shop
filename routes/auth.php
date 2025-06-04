<?php

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLogoutRequest;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\User;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    $workosUser = $request->authenticate();

    $user = User::firstOrCreate(
        ['email' => $workosUser->email],
        ['name' => $workosUser->firstName . ' ' . $workosUser->lastName]
    );

    Auth::login($user);

    // Gera o token Sanctum
    $token = $user->createToken('api-token')->plainTextToken;

    // Define o cookie — HttpOnly e Secure só se for HTTPS
    $cookie = cookie('X-API-TOKEN', $token, 60 * 24); // 1 dia válido

    Logger::critical('token ->>', [$token]);

    return tap(
        to_route('dashboard'), callback:
        fn() => $request->authenticate()
    )->withCookie($cookie);
})->middleware(['guest']);

Route::post('logout', function (AuthKitLogoutRequest $request) {
    return $request->logout();
})->middleware(['auth'])->name('logout');
