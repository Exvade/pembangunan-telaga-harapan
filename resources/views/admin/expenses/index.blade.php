@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Pengeluaran</h1>
        <a href="{{ route('admin.expenses.create') }}" class="px-3 py-2 bg-orange-600 text-white rounded-lg text-sm">Tambah
            Pengeluaran</a>
    </div>

    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-2">
        <select name="category_id" class="border rounded p-2">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected($categoryId == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ $from }}" class="border rounded p-2" />
        <input type="date" name="to" value="{{ $to }}" class="border rounded p-2" />
        <button class="border rounded p-2">Filter</button>
    </form>

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left p-3">Tanggal</th>
                    <th class="text-left p-3">Kategori</th>
                    <th class="text-left p-3">Keterangan</th>
                    <th class="text-left p-3">Satuan</th>
                    <th class="text-right p-3">Nominal</th>
                    <th class="text-left p-3">Bukti</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    <tr class="border-t">
                        <td class="p-3">{{ $it->date?->format('d M Y') }}</td>
                        <td class="p-3">{{ $it->category?->name }}</td>
                        <td class="p-3">{{ $it->description }}</td>
                        <td class="p-3">{{ $it->unit_label ?? '-' }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($it->amount, 0, ',', '.') }}</td>
                        <td class="p-3">
                            @if ($it->attachment_path)
                                <a class="text-blue-600 underline" target="_blank"
                                    href="{{ Storage::url($it->attachment_path) }}">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ route('admin.expenses.edit', $it) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.expenses.destroy', $it) }}" class="inline"
                                onsubmit="return confirm('Hapus pengeluaran ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection
