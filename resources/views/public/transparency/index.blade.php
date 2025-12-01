@extends('public.layouts.app')
@section('title', 'Transparansi Dana — Telaga Harapan')

@section('content')
    <div x-data="{ modalOpen: false, modalContentUrl: '', isModalContentImage: false }" @keydown.escape.window="modalOpen = false" class="bg-slate-50 min-h-screen pb-12">

        {{-- 1. HEADER SEDERHANA (Tanpa Background Aneh-aneh) --}}
        <div class="bg-white border-b border-slate-200 shadow-sm">
            <div class="container mx-auto px-4 py-8 sm:py-12">
                <div class="max-w-3xl">
                    <span
                        class="inline-block py-1 px-3 rounded bg-blue-100 text-blue-700 text-xs font-bold tracking-wide uppercase mb-3">
                        Laporan Keuangan
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                        Transparansi Dana Pembangunan
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        Data keuangan masjid yang disajikan secara terbuka, akurat, dan dapat dipertanggungjawabkan kepada
                        seluruh warga.
                    </p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 -mt-0 pt-8">

            {{-- 2. GRID STATISTIK (Kotak Tegas & Jelas) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Pemasukan --}}
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Pemasukan</h3>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">
                            Rp {{ number_format($global['total_income'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
                        Akumulasi dana masuk
                    </div>
                </div>

                {{-- Pengeluaran --}}
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-rose-100 text-rose-600 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Pengeluaran</h3>
                        </div>
                        <p class="text-3xl font-extrabold text-slate-800 mt-2">
                            Rp {{ number_format($global['total_expense'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
                        Dana yang telah digunakan
                    </div>
                </div>

                {{-- Saldo (Warna Biru) --}}
                <div
                    class="bg-blue-600 p-6 rounded-xl border border-blue-500 shadow-lg text-white flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-white/20 rounded-lg text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-blue-100 uppercase tracking-wider">Saldo Kas</h3>
                        </div>
                        <p class="text-3xl font-extrabold mt-2">
                            Rp {{ number_format($global['balance'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-blue-500 text-xs text-blue-100">
                        Dana tersedia saat ini
                    </div>
                </div>
            </div>

            {{-- 3. LAYOUT UTAMA (2 Kolom Standar) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: LIST PEMASUKAN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">Pemasukan Terakhir</h3>
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse($recentIncomes as $inc)
                                @php
                                    $isAttachmentImage = $inc->attachment_path
                                        ? \Illuminate\Support\Str::contains($inc->attachment_mime_type, 'image')
                                        : false;
                                @endphp
                                <div class="p-4 hover:bg-slate-50 transition-colors">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-xs font-semibold text-slate-500">
                                            {{ \Illuminate\Support\Carbon::parse($inc->date)->format('d M Y') }}
                                        </span>
                                        <span class="text-sm font-bold text-emerald-600">
                                            + {{ number_format((int) $inc->amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $inc->source ?: 'Hamba Allah' }}
                                    </p>

                                    @if ($inc->attachment_path)
                                        <button type="button"
                                            @click="modalOpen = true; modalContentUrl = '{{ Storage::url($inc->attachment_path) }}'; isModalContentImage = {{ $isAttachmentImage ? 'true' : 'false' }}"
                                            class="mt-2 text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Lihat Bukti
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center text-slate-400 text-sm">Belum ada data.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KATEGORI PENGELUARAN --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-800 text-lg mb-6">Realisasi Anggaran per Kategori</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($categories as $c)
                                <a href="{{ route('public.category.show', $c['id']) }}"
                                    class="block p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition-all duration-200 group">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4
                                            class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1">
                                            {{ $c['name'] }}
                                        </h4>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-slate-300 group-hover:text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>

                                    <p class="text-sm text-slate-500 mb-4 line-clamp-2 min-h-[2.5em]">
                                        {{ $c['description'] ?: 'Tidak ada deskripsi detail.' }}
                                    </p>

                                    <div class="space-y-2">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs text-slate-500">Terkewat</span>
                                            <span class="text-lg font-bold text-rose-600">
                                                Rp {{ number_format($c['total_expense'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full"
                                                style="width: {{ $c['share_pct'] }}%"></div>
                                        </div>
                                        <div class="text-right text-xs text-slate-400">
                                            {{ $c['share_pct'] }}% dari total pengeluaran
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div
                                    class="col-span-full py-12 text-center text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                                    Belum ada kategori rencana.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL PREVIEW (Simpel & Fungsional) --}}
        <div x-show="modalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen = false">

            <div @click.stop
                class="relative w-full max-w-3xl bg-white rounded-lg shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Bukti Transaksi</h3>
                    <button @click="modalOpen = false" class="text-slate-400 hover:text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 bg-slate-100 overflow-auto flex items-center justify-center p-4">
                    <template x-if="isModalContentImage">
                        <img :src="modalContentUrl" class="max-w-full max-h-full object-contain shadow-sm rounded">
                    </template>
                    <template x-if="!isModalContentImage">
                        <iframe :src="modalContentUrl" class="w-full h-full min-h-[500px] border-0 bg-white"></iframe>
                    </template>
                </div>

                <div class="p-4 border-t border-slate-100 bg-white flex justify-end">
                    <a :href="modalContentUrl" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
                        Download / Buka Asli
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
