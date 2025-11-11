<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;


// Vendor API Routes
Route::apiResource('vendors', VendorController::class)->names('api.vendors');
Route::get('/vendor', [VendorController::class, 'index']);
Route::delete('/vendor/{id}', [VendorController::class, 'destroy']);



// Produk API Routes
Route::apiResource('products', ProductController::class)->names('api.products');


// Stok Terkini (misalnya daftar stok aktif)
Route::get('/stocks', [StockController::class, 'index'])->name('api.stocks.index');


// Barang Masuk & Keluar (opsional bisa dipisah controller-nya nanti)
Route::get('/barang_masuk', [TransactionController::class, 'incoming'])->name('api.barang_masuk.index');
Route::get('/barang_keluar', [TransactionController::class, 'outgoing'])->name('api.barang_keluar.index');


// Riwayat Transaksi
Route::get('/riwayat_transaksi', [TransactionController::class, 'history'])->name('api.transaksi.history');


// Pengguna
Route::apiResource('users', UserController::class)->names('api.users');
