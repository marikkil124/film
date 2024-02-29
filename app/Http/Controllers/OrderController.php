<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\DeleteProductInOrderRequest;
use App\Http\Requests\Order\UpdateProuductInCartRequest;
use App\Http\Requests\Order\UpdateStatusReques;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function store(CreateOrderRequest $request)
    {
        try {
            DB::begintransaction();
            $order= Order::create([
                'user_id'=>auth()->id(),
            ]);
            auth()->user()->productInCart()->updateExistingPivot(
                [auth()->user()->productIncart->pluck('id')],
                ['order_id' => $order->id]);

            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
        }

    }

    public function updateStatus(Order $order,UpdateStatusReques $request)
    {
        $data = $request->validated();
        $order->update($data);
       $order=  $order->fresh();

        return OrderResource::make($order);
    }

    //обновление продукта в заказе gde status ==1
    public function updateProducts(Order $order,UpdateProuductInCartRequest $request)
    {
        $data = $request->validated();
        if ($order->status===Order::STATUS_CREATE)
        {
            auth()->user()->products()
                ->wherePivot('order_id',$order->id)
                ->updateExistingPivot($data['product_id'], [
                'count_product' => $data['count_product'],
            ]);
            return response()->json([
                'message' => 'продукт в заказе обновлен',
            ]);
        }
        else
            return response()->json([
                'message' => 'такого заказа не существует!',
            ]);

    }

    //удаление продукта из заказа
    public function destroyProducts(Order $order, DeleteProductInOrderRequest $request)
    {
        $data = $request->validated();

        if ($order->status===Order::STATUS_CREATE)
            auth()->user()->products()
                ->wherePivot('order_id',$order->id)->
            detach($data['product_id']);

        return response()->json([
            'message' => 'проудкт удален из заказа',
        ]);


    }

}
