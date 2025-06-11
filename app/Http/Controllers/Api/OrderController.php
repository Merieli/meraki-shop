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
use MerakiShop\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Authenticatable $user)
    {
        try {
            if ($request->input('scope') === 'all') {
                $orders = Order::with(['orderItem.product', 'user'])
                    ->latest()
                    ->get();

                Logger::info('All orders found for dashboard', ['count' => $orders->count()]);
            } else {
                $user = User::find($user['id']);
                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                $orders = Order::where('user_id', $user['id'])
                    ->with(['orderItem.product'])
                    ->get();

                if ($orders->isEmpty()) {
                    return response()->json(['message' => 'No existing orders'], 404);
                }

                Logger::info('Orders found for user', ['user_id' => $user['id'], 'count' => $orders->count()]);
            }

            // Transform orders data to match frontend expectations
            $formattedOrders = $orders->map(function ($order) {
                $item = $order->orderItem;
                $product = $item ? $item->product : null;

                if ($order->user) {
                    // Format for dashboard view (includes user and order_items)
                    return [
                        'id' => $order->id,
                        'status' => $order->status,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                        'user' => [
                            'id' => $order->user->id,
                            'name' => $order->user->name,
                        ],
                        'order_items' => $item ? [
                            [
                                'id' => $item->id,
                                'product_id' => $item->product_id,
                                'variation_id' => $item->variation_id,
                                'quantity' => $item->quantity,
                                'unit_price' => $item->unit_price
                            ]
                        ] : []
                    ];
                } else {
                    // Format for user orders view
                    return [
                        'id' => $order->id,
                        'status' => $order->status,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                        'items' => $item ? [
                            [
                                'id' => $item->id,
                                'product_id' => $item->product_id,
                                'variation_id' => $item->variation_id,
                                'product_name' => $product ? $product->name : 'Unknown Product',
                                'variation_name' => $item->variation ? $item->variation->name : 'Standard',
                                'quantity' => $item->quantity,
                                'unit_price' => $item->unit_price
                            ]
                        ] : []
                    ];
                }
            });

            return response()->json($formattedOrders);
        } catch (\Throwable $e) {
            Logger::error('Error fetching orders', [$e]);
            return response()->json(
                ['message' => 'Error fetching orders'],
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
                return response()->json(['message' => 'User not found'], 401);
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
                    'variation_id' => $request->variation_id ?? null,
                    'quantity' => $request->quantity ?? 1,
                    'unit_price' => $request->unit_price,
                ]);

                Logger::info('Order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $user['id']
                ]);

                $product = Product::find($request->product_id);

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
                            'product_name' => $product ? $product->name : 'Unknown Product',
                            'variation_name' => 'Standard',
                            'quantity' => $orderItem->quantity,
                            'unit_price' => $orderItem->unit_price
                        ]
                    ]
                ];

                return response()->json($response, 201);
            }, 3);
        } catch (\Throwable $e) {
            Logger::error('Failed to create order', [$e->getMessage()]);
            return response()->json(
                ['message' => 'Failed to create order: ' . $e->getMessage()],
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id, Authenticatable $user)
    {
        try {
            return DB::transaction(function () use ($id, $request, $user) {
                $order = Order::find($id);

                if (!$order) {
                    return response()->json(['message' => 'Order not found'], 404);
                }

                if ($user['id'] !== $order->user_id) {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }

                $order->update([
                    'status' => $request['status'] ?? $order->status,
                ]);

                return response()->json($order->fresh());
            }, 3);
        } catch (\Throwable $e) {
            Logger::error('Failed to update order', [$e->getMessage()]);
            return response()->json(
                ['message' => 'Failed to update order: ' . $e->getMessage()],
                500
            );
        }
    }
}
