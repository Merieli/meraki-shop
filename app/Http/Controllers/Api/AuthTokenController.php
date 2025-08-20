<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MerakiShop\DTOs\ResponseToken;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;
use Laravel\Sanctum\NewAccessToken;
use Throwable;

class AuthTokenController extends Controller
{
    /**
     * Create a token
     *
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $user =  Auth::user();
            if (!isset($user)) {
                return response()->json([
                    'message' => 'User unauthorized'
                ], 401);
            }
            Auth::login($user);

            $scopes = $this->getScopesBasedOnRole($user->role);

            /** @var NewAccessToken $accessToken */
            $accessToken = $user->createToken('api-token', $scopes);
            $token = $accessToken->plainTextToken;

            return response()->json(new ResponseToken($token));
        } catch (Throwable $e) {
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

    /**
     * Get scopes based on user role
     *
     * @param string $role
     * @return array<string>
     */
    private function getScopesBasedOnRole(string $role): array
    {
        switch ($role) {
            case 'a':
                return ['orders:get-all'];
            default:
                return [];
        }
    }
}
