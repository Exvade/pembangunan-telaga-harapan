<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin — Telaga Harapan</title>

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
    {{-- Use Alpine.js to manage the mobile menu state --}}
    <div x-data="{ open: false }">
        <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo/Brand Name --}}
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-slate-800">
                            Admin Panel
                        </a>
                    </div>

                    {{-- Desktop Navigation Links --}}
                    <div class="hidden md:flex md:items-center md:gap-1">
                        <a href="{{ route('admin.dashboard') }}" @class([
                            'px-3 py-2 rounded-md text-sm font-medium',
                            'bg-slate-100 text-indigo-600' => request()->routeIs('admin.dashboard'),
                            'text-slate-600 hover:bg-slate-100/75',
                        ])>Dashboard</a>
                        <a href="{{ route('admin.news.index') }}" @class([
                            'px-3 py-2 rounded-md text-sm font-medium',
                            'bg-slate-100 text-indigo-600' => request()->routeIs('admin.news.*'),
                            'text-slate-600 hover:bg-slate-100/75',
                        ])>Berita</a>
                        <a href="{{ route('admin.categories.index') }}" @class([
                            'px-3 py-2 rounded-md text-sm font-medium',
                            'bg-slate-100 text-indigo-600' => request()->routeIs('admin.categories.*'),
                            'text-slate-600 hover:bg-slate-100/75',
                        ])>Kategori</a>
                        <a href="{{ route('admin.incomes.index') }}" @class([
                            'px-3 py-2 rounded-md text-sm font-medium',
                            'bg-slate-100 text-indigo-600' => request()->routeIs('admin.incomes.*'),
                            'text-slate-600 hover:bg-slate-100/75',
                        ])>Pemasukan</a>
                        <a href="{{ route('admin.expenses.index') }}" @class([
                            'px-3 py-2 rounded-md text-sm font-medium',
                            'bg-slate-100 text-indigo-600' => request()->routeIs('admin.expenses.*'),
                            'text-slate-600 hover:bg-slate-100/75',
                        ])>Pengeluaran</a>

                        {{-- Logout Form --}}
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button
                                class="px-3 py-2 rounded-md text-sm font-medium text-rose-600 hover:bg-rose-50">Logout</button>
                        </form>
                    </div>

                    {{-- Hamburger Menu Button --}}
                    <div class="flex md:hidden">
                        <button @click="open = !open" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            {{-- Icon for menu closed --}}
                            <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            {{-- Icon for menu open --}}
                            <svg x-show="open" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-cloak @click.away="open = false" class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('admin.dashboard') }}" @class([
                        'block px-3 py-2 rounded-md text-base font-medium',
                        'bg-indigo-50 text-indigo-700' => request()->routeIs('admin.dashboard'),
                        'text-slate-700 hover:bg-slate-50',
                    ])>Dashboard</a>
                    <a href="{{ route('admin.news.index') }}" @class([
                        'block px-3 py-2 rounded-md text-base font-medium',
                        'bg-indigo-50 text-indigo-700' => request()->routeIs('admin.news.*'),
                        'text-slate-700 hover:bg-slate-50',
                    ])>Berita</a>
                    <a href="{{ route('admin.categories.index') }}" @class([
                        'block px-3 py-2 rounded-md text-base font-medium',
                        'bg-indigo-50 text-indigo-700' => request()->routeIs('admin.categories.*'),
                        'text-slate-700 hover:bg-slate-50',
                    ])>Kategori</a>
                    <a href="{{ route('admin.incomes.index') }}" @class([
                        'block px-3 py-2 rounded-md text-base font-medium',
                        'bg-indigo-50 text-indigo-700' => request()->routeIs('admin.incomes.*'),
                        'text-slate-700 hover:bg-slate-50',
                    ])>Pemasukan</a>
                    <a href="{{ route('admin.expenses.index') }}" @class([
                        'block px-3 py-2 rounded-md text-base font-medium',
                        'bg-indigo-50 text-indigo-700' => request()->routeIs('admin.expenses.*'),
                        'text-slate-700 hover:bg-slate-50',
                    ])>Pengeluaran</a>
                </div>
                {{-- Mobile Logout --}}
                <div class="border-t border-slate-200 px-2 py-3 sm:px-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-rose-700 hover:bg-rose-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
            {{-- Improved Flash Message --}}
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 p-4 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium">
                            {{ session('status') }}
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
