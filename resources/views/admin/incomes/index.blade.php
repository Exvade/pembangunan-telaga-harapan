@extends('admin.layouts.app')

@section('content')
    {{-- State Alpine.js disederhanakan, hanya untuk URL gambar --}}
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6"
         x-data="{ modalOpen: false, modalContentUrl: '' }"
         @keydown.escape.window="modalOpen = false">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Pemasukan
            </h1>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('admin.incomes.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg shadow-sm hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    <span>Tambah Pemasukan</span>
                </a>
            </div>
        </div>

        {{-- Panel Filter --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="from" class="block text-xs font-medium text-slate-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="from" id="from" value="{{ $from }}"
                               class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition" />
                    </div>
                    <div>
                        <label for="to" class="block text-xs font-medium text-slate-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="to" id="to" value="{{ $to }}"
                               class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition" />
                    </div>
                    <div class="flex items-end gap-2 lg:col-span-2">
                        <button class="w-full inline-flex justify-center p-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">Filter</button>
                        <a href="{{ route('admin.incomes.index') }}" class="w-full p-2 border-2 border-slate-200 rounded-lg text-sm text-center font-semibold bg-white hover:bg-slate-50">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="border-b border-slate-200">
                        <tr>
                            <th class="text-left font-semibold text-slate-500 uppercase tracking-wider p-4">Sumber</th>
                            <th class="text-left font-semibold text-slate-500 uppercase tracking-wider p-4">Tanggal</th>
                            <th class="text-right font-semibold text-slate-500 uppercase tracking-wider p-4">Nominal</th>
                            <th class="text-center font-semibold text-slate-500 uppercase tracking-wider p-4">Bukti</th>
                            <th class="text-right font-semibold text-slate-500 uppercase tracking-wider p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $it)
                            @php
                                $isAttachmentImage = $it->attachment_mime_type ? \Illuminate\Support\Str::contains($it->attachment_mime_type, 'image') : false;
                            @endphp
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4"><div class="font-medium text-slate-800">{{ $it->source ?? 'Tidak ada sumber' }}</div></td>
                                <td class="p-4 text-slate-600">{{ $it->date?->format('d M Y') }}</td>
                                <td class="p-4 text-right font-semibold text-emerald-600">Rp {{ number_format($it->amount, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    @if ($it->attachment_path && $isAttachmentImage)
                                        {{-- Tombol ini HANYA untuk gambar --}}
                                        <button type="button" title="Lihat Bukti"
                                                @click="modalOpen = true; modalContentUrl = '{{ Storage::url($it->attachment_path) }}'"
                                                class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                        </button>
                                    @elseif($it->attachment_path)
                                        {{-- Link biasa untuk file selain gambar (PDF, dll) --}}
                                        <a href="{{ Storage::url($it->attachment_path) }}" target="_blank" title="Lihat File" class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                        </a>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    {{-- ... Tombol Aksi Edit & Hapus ... --}}
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-8 text-center text-slate-500" colspan="5">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($items->hasPages())
                <div class="p-4 border-t border-slate-200">{{ $items->links() }}</div>
            @endif
        </div>

        {{-- ================================================= --}}
        {{-- Komponen Modal HANYA UNTUK GAMBAR --}}
        {{-- ================================================= --}}
        <div x-show="modalOpen" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/75 p-4"
             @click="modalOpen = false">

            <div @click.stop class="relative">
                <img :src="modalContentUrl" class="block max-w-xl max-h-[75vh] rounded-lg shadow-2xl" alt="Preview Bukti">
                <button @click="modalOpen = false" class="absolute -top-2 -right-2 z-20 p-1.5 rounded-full bg-slate-700 text-white hover:bg-slate-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>
@endsection