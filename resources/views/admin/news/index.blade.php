@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Berita</h1>
        <a href="{{ route('admin.news.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">Tambah
            Berita</a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul..."
            class="w-full md:w-64 rounded border p-2">
    </form>

    <div class="bg-white rounded-xl border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left p-3">Judul</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Publish</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    <tr class="border-t">
                        <td class="p-3">{{ $it->title }}</td>
                        <td class="p-3">{{ ucfirst($it->status) }}</td>
                        <td class="p-3">{{ $it->published_at?->format('d M Y') ?? '-' }}</td>
                        <td class="p-3 text-right">
                            <a href="{{ route('admin.news.edit', $it) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.news.destroy', $it) }}" class="inline"
                                onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3" colspan="4">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection
