@extends('public.layouts.app')

@section('title', 'Beranda — Telaga Harapan')

@section('content')
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-slate-50 border rounded-xl p-6">
            <h1 class="text-2xl font-bold mb-2">Team Pembangunan Telaga Harapan</h1>
            <p class="text-slate-600">Ikuti progres pembangunan, lihat laporan pemasukan & pengeluaran secara transparan.</p>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('public.transparency') }}"
                    class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm">Lihat Transparansi</a>
                <a href="{{ route('public.news.index') }}" class="px-4 py-2 border rounded-lg text-sm">Berita Terbaru</a>
            </div>
        </div>

        <div class="bg-white border rounded-xl p-6">
            <div class="text-sm text-slate-500">Ringkasan Dana (semua kategori)</div>
            <div class="mt-2 space-y-2">
                <div class="flex items-center justify-between">
                    <span>Total Pemasukan</span>
                    <span class="font-semibold">Rp {{ number_format($totalIn, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Pengeluaran</span>
                    <span class="font-semibold">Rp {{ number_format($totalEx, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Saldo</span>
                    <span class="font-semibold {{ $saldo < 0 ? 'text-red-600' : '' }}">Rp
                        {{ number_format($saldo, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-2">
        <h2 class="text-xl font-semibold mb-3">Berita Terbaru</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($latestNews as $n)
                <article class="bg-white border rounded-xl overflow-hidden">
                    @if ($n->cover_path)
                        <img src="{{ Storage::url($n->cover_path) }}" class="h-40 w-full object-cover" alt="cover">
                    @endif
                    <div class="p-4">
                        <div class="text-xs text-slate-500">{{ $n->published_at?->format('d M Y') }}</div>
                        <a href="{{ route('public.news.show', $n->slug) }}"
                            class="font-semibold line-clamp-2">{{ $n->title }}</a>
                        <p class="text-sm text-slate-600 line-clamp-3 mt-1">{{ $n->excerpt }}</p>
                    </div>
                </article>
            @empty
                <div class="text-slate-500">Belum ada berita.</div>
            @endforelse
        </div>
    </section>
@endsection
