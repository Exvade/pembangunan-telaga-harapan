@extends('public.layouts.app')
@section('title', 'Tentang — Telaga Harapan')

@section('content')
    <h1 class="text-2xl font-bold mb-2">Tentang Kami</h1>
    <p class="text-slate-700 max-w-3xl">
        Team Pembangunan Telaga Harapan adalah inisiatif warga untuk membangun fasilitas bersama secara transparan.
        Situs ini menampilkan berita progres dan laporan pemasukan & pengeluaran.
    </p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Misi</div>
            <div class="mt-1">Transparansi, kolaborasi, dan pembangunan berkelanjutan.</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Kontak</div>
            <div class="mt-1">Email: admin@telaga-harapan.test</div>
        </div>
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-slate-500">Lokasi</div>
            <div class="mt-1">[Tulis alamat/lokasi proyek]</div>
        </div>
    </div>
@endsection
