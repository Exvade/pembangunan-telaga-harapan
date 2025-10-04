@extends('admin.layouts.app')

@php
    $selectedCategory = request('category_id') ?: old('category_id', $item->category_id);
@endphp

@section('content')
    <h1 class="text-xl font-semibold mb-4">
        {{ $item->exists ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}
    </h1>

    <form method="POST" enctype="multipart/form-data"
        action="{{ $item->exists ? route('admin.expenses.update', $item) : route('admin.expenses.store') }}"
        class="bg-white p-4 rounded-xl border grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="category_id" class="w-full border rounded p-2" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected($selectedCategory == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tanggal</label>
            <input type="date" name="date" class="w-full border rounded p-2"
                value="{{ old('date', $item->date?->format('Y-m-d')) }}" required>
            @error('date')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Keterangan</label>
            <input name="description" class="w-full border rounded p-2" value="{{ old('description', $item->description) }}"
                required>
            @error('description')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Satuan (opsional)</label>
            <input name="unit_label" class="w-full border rounded p-2" value="{{ old('unit_label', $item->unit_label) }}"
                placeholder="mis. 50 sak / 20 pcs">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nominal Total (Rp)</label>
            <input type="number" name="amount" min="0" class="w-full border rounded p-2"
                value="{{ old('amount', $item->amount) }}" required>
            @error('amount')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Lampiran Bukti (jpg/png/webp/pdf, maks 2MB)</label>
            <input type="file" name="attachment" class="w-full border rounded p-2">
            @if ($item->attachment_path)
                <a class="text-blue-600 underline mt-2 inline-block" target="_blank"
                    href="{{ Storage::url($item->attachment_path) }}">Lihat file saat ini</a>
            @endif
            @error('attachment')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
            <input name="notes" class="w-full border rounded p-2" value="{{ old('notes', $item->notes) }}">
        </div>

        <div class="md:col-span-2 flex items-center gap-2">
            <button
                class="px-4 py-2 bg-orange-600 text-white rounded-lg">{{ $item->exists ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
        </div>
    </form>
@endsection
