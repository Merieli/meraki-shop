<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\CustomerCard;
use MerakiShop\Models\User;

class CustomerCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authenticatable $user)
    {
        try {
            $user = User::find($user['id']);

            if (! $user || empty($user->customerCard)) {
                return response()->json(['message' => 'Nenhum endereço existente'], 404);
            }

            return response()->json($user->customerCard);
        } catch (\Throwable $e) {

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Authenticatable $user)
    {
        if (empty($user['id'])) {
            return response()->json(['message' => 'Usuário não encontrado'], 401);
        }

        return DB::transaction(function () use ($request, $user) {
            return CustomerCard::create([
                'user_id' => $user['id'],
                'card_token' => $request['card_token'],
                'card_last4' => $request['card_last4'],
                'card_brand' => $request['card_brand'],
            ]);
        }, 3);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Authenticatable $user)
    {
        return DB::transaction(function () use ($id, $request, $user) {
            $customerCard = $this->findById($id);

            if (! $customerCard || $user['id'] !== $customerCard->user_id) {
                return null;
            }

            $customerCard->update([
                'card_token' => $request['card_token'] ?? $customerCard->card_token,
                'card_last4' => $request['card_last4'] ?? $customerCard->card_last4,
                'card_brand' => $request['card_brand'] ?? $customerCard->card_brand,
            ]);

            return $customerCard->fresh();
        }, 3);
    }
}
