@extends('layouts.navigation')

@section('title', 'Beranda - KopsisApp')
@section('content')
    <!-- Konten yang bisa di-scroll -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-6">
        <h1 class="text-3xl md:text-2xl font-bold text-gray-800 mb-6">Beranda</h1>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500">Saldo</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">1.000.000</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500">Pemasukan</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">500.000</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500">Pengeluaran</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">200.000</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">200</p>
            </div>
        </div>

        <!-- Chart Cards -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-5 gap-4 md:gap-6">
            <!-- Grafik Pemasukan & Pengeluaran -->
            <div class="lg:col-span-3 bg-white p-5 md:p-6 rounded-xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-lg">Pemasukan Dan Pengeluaran Minggu Ini</h3>
                <p class="text-3xl font-bold text-gray-800 mt-1">+12%</p>
                <p class="text-sm text-green-500 font-semibold">Minggu Ini +12%</p>
                <div class="mt-4 h-64">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>

            <!-- Distribusi Produk -->
            <div class="lg:col-span-2 bg-white p-5 md:p-6 rounded-xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-lg">Distribusi Produk (Berdasarkan Kategori)</h3>
                <p class="text-3xl font-bold text-gray-800 mt-1">+15%</p>
                <p class="text-sm text-green-500 font-semibold">Bulan Ini +15%</p>
                <div class="mt-6 flex justify-around items-end text-center h-48">
                    <div class="flex flex-col items-center w-1/4">
                        <div class="w-10/12 h-3/4 bg-gray-100 rounded-lg"></div>
                        <p class="mt-2 text-sm text-gray-600">Alat Tulis</p>
                    </div>
                    <div class="flex flex-col items-center w-1/4">
                        <div class="w-10/12 h-full bg-gray-100 rounded-lg"></div>
                        <p class="mt-2 text-sm text-gray-600">Makanan</p>
                    </div>
                    <div class="flex flex-col items-center w-1/4">
                        <div class="w-10/12 h-2/5 bg-gray-100 rounded-lg"></div>
                        <p class="mt-2 text-sm text-gray-600">Minuman</p>
                    </div>
                    <div class="flex flex-col items-center w-1/4">
                        <div class="w-10/12 h-3/5 bg-gray-100 rounded-lg"></div>
                        <p class="mt-2 text-sm text-gray-600">Lainnya</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    @vite(['resources/js/beranda.js'])
@endsection