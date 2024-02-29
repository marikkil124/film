<?php

namespace App\Models;

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
}
