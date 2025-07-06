<?php

namespace MerakiShop\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'workos_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'workos_id',
        'remember_token',
        'role',
    ];

    protected $appends = ['first_name', 'last_name', 'is_admin'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === 'a'
        )->shouldCache();
    }

    /**
     * Get the user's first name.
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Str::before($this->name, ' ')),
        );
    }

    /**
     * Get the user's last name.
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $nameParts = explode(' ', $this->name);
                if (count($nameParts) <= 1) {
                    return '';
                }

                return ucfirst(end($nameParts));
            }
        );
    }

    /**
     * Get the addres associated with the user
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Get the customer_card associated with the user
     */
    public function customerCard(): HasOne
    {
        return $this->hasOne(CustomerCard::class);
    }

    /**
     * Get the customer_card associated with the user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
