<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MerakiShop\DTOs\ResponseToken;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;
use Laravel\Sanctum\NewAccessToken;
use MerakiShop\Models\User;
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
            $user = $this->authenticateUser();
            if (! $user) {
                return response()->json([
                    'message' => 'User unauthorized'
                ], 401);
            }

            /** @var User $user */
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
     * Summary of authenticateUser
     * @throws Throwable
     */
    private function authenticateUser(): Authenticatable|null
    {
        $user =  Auth::user();
        if (!isset($user)) {
            return $user;
        }
        Auth::login($user);

        return $user;
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
                return ['orders-get-all'];
            default:
                return [];
        }
    }
}
