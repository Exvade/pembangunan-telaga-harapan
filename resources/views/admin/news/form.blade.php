@extends('admin.layouts.app')

@section('content')
    <h1 class="text-xl font-semibold mb-4">
        {{ $item->exists ? 'Edit Berita' : 'Tambah Berita' }}
    </h1>

    <form method="POST" enctype="multipart/form-data"
        action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
        class="bg-white p-4 rounded-xl border space-y-4">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input name="title" value="{{ old('title', $item->title) }}" required class="w-full border rounded p-2">
            @error('title')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cover (opsional)</label>
            <input type="file" name="cover" accept="image/*" class="w-full border rounded p-2">
            @if ($item->cover_path)
                <img src="{{ Storage::url($item->cover_path) }}" class="mt-2 h-24 object-cover rounded">
            @endif
            @error('cover')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Isi</label>
            <textarea name="body" rows="8" class="w-full border rounded p-2">{{ old('body', $item->body) }}</textarea>
            @error('body')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="border rounded p-2">
                @foreach (['draft' => 'Draft', 'published' => 'Published'] as $k => $v)
                    <option value="{{ $k }}" @selected(old('status', $item->status ?? 'draft') === $k)>{{ $v }}</option>
                @endforeach
            </select>
            @error('status')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                {{ $item->exists ? 'Simpan Perubahan' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.news.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
        </div>
    </form>
@endsection
