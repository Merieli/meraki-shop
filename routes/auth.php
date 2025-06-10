<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\User;
use Illuminate\Http\Request;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    try {
        $workosUser = $request->authenticate();

        $user = User::firstOrCreate(
            ['email' => $workosUser->email],
            [
                'name' => $workosUser->firstName . ' ' . $workosUser->lastName,
                'workos_id' => $workosUser->id ?? null,
                'avatar' => $workosUser->profilePictureUrl ?? '',
            ]
        );

        Auth::login($user);

        $token = $user->createToken('api-token')->plainTextToken;
        $cookie = cookie(
            'X-API-TOKEN',
            $token,
            60 * 24,
            null,
            null,
            config('session.secure'),
            true
        );

        return redirect()->route('orders')
            ->withCookie($cookie)
            ->with('api_token', $token);
    } catch (\Exception $e) {
        Logger::critical('Erro de autenticação: ' . $e->getMessage());
        return redirect()->route('login');
    }
})->middleware(['web', 'guest'])->name('authenticate');

Route::match(['get', 'post'], 'logout', function (Request $request) {
    // Limpa o cookie do token
    $cookie = cookie('X-API-TOKEN', '', -1);
    
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/')->withCookie($cookie);
})->middleware(['auth'])->name('logout');
