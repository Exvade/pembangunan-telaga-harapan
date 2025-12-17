<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Panel — Telaga Harapan</title>

    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Figtree', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Resources (Keep for production) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-900 antialiased">

    <!-- Navbar Container -->
    <div x-data="{ mobileMenuOpen: false }">

        <!-- Navbar Sticky -->
        <nav class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    <!-- Kiri: Logo & Desktop Menu -->
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                                TH</div>
                            <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-slate-800">
                                Telaga Harapan
                            </a>
                        </div>

                        <!-- Desktop Links (Hidden on Mobile) -->
                        <div class="hidden md:ml-10 md:flex md:space-x-2 items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.news.index') }}"
                                class="{{ request()->routeIs('admin.news.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Berita
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                                class="{{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Kategori
                            </a>
                            <a href="{{ route('admin.incomes.index') }}"
                                class="{{ request()->routeIs('admin.incomes.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Pemasukan
                            </a>
                            <a href="{{ route('admin.expenses.index') }}"
                                class="{{ request()->routeIs('admin.expenses.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Pengeluaran
                            </a>
                            <a href="{{ route('admin.suggestions.index') }}"
                                class="{{ request()->routeIs('admin.suggestions.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Saran dan Masukan
                            </a>
                        </div>
                    </div>

                    <!-- Kanan: Profil & Logout -->
                    <div class="hidden md:flex items-center gap-4">
                        <div class="text-sm text-right hidden lg:block">
                            <div class="font-medium text-slate-700">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-xs text-slate-500">Pengurus</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="p-2 text-slate-400 hover:text-rose-600 transition-colors rounded-full hover:bg-rose-50"
                                title="Keluar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Tombol Hamburger Mobile -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none">
                            <span class="sr-only">Buka menu</span>
                            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenuOpen" x-transition x-cloak
                class="md:hidden border-t border-slate-200 bg-white shadow-lg">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.news.index') }}"
                        class="{{ request()->routeIs('admin.news.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Berita
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Kategori
                    </a>
                    <a href="{{ route('admin.incomes.index') }}"
                        class="{{ request()->routeIs('admin.incomes.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Pemasukan
                    </a>
                    <a href="{{ route('admin.expenses.index') }}"
                        class="{{ request()->routeIs('admin.expenses.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Pengeluaran
                    </a>
                    <a href="{{ route('admin.suggestions.index') }}"
                        class="{{ request()->routeIs('admin.suggestions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }} block px-3 py-2 rounded-md text-base font-medium">
                        Saran dan Masukan
                    </a>
                </div>
                <div class="pt-4 pb-4 border-t border-slate-200 px-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-base font-medium text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email ?? '' }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="w-full flex justify-center items-center gap-2 px-4 py-2 border border-rose-200 rounded-lg text-sm font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[calc(100vh-4rem)]">

            <!-- Toast Notification (Flash Message) -->
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2" x-init="setTimeout(() => show = false, 5000)"
                    class="fixed top-20 right-4 sm:right-8 z-50 flex items-center gap-3 w-full max-w-sm bg-white border-l-4 border-emerald-500 shadow-lg rounded-r-lg p-4">
                    <div class="text-emerald-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-800">Berhasil!</p>
                        <p class="text-sm text-slate-500">{{ session('status') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>

</html>
