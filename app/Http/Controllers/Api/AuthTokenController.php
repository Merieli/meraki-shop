<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;

class AuthTokenController extends Controller
{
    public function create(Request $request)
    {
        $credentials = $request->only('email', 'workos_id');

        if (!Auth::attempt($credentials)) {
            return abort(401, 'Invalid credentials');
        }

        $token = $request->user()->createAccessToken('api-token')->plainTextToken;

        Logger::critical('token ->>', [$token]);

        return response()->json([
            'token' => $token,
        ]);
    }
}
