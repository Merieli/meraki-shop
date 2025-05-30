<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use MerakiShop\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $habilities = [
            'card:read',
            'card:create',
            'orders:create'
        ];

        $token = $request->user()
            ->createToken($request->token_name, $habilities);

        return ['token' => $token->plainTextToken];
    }
}
