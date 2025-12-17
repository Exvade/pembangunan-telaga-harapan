{{-- Menggunakan Layout Admin Utama --}}
@extends('admin.layouts.app')

{{-- Judul Halaman (Opsional, sesuaikan dengan layout Anda) --}}
@section('title', 'Kelola Aspirasi Warga')

{{-- Konten Utama --}}
@section('content')

    {{-- Container Utama --}}
    <div class="p-6">

        <div class="space-y-6">
            {{-- Header Halaman --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Daftar Aspirasi & Saran</h2>
                    <p class="text-sm text-slate-500 mt-1">Kelola masukan dari warga Telaga Harapan.</p>
                </div>
            </div>

            {{-- Container Tabel --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Warga
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-1/3">
                                    Pesan
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Lampiran
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Publikasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($data as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    {{-- 1. WARGA (Avatar & Nama) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                {{-- Avatar Generator --}}
                                                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-100"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($item->name ?? 'A') }}&background=e2e8f0&color=475569"
                                                    alt="{{ $item->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900">
                                                    {{ $item->name ?? 'Hamba Allah' }}</div>
                                                <div class="text-xs text-slate-500">
                                                    {{ $item->created_at->format('d M Y, H:i') }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 2. PESAN --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600 line-clamp-2" title="{{ $item->message }}">
                                            {{ $item->message }}
                                        </div>
                                    </td>

                                    {{-- 3. FOTO --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->photos && count($item->photos) > 0)
                                            <div class="flex -space-x-2 overflow-hidden">
                                                @foreach ($item->photos as $img)
                                                    <a href="{{ asset('uploads/suggestions/' . $img) }}" target="_blank"
                                                        class="inline-block h-8 w-8 rounded-full ring-2 ring-white cursor-pointer hover:z-10 hover:scale-110 transition-transform relative bg-slate-100">
                                                        <img class="h-full w-full object-cover rounded-full"
                                                            src="{{ asset('uploads/suggestions/' . $img) }}"
                                                            alt="Foto Saran">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    {{-- 4. STATUS --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($item->status == 'handled')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <svg class="mr-1.5 w-2 h-2 text-emerald-600" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Ditindaklanjuti
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                                <svg class="mr-1.5 w-2 h-2 text-amber-600" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 5. PUBLIKASI --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($item->allow_public)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                Public
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                                Private
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 6. AKSI --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Tombol Toggle Publik --}}
                                            <form action="/admin/suggestions/{{ $item->id }}/publish" method="POST">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Ubah status publikasi?')"
                                                    class="p-2 rounded-lg transition-colors border {{ $item->allow_public ? 'border-slate-200 text-slate-500 hover:bg-slate-50' : 'bg-blue-50 border-blue-200 text-blue-600 hover:bg-blue-100' }}"
                                                    title="{{ $item->allow_public ? 'Sembunyikan' : 'Tampilkan ke Publik' }}">
                                                    @if ($item->allow_public)
                                                        {{-- Icon Eye Slash --}}
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                                            </path>
                                                        </svg>
                                                    @else
                                                        {{-- Icon Eye --}}
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            {{-- Tombol Handled --}}
                                            @if ($item->status != 'handled')
                                                <form action="/admin/suggestions/{{ $item->id }}/handled"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Tandai saran ini sebagai ditindaklanjuti?')"
                                                        class="p-2 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 transition-colors"
                                                        title="Tandai Selesai / Ditindaklanjuti">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-slate-50 p-4 rounded-full mb-3">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-slate-600">Belum ada aspirasi masuk</p>
                                            <p class="text-sm text-slate-400">Data aspirasi dari warga akan muncul di sini.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination (Jika ada) --}}
            @if (method_exists($data, 'links'))
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
