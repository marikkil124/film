<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = false;


const   STATUS_CREATE = 1;
  const  STATUS_SUCCESS = 2;
  const  STATUS_ERROR = 3;

    const STATUSES = [
        self::STATUS_CREATE => 'Заказ создан',
        self::STATUS_SUCCESS => 'Заказ оплачен',
        self::STATUS_ERROR => 'Заказ ошибка',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user', 'order_id', 'product_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products()->withPivot('count_product')->get()->sum(function ($x)
            {
               return ($x->getOriginal('pivot_count_product')??1) *  $x->price;
            })

        );

    }

}
