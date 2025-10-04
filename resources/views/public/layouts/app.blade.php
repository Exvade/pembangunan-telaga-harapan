<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Telaga Harapan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-900">
    <header class="border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('public.home') }}" class="font-semibold">Telaga Harapan</a>
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('public.home') }}" class="px-3 py-2 rounded hover:bg-slate-100">Beranda</a>
                <a href="{{ route('public.news.index') }}" class="px-3 py-2 rounded hover:bg-slate-100">Berita</a>
                <a href="{{ route('public.transparency') }}"
                    class="px-3 py-2 rounded hover:bg-slate-100">Transparansi</a>
                <a href="{{ route('public.about') }}" class="px-3 py-2 rounded hover:bg-slate-100">Tentang</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="border-t">
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-600">
            © {{ date('Y') }} Telaga Harapan — Transparansi & Kolaborasi
        </div>
    </footer>
</body>

</html>
