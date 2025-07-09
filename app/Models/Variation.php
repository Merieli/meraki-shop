<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'price',
        'stock',
        'sku',
        'available'
    ];
}
