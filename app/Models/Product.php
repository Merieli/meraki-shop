<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'price',
        'cost_price',
        'stock',
        'thumbnail',
        'images',
        'short_description',
        'description',
        'rating',
        'sku'
    ];

}
