@extends('admin.layouts.app')

@section('content')
    <!-- Section Header & Quick Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, pantau perkembangan Telaga Harapan hari ini.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.incomes.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm shadow-emerald-200 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Pemasukan
            </a>
            <a href="{{ route('admin.expenses.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-lg shadow-sm shadow-rose-200 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
                Pengeluaran
            </a>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold rounded-lg shadow-sm transition-colors">
                + Kategori
            </a>
        </div>
    </div>

    <!-- STATS CARDS: Grid 4 Kolom (Top Priority) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Card 1: Saldo Utama -->
        <div
            class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-indigo-400 to-indigo-600"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Saldo</p>
                    <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-width="2"
                            d="M16 16c0-1.105-3.134-2-7-2s-7 .895-7 2s3.134 2 7 2s7-.895 7-2ZM2 16v4.937C2 22.077 5.134 23 9 23s7-.924 7-2.063V16M9 5c-4.418 0-8 .895-8 2s3.582 2 8 2M1 7v5c0 1.013 3.582 2 8 2M23 4c0-1.105-3.1-2-6.923-2s-6.923.895-6.923 2s3.1 2 6.923 2S23 5.105 23 4Zm-7 12c3.824 0 7-.987 7-2V4M9.154 4v10.166M9 9c0 1.013 3.253 2 7.077 2S23 10.013 23 9" />
                    </svg>
                </div>
            </div>
            <div class="text-xs text-slate-400 flex items-center gap-1">
                <span class="px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-700 font-semibold">Dana Umum</span>
                <span>Tersedia</span>
            </div>
        </div>

        <!-- Card 2: Pemasukan Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Masuk ({{ $monthText }})</p>
                    <h3 class="text-2xl font-bold text-emerald-600">Rp {{ number_format($monthIn, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <div class="text-xs text-slate-400">Total akumulasi bulan ini</div>
        </div>

        <!-- Card 3: Pengeluaran Bulan Ini -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Keluar ({{ $monthText }})</p>
                    <h3 class="text-2xl font-bold text-rose-600">Rp {{ number_format($monthEx, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
            </div>
            <div class="text-xs text-slate-400">Total akumulasi bulan ini</div>
        </div>

        <!-- Card 4: Berita -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Berita Aktif</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $newsPublished }}</h3>
                </div>
                <div class="p-2 bg-sky-50 rounded-lg text-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.news.index') }}"
                class="text-xs font-medium text-indigo-600 hover:text-indigo-800 hover:underline">Kelola Berita &rarr;</a>
        </div>
    </div>

    <!-- MAIN GRID CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Recent Transactions (Span 2) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-800">Transaksi Terbaru</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.incomes.index') }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition">Masuk</a>
                        <a href="{{ route('admin.expenses.index') }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 transition">Keluar</a>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($latestTransactions as $t)
                        <div class="p-4 sm:p-5 hover:bg-slate-50 transition-colors group flex items-center gap-4">
                            <!-- Icon Type -->
                            <div @class([
                                'flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center border',
                                'bg-emerald-50 border-emerald-100 text-emerald-600' =>
                                    $t->type === 'income',
                                'bg-rose-50 border-rose-100 text-rose-600' => $t->type === 'expense',
                            ])>
                                @if ($t->type === 'income')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-grow min-w-0">
                                <p
                                    class="text-sm font-semibold text-slate-800 truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $t->label }}</p>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mt-0.5">
                                    <span>{{ \Illuminate\Support\Carbon::parse($t->date)->translatedFormat('d F Y') }}</span>
                                    @if (!empty($t->category?->name))
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span
                                            class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">{{ $t->category->name }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Amount & Action -->
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="font-bold text-sm {{ $t->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $t->type === 'income' ? '+' : '-' }} Rp
                                    {{ number_format($t->amount, 0, ',', '.') }}
                                </div>
                                @if (!empty($t->attachment_path))
                                    <a target="_blank"
                                        href="{{ \Illuminate\Support\Facades\Storage::url($t->attachment_path) }}"
                                        class="text-[10px] font-medium text-indigo-500 hover:text-indigo-700 hover:underline flex items-center justify-end gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Bukti
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-3">
                                <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <p class="text-slate-500 text-sm">Belum ada transaksi terbaru.</p>
                        </div>
                    @endforelse
                </div>
                @if (count($latestTransactions) > 0)
                    <div class="bg-slate-50 p-3 text-center border-t border-slate-100">
                        <a href="{{ route('admin.incomes.index') }}"
                            class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition">Lihat Semua
                            Transaksi &rarr;</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Top Expenses & Summary (Span 1) -->
        <div class="space-y-6">

            <!-- Top Expenses Widget -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center justify-between">
                    <span>Pengeluaran Top</span>
                    <span
                        class="text-xs font-normal text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $monthText }}</span>
                </h2>

                <div class="space-y-4">
                    @forelse($topExpenseThisMonth as $index => $c)
                        <div class="relative">
                            <div class="flex items-center justify-between text-sm mb-1 z-10 relative">
                                <span class="font-medium text-slate-700">{{ $index + 1 }}. {{ $c->name }}</span>
                                <span class="font-bold text-slate-800">Rp
                                    {{ number_format($c->total, 0, ',', '.') }}</span>
                            </div>
                            <!-- Simple Progress Bar visual -->
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-rose-400 h-1.5 rounded-full"
                                    style="width: {{ $totalEx > 0 ? ($c->total / $totalEx) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-sm text-slate-500 italic">Belum ada data pengeluaran.</div>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">Total Keluar (All Time)</span>
                        <span class="text-sm font-bold text-rose-600">Rp {{ number_format($totalEx, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Mini Widget: Quick Info / Support -->
            <div class="bg-indigo-900 rounded-2xl p-6 text-white shadow-lg shadow-indigo-200">
                <h3 class="font-bold text-lg mb-2">Butuh Bantuan?</h3>
                <p class="text-indigo-200 text-sm mb-4">Jika ada kendala input data atau selisih saldo, silakan hubungi
                    bendahara utama.</p>
                <div class="text-xs text-indigo-300 border-t border-indigo-700 pt-3">
                    System Version 1.0.0
                </div>
            </div>

        </div>
    </div>
@endsection
