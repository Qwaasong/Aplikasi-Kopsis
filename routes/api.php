<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Barang_MasukController;


// Vendor API Routes
Route::get('/vendor', [VendorController::class, 'index'])->name('api.vendor.index');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy']);


// Produk API Routes
Route::get('/produk', [ProductController::class, 'index'])->name('api.produk.index');
Route::delete('/produk/{id}', [ProductController::class, 'destroy'])->name('api.produk.destroy');

// Stok Terkini API Routes
Route::get('/stok_terkini', [StockController::class, 'index'])->name('api.stok_terkini.index');

// Barang Masuk API Routes
// API Barang Masuk (Purchase)
    Route::get('purchase', [Barang_MasukController::class, 'index'])->name('api.barang_masuk.index'); // <-- PERUBAHAN
    Route::get('purchase/{id}', [Barang_MasukController::class, 'show']); // <-- PERUBAHAN
    Route::delete('purchase/{id}', [Barang_MasukController::class, 'destroy']); // <-- PERUBAHAN
