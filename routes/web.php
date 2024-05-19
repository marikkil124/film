<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products',\App\Http\Controllers\Admin\ProductController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('products',\App\Http\Controllers\ProductController::class);

    Route::post('/user/store-product-cart', [\App\Http\Controllers\UserController::class, 'storeProductInCart']);
    Route::patch('/user/update-product-cart', [\App\Http\Controllers\UserController::class, 'updateProductInCart']);
    Route::post('/user/destroy-product-cart', [\App\Http\Controllers\UserController::class, 'deleteProductInCart']);

    Route::get('/references/product-count', [\App\Http\Controllers\References::class, 'productCount']);

    Route::get('/user/product-cart', [\App\Http\Controllers\UserController::class, 'productInCart'])->name('cart');



    Route::prefix('favourite')->name('favourite.')->group(function () {
        //мои любимые фильмы
        Route::prefix('films')->group(function () {
            Route::get('/', \App\Http\Controllers\FavouriteFilm\IndexController::class)->name('films');
        });
    });

    Route::get('/films', [\App\Http\Controllers\FilmController::class, 'index']);
    Route::post('/film', [\App\Http\Controllers\FilmController::class, 'store']);
});



//
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
