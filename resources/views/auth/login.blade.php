@extends('layouts.auth')

@section('title', 'Masuk - KopsisApp')

@section('content')
    <body class="bg-white">
        <!-- Konten Utama: Form Login -->
        <main class="flex items-center justify-center" style="min-height: calc(100dvh - 65px);">
            <div class="w-full max-w-sm px-6">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Masuk ke KopsisApp</h2>
                </div>

                <form class="space-y-6" action="#" method="POST">
                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                placeholder="alamat@email.com">
                        </div>
                    </div>

                    <!-- Input Kata Sandi -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Kata Sandi
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                placeholder="Kata sandi">
                        </div>
                    </div>

                    <!-- Tombol Masuk -->
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-lg bg-blue-500 py-3 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Link Daftar -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="#" class="font-medium text-blue-500 hover:text-blue-600">
                        Daftar
                    </a>
                </p>
            </div>
        </main>

    </body>
@endsection