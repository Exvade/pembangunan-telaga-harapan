@extends('public.layouts.app')
@section('title', 'Transparansi Dana — Telaga Harapan')

@section('content')
    {{-- State Alpine.js untuk Modal --}}
    <div x-data="{ modalOpen: false, modalContentUrl: '', isModalContentImage: false }" @keydown.escape.window="modalOpen = false">

        {{-- 1. HERO SECTION --}}
        <section class="bg-blue-800 text-white">
            <div class="container mx-auto px-4 py-16 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">
                    Laporan Transparansi Dana
                </h1>
                <p class="mt-3 text-slate-300 max-w-2xl mx-auto">
                    Kami percaya pada keterbukaan. Di sini Anda dapat melihat rincian alokasi dana secara transparan sebagai
                    bentuk akuntabilitas kami kepada publik.
                </p>
            </div>
        </section>

        <div class="bg-slate-50">
            <div class="container mx-auto px-4 py-16 sm:py-20">

                {{-- 2. KARTU STATISTIK UTAMA --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                        <div class="bg-emerald-100 text-blue-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M16 16c0-1.105-3.134-2-7-2s-7 .895-7 2s3.134 2 7 2s7-.895 7-2ZM2 16v4.937C2 22.077 5.134 23 9 23s7-.924 7-2.063V16M9 5c-4.418 0-8 .895-8 2s3.582 2 8 2M1 7v5c0 1.013 3.582 2 8 2M23 4c0-1.105-3.1-2-6.923-2s-6.923.895-6.923 2s3.1 2 6.923 2S23 5.105 23 4Zm-7 12c3.824 0 7-.987 7-2V4M9.154 4v10.166M9 9c0 1.013 3.253 2 7.077 2S23 10.013 23 9" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Total Pemasukan</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">Rp
                                {{ number_format($global['total_income'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                        <div class="bg-rose-100 text-rose-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Total Pengeluaran</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">Rp
                                {{ number_format($global['total_expense'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                        <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Saldo Dana Umum</div>
                            <div
                                class="text-2xl font-bold mt-1 {{ $global['balance'] < 0 ? 'text-rose-600' : 'text-slate-800' }}">
                                Rp {{ number_format($global['balance'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                {{-- POSISI BARU: RIWAYAT PEMASUKAN TERBARU --}}
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Riwayat Pemasukan Terbaru</h2>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 max-w-4xl mx-auto">
                        <ul class="divide-y divide-slate-100">
                            @forelse($recentIncomes as $inc)
                                @php
                                    $isAttachmentImage = $inc->attachment_path
                                        ? \Illuminate\Support\Str::contains($inc->attachment_mime_type, 'image')
                                        : false;
                                @endphp
                                <li class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <p class="text-xs text-slate-500">
                                            {{ \Illuminate\Support\Carbon::parse($inc->date)->format('d F Y') }}</p>
                                        <p class="font-medium text-slate-800 mt-1">{{ $inc->source ?: 'Donatur Anonim' }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4 flex-shrink-0">
                                        <p class="font-semibold text-emerald-600">Rp
                                            {{ number_format((int) $inc->amount, 0, ',', '.') }}</p>
                                        @if ($inc->attachment_path && $isAttachmentImage)
                                            <button type="button" title="Lihat Bukti"
                                                @click="modalOpen = true; modalContentUrl = '{{ Storage::url($inc->attachment_path) }}'"
                                                class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @elseif($inc->attachment_path)
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($inc->attachment_path) }}"
                                                target="_blank" title="Lihat File"
                                                class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-slate-500">Belum ada pemasukan tercatat.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- POSISI LAMA: DAFTAR RINCIAN PENGELUARAN --}}
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Rincian Pengeluaran per Kategori</h2>
                    <div class="space-y-4 max-w-4xl mx-auto">
                        @forelse($categories as $c)
                            <a href="{{ route('public.category.show', $c['id']) }}" class="block group">
                                <div
                                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 group-hover:shadow-md group-hover:border-indigo-300">
                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                                        <div class="sm:col-span-2">
                                            <h3
                                                class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                                {{ $c['name'] }}</h3>
                                            @if ($c['description'])
                                                <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $c['description'] }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-left sm:text-right">
                                            <p class="text-xs text-slate-500">Total Keluar</p>
                                            <p class="font-semibold text-rose-600">Rp
                                                {{ number_format($c['total_expense'], 0, ',', '.') }}</p>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <div class="flex justify-between mb-1"><span
                                                    class="text-xs font-medium text-slate-700">Porsi Dana</span><span
                                                    class="text-xs font-medium text-slate-700">{{ $c['share_pct'] }}%</span>
                                            </div>
                                            <div class="w-full bg-slate-200 rounded-full h-2.5">
                                                <div class="bg-cyan-500 h-2.5 rounded-full"
                                                    style="width: {{ $c['share_pct'] }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center bg-white border border-dashed border-slate-300 rounded-2xl p-12">
                                <h3 class="text-lg font-semibold text-slate-700">Belum Ada Data</h3>
                                <p class="text-slate-500 mt-1">Belum ada rincian pengeluaran yang tercatat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <p class="text-xs text-slate-500 mt-12 text-center max-w-xl mx-auto">
                    Catatan: Saldo dana bersifat global dan dialokasikan sesuai kebutuhan pembangunan di berbagai kategori.
                </p>
            </div>
        </div>

        {{-- Komponen Modal --}}
        <div x-show="modalOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/75 p-4" @click="modalOpen = false">
            <template x-if="modalOpen">
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
        </div>
    </div>
@endsection
