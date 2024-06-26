<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});
Route::middleware(['auth.admin','jwt.auth'])->group(function () {
    Route::apiResource('films', \App\Http\Controllers\admin\Film\FilmController::class);

});

Route::middleware(['jwt.auth'])->group(function () {
    Route::apiResource('films', \App\Http\Controllers\admin\Film\FilmController::class);
    Route::post('/user', [\App\Http\Controllers\UserController::class, 'store']);
    Route::patch('/user', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/{user}', [\App\Http\Controllers\UserController::class, 'delete']);


    Route::post('/user/store-product-cart', [\App\Http\Controllers\UserController::class, 'storeProductInCart']);
    Route::patch('/user/update-product-cart', [\App\Http\Controllers\UserController::class, 'updateProductInCart']);
    Route::post('/user/destroy-product-cart', [\App\Http\Controllers\UserController::class, 'deleteProductInCart']);


    Route::patch('/promocode/update-user-id', [\App\Http\Controllers\admin\PromocodeController::class, 'updateUser']);
    Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store']);

    //обновление статуса в заказе
    Route::patch('/order/{order}/update-order-status', [\App\Http\Controllers\OrderController::class, 'updateStatus']);
    //изменение количества товара в заказе
    Route::patch('/order/{order}/products', [\App\Http\Controllers\OrderController::class, 'updateProducts']);
    //удаление  товара из заказа
    Route::delete('/order/{order}/products', [\App\Http\Controllers\OrderController::class, 'destroyProducts']);
    //списание со счета/ покупка проудкта
    Route::post('/order/{order}/transaction', [\App\Http\Controllers\OrderController::class, 'storeTransaction']);

        //создание транзакции (пополнение баланса)
    Route::post('/transaction/store-type-debit', [\App\Http\Controllers\TransactionController::class, 'storeTypeDebit']);
    //платежная система сюда должна отправить статус успех
   // Route::patch('/transaction/{transaction}/status-success', [\App\Http\Controllers\TransactionController::class, 'updateStatusSuccess']);
    //платежная система сюда должна отправить статус ошибка
    Route::patch('/transaction/{transaction}/status-external-failed', [\App\Http\Controllers\TransactionController::class, 'updateStatusExternalFailed']);


});
Route::patch('/transaction/{transaction}/status-success', [\App\Http\Controllers\TransactionController::class, 'updateStatusSuccess']);
Route::get('/profiles', [\App\Http\Controllers\admin\Profile\ProfileController::class,'index']);

Route::resource('products',\App\Http\Controllers\ProductController::class);
