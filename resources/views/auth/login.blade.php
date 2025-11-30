<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Admin - Tim Pembangunan Telaga Harapan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- CDN Tailwind CSS (PENTING: Agar layout langsung rapi tanpa build step) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Scripts (Tetap simpan untuk production) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <!-- Card Login Utama -->
    <div
        class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-wrap lg:flex-nowrap min-h-[550px]">

        <!-- Bagian Kiri: Tema Pembangunan / Konstruksi -->
        <!-- Menggunakan w-full pada mobile, dan w-1/2 pada desktop (md) -->
        <div class="hidden md:flex md:w-1/2 bg-cover bg-center relative"
            style="background-image: url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1000&auto=format&fit=crop');">

            <!-- Overlay Gradient -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-slate-900/95 to-slate-800/60 flex flex-col justify-end p-12 text-white">
                <div class="mb-4">
                    <!-- Icon Gedung/Konstruksi -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>

                    <h2 class="text-3xl font-bold mb-3 leading-tight">Sistem Informasi Pembangunan</h2>
                    <p class="text-slate-300 text-sm leading-relaxed opacity-90">
                        Platform terpadu Tim Telaga Harapan. Kelola update berita kegiatan, transparansi pemasukan, dan
                        monitoring pengeluaran anggaran secara akurat.
                    </p>
                </div>

                <!-- Indikator Statistik Kecil -->
                <div class="flex gap-4 mt-2 border-t border-slate-600/50 pt-4">
                    <div>
                        <span class="block text-xs text-slate-400 uppercase tracking-wider">Anggaran</span>
                        <span class="font-semibold text-blue-300">Terpantau</span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 uppercase tracking-wider">Laporan</span>
                        <span class="font-semibold text-blue-300">Real-time</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative bg-white">

            <!-- Logo Mobile -->
            <div class="md:hidden text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 text-blue-700 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Telaga Harapan</h2>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Selamat Datang</h1>
                <p class="text-slate-500 mt-2 text-sm">Silakan login untuk mengakses panel pengurus.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Pengurus</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email"
                            class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400
                                      focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                      transition duration-200 ease-in-out bg-slate-50 focus:bg-white"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" placeholder="admin@telagaharapan.org" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Input dengan Fitur Toggle -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    </div>
                    <div class="relative group">
                        <!-- Ikon Kunci -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition-colors"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Input Password -->
                        <input id="password"
                            class="block w-full pl-10 pr-12 py-3 border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400
                                      focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                      transition duration-200 ease-in-out bg-slate-50 focus:bg-white"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••" />

                        <!-- Tombol Toggle Show/Hide -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none cursor-pointer transition-colors">
                            <svg id="icon-show" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="icon-hide" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-8">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer"
                            name="remember">
                        <span
                            class="ms-2 text-sm text-slate-600 group-hover:text-slate-800 transition">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-blue-600 hover:text-blue-800 transition hover:underline"
                            href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                    class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-base font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    {{ __('Masuk Dashboard') }}
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Tim Pembangunan Telaga Harapan.
            </div>
        </div>
    </div>

    <!-- Script untuk Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const iconShow = document.getElementById('icon-show');
            const iconHide = document.getElementById('icon-hide');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
