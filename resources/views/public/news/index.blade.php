@extends('public.layouts.app')
@section('title', 'Berita & Pembangunan — Telaga Harapan')

@section('content')
    {{-- Menggunakan background abu-abu terang agar kartu putih lebih menonjol --}}
    <div class="bg-slate-50">
        <div class="container mx-auto px-4 py-12 sm:py-16">

            {{-- HEADER HALAMAN BERITA --}}
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                    Berita & Progres Pembangunan
                </h1>
                <p class="mt-3 text-base sm:text-lg text-slate-600">
                    Ikuti perkembangan terbaru dari proyek pembangunan Telaga Harapan.
                </p>
            </div>

            {{-- Cek apakah ada berita untuk ditampilkan --}}
            @if ($items->isNotEmpty())

                @php
                    $latestNews = $items->first();
                    $otherNews = $items->skip(1);
                @endphp

                {{-- BERITA UTAMA (TERBARU) - Layout Lebih Modern --}}
                <div class="mb-12 sm:mb-16">
                    <a href="{{ route('public.news.show', $latestNews->slug) }}" class="block group">
                        <article class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                            {{-- Kolom Gambar --}}
                            <div class="overflow-hidden">
                                @if ($latestNews->cover_path)
                                    <img src="{{ Storage::url($latestNews->cover_path) }}"
                                        class="rounded-xl w-full h-auto object-cover aspect-[16/10] shadow-md transition-transform duration-300 ease-in-out group-hover:scale-105"
                                        alt="Cover: {{ $latestNews->title }}">
                                @else
                                    <div
                                        class="aspect-[16/10] w-full bg-slate-200 flex items-center justify-center rounded-xl">
                                        <svg class="w-16 h-16 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Kolom Teks --}}
                            <div class="flex flex-col justify-center">
                                <p class="text-sm text-slate-500 mb-2">{{ $latestNews->published_at?->format('d F Y') }}</p>
                                <h2
                                    class="text-2xl sm:text-3xl font-bold text-slate-800 line-clamp-3 transition-colors duration-300 group-hover:text-green-600">
                                    {{ $latestNews->title }}
                                </h2>
                                @if ($latestNews->excerpt)
                                    <p class="text-base text-slate-600 line-clamp-3 mt-4">{{ $latestNews->excerpt }}</p>
                                @endif
                                {{-- Tombol Call-to-action --}}
                                <div
                                    class="mt-6 text-sm font-semibold text-green-600 flex items-center gap-2 group-hover:underline">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1">
                                        <path fill-rule="evenodd"
                                            d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>

                {{-- Pemisah Visual --}}
                <div class="border-t border-slate-200 my-10 sm:my-14"></div>

                {{-- JUDUL & PENCARIAN BERITA LAINNYA --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                    <h3 class="text-2xl font-bold text-slate-900">
                        Berita Lainnya
                    </h3>
                    <form method="GET" class="relative w-full sm:w-auto sm:max-w-xs">
                        <input type="text" name="q" value="{{ $q }}" placeholder="Cari berita..."
                            class="w-full border border-slate-300 rounded-lg text-sm p-2.5 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                    </form>
                </div>

                {{-- DAFTAR BERITA LAINNYA --}}
                @if ($otherNews->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($otherNews as $n)
                            <a href="{{ route('public.news.show', $n->slug) }}" class="block group">
                                <article
                                    class="bg-white rounded-xl overflow-hidden h-full transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 border border-slate-100">
                                    @if ($n->cover_path)
                                        <img src="{{ Storage::url($n->cover_path) }}" class="h-44 w-full object-cover"
                                            alt="Cover: {{ $n->title }}">
                                    @else
                                        <div class="h-44 w-full bg-slate-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="p-5 flex flex-col">
                                        <p class="text-xs text-slate-500 mb-2">{{ $n->published_at?->format('d F Y') }}</p>
                                        <h3
                                            class="font-bold text-lg text-slate-800 line-clamp-2 transition-colors group-hover:text-green-600">
                                            {{ $n->title }}
                                        </h3>
                                        @if ($n->excerpt)
                                            <p class="text-sm text-slate-600 line-clamp-3 mt-2 flex-grow">
                                                {{ $n->excerpt }}</p>
                                        @endif
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                {{-- KONDISI JIKA TIDAK ADA BERITA SAMA SEKALI --}}
                <div class="text-center bg-white border border-dashed border-slate-300 rounded-xl p-12 mt-12">
                    <h3 class="text-lg font-semibold text-slate-700">Tidak Ada Berita</h3>
                    <p class="text-slate-500 mt-1">Belum ada berita yang dipublikasikan atau hasil pencarian tidak
                        ditemukan.</p>
                </div>
            @endif

            {{-- PAGINATION --}}
            @if ($items->hasPages())
                <div class="mt-12">
                    {{ $items->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
