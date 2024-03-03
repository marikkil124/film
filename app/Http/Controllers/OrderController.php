<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\DeleteProductInOrderRequest;
use App\Http\Requests\Order\StoreRequestCredit;
use App\Http\Requests\Order\StoreTransactionRequest;
use App\Http\Requests\Order\UpdateProuductInCartRequest;
use App\Http\Requests\Order\UpdateStatusReques;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TransactionResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request)
    {
       return OrderService::store();
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
         return  OrderService::updateProducts($data, $order);
    }
    //удаление продукта из заказа
    public function destroyProducts(Order $order, DeleteProductInOrderRequest $request)
    {
        $data = $request->validated();
        return  OrderService::destroyProducts($data, $order);
    }
    public function storeTransaction(Order $order,StoreTransactionRequest $request)
    {
        $data = $request->validationData();
        return  OrderService::storeTransaction($data, $order);

    }

}
