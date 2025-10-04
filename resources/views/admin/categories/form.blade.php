@extends('admin.layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">
        {{ $item->exists ? 'Edit Kategori' : 'Tambah Kategori' }}
    </h1>

    <form method="POST"
        action="{{ $item->exists ? route('admin.categories.update', $item) : route('admin.categories.store') }}"
        class="bg-white p-4 rounded-xl border space-y-4">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input name="name" value="{{ old('name', $item->name) }}" required class="w-full border rounded p-2">
            @error('name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $item->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Target Dana (opsional)</label>
            <input type="number" name="target_amount" min="0"
                value="{{ old('target_amount', $item->target_amount) }}" class="w-full border rounded p-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
            <label for="is_active">Aktif</label>
        </div>

        <div class="flex items-center gap-2">
            <button
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">{{ $item->exists ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
        </div>
    </form>
@endsection
