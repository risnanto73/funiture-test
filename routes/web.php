<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyTransaksiController;
use App\Http\Controllers\ProdukGaleriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;

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

Route::get('/', [FrontEndController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontEndController::class, 'details'])->name('details');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
    Route::post('/cart/{id}',[FrontEndController::class,'cartAdd'])->name('cart-add');
    Route::delete('/cart/{id}',[FrontEndController::class,'cartDelete'])->name('cart-delete');
    Route::post('/checkout', [FrontEndController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', [FrontEndController::class, 'success'])->name('checkout-success');
});

Route::middleware(['auth:sanctum', 'verified'])->name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index'); //dashboard.index
    Route::resource('my-transaksi', MyTransaksiController::class)->only([
        'index',
        'show'
    ]);

    Route::middleware(['admin'])->group(function () {
        Route::resource('produk', ProdukController::class);
        Route::resource('produk.galeri', ProdukGaleriController::class)->shallow()->only([
            'index',
            'create',
            'store',
            'destroy',
        ]);
        Route::resource('transaksi', TransaksiController::class)->only([
            'index',
            'show',
            'edit',
            'update'
        ]);
        Route::resource('user', UserController::class)->only([
            'index',
            'edit',
            'update',
            'destroy'
        ]);
    });
});


