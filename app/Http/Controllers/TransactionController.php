<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequestDebit;
use App\Http\Requests\Transaction\UpdateStatusRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    //при пополнении баланса
    public function storeTypeDebit(StoreRequestDebit $request)
    {
        $data = $request->validationData();
        $transaction = Transaction::create($data);
        return TransactionResource::make($transaction);

    }



    //платежная система сюда должна отправить статус успех
    public function updateStatusSuccess(Transaction $transaction, UpdateStatusRequest $request)
    {

            $transaction->update($request->validated());

        try {
            DB::beginTransaction();
            $transaction->update([
                'status' => Transaction::STATUS_SUCCESS,
            ]);
            //сумма транзакции к балансу профиля
            $transaction->user->profile->update([
                'balance' => $transaction->user->profile->balance + $transaction->amount,
            ]);
            DB::commit();
            return response()->json([
                'статус' => 'успех ',

            ]);

        } catch (\Exception $ex) {
            DB::rollBack();
            $transaction->update([
                'status' => Transaction::STATUS_EXTERNAL_FAILED,
                'error_message' => $ex->getMessage()
            ]);
            return response()->json([
                'ошибка' => 'ошибка ',

            ]);
        }
    }

    public function updateStatusExternalFailed(Transaction $transaction)
    {


        $transaction->update([
            'status' => Transaction::STATUS_EXTERNAL_FAILED,
        ]);
        return response()->json([
            'сообщение' => 'успех',

        ]);
    }
}
