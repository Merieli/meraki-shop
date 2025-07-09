<?php

namespace MerakiShop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCard extends Model
{
    protected $fillable = [
        'user_id',
        'card_token',
        'card_last4',
        'card_brand',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
