<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @yield('style')
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
</head>

<body>
    <div class="flex flex-col min-h-[100dvh] overflow-x-hidden">
        <!-- Header Destop -->
        <header class="hidden md:flex border-b border-gray-200">
            <div class="container py-4 px-10">
                <h1 class="text-xl font-semibold text-gray-800">KopsisApp</h1>
            </div>
        </header>

        <!-- Header Mobile -->
        <header class="md:hidden flex justify-between items-center p-4 border-b">
            <button id="menu-btn" class="text-gray-600 focus:outline-none" aria-label="Buka Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </header>

        <!-- (Sidebar + Content) -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar untuk Desktop -->
            <aside class="hidden md:flex md:flex-col md:w-64 bg-white border-r border-gray-200">
                <nav class="flex-1 px-4 py-4 space-y-2">
                    <a href="/beranda"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                            width="24" viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                        </svg>
                        Beranda
                    </a>

                    <!-- Menu Dropdown -->
                    <details open class="group">
                        <summary
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                            <div class="flex items-center">
                                Data Master
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="pl-6 mt-1 space-y-1">
                            <a href="/vendor"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z" />
                                </svg>
                                Vendor
                            </a>
                            <a href="/produk"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="m400-570 80-40 80 40v-190H400v190ZM280-280v-80h200v80H280Zm-80 160q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-640v560-560Zm0 560h560v-560H640v320l-160-80-160 80v-320H200v560Z" />
                                </svg>
                                Produk
                            </a>
                        </div>
                    </details>

                    <!-- Menu lainnya dengan pola yang sama -->
                    <details open class="group">
                        <summary
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                            <div class="flex items-center">
                                Manajemen Stok
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="pl-6 mt-1 space-y-1">
                            <a href="/stok_terkini"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M80-80v-160h800v160H760v-80H540v80H420v-80H200v80H80Zm160-240q-17 0-28.5-11.5T200-360v-480q0-17 11.5-28.5T240-880h480q17 0 28.5 11.5T760-840v480q0 17-11.5 28.5T720-320H240Zm40-80h400v-400H280v400Zm80-240h240v-80H360v80Zm-80 240v-400 400Z" />
                                </svg>
                                Stok Terkini
                            </a>
                            <a href="/barang_masuk"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z" />
                                </svg>
                                Barang Masuk
                            </a>
                            <a href="/barang_keluar"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M856-390 570-104q-12 12-27 18t-30 6q-15 0-30-6t-27-18L103-457q-11-11-17-25.5T80-513v-287q0-33 23.5-56.5T160-880h287q16 0 31 6.5t26 17.5l352 353q12 12 17.5 27t5.5 30q0 15-5.5 29.5T856-390ZM513-160l286-286-353-354H160v286l353 354ZM260-640q25 0 42.5-17.5T320-700q0-25-17.5-42.5T260-760q-25 0-42.5 17.5T200-700q0 25 17.5 42.5T260-640Zm220 160Z" />
                                </svg>
                                Barang Keluar
                            </a>
                        </div>
                    </details>

                    <details open class="group">
                        <summary
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                            <div class="flex items-center">
                                Keuangan
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="pl-6 mt-1 space-y-1">
                            <a href="/riwayat_transaksi"
                                class="flex items-center     px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M360-200v-80h480v80H360Zm0-240v-80h480v80H360Zm0-240v-80h480v80H360ZM200-160q-33 0-56.5-23.5T120-240q0-33 23.5-56.5T200-320q33 0 56.5 23.5T280-240q0 33-23.5 56.5T200-160Zm0-240q-33 0-56.5-23.5T120-480q0-33 23.5-56.5T200-560q33 0 56.5 23.5T280-480q0 33-23.5 56.5T200-400Zm0-240q-33 0-56.5-23.5T120-720q0-33 23.5-56.5T200-800q33 0 56.5 23.5T280-720q0 33-23.5 56.5T200-640Z" />
                                </svg>
                                Riwayat Transaksi
                            </a>
                        </div>
                    </details>

                    <details open class="group">
                        <summary
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                            <div class="flex items-center">
                                Manajemen Pengguna
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="pl-6 mt-1 space-y-1">
                            <a href="/pengguna"
                                class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                    width="24" viewBox="0 -960 960 960" fill="currentColor">
                                    <path
                                        d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z" />
                                </svg>
                                Pengguna
                            </a>
                        </div>
                    </details>
                </nav>
                <div class="mt-auto p-4 space-y-2 border-t border-gray-200">
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Bantuan
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                            width="24" viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                        </svg>
                        Logout
                    </a>
                </div>
            </aside>

            <!-- Sidebar untuk Mobile (Off-canvas) -->
            <div id="mobile-menu"
                class="md:hidden fixed inset-0 flex z-40 transform -translate-x-full transition-transform duration-300 ease-in-out">
                <!-- Konten Sidebar -->
                <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
                    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200">
                        <h1 class="text-xl font-bold text-gray-800">KopsisApp</h1>
                        <button id="close-btn" class="text-gray-600 focus:outline-none" aria-label="Tutup Sidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960"
                                fill="currentColor">
                                <path
                                    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Konten Navigasi Mobile (sama dengan desktop) -->
                    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                        <a href="/beranda"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                width="24" viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                            </svg>
                            Beranda
                        </a>

                        <!-- Menu Dropdown -->
                        <details open class="group">
                            <summary
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex items-center">
                                    Data Master
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="pl-6 mt-1 space-y-1">
                                <a href="/vendor"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z" />
                                    </svg>
                                    Vendor
                                </a>
                                <a href="/produk"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="m400-570 80-40 80 40v-190H400v190ZM280-280v-80h200v80H280Zm-80 160q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-640v560-560Zm0 560h560v-560H640v320l-160-80-160 80v-320H200v560Z" />
                                    </svg>
                                    Produk
                                </a>
                            </div>
                        </details>

                        <!-- Menu lainnya dengan pola yang sama -->
                        <details open class="group">
                            <summary
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex items-center">
                                    Manajemen Stok
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="pl-6 mt-1 space-y-1">
                                <a href="/stok_terkini"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M80-80v-160h800v160H760v-80H540v80H420v-80H200v80H80Zm160-240q-17 0-28.5-11.5T200-360v-480q0-17 11.5-28.5T240-880h480q17 0 28.5 11.5T760-840v480q0 17-11.5 28.5T720-320H240Zm40-80h400v-400H280v400Zm80-240h240v-80H360v80Zm-80 240v-400 400Z" />
                                    </svg>
                                    Stok Terkini
                                </a>
                                <a href="/barang_masuk"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z" />
                                    </svg>
                                    Barang Masuk
                                </a>
                                <a href="/barang_keluar"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M856-390 570-104q-12 12-27 18t-30 6q-15 0-30-6t-27-18L103-457q-11-11-17-25.5T80-513v-287q0-33 23.5-56.5T160-880h287q16 0 31 6.5t26 17.5l352 353q12 12 17.5 27t5.5 30q0 15-5.5 29.5T856-390ZM513-160l286-286-353-354H160v286l353 354ZM260-640q25 0 42.5-17.5T320-700q0-25-17.5-42.5T260-760q-25 0-42.5 17.5T200-700q0 25 17.5 42.5T260-640Zm220 160Z" />
                                    </svg>
                                    Barang Keluar
                                </a>
                            </div>
                        </details>

                        <details open class="group">
                            <summary
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex items-center">
                                    Keuangan
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="pl-6 mt-1 space-y-1">
                                <a href="/riwayat_transaksi"
                                    class="flex items-center     px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M360-200v-80h480v80H360Zm0-240v-80h480v80H360Zm0-240v-80h480v80H360ZM200-160q-33 0-56.5-23.5T120-240q0-33 23.5-56.5T200-320q33 0 56.5 23.5T280-240q0 33-23.5 56.5T200-160Zm0-240q-33 0-56.5-23.5T120-480q0-33 23.5-56.5T200-560q33 0 56.5 23.5T280-480q0 33-23.5 56.5T200-400Zm0-240q-33 0-56.5-23.5T120-720q0-33 23.5-56.5T200-800q33 0 56.5 23.5T280-720q0 33-23.5 56.5T200-640Z" />
                                    </svg>
                                    Riwayat Transaksi
                                </a>
                            </div>
                        </details>

                        <details open class="group">
                            <summary
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-600 rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex items-center">
                                    Manajemen Pengguna
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transform group-open:rotate-180" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="pl-6 mt-1 space-y-1">
                                <a href="/prngguna"
                                    class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        height="24" width="24" viewBox="0 -960 960 960" fill="currentColor">
                                        <path
                                            d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z" />
                                    </svg>
                                    Pengguna
                                </a>
                            </div>
                        </details>
                    </nav>
                    <div class="mt-auto p-4 space-y-2 border-t border-gray-200">
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Bantuan
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24"
                                width="24" viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                <!-- Overlay -->
                <div id="overlay" class="flex-1 bg-black bg-opacity-50"></div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('script')
</body>

</html>