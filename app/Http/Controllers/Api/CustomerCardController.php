<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\DB;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\{CustomerCard, User};
use Throwable;

class CustomerCardController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @throws Throwable
     */
    public function index(Request $request, Authenticatable $user): JsonResponse
    {
        try {
            $userId = $user->getAuthIdentifier();
            $user = User::find($userId);

            if (! $user || empty($user->customerCard)) {
                return response()->json(['message' => 'Nenhum endereço existente'], 404);
            }

            return response()->json($user->customerCard);
        } catch (Throwable $e) {
            Logger::error('Get Customer Card', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()->json(
                [
                    'message' => 'Não foi possível obter os produtos',
                ],
                $e->getCode()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @throws Throwable
     */
    public function store(Request $request, Authenticatable $user): JsonResponse
    {
        try {
            $userId = $user->getAuthIdentifier();

            $customerCard = DB::transaction(function () use ($request, $userId) {
                return CustomerCard::create([
                    'user_id' => $userId,
                    'card_token' => $request['card_token'],
                    'card_last4' => $request['card_last4'],
                    'card_brand' => $request['card_brand'],
                ]);
            }, 3);

            return response()->json($customerCard);
        } catch (Throwable $e) {
            Logger::error('Get Customer Card', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()->json(
                [
                    'message' => 'Não foi possível obter os produtos',
                ],
                $e->getCode()
            );
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @throws Throwable
     */
    public function update(Request $request, string $id, Authenticatable $user): JsonResponse
    {
        try {
            $userId = $user->getAuthIdentifier();

            $customerCard = DB::transaction(function () use ($id, $request, $userId) {
                $customerCard = CustomerCard::find($id);

                if (! $customerCard || $userId !== $customerCard->user_id) {
                    return null;
                }

                $customerCard->update([
                    'card_token' => $request['card_token'] ?? $customerCard->card_token,
                    'card_last4' => $request['card_last4'] ?? $customerCard->card_last4,
                    'card_brand' => $request['card_brand'] ?? $customerCard->card_brand,
                ]);

                return $customerCard->fresh();
            }, 3);

            return response()->json($customerCard);
        } catch (Throwable $e) {
            Logger::error('Get Customer Card', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()->json(
                [
                    'message' => 'Não foi possível obter os produtos',
                ],
                $e->getCode()
            );
        }
    }
}
