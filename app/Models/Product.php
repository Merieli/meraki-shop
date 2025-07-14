<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'sku',
    ];

    /**
     * @throws \Throwable
     */
    protected static function booted(): void
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('name');
        });
    }
}
