<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MerakiShop\Contracts\Repositories\AddressRepositoryInterface;
use MerakiShop\Contracts\Repositories\UserRepositoryInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AddressRepositoryInterface $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authenticatable $user): JsonResponse
    {
        try {
            $user = $this->userRepository->findById($user['id']);

            if (! $user) {
                return response()->json(['message' => 'Nenhum endereço existente'], 404);
            }

            return response()->json($user->address);
        } catch (\Throwable $e) {
            Logger::error('List Address', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()
                ->json(
                    [
                        'message' => 'Não foi possível listar o endereço',
                    ],
                    $e->getCode()
                );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Authenticatable $user): JsonResponse
    {
        try {
            $newAddress = $this->repository->create($request, $user);

            return response()->json(
                $newAddress,200
            );
        } catch (\Throwable $e) {
            Logger::error('Create Address', [
               'exception' => $e,
               'request' => $request,
            ]);

            return response()
                ->json(
                    [
                        'message' => 'Não foi possível salvar o endereço',
                    ],
                    $e->getCode()
                );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Authenticatable $user): JsonResponse
    {
        try {
            $address = $this->repository
                ->update($request, $id, $user);

            return response()->json($address,200);
        } catch (\Throwable $e) {
            Logger::error('Update Address', [
                'exception' => $e,
                'request' => $request,
            ]);

            return response()
                ->json(
                    [
                        'message' => 'Não foi possível atualizar o endereço',
                    ],
                    $e->getCode()
                );
        }
    }
}
