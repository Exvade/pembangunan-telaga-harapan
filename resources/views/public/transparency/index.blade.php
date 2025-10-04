@extends('public.layouts.app')
@section('title', 'Transparansi Anggaran — Telaga Harapan')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Transparansi</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Total Pemasukan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($global['total_income'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Total Pengeluaran</div>
            <div class="text-2xl font-bold">Rp {{ number_format($global['total_expense'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Saldo</div>
            <div class="text-2xl font-bold {{ $global['balance'] < 0 ? 'text-red-600' : '' }}">
                Rp {{ number_format($global['balance'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="bg-white border rounded-xl overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left p-3">Kategori</th>
                    <th class="text-right p-3">Pemasukan</th>
                    <th class="text-right p-3">Pengeluaran</th>
                    <th class="text-right p-3">Saldo</th>
                    <th class="text-right p-3">% Target</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr class="border-t">
                        <td class="p-3">
                            <div class="font-medium">{{ $c['name'] }}</div>
                            @if ($c['description'])
                                <div class="text-xs text-slate-500 line-clamp-2">{{ $c['description'] }}</div>
                            @endif
                            <div class="mt-1">
                                <span
                                    class="px-2 py-0.5 rounded text-xs {{ $c['is_active'] ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $c['is_active'] ? 'Aktif' : 'Arsip' }}
                                </span>
                            </div>
                        </td>
                        <td class="p-3 text-right">Rp {{ number_format($c['total_income'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($c['total_expense'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-semibold {{ $c['balance'] < 0 ? 'text-red-600' : '' }}">Rp
                            {{ number_format($c['balance'], 0, ',', '.') }}</td>
                        <td class="p-3 text-right">
                            @if (!is_null($c['target_pct']))
                                {{ $c['target_pct'] }}%
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ route('public.category.show', $c['id']) }}" class="text-blue-600">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
