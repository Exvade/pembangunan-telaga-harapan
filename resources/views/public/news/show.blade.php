@extends('public.layouts.app')
@section('title', $item->title . ' — Telaga Harapan')

@section('content')
    <div class="bg-slate-50">
        <div class="container mx-auto px-4 py-16 sm:py-20">
            <div class="mb-8">
                <a href="{{ route('public.news.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke semua berita
                </a>
            </div>

            {{-- Grid Utama 2 Kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- KIRI: KONTEN ARTIKEL UTAMA --}}
                <article class="lg:col-span-2">
                    {{-- Header Artikel --}}
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-800">
                            {{ $item->title }}
                        </h1>
                        <p class="mt-3 text-sm text-slate-500">
                            Dipublikasikan pada {{ $item->published_at?->format('d F Y') }}
                        </p>
                    </div>

                    {{-- Gambar Sampul --}}
                    @if ($item->cover_path)
                        <img src="{{ Storage::url($item->cover_path) }}" class="rounded-2xl shadow-lg mt-8 mb-8 w-full aspect-video object-cover" alt="Cover: {{ $item->title }}">
                    @endif
                    
                    {{-- Isi Artikel --}}
                    <div class="prose prose-lg prose-slate max-w-none mt-8">
                        {!! $item->body !!}
                    </div>
                </article>

                {{-- KANAN: SIDEBAR ESTETIS --}}
                <aside class="lg:col-span-1 space-y-8">
                    
                    {{-- Widget 1: Bagikan Artikel --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Bagikan Artikel Ini</h3>
                        <div class="flex items-center gap-2">
                            {{-- Tombol Share --}}
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' - ' . route('public.news.show', $item->slug)) }}" target="_blank" class="flex-1 text-center py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors font-semibold text-sm">WhatsApp</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('public.news.show', $item->slug) }}" target="_blank" class="p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                             <a href="https://twitter.com/intent/tweet?url={{ route('public.news.show', $item->slug) }}&text={{ urlencode($item->title) }}" target="_blank" class="p-2 rounded-lg bg-slate-800 text-white hover:bg-slate-900 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
                            </a>
                            {{-- Tombol Salin Link dengan Alpine.js --}}
                            <div x-data="{ copied: false }" class="relative">
                                <button @click="navigator.clipboard.writeText('{{ route('public.news.show', $item->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)" class="p-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition-colors">
                                    <svg x-show="!copied" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" /></svg>
                                    <svg x-show="copied" x-cloak class="w-5 h-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Widget 2: Kategori --}}
                    @if ($item->category)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-800 mb-3">Kategori</h3>
                            <a href="#" class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold hover:bg-indigo-200 transition-colors">
                                {{ $item->category->name }}
                            </a>
                        </div>
                    @endif

                     {{-- Widget 3: Berita Lainnya --}}
                    @if ($others->count())
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                             <h3 class="text-lg font-semibold text-slate-800 mb-4">Baca Juga</h3>
                             <ul class="space-y-4">
                                @foreach ($others as $n)
                                    <li>
                                        <a href="{{ route('public.news.show', $n->slug) }}" class="group flex items-start gap-4">
                                            @if ($n->cover_path)
                                                <img src="{{ Storage::url($n->cover_path) }}" class="w-20 h-16 object-cover rounded-lg flex-shrink-0" alt="Cover: {{ $n->title }}">
                                            @else
                                                <div class="w-20 h-16 bg-slate-200 rounded-lg flex-shrink-0"></div>
                                            @endif
                                            <div>
                                                 <p class="text-xs text-slate-500">{{ $n->published_at?->format('d M Y') }}</p>
                                                 <h4 class="font-semibold text-sm text-slate-800 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                                     {{ $n->title }}
                                                 </h4>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                             </ul>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </div>
@endsection