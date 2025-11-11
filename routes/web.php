<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/dashboard', function () {
    return view('app.beranda'); // menyesuaikan dengan folder app/
})->middleware(['auth', 'verified'])->name('dashboard');

route::get('/beranda', function () {
    return view('app.beranda');
});

// Vendor 
Route::get('/vendor', function () { // <--- Route yang dituju
    return view('vendor.index');})->name('vendor.index');

//Ke halaman create vendor
Route::get('/vendor/create', function () {
    return view('vendor.store');})->name('vendor.create');

//Ketika Submit Akan Menjalankan Method Store di VendorController
Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.store');

//Ke halaman edit vendor
Route::get('/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');

//Ketika Submit Akan Menjalankan Method Update di VendorController
Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');


// Produk 
Route::get('/produk', function () {
    return view('app.produk');
});

Route::get('/produk/tambah', function () {
    return view('produk.tambah');
});



// Stok Terkini 
Route::get('/stok_terkini', function () {
    return view('app.stok_terkini');
});



// Barang Masuk 
Route::get('/barang_masuk', function () {
    return view('app.barang_masuk');
});



// =============== Barang Keluar 
Route::get('/barang_keluar', function () {
    return view('app.barang_keluar');
});



// =============== Riwayat Transaksi 
Route::get('/riwayat_transaksi', function () {
    return view('app.riwayat_transaksi');
});



// Pengguna 
Route::get('/pengguna', function () {
    return view('app.pengguna');
});
require __DIR__.'/auth.php';
