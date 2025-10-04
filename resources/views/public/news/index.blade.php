@extends('public.layouts.app')
@section('title', 'Berita Pembangunan — Telaga Harapan')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Berita Pembangunan</h1>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul..."
            class="border rounded p-2 w-full md:w-72">
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($items as $n)
            <article class="bg-white border rounded-xl overflow-hidden">
                @if ($n->cover_path)
                    <img src="{{ Storage::url($n->cover_path) }}" class="h-40 w-full object-cover" alt="cover">
                @endif
                <div class="p-4">
                    <div class="text-xs text-slate-500">{{ $n->published_at?->format('d M Y') }}</div>
                    <a href="{{ route('public.news.show', $n->slug) }}"
                        class="font-semibold line-clamp-2">{{ $n->title }}</a>
                    @if ($n->excerpt)
                        <p class="text-sm text-slate-600 line-clamp-3 mt-1">{{ $n->excerpt }}</p>
                    @endif
                </div>
            </article>
        @empty
            <div class="text-slate-500">Belum ada berita.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection
