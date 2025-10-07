@extends('public.layouts.app')
@section('title','Transparansi Dana — Telaga Harapan')

@section('content')
    {{-- 1. HERO SECTION --}}
    <section class="bg-slate-800 text-white">
        <div class="container mx-auto px-4 py-16 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">
                Laporan Transparansi Dana
            </h1>
            <p class="mt-3 text-slate-300 max-w-2xl mx-auto">
                Kami percaya pada keterbukaan. Di sini Anda dapat melihat rincian alokasi dana secara transparan sebagai bentuk akuntabilitas kami kepada publik.
            </p>
        </div>
    </section>

    <div class="bg-slate-50">
        <div class="container mx-auto px-4 py-16 sm:py-20">
            
            {{-- 2. KARTU STATISTIK UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- Total Pemasukan --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                    <div class="bg-emerald-100 text-emerald-600 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Total Pemasukan</div>
                        <div class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($global['total_income'], 0, ',', '.') }}</div>
                    </div>
                </div>
                {{-- Total Pengeluaran --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                    <div class="bg-rose-100 text-rose-600 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Total Pengeluaran</div>
                        <div class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($global['total_expense'], 0, ',', '.') }}</div>
                    </div>
                </div>
                {{-- Saldo --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-start gap-4">
                    <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Saldo Dana Umum</div>
                        <div class="text-2xl font-bold mt-1 {{ ($global['balance']<0)?'text-rose-600':'text-slate-800' }}">
                            Rp {{ number_format($global['balance'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. DAFTAR RINCIAN PENGELUARAN --}}
            <div>
                 <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">
                    Rincian Pengeluaran per Kategori
                </h2>
                <div class="space-y-4 max-w-4xl mx-auto">
                    @forelse($categories as $c)
                        <a href="{{ route('public.category.show', $c['id']) }}" class="block group">
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 group-hover:shadow-md group-hover:border-indigo-300">
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                                    {{-- Info Kategori --}}
                                    <div class="sm:col-span-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $c['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $c['is_active'] ? 'Aktif' : 'Arsip' }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-slate-800 mt-2 group-hover:text-indigo-600 transition-colors">{{ $c['name'] }}</h3>
                                        @if($c['description'])<p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $c['description'] }}</p>@endif
                                    </div>
                                    
                                    {{-- Total Pengeluaran --}}
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs text-slate-500">Total Keluar</p>
                                        <p class="font-semibold text-rose-600">Rp {{ number_format($c['total_expense'],0,',','.') }}</p>
                                    </div>

                                    {{-- Progress Bar --}}
                                    <div class="sm:col-span-1">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-xs font-medium text-slate-700">Porsi Dana</span>
                                            <span class="text-xs font-medium text-slate-700">{{ $c['share_pct'] }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                                            <div class="bg-cyan-500 h-2.5 rounded-full" style="width: {{ $c['share_pct'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                         <div class="text-center bg-white border border-dashed border-slate-300 rounded-2xl p-12">
                            <h3 class="text-lg font-semibold text-slate-700">Belum Ada Data</h3>
                            <p class="text-slate-500 mt-1">Belum ada kategori atau rincian pengeluaran yang tercatat.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <p class="text-xs text-slate-500 mt-8 text-center max-w-xl mx-auto">
                Catatan: Kategori berfungsi sebagai label pengeluaran. Saldo dana bersifat global dan dialokasikan sesuai kebutuhan pembangunan.
            </p>
        </div>
    </div>
@endsection