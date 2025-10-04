@extends('public.layouts.app')
@section('title', 'Transparansi: ' . $category->name . ' — Telaga Harapan')

@section('content')
    <a href="{{ route('public.transparency') }}" class="text-sm text-blue-600">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mb-1">{{ $category->name }}</h1>
    @if ($category->description)
        <p class="text-slate-600 mb-4">{{ $category->description }}</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Pemasukan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($summary['total_income'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Pengeluaran</div>
            <div class="text-2xl font-bold">Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Saldo</div>
            <div class="text-2xl font-bold {{ $summary['balance'] < 0 ? 'text-red-600' : '' }}">
                Rp {{ number_format($summary['balance'], 0, ',', '.') }}
            </div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">% Target</div>
            <div class="text-2xl font-bold">
                @if (!is_null($summary['target_pct']))
                    {{ $summary['target_pct'] }}%
                @else
                    —
                @endif
            </div>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-2">Transaksi Terbaru</h2>
    <ul class="divide-y bg-white border rounded-xl">
        @forelse($transactions as $t)
            <li class="p-3 flex items-center justify-between gap-3">
                <div>
                    <div class="text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($t['date'])->format('d M Y') }}
                    </div>
                    <div class="font-medium">
                        @if ($t['type'] === 'income')
                            <span class="px-2 py-0.5 rounded text-xs bg-green-100 text-green-700">Pemasukan</span>
                            <span class="ml-2">{{ $t['label'] }}</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs bg-orange-100 text-orange-700">Pengeluaran</span>
                            <span class="ml-2">{{ $t['label'] }}</span>
                            @if (!empty($t['unit']))
                                <span class="ml-1 text-xs text-slate-500">({{ $t['unit'] }})</span>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold {{ $t['type'] === 'income' ? 'text-green-700' : 'text-orange-700' }}">
                        Rp {{ number_format($t['amount'], 0, ',', '.') }}
                    </div>
                    @if ($t['attachment'])
                        <a target="_blank" href="{{ Storage::url($t['attachment']) }}"
                            class="text-xs text-blue-600 underline">Bukti</a>
                    @endif
                </div>
            </li>
        @empty
            <li class="p-3 text-slate-500">Belum ada transaksi.</li>
        @endforelse
    </ul>
@endsection
