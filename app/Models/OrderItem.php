<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;

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
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
