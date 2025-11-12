<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/dashboard', function () {
    return view('app.beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

route::get('/beranda', function () {
    return view('app.beranda');
});

// Vendor 
Route::get('/vendor', function () {
    return view('vendor.index');})->name('vendor.index');

//Ke halaman create vendor
Route::get('/vendor/create', function () {
    return view('vendor.store');})->name('vendor.create');

//Ketika Submit Akan Menjalankan Method Store di VendorController
Route::post('/vendor/create', [VendorController::class, 'store'])->name('vendor.store');

//Ke halaman edit vendor
Route::get('/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');

//Ketika Submit Akan Menjalankan Method Update di VendorController
Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');

//=========================================================================================================
// Produk 
Route::get('/produk', function () {
    return view('produk.index');})->name('produk.index');

//Ke halaman create Produk
Route::get('/produk/create', function () {
    return view('produk.store');})->name('produk.create');

//Ketika Submit Akan Menjalankan Method Store di ProdukController
Route::post('/produk/create', [ProductController::class, 'store'])->name('produk.store');

//Ke halaman edit Produk
Route::get('/produk/{id}/edit', [ProductController::class, 'edit'])->name('produk.edit');

//Ketika Submit Akan Menjalankan Method Update di ProdukController
Route::put('/produk/{id}', [ProductController::class, 'update'])->name('produk.update');

//=========================================================================================================
// Stok Terkini 
Route::get('/stok_terkini', function () {
    return view('stok_terkini.index');})->name('stok_terkini.index');

//=========================================================================================================
// Barang Masuk 
Route::get('/barang_masuk', function () {
    return view('barang_masuk.index');})->name('barang_masuk.index');

//Ke halaman create Barang Masuk
Route::get('/barang_masuk/create', function () {
    return view('barang_masuk.store');})->name('barang_masuk.create');

//Ketika Submit Akan Menjalankan Method Store di BarangMasukController
Route::post('/barang_masuk/create', [Barang_MasukController::class, 'store'])->name('barang_masuk.store');

//Ke halaman edit Barang Masuk
Route::get('/barang_masuk/{id}/edit', [Barang_MasukController::class, 'edit'])->name('barang_masuk.edit');

//Ketika Submit Akan Menjalankan Method Update di BarangMasukController
Route::put('/barang_masuk/{id}', [Barang_MasukController::class, 'update'])->name('barang_masuk.update');

//=========================================================================================================
// Barang Keluar 
Route::get('/barang_keluar', function () {
    return view('barang_keluar.index');})->name('barang_keluar.index');

//Ke halaman create Barang Keluar
Route::get('/barang_keluar/create', function () {
    return view('barang_keluar.store');})->name('barang_keluar.create');

//Ketika Submit Akan Menjalankan Method Store di BarangKeluarController
Route::post('/barang_keluar/create', [Barang_KeluarController::class, 'store'])->name('barang_keluar.store');

//Ke halaman edit Barang Keluar
Route::get('/barang_keluar/{id}/edit', [Barang_KeluarController::class, 'edit'])->name('barang_keluar.edit');

//Ketika Submit Akan Menjalankan Method Update di BarangKeluarController
Route::put('/barang_keluar/{id}', [Barang_KeluarController::class, 'update'])->name('barang_keluar.update');

//=========================================================================================================
// Riwayat Transaksi 
Route::get('/riwayat_transaksi', function () {
    return view('riwayat_transaksi.index');})->name('riwayat_transaksi.index');

//Ke halaman create Barang Keluar
Route::get('/riwayat_transaksi/create', function () {
    return view('riwayat_transaksi.store');})->name('riwayat_transaksi.create');

//Ketika Submit Akan Menjalankan Method Store di BarangKeluarController
Route::post('/riwayat_transaksi/create', [Riwayat_TransaksiController::class, 'store'])->name('riwayat_transaksi.store');

//Ke halaman edit Barang Keluar
Route::get('/riwayat_transaksi/{id}/edit', [Riwayat_TransaksiController::class, 'edit'])->name('riwayat_transaksi.edit');

//Ketika Submit Akan Menjalankan Method Update di BarangKeluarController
Route::put('/riwayat_transaksi/{id}', [Riwayat_TransaksiController::class, 'update'])->name('riwayat_transaksi.update');

//=========================================================================================================
// Pengguna 
Route::get('/pengguna', function () {
    return view('pengguna.index');})->name('pengguna.index');

//Ke halaman create Barang Keluar
Route::get('/pengguna/create', function () {
    return view('pengguna.store');})->name('pengguna.create');

//Ketika Submit Akan Menjalankan Method Store di BarangKeluarController
Route::post('/pengguna/create', [UserController::class, 'store'])->name('pengguna.store');

//Ke halaman edit Barang Keluar
Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');

//Ketika Submit Akan Menjalankan Method Update di BarangKeluarController
Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');

require __DIR__.'/auth.php';
