<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use MerakiShop\Http\Requests\StoreOrderRequest;
use MerakiShop\Http\Requests\UpdateOrderRequest;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\{
    Order,
    OrderItem,
    User
};
use MerakiShop\Facades\Logger;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authenticatable $user)
    {
        try {
            $user = User::find($user['id']);
            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $orders = Order::where('user_id', $user['id'])
                ->with(['orderItems.product'])
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['message' => 'Nenhum pedido existente'], 404);
            }

            Logger::info('Orders found for user', ['user_id' => $user['id'], 'count' => $orders->count()]);
            return response()->json($orders);
        } catch (\Throwable $e) {
            Logger::error('Erro ao buscar pedidos', [$e]);
            return response()->json(
                ['message' => 'Erro ao buscar pedidos'],
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, Authenticatable $user)
    {
        try {
            if (empty($user['id'])) {
                return response()->json(['message' => 'Usuário não encontrado'], 401);
            }

            return DB::transaction(function () use ($request, $user) {
                $order = Order::create([
                    'user_id' => $user['id'],
                    'status' => $request->status,
                    'payment_method' => $request->payment_method,
                ]);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'quantity' => 1,
                    'unit_price' => $request->unit_price,
                ]);

                Logger::error('Order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $user['id']
                ]);

                return response()->json(
                    $order->orderItem,
                    201
                );
            }, 3);
        } catch (\Throwable $e) {
            Logger::error('Failed to create order', [$e]);
            return response()->json(
                ['message' => 'Erro ao criar pedido'],
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id, Authenticatable $user)
    {
        return DB::transaction(function () use ($id, $request, $user) {
            $order = $this->findById($id);

            if (!$order || $user['id'] !== $order->user_id) {
                return null;
            }

            $order->update([
                'status' => $request['status'] ?? $order->status,
            ]);

            return $order->fresh();
        }, 3);
    }
}
