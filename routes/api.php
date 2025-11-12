<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\StockOutController;
use App\Http\Controllers\Api\FinancialTransactionController;
use App\Http\Controllers\Api\UserController;


// Vendor API Routes
Route::get('/vendor', [VendorController::class, 'index'])->name('api.vendor.index');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy']);


// Produk API Routes
Route::get('/produk', [ProductController::class, 'index'])->name('api.produk.index');
Route::delete('/produk/{id}', [ProductController::class, 'destroy'])->name('api.produk.destroy');

// Stok Terkini API Routes
Route::get('/stok_terkini', [StockController::class, 'index'])->name('api.stok_terkini.index');

// Barang Masuk API Routes
Route::get('/barang_masuk', [PurchaseController::class, 'index'])->name('api.barang_masuk.index');
Route::delete('/barang_masuk/{id}', [PurchaseController::class, 'destroy'])->name('api.barang_masuk.destroy');

// Barang Keluar API Routes
Route::get('/barang_keluar', [StockOutController::class, 'index'])->name('api.barang_keluar.index');
Route::delete('/barang_keluar/{id}', [StockOutController::class, 'destroy'])->name('api.barang_keluar.destroy');

// Riwayat Transaksi API Routes
Route::get('/riwayat_transaksi', [FinancialTransactionController::class, 'index'])->name('api.riwayat_transaksi.index');
Route::delete('/riwayat_transaksi/{id}', [FinancialTransactionController::class, 'destroy'])->name('api.riwayat_transaksi.destroy');

// Pengguna API Routes
Route::get('/pengguna', [UserController::class, 'index'])->name('api.pengguna.index');
Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('api.pengguna.destroy');
