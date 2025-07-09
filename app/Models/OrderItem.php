<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MerakiShop\Models\Order;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'quantity',
        'unit_price',
    ];

    /**
     * Get the order associated with the order item
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
