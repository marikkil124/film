<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateStatusRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TransactionController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $transaction = Transaction::create($data);
        return TransactionResource::make($transaction);
    }

    //платежная система сюда должна отправить статус успех
    public function updateStatus(Transaction $transaction, UpdateStatusRequest $request)
    {

        try {
            DB::beginTransaction();

            $transaction->update($request->validated());
            //сумма транзакции к балансу профиля
            $transaction->user->profile->update([
                'balance' => $transaction->user->profile->balance + $transaction->amount,

            ]);
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            $transaction->update([
                'status' => Transaction::STATUS_EXTERNAL_FAILED,
                'error_message'=>$ex->getMessage()
            ]);
            return response()->json([
                'ошибка' => 'ошибка ',

            ]);
        }


    }
}
