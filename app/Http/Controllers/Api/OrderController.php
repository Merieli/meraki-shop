<?php

namespace MerakiShop\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MerakiShop\Facades\Logger;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Http\Requests\IndexOrderRequest;
use MerakiShop\Http\Requests\StoreOrderRequest;
use MerakiShop\Http\Requests\UpdateOrderRequest;
use MerakiShop\Models\{
    Order,
    OrderItem
};
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(IndexOrderRequest $request, Authenticatable $user): JsonResponse
    {
        try {
            /** @var int $userId */
            $userId = $user->getAuthIdentifier();
            $user = Auth::user();

            $scope = $request->input('scope');
            $notHasPermission = $user?->tokenCant('orders:get-all');

            if (! $userId || ($notHasPermission && $scope === 'all')) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $orderModel = Order::with(['orderItems.product', 'user']);

            if (empty($scope) ||  $scope === 'user') {
                $orderModel = Order::with(['orderItems.product'])
                    ->where('user_id', $userId);
            }

            $orders = $orderModel
                ->latest()
                ->get();


            if ($orders->isEmpty()) {
                $orders = [];
            }

            return response()->json($orders);
        } catch (Throwable $e) {
            Logger::error('Error fetching orders', [$e]);

            return response()->json(
                ['message' => 'Error fetching orders'],
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StoreOrderRequest $request, Authenticatable $user): JsonResponse
    {
        try {
            $userId = $user->getAuthIdentifier();

            return DB::transaction(function () use ($request, $userId) {
                $order = Order::create([
                    'user_id' => $userId,
                    'status' => $request->status,
                    'payment_method' => $request->payment_method,
                ]);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'variation_id' => $request->variation_id ?? null,
                    'quantity' => $request->quantity ?? 1,
                    'unit_price' => $request->unit_price,
                ]);

                Logger::info('Order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $userId,
                ]);

                $response = [
                    'id' => $order->id,
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                    'items' => [
                        [
                            'id' => $orderItem->id,
                            'product_id' => $orderItem->product_id,
                            'variation_id' => $orderItem->variation_id,
                            'product_name' =>  $orderItem->product ? $orderItem->product->name : 'Unknown Product',
                            'variation_name' => 'Standard',
                            'quantity' => $orderItem->quantity,
                            'unit_price' => $orderItem->unit_price,
                        ],
                    ],
                ];

                return response()->json($response, 201);
            }, 3);
        } catch (Throwable $e) {
            Logger::error('Failed to create order', [$e->getMessage()]);

            return response()->json(
                ['message' => 'Failed to create order: '.$e->getMessage()],
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(UpdateOrderRequest $request, string $id, Authenticatable $user): JsonResponse
    {
        try {
            return DB::transaction(function () use ($id, $request, $user) {
                $order = Order::find($id);

                if (! $order) {
                    return response()->json(['message' => 'Order not found'], 404);
                }

                $userId = $user->getAuthIdentifier();
                if ($userId !== $order->user_id) {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }

                $order->update([
                    'status' => $request['status'] ?? $order->status,
                ]);

                return response()->json($order->fresh());
            }, 3);
        } catch (Throwable $e) {
            Logger::error('Failed to update order', [$e->getMessage()]);

            return response()->json(
                ['message' => 'Failed to update order: '.$e->getMessage()],
                500
            );
        }
    }
}
