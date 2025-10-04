@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        {{-- === Header dengan Tombol Aksi (Tetap sama) === --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Dashboard
            </h1>
            <div class="mt-3 sm:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                    + Kategori
                </a>
                <a href="{{ route('admin.incomes.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-emerald-800 bg-emerald-100 border border-emerald-200 rounded-lg shadow-sm hover:bg-emerald-200 transition-colors">
                    + Pemasukan
                </a>
                <a href="{{ route('admin.expenses.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-rose-800 bg-rose-100 border border-rose-200 rounded-lg shadow-sm hover:bg-rose-200 transition-colors">
                    + Pengeluaran
                </a>
            </div>
        </div>

        {{-- === Grid Utama Layout Baru (2 kolom di layar besar) === --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- KANAN (sekarang di KIRI): Transaksi Terbaru --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Transaksi Terbaru</h2>
                        <div class="flex gap-4 text-sm font-semibold">
                            <a href="{{ route('admin.incomes.index') }}"
                                class="text-emerald-600 hover:text-emerald-800">Pemasukan</a>
                            <a href="{{ route('admin.expenses.index') }}"
                                class="text-rose-600 hover:text-rose-800">Pengeluaran</a>
                        </div>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse($latestTransactions as $t)
                            <li class="py-4 flex items-center gap-4">
                                <div @class([
                                    'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center',
                                    'bg-emerald-100 text-emerald-600' => $t['type'] === 'income',
                                    'bg-rose-100 text-rose-600' => $t['type'] === 'expense',
                                ])>
                                    @if ($t['type'] === 'income')
                                        <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <div class="font-medium text-slate-800">{{ $t['label'] }}</div>
                                    <div class="text-xs text-slate-500">
                                        <span>{{ \Illuminate\Support\Carbon::parse($t['date'])->format('d M Y') }}</span>
                                        <span class="mx-1">&middot;</span>
                                        <span>{{ $t['category'] ?? 'Tanpa Kategori' }}</span>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div
                                        class="font-semibold {{ $t['type'] === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        Rp {{ number_format($t['amount'], 0, ',', '.') }}
                                    </div>
                                    @if ($t['attachment'])
                                        <a target="_blank" href="{{ Storage::url($t['attachment']) }}"
                                            class="text-xs text-indigo-600 hover:underline">Lihat Bukti</a>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-center text-slate-500">Belum ada transaksi.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- KIRI (Tetap di KIRI): Top Saldo Kategori --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Top Kategori (Saldo Terbesar)</h2>
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 mt-2 sm:mt-0">Kelola Kategori
                            &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b border-slate-200">
                                <tr>
                                    <th class="text-left font-semibold text-slate-600 p-3">Kategori</th>
                                    <th class="text-right font-semibold text-slate-600 p-3">Masuk</th>
                                    <th class="text-right font-semibold text-slate-600 p-3">Keluar</th>
                                    <th class="text-right font-semibold text-slate-600 p-3">Saldo</th>
                                    <th class="text-right font-semibold text-slate-600 p-3">% Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topBalance as $it)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                                        <td class="p-3">
                                            <div class="font-medium text-slate-800">{{ $it['name'] }}</div>
                                            <span
                                                class="px-2 py-0.5 rounded text-xs {{ $it['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">{{ $it['is_active'] ? 'Aktif' : 'Arsip' }}</span>
                                        </td>
                                        <td class="p-3 text-right text-emerald-600">Rp
                                            {{ number_format($it['total_income'], 0, ',', '.') }}</td>
                                        <td class="p-3 text-right text-rose-600">Rp
                                            {{ number_format($it['total_expense'], 0, ',', '.') }}</td>
                                        <td
                                            class="p-3 text-right font-semibold {{ $it['balance'] < 0 ? 'text-rose-600' : 'text-slate-800' }}">
                                            Rp {{ number_format($it['balance'], 0, ',', '.') }}</td>
                                        <td class="p-3 text-right text-slate-600">
                                            @if (!is_null($it['target_pct']))
                                                <span class="font-semibold">{{ $it['target_pct'] }}%</span>
                                            @else
                                                <span>—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-slate-500">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1 space-y-6">

                {{-- === Tiles Angka Utama (All time) === --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-800">Ringkasan Total</h2>
                    {{-- Total Pemasukan --}}
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-100 text-emerald-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Total Pemasukan</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">Rp
                                {{ number_format($totalIn, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    {{-- Total Pengeluaran --}}
                    <div class="flex items-start gap-4">
                        <div class="bg-rose-100 text-rose-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Total Pengeluaran</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">Rp
                                {{ number_format($totalEx, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    {{-- Saldo --}}
                    <div class="flex items-start gap-4">
                        <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Saldo</div>
                            <div class="text-2xl font-bold mt-1 {{ $saldo < 0 ? 'text-rose-600' : 'text-slate-800' }}">Rp
                                {{ number_format($saldo, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    {{-- Berita Terpublikasi --}}
                    <div class="flex items-start gap-4">
                        <div class="bg-sky-100 text-sky-600 rounded-lg p-3"><svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg></div>
                        <div>
                            <div class="text-sm font-medium text-slate-500">Berita Terpublikasi</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">{{ $newsPublished }}</div>
                        </div>
                    </div>
                </div>

                {{-- === Bulan Berjalan === --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-700">Bulan Ini ({{ $monthText }})</h2>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Pemasukan</div>
                        <div class="text-2xl font-bold text-emerald-600 mt-1">Rp
                            {{ number_format($monthIn, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Pengeluaran</div>
                        <div class="text-2xl font-bold text-rose-600 mt-1">Rp {{ number_format($monthEx, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">Saldo</div>
                        <div class="text-2xl font-bold mt-1 {{ $monthSaldo < 0 ? 'text-rose-600' : 'text-slate-800' }}">Rp
                            {{ number_format($monthSaldo, 0, ',', '.') }}</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
