<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MerakiShop\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (empty($user)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 
                401);
            }

            return response()->json(
                 $user
            );
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error to get user'
            ], 
            $th->getCode());
        }
    }
}
