@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Kategori / Rencana</h1>
        <a href="{{ route('admin.categories.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">Tambah
            Kategori</a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama kategori"
            class="border rounded p-2 w-full md:w-72">
    </form>

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left p-3">Nama</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-right p-3">Target</th>
                    <th class="text-right p-3">Total Masuk</th>
                    <th class="text-right p-3">Total Keluar</th>
                    <th class="text-right p-3">Saldo</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    @php
                        $in = $it->totalIncome();
                        $ex = $it->totalExpense();
                        $bal = $in - $ex;
                    @endphp
                    <tr class="border-t">
                        <td class="p-3">
                            <div class="font-medium">{{ $it->name }}</div>
                            @if ($it->description)
                                <div class="text-slate-500 text-xs">{{ $it->description }}</div>
                            @endif
                        </td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded text-xs {{ $it->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $it->is_active ? 'Aktif' : 'Arsip' }}
                            </span>
                        </td>
                        <td class="p-3 text-right">Rp {{ number_format($it->target_amount ?? 0, 0, ',', '.') }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($in, 0, ',', '.') }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($ex, 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-semibold {{ $bal < 0 ? 'text-red-600' : '' }}">
                            Rp {{ number_format($bal, 0, ',', '.') }}
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ route('admin.incomes.create') }}?category_id={{ $it->id }}"
                                class="text-green-600">+ Pemasukan</a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.expenses.create') }}?category_id={{ $it->id }}"
                                class="text-orange-600">+ Pengeluaran</a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.categories.edit', $it) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $it) }}" class="inline"
                                onsubmit="return confirm('Hapus kategori?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection
