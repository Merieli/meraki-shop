<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    /**
     * Get the customer_card associated with the user
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
