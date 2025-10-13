<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>@yield('title', 'Telaga Harapan')</title>

    {{-- Alpine.js untuk interaktivitas menu mobile --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ===== Pengaturan Warna Scrollbar ===== */
        :root {
            --brand: #298c47;
            /* Warna utama untuk focus ring */
            --sb-track-color: #E8F5EE;
            /* Warna latar (track) scrollbar */
            --sb-thumb-color: #7BD09B;
            /* Warna gagang (thumb) scrollbar */
            --sb-thumb-hover-color: #4FB976;
            /* Warna gagang saat di-hover */
        }

        /* Versi Dark Mode (jika ada) */
        .dark {
            --sb-track-color: rgba(41, 140, 71, .12);
            --sb-thumb-color: rgba(123, 208, 155, .9);
            --sb-thumb-hover-color: #3aa35c;
        }

        /* ===== Styling Scrollbar ===== */

        /* 1. Target elemen yang ingin di-style */
        .scroll-area {
            /* Untuk Firefox */
            scrollbar-width: thin;
            scrollbar-color: var(--sb-thumb-color) var(--sb-track-color);
        }

        /* 2. Untuk Chrome, Safari, Edge (berbasis WebKit) */
        .scroll-area::-webkit-scrollbar {
            width: 10px;
            /* Lebar scrollbar vertikal */
            height: 10px;
            /* Tinggi scrollbar horizontal */
        }

        .scroll-area::-webkit-scrollbar-track {
            background-color: var(--sb-track-color);
            border-radius: 100vw;
            /* Cukup besar agar ujungnya selalu bulat */
            margin-block: 0.25rem;
            /* Sedikit margin atas-bawah */
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background-color: var(--sb-thumb-color);
            border-radius: 100vw;
            /* Samakan dengan track agar bulat sempurna */
            border: 2px solid var(--sb-track-color);
            /* Trik agar thumb terlihat lebih ramping */
        }

        /* 3. Efek Interaktif (Hover) */
        @media (hover: hover) {
            .scroll-area:hover::-webkit-scrollbar-thumb {
                background-color: var(--sb-thumb-hover-color);
            }
        }

        /* 4. Aksesibilitas: Tampilkan outline saat di-fokus dengan keyboard */
        .scroll-area:focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
            border-radius: 0.5rem;
        }
    </style>

</head>

<body class="bg-white text-slate-800 antialiased">

    {{-- Alpine.js state untuk menu mobile --}}
    <div x-data="{ mobileMenuOpen: false }">
        {{-- HEADER MODERN --}}
        <header class="bg-white sticky top-0 z-50 border-b border-slate-200">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo / Nama Brand --}}
                    <a href="{{ route('public.home') }}"
                        class="text-lg font-bold text-slate-800 flex justify-center items-center gap-2">
                        {{-- Team Pembangunan Telaga Harapan --}}
                        <img src="/logo.jpeg" class="w-12" alt="Logo Team Pembangunan Telaga Harapan">
                        <span class="text-blue-800 font-bold">Team <span
                                class="text-orange-700">Pembangunan</span></span>
                    </a>

                    {{-- Navigasi Desktop --}}
                    <nav class="hidden md:flex items-center gap-2 text-sm font-medium">
                        <a href="{{ route('public.home') }}" @class([
                            'px-3 py-2 rounded-lg transition-colors',
                            'bg-slate-100 text-slate-900' => request()->routeIs('public.home'),
                            'text-slate-600 hover:bg-slate-100/75 hover:text-slate-900',
                        ])>
                            Beranda
                        </a>
                        <a href="{{ route('public.news.index') }}" @class([
                            'px-3 py-2 rounded-lg transition-colors',
                            'bg-slate-100 text-slate-900' => request()->routeIs('public.news.*'),
                            'text-slate-600 hover:bg-slate-100/75 hover:text-slate-900',
                        ])>
                            Berita
                        </a>
                        <a href="{{ route('public.transparency') }}" @class([
                            'px-3 py-2 rounded-lg transition-colors',
                            'bg-slate-100 text-slate-900' => request()->routeIs('public.transparency'),
                            'text-slate-600 hover:bg-slate-100/75 hover:text-slate-900',
                        ])>
                            Transparansi
                        </a>
                    </nav>

                    {{-- Tombol Hamburger untuk Mobile --}}
                    <div class="md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="p-2 rounded-md text-slate-600 hover:bg-slate-100">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" xmlns="http://www.w.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Mobile --}}
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-slate-200">
                <nav class="flex flex-col p-4 space-y-2">
                    <a href="{{ route('public.home') }}" @class([
                        'px-3 py-2 rounded-lg',
                        'bg-slate-100 text-slate-900 font-semibold' => request()->routeIs(
                            'public.home'),
                        'text-slate-600',
                    ])>Beranda</a>
                    <a href="{{ route('public.news.index') }}" @class([
                        'px-3 py-2 rounded-lg',
                        'bg-slate-100 text-slate-900 font-semibold' => request()->routeIs(
                            'public.news.*'),
                        'text-slate-600',
                    ])>Berita</a>
                    <a href="{{ route('public.transparency') }}" @class([
                        'px-3 py-2 rounded-lg',
                        'bg-slate-100 text-slate-900 font-semibold' => request()->routeIs(
                            'public.transparency'),
                        'text-slate-600',
                    ])>Transparansi</a>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        {{-- FOOTER MODERN --}}
        <footer class="bg-slate-800 text-slate-300">
            <div class="container mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- Kolom 1: Tentang --}}
                    <div class="md:col-span-2">
                        <h4 class="text-lg font-bold text-white mb-2"> Team Pembangunan Telaga Harapan</h4>

                        <p class="text-sm max-w-md">
                            Inisiatif pembangunan pusat komunitas dan peribadatan untuk kemaslahatan bersama.
                            Transparansi dan kolaborasi adalah pilar utama kami.
                        </p>
                    </div>

                    {{-- Kolom 2: Navigasi --}}
                    <div>
                        <h5 class="font-semibold text-white mb-3">Navigasi</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('public.home') }}" class="hover:text-white">Beranda</a></li>
                            <li><a href="{{ route('public.news.index') }}" class="hover:text-white">Berita</a></li>
                            <li><a href="{{ route('public.transparency') }}" class="hover:text-white">Transparansi</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Kolom 3: Media Sosial --}}
                    <div>
                        <h5 class="font-semibold text-white mb-3">Ikuti Kami</h5>
                        <div class="flex space-x-4">
                            {{-- Ganti '#' dengan URL media sosial Anda --}}
                            <a href="#" class="hover:text-white" title="Facebook"><svg class="w-6 h-6"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg></a>
                            <a href="#" class="hover:text-white" title="Instagram"><svg class="w-6 h-6"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.067-.06-1.407-.06-4.123v-.08c0-2.643.012-2.987.06-4.043.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 013.45 2.525c.636-.247 1.363-.416 2.427-.465C7.902 2.013 8.242 2 10.885 2h.08zm0 2.043c-2.517 0-2.848.011-3.896.06-1.003.045-1.505.2-1.858.344a2.888 2.888 0 00-1.08 1.08c-.145.353-.3.855-.344 1.858-.049 1.048-.06 1.379-.06 3.896v.08c0 2.517.011 2.848.06 3.896.045 1.003.2 1.505.344 1.858a2.888 2.888 0 001.08 1.08c.353.145.855.3 1.858.344 1.048.049 1.379.06 3.896.06h.08c2.517 0 2.848-.011 3.896-.06 1.003-.045 1.505-.2 1.858-.344a2.888 2.888 0 001.08-1.08c.145-.353.3-.855.344-1.858.049-1.048.06-1.379.06-3.896v-.08c0-2.517-.011-2.848-.06-3.896-.045-1.003-.2-1.505-.344-1.858a2.888 2.888 0 00-1.08-1.08c-.353-.145-.855-.3-1.858-.344-1.048-.049-1.379-.06-3.896-.06h-.08z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M12 6.865a5.135 5.135 0 100 10.27 5.135 5.135 0 000-10.27zm0 8.242a3.108 3.108 0 110-6.216 3.108 3.108 0 010 6.216zM16.92 6.402a1.22 1.22 0 100 2.44 1.22 1.22 0 000-2.44z" />
                                </svg></a>
                            <a href="#" class="hover:text-white" title="YouTube"><svg class="w-6 h-6"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M19.802 5.345a3.003 3.003 0 012.122 2.122C22 8.736 22 12 22 12s0 3.264-.076 4.533a3.004 3.004 0 01-2.122 2.122C18.336 18.73 12 18.73 12 18.73s-6.336 0-7.602-.075a3.004 3.004 0 01-2.122-2.122C2 15.264 2 12 2 12s0-3.264.076-4.533A3.003 3.003 0 014.2 5.345C5.466 5.27 12 5.27 12 5.27s6.336 0 7.602.075zM9.75 14.33l4.5-2.33-4.5-2.33v4.66z"
                                        clip-rule="evenodd" />
                                </svg></a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-700 text-center text-sm">
                    © {{ date('Y') }} Telaga Harapan — Transparansi & Kolaborasi
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
