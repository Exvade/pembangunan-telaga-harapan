@extends('public.layouts.app')
@section('title', 'Berita Pembangunan — Telaga Harapan')

@section('content')
    <div class="bg-slate-50">
        <div class="container mx-auto px-4 py-16 sm:py-20">
            {{-- HEADER HALAMAN BERITA --}}
            <div class="text-center max-w-2xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-800">
                    Berita & Progres Pembangunan
                </h1>
                <p class="mt-3 text-slate-600">
                    Ikuti perkembangan terbaru dari proyek pembangunan Telaga Harapan melalui artikel dan dokumentasi kami.
                </p>
                <form method="GET" class="mt-6 relative">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul berita..."
                           class="w-full border-2 border-slate-200 rounded-lg text-sm p-3 pl-10 focus:outline-none focus:border-indigo-500 transition">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                </form>
            </div>

            {{-- DAFTAR BERITA --}}
            <div class="mt-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($items as $n)
                        {{-- DIUBAH: Link <a> sekarang membungkus seluruh <article> --}}
                        <a href="{{ route('public.news.show', $n->slug) }}" class="block group">
                            <article class="bg-white rounded-2xl shadow-lg overflow-hidden h-full transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                                @if ($n->cover_path)
                                    <img src="{{ Storage::url($n->cover_path) }}" class="h-48 w-full object-cover" alt="Cover: {{ $n->title }}">
                                @else
                                    <div class="h-48 w-full bg-slate-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                    </div>
                                @endif
                                
                                <div class="p-5 flex flex-col">
                                    <p class="text-xs text-slate-500 mb-2">{{ $n->published_at?->format('d F Y') }}</p>
                                    
                                    {{-- Link <a> dihapus dari sini --}}
                                    <h3 class="font-bold text-slate-800 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $n->title }}
                                    </h3>
                                    
                                    @if ($n->excerpt)
                                        <p class="text-sm text-slate-600 line-clamp-3 mt-2">{{ $n->excerpt }}</p>
                                    @endif
                                </div>
                            </article>
                        </a>
                    @empty
                        <div class="sm:col-span-2 lg:col-span-3 text-center bg-white border border-dashed border-slate-300 rounded-2xl p-12">
                            <h3 class="text-lg font-semibold text-slate-700">Tidak Ada Berita</h3>
                            <p class="text-slate-500 mt-1">Belum ada berita yang dipublikasikan atau tidak ada hasil yang cocok dengan pencarian Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- PAGINATION --}}
            @if ($items->hasPages())
                <div class="mt-12">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection