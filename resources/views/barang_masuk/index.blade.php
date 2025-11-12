@extends('layouts.main')
@section('title', 'KopsisApp - Vendor')
@section('content')
    <div class="px-8 py-6">
        <!-- Header Konten -->
        <div class="flex flex-col space-y-4">
            <div class="flex items-center text-sm text-gray-500">
                <span>Manajemen Stok</span>
                <svg class="h-4 w-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Barang Masuk</span>
            </div>

            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-gray-900 m-0">Barang Masuk</h2>
                <button
                    class="hidden md:flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tambah Barang Masuk
                </button>
            </div>
        </div>

        <!-- FAB Container -->
        <div id="fab-container" class="fixed bottom-6 right-6 md:hidden z-50">

            <!-- Speed Dial Menu -->
            <div id="fab-menu"
                class="absolute bottom-full right-1 mb-4 flex flex-col items-end gap-3 opacity-0 translate-y-3 scale-95 pointer-events-none transition-all duration-300">

                <!-- Item 1 -->
                <button
                    class="flex items-center justify-between gap-3 bg-white/80 backdrop-blur-md px-4 py-2 rounded-full shadow-lg text-gray-800 hover:bg-white transition-all w-40">
                    <span class="text-sm font-medium">Tambah Barang Keluar</span>
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

            <!-- Tombol FAB -->
            <button id="fab-btn"
                class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full shadow-[0_4px_12px_rgba(0,0,0,0.3)] text-white cursor-pointer hover:bg-blue-700 transition-transform duration-300">
                <svg id="fab-icon" xmlns="http://www.w3.org/2000/svg" class="icon-rotate w-6 h-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <hr class="my-6 border-gray-200">
        {{-- PANGGIL COMPONENT --}}
        <x-table :data-table="[
                                    'Vendor' => 'vendor.nama_vendor',
                                    'Tanggal' => 'tanggal',
                                    'No Faktur' => 'no_faktur',
                                    'Tanggal Input' => 'created_at',
                                    ]" data-url="{{ route('api.barang_masuk.index') }}">
            {{-- Slot untuk filter --}}
            <x-slot:filter>
                <div class="flex items-center space-x-4">
                    <button id="filter-button"
                        class="p-3 sm:p-2 text-gray-500 border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>

                    <!-- Dropdown Filter -->
                    <div id="filter-dropdown"
                        class="hidden absolute mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl z-20 top-full">
                        <form id="filter-form" class="p-6 space-y-4">
                            <div>
                                <label for="filter_nama_vendor" class="block text-sm font-medium text-gray-700">Nama
                                    Vendor</label>
                                <input type="text" name="filter[nama_vendor]" id="filter_nama_vendor"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="filter_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <input type="text" name="filter[alamat]" id="filter_alamat"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="filter_start_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" name="filter[start_date]" id="filter_start_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="filter_end_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Akhir</label>
                                <input type="date" name="filter[end_date]" id="filter_end_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="flex justify-end space-x-2 pt-4">
                                <button type="button" id="reset-filter-btn"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Reset</button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </x-slot:filter>
        </x-table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/fab.js') }}"></script>
@endsection