<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;
use Laravel\Sanctum\NewAccessToken;

class AuthTokenController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'workos_id');
    
            $user =  Auth::user();
            if (!isset($user) || ! Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'User unauthorized'
                ], 401);
            }

            /** @var NewAccessToken $accessToken */
            $accessToken = $user->createAccessToken('api-token');
    
            $token = $accessToken->plainTextToken;
    
            Logger::critical('token ->>', [$token]);
    
            return response()->json([
                'token' => $token,
            ]);
        } catch (\Throwable $e) {
            Logger::error('Create Token', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()->json(
                [
                    'message' => 'Não foi possível criar um token',
                ],
                $e->getCode()
            );
        }
    }
}
