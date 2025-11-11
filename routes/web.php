<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\VendorController;

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
Route::get('/vendor', function () {
    return view('vendor.vendor');});
#Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.store');
Route::get('/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');

#Route::get('/vendor/tambah', function () {
#    return view('vendor.tambah');
#})->name('vendor.tambah');
#
#Route::get('/vendor/edit', function () {
#    return view('vendor.edit');
#})->name('vendor.edit');




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


