@extends('public.layouts.app')
@section('title','Transparansi: '.$category->name.' — Telaga Harapan')

@section('content')
<a href="{{ route('public.transparency') }}" class="text-sm text-blue-600">&larr; Kembali</a>
<h1 class="text-2xl font-bold mb-1">{{ $category->name }}</h1>
@if($category->description)<p class="text-slate-600 mb-4">{{ $category->description }}</p>@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <div class="bg-white border rounded-xl p-4">
    <div class="text-sm text-slate-500">Total Pengeluaran Kategori</div>
    <div class="text-2xl font-bold">Rp {{ number_format($totalExpense,0,',','.') }}</div>
  </div>
  <div class="bg-white border rounded-xl p-4">
    <div class="text-sm text-slate-500">Status</div>
    <div class="text-2xl font-bold">{{ $category->is_active ? 'Aktif' : 'Arsip' }}</div>
  </div>
</div>

<h2 class="text-lg font-semibold mb-2">Pengeluaran Terbaru</h2>
<div class="bg-white border rounded-xl overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-slate-100">
      <tr>
        <th class="text-left p-3">Tanggal</th>
        <th class="text-left p-3">Keterangan</th>
        <th class="text-left p-3">Satuan</th>
        <th class="text-right p-3">Nominal</th>
        <th class="text-left p-3">Bukti</th>
      </tr>
    </thead>
    <tbody>
      @forelse($expenses as $e)
      <tr class="border-t">
        <td class="p-3">{{ \Illuminate\Support\Carbon::parse($e->date)->format('d M Y') }}</td>
        <td class="p-3">{{ $e->description }}</td>
        <td class="p-3">{{ $e->unit_label ?? '-' }}</td>
        <td class="p-3 text-right">Rp {{ number_format($e->amount,0,',','.') }}</td>
        <td class="p-3">
          @if($e->attachment_path)
            <a class="text-blue-600 underline" target="_blank" href="{{ Storage::url($e->attachment_path) }}">Bukti</a>
          @else — @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="p-3">Belum ada pengeluaran untuk kategori ini.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $expenses->links() }}</div>

<p class="text-xs text-slate-500 mt-3">Catatan: Saldo tidak ditampilkan per kategori karena kita menggunakan Dana Umum (satu kolam).</p>
@endsection
