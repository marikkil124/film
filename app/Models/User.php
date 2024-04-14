<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn($v) => $this->role->pluck('title')->contains('admin'),

        );
    }

    public function promocode()
    {
        return $this->hasMany(Promocode::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function productInCart()
    {
        return $this->belongsToMany(Product::class)->wherePivot('order_id',null);

    }

    protected function totalInCart(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->productInCart()->withPivot('count_product')->get()->sum(function ($x)
            {

               return ($x->getOriginal('pivot_count_product')??1) *  $x->price;

            })

        );

    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
