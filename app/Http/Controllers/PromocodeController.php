<?php

namespace App\Http\Controllers;

use App\Http\Requests\Promocode\UpdateUserRequest;
use App\Http\Resources\PromocodeResource;
use App\Models\Promocode;

class PromocodeController extends Controller
{
    public function updateUser(UpdateUserRequest $request)
    {

        $data = $request->validationData();
        Promocode::where('user_id', auth()->id())->update([
            'user_id' => null,
        ]);
        Promocode::where('code',   $data['code'])->update(
            [
                'user_id' => auth()->id(),
            ]
        );

        $p =Promocode::where('code',   $data['code'])->first();
        return PromocodeResource::make($p)->resolve();

       // return response()->json(['message'=>'Обновлен пользователь в промокоде']);
    }
}
