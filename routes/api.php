<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;


// Vendor API Routes
Route::get('/vendor', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy']);


// Produk API Routes
Route::apiResource('products', ProductController::class)->names('api.products');
Route::get('/products', [VendorController::class, 'index']);
Route::delete('/products/{id}', [VendorController::class, 'destroy']);


// Stok Terkini (misalnya daftar stok aktif)
Route::get('/stocks', [StockController::class, 'index'])->name('api.stocks.index');


// Barang Masuk & Keluar (opsional bisa dipisah controller-nya nanti)
Route::get('/barang_masuk', [TransactionController::class, 'incoming'])->name('api.barang_masuk.index');
Route::get('/barang_keluar', [TransactionController::class, 'outgoing'])->name('api.barang_keluar.index');


// Riwayat Transaksi API Routes
Route::get('/riwayat_transaksi', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/riwayat_transaksi/{riwayat_transaksi}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');

// Pengguna API Routes
Route::get('/pengguna', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/pengguna/{pengguna}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');