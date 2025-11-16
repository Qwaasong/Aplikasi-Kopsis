@extends('layouts.main')
@section('title', 'KopsisApp - Vendor')
@section('content')
    <div class="px-8 py-6">
        <!-- Header Konten -->
        <div class="flex flex-col space-y-4">
            <div class="flex items-center text-sm text-gray-500">
                <span>Keuangan</span>
                <svg class="h-4 w-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Riwayat Transaksi</span>
            </div>

            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-gray-900 m-0">Riwayat Transaksi</h2>
                <div class="flex gap-4">
                    <button
                        class="hidden md:flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        onclick="openModal()">
                        Export PDF
                    </button>
                    <button
                        class="hidden md:flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        onclick="window.location.href='{{ route('riwayat_transaksi.create') }}'">
                        Tambah Transaksi
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Background -->
        <div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-start justify-center p-4 z-50">

            <!-- Modal Card -->
            <div class="bg-white w-full max-w-sm rounded-xl shadow-lg p-6">
                <form action="{{ route('laporan.keuangan.pdf') }}" method="GET">
                    <h2 class="text-xl font-semibold mb-4">Pilih Tanggal</h2>

                    <!-- Input Tanggal -->
                    <label class="block mb-2 text-sm font-medium">Tanggal:</label>
                    <div id="myDatePickerContainer" class="max-w-md">
                        <!-- DatePicker akan diinisialisasi di sini -->
                    </div>

                    <input type="hidden" name="start_date" id="start_date_input">
                    <input type="hidden" name="end_date" id="end_date_input">

                    <!-- Buttons -->
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAB Container -->
        <div class="md:hidden fab fixed bottom-6 right-6 flex flex-col items-end gap-3">
            <div class="fab-items flex flex-col-reverse items-end gap-3">
                <div class="fab-item-wrapper hidden-space" data-idx="0">
                    <span class="fab-label" onclick="window.location.href='{{ route('riwayat_transaksi.create') }}'">Tambah
                        Transaksi</span>
                    <button
                        class="fab-item w-14 h-14 rounded-full flex items-center justify-center text-white font-semibold shadow-lg bg-gradient-to-br from-purple-500 to-pink-500"
                        onclick="window.location.href='{{ route('riwayat_transaksi.create') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 640" class="w-6 h-6">
                            <path
                                d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                        </svg>
                    </button>
                </div>
                <div class="fab-item-wrapper hidden-space" data-idx="1">
                    <span class="fab-label" onclick="openModal()">Export
                        PDF</span>
                    <button
                        class="fab-item w-14 h-14 rounded-full flex items-center justify-center text-white font-semibold shadow-lg bg-gradient-to-br from-blue-500 to-cyan-500"
                        onclick="openModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M128 128C128 92.7 156.7 64 192 64L405.5 64C422.5 64 438.8 70.7 450.8 82.7L493.3 125.2C505.3 137.2 512 153.5 512 170.5L512 208L128 208L128 128zM64 320C64 284.7 92.7 256 128 256L512 256C547.3 256 576 284.7 576 320L576 416C576 433.7 561.7 448 544 448L512 448L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 448L96 448C78.3 448 64 433.7 64 416L64 320zM192 480L192 512L448 512L448 416L192 416L192 480zM520 336C520 322.7 509.3 312 496 312C482.7 312 472 322.7 472 336C472 349.3 482.7 360 496 360C509.3 360 520 349.3 520 336z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- FAB Button-->
            <button id="fabMain"
                class="fab-main w-14 h-14 rounded-full btn-lg shadow-lg flex items-center justify-center transition-all bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white"
                aria-expanded="false" aria-label="Open FAB" title="Open FAB">
                <span id="iconX" class="fab-icon text-xl visible" role="img" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 640" class="w-6 h-6">
                        <path
                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                    </svg>
                </span>
            </button>
        </div>

        <hr class="my-6 border-gray-200">
        {{-- PANGGIL COMPONENT --}}
        <x-table :data-table="[
                                                                                'Tipe' => 'tipe', 
                                                                                'Jumlah' => 'jumlah', 
                                                                                'Tanggal' => 'tanggal', 
                                                                                'Keterangan' => 'keterangan',    
                                                                                ]"
            data-url="{{ route('api.riwayat_transaksi.index') }}">
            {{-- Slot untuk filter --}}
            <x-slot:filter>
                <div class="flex items-center space-x-4 relative">
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
    <script src="{{ asset('assets/js/DatePicker.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('myDatePickerContainer');
            const resultDisplay = document.getElementById('resultDisplay');
            const startDateInput = document.getElementById('start_date_input');
            const endDateInput = document.getElementById('end_date_input');

            const normalizeDate = (d) => {
                const date = new Date(d);
                const m = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${date.getFullYear()}-${m}-${day}`;
            };

            const myDatePicker = new DatePicker(container, {
                type: 'dateRange', // Tipe picker
                data: {
                    startDate: null, // Inisialisasi tanpa tanggal awal
                    endDate: null    // Inisialisasi tanpa tanggal akhir
                },
                options: {
                    onApply: function (dates) {
                        console.log(normalizeDate(dates.startDate), normalizeDate(dates.endDate));
                        startDateInput.value = normalizeDate(dates.startDate);
                        endDateInput.value = normalizeDate(dates.endDate);
                    }
                }
            });
        });

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
@endsection