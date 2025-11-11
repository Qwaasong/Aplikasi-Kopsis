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
Route::get('/produk', [VendorController::class, 'index'])->name('api.produk.index');
Route::delete('/produk/{produk}', [VendorController::class, 'destroy'])->name('api.vendor.destroy');

// Stok Terkini API Routes
Route::get('/stok_terkini', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/stok_terkini/{stok_terkini}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');

// Barang Masuk API Routes
Route::get('/barang_masuk', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/barang_masuk/{barang_masuk}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');

// Barang Keluar API Routes
Route::get('/barang_keluar', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/barang_keluar/{barang_keluar}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');

// Riwayat Transaksi API Routes
Route::get('/riwayat_transaksi', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/riwayat_transaksi/{riwayat_transaksi}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');

// Pengguna API Routes
Route::get('/pengguna', [VendorController::class, 'index'])->name('api.vendors.index');
Route::delete('/pengguna/{pengguna}', [VendorController::class, 'destroy'])->name('api.vendors.destroy');