<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = false;

    const TYPE_DEBIT = 1;
    const TYPE_CREDIT = 2;

    const STATUS_CREATE = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILED = 3;
    const STATUS_EXTERNAL_FAILED = 4;

    const STATUSES = [
        self::STATUS_CREATE=>'транзакция создана',
        self::STATUS_SUCCESS=>'транзакция успешна',
        self::STATUS_FAILED=>'транзакция ошибка',
        self::STATUS_EXTERNAL_FAILED=>'транзакция из платежки ошибка',
    ];
    const TYPES = [
        self::TYPE_DEBIT=>'пополнение',
        self::TYPE_CREDIT=>'списание',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
