<?php

namespace MerakiShop\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MerakiShop\Contracts\Repositories\AddressRepositoryInterface;
use MerakiShop\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function create(Request $request, Authenticatable $user): Address
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

    public function update(Request $request, string $id, Authenticatable $user): ?Address
    {
        return DB::transaction(function () use ($id, $request, $user) {
            $address = $this->findById($id);

            if (! $address || $user['id'] !== $address->user_id) {
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

    public function findById(string $id): ?Address
    {
        return Address::find($id);
    }
}
