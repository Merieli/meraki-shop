<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCard extends Model
{
    protected $fillable = [
        'user_id',
        'card_token',
        'card_last4',
        'card_brand',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
