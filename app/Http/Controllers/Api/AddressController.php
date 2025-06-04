<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MerakiShop\Contracts\Repositories\AddressRepositoryInterface;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\Address;
use MerakiShop\Models\User;

class AddressController extends Controller
{
    // public function __construct(private AddressRepositoryInterface $repository) {
    // }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authenticatable $user)
    {
        try {
            $user = User::find($user['id']);

            if (!$user) {
                return response()->json([ 'message' => 'Nenhum endereço existente'], 404);
            }

            return response()->json( $user->address);
        } catch (\Throwable $e) {

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Authenticatable $user)
    {
        return DB::transaction(function () use ($request, $user) {
            return Address::create([
                'user_id' => $user['id'],
                'label' => $request['label'],
                'recipient_name' => $request['recipient_name'],
                'street' => $request['street'],
                'number' => $request['number'] ?? null,
                'neighborhood' => $request['neighborhood'],
                'complement' => $request['complement'] ?? null,
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'postal_code' => $request['postal_code'],
            ]);
        }, 3);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Authenticatable $user)
    {
        return DB::transaction(function () use ($id, $request, $user) {
            $address = $this->findById($id);

            if (!$address || $user['id'] !== $address->user_id) {
                return null;
            }

            $address->update([
                'label' => $request['label'] ?? $address->label,
                'recipient_name' => $request['recipient_name'] ?? $address->recipient_name,
                'street' => $request['street'] ?? $address->street,
                'number' => $request['number'] ?? $address->number,
                'neighborhood' => $request['neighborhood'] ?? $address->neighborhood,
                'complement' => $request['complement'] ?? $address->complement,
                'city' => $request['city'] ?? $address->city,
                'state' => $request['state'] ?? $address->state,
                'country' => $request['country'] ?? $address->country,
                'postal_code' => $request['postal_code'] ?? $address->postal_code,
            ]);

            return $address->fresh();
        }, 3);
    }
}
