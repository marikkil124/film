<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreProductInCartRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateProuductInCart;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        dd($user);

    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'password'=>'required|string',
            'email'=> ['required',Rule::unique('users')->ignore(auth()->id())],
        ]);
       auth()->user()->update($data);

        return response()->json(['message' => 'пользователь обновлен',
        ]);
    }
    public function delete(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'user deleted',
        ]);
    }

//добавление продукта в корзину
    public function storeProductInCart(StoreProductInCartRequest $request)
    {
        $data = $request->validated();

      auth()->user()->productInCart()->syncWithoutDetaching($data);


        return response()->json([
            'message' => 'продукт доабвлен','total'=>auth()->user()->total_in_cart ,'count'=> auth()->user()->productInCart()->count()]);

    }

    //обновление текущего продука в корзине( его кличество)
    public function updateProductInCart(UpdateProuductInCart $request)
    {
        $data = $request->validated();


        auth()->user()->productInCart()->updateExistingPivot($data['product_id'],

            ['count_product'=>$data['count_product']]);

        return response()->json([
            'message' => 'продукт обновлен' ]);

    }

    //удаление текущего продукта из корзины
    public function deleteProductInCart(Request $request)
    {
        $data = $request->validate(
            [
                'product_id'=>'required|integer|exists:products,id'
            ]
        );
        auth()->user()->productInCart()->detach($data['product_id']);

        return response()->json([
            'product' => auth()->user()->productInCart ]);


    }

    public function productInCart()
    {
        $products = auth()->user()->productInCart;
        $total = auth()->user()->total_in_cart;
        return inertia('Product/cart/cart',compact('products','total'));

    }


}
