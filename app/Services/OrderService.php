<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Http\Resources\TransactionResource;
use App\Models\Film;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function store()
    {
        try {
            DB::begintransaction();
            $order = Order::create([
                'user_id' => auth()->id(),
            ]);
            auth()->user()->productInCart()->updateExistingPivot(
                [auth()->user()->productIncart->pluck('id')],
                ['order_id' => $order->id]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'ошибка создания заказа',

            ]);
        }
        return OrderResource::make($order)->resolve();
    }

    public static function updateProducts($data, $order)
    {
        if ($order->status === Order::STATUS_CREATE) {
            auth()->user()->products()
                ->wherePivot('order_id', $order->id)
                ->updateExistingPivot($data['product_id'], [
                    'count_product' => $data['count_product'],
                ]);
        } else
            return response()->json([
                'message' => 'такого заказа не существует!',
            ]);

        return response()->json([
            'message' => 'продукт в заказе обновлен',
        ]);
    }

    //удаление продуктов из заказа
    public static function destroyProducts($data, $order)
    {
        //если заказ создан , но не оплачен
        if ($order->status === Order::STATUS_CREATE) {
            auth()->user()->products()
                ->wherePivot('order_id', $order->id)->
                detach($data['product_id']);
        }
        return response()->json([
            'message' => 'проудкт удален из заказа',
        ]);
    }

    //оплата заказа( поупка продукта и вчет ее суммы из баланса прфоля)
    public static  function storeTransaction($data, $order)
    {
        try {
            DB::beginTransaction();
            $transaction = $order->transactions()->create($data);
            //вычитаем из баланса пользователя сумму продуктов заказа
            $transaction->user->profile->update(
                ['balance'=> $transaction->user->profile->balance - $order->total],
            );
            $order->update([
                'status' => Order::STATUS_SUCCESS,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'mesage' => 'error',
            ]);
        }
        return TransactionResource::make($transaction);
    }
}
