<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\User;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    try {
        /** @var Laravel\WorkOS\User  $workosUser */
        $workosUser = $request->authenticate();

        $user = User::firstOrCreate(
            ['email' => $workosUser->email],
            [
                'name' => $workosUser->firstName.' '.$workosUser->lastName,
                'workos_id' => $workosUser->id ?? null,
                'avatar' => $workosUser->profilePictureUrl ?? '',
            ]
        );

        $tokenResponse = app(\MerakiShop\Http\Controllers\Api\AuthTokenController::class)->create(new Request(['email' => $user->email, 'workos_id' => $user->workos_id]));

        if ($tokenResponse->status() !== 200) {
            throw new \Exception('Failed to create token');
        }

        /** @var \MerakiShop\DTOs\ResponseToken $tokenResponse */
        $tokenResponse = $tokenResponse->getData();
        $cookie = cookie(
            'X-API-TOKEN',
            $tokenResponse->token,
            60 * 24,
            null,
            null,
            (bool) config('session.secure', false),
            true
        );

        return redirect()->route('orders.index')
            ->withCookie(cookie: $cookie)
            ->with('api_token', $tokenResponse->token);
    } catch (\Exception $e) {
        Logger::critical('Erro de autenticação: '.$e->getMessage());

        return redirect()->route('login');
    }
})->middleware(['web', 'guest'])->name('authenticate');

Route::match(['get', 'post'], 'logout', function (Request $request) {
    if (Auth::check()) {
        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();
    }

    $cookie = cookie('X-API-TOKEN', '', -1);

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->withCookie($cookie);
})->middleware(['auth'])->name('logout');
