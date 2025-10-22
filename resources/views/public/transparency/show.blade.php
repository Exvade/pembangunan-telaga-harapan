@extends('public.layouts.app')
@section('title', 'Transparansi: ' . $category->name . ' — Telaga Harapan')

@section('content')
    {{-- State Alpine.js untuk Modal --}}
    <div x-data="{ modalOpen: false, modalContentUrl: '', isModalContentImage: false }" @keydown.escape.window="modalOpen = false">

        {{-- 1. HERO SECTION --}}
        <section class="bg-green-800 text-white">
            <div class="container mx-auto px-4 py-12">
                <div class="max-w-4xl mx-auto">
                    <a href="{{ route('public.transparency') }}"
                        class="text-sm font-semibold text-slate-300 hover:text-white transition-colors inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Laporan Transparansi
                    </a>
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mt-4">{{ $category->name }}</h1>
                    @if ($category->description)
                        <p class="text-slate-300 mt-2 max-w-2xl">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
        </section>

        <div class="bg-slate-50">
            <div class="container mx-auto px-4 py-16 sm:py-20">
                <div class="max-w-4xl mx-auto">

                    {{-- 2. KARTU STATISTIK --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        {{-- Total Pengeluaran --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                            <div class="bg-rose-100 text-rose-600 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-500">Total Pengeluaran Kategori</div>
                                <div class="text-2xl font-bold text-slate-800 mt-1">Rp
                                    {{ number_format($totalExpense, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        {{-- Status --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                            <div
                                class="rounded-lg p-3 {{ $category->is_active ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-500">Status</div>
                                <div class="text-2xl font-bold mt-1 flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-sm font-medium {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Arsip' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. DAFTAR RINCIAN PENGELUARAN --}}
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Rincian Pengeluaran</h2>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                            <ul class="divide-y divide-slate-100">
                                @forelse($expenses as $e)
                                    @php
                                        $isAttachmentImage = $e->attachment_mime_type
                                            ? \Illuminate\Support\Str::contains($e->attachment_mime_type, 'image')
                                            : false;
                                    @endphp
                                    <li
                                        class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div>
                                            <p class="text-xs text-slate-500">
                                                {{ \Illuminate\Support\Carbon::parse($e->date)->format('d F Y') }}</p>
                                            <p class="font-medium text-slate-800 mt-1">{{ $e->description }}</p>
                                            @if ($e->unit_label)
                                                <p class="text-xs text-slate-500 mt-1">({{ $e->unit_label }})</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-4 flex-shrink-0">
                                            <p class="font-semibold text-rose-600">Rp
                                                {{ number_format($e->amount, 0, ',', '.') }}</p>
                                            @if ($e->attachment_path)
                                                <button type="button" title="Lihat Bukti"
                                                    @click="modalOpen = true; modalContentUrl = '{{ Storage::url($e->attachment_path) }}'; isModalContentImage = {{ $isAttachmentImage ? 'true' : 'false' }}"
                                                    class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="p-8 text-center text-slate-500">
                                        Belum ada pengeluaran untuk kategori ini.
                                    </li>
                                @endforelse
                            </ul>
                            @if ($expenses->hasPages())
                                <div class="p-4 border-t border-slate-200">
                                    {{ $expenses->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Komponen Modal --}}
        <div x-show="modalOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/75 p-4" @click="modalOpen = false">

            <template x-if="isModalContentImage">
                <div @click.stop class="relative">
                    <img :src="modalContentUrl" class="block max-w-xl max-h-[75vh] rounded-lg shadow-2xl"
                        alt="Preview Bukti">
                    <button @click="modalOpen = false"
                        class="absolute -top-2 -right-2 z-20 p-1.5 rounded-full bg-slate-700 text-white hover:bg-slate-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>

            <template x-if="!isModalContentImage && modalOpen">
                <div @click.stop class="relative w-full max-w-4xl h-[90vh] bg-white rounded-lg shadow-xl overflow-hidden">
                    <iframe :src="modalContentUrl" class="w-full h-full" frameborder="0"></iframe>
                    <button @click="modalOpen = false"
                        class="absolute top-2 right-2 z-20 p-2 rounded-full bg-black/20 text-white hover:bg-black/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

    </div>
@endsection
