@extends('public.layouts.app')
@section('title', $item->title . ' — Telaga Harapan')

@section('content')
    <article class="max-w-3xl">
        <div class="text-xs text-slate-500">{{ $item->published_at?->format('d M Y') }}</div>
        <h1 class="text-3xl font-bold mb-3">{{ $item->title }}</h1>
        @if ($item->cover_path)
            <img src="{{ Storage::url($item->cover_path) }}" class="rounded-xl border mb-4 max-h-96 object-cover w-full"
                alt="cover">
        @endif
        <div class="prose max-w-none">
            {!! nl2br(e($item->body)) !!}
        </div>
    </article>

    @if ($others->count())
        <section class="mt-8">
            <h2 class="text-lg font-semibold mb-2">Berita lain</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($others as $n)
                    <a href="{{ route('public.news.show', $n->slug) }}"
                        class="block bg-white border rounded-xl overflow-hidden">
                        @if ($n->cover_path)
                            <img src="{{ Storage::url($n->cover_path) }}" class="h-28 w-full object-cover" alt="cover">
                        @endif
                        <div class="p-3">
                            <div class="text-xs text-slate-500">{{ $n->published_at?->format('d M Y') }}</div>
                            <div class="font-medium line-clamp-2">{{ $n->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
