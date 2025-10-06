@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6"
         x-data="{ modalOpen: false, modalContentUrl: '', isModalContentImage: false }"
         @keydown.escape.window="modalOpen = false">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Pemasukan
            </h1>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('admin.incomes.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg shadow-sm hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                              clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Pemasukan</span>
                </a>
            </div>
        </div>

        {{-- Panel Filter (tanpa kategori) --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
            <form method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="from" class="block text-xs font-medium text-slate-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="from" id="from" value="{{ $from }}"
                               class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition" />
                    </div>
                    <div>
                        <label for="to" class="block text-xs font-medium text-slate-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="to" id="to" value="{{ $to }}"
                               class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition" />
                    </div>
                    <div class="flex items-end gap-2 lg:col-span-2">
                        <button class="w-full inline-flex justify-center p-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.incomes.index') }}"
                           class="w-full p-2 border-2 border-slate-200 rounded-lg text-sm text-center font-semibold bg-white hover:bg-slate-50">
                            Reset
                        </a>
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
                                $isAttachmentImage = $it->attachment_mime_type
                                    ? \Illuminate\Support\Str::contains($it->attachment_mime_type, 'image')
                                    : false;
                            @endphp
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4">
                                    <div class="font-medium text-slate-800">{{ $it->source ?? 'Tidak ada sumber' }}</div>
                                    {{-- Tidak ada kategori untuk pemasukan pada skema Dana Umum --}}
                                </td>
                                <td class="p-4 text-slate-600">{{ $it->date?->format('d M Y') }}</td>
                                <td class="p-4 text-right font-semibold text-emerald-600">
                                    Rp {{ number_format($it->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    @if ($it->attachment_path)
                                        <button type="button" title="Lihat Bukti"
                                                @click="modalOpen = true; modalContentUrl = '{{ Storage::url($it->attachment_path) }}'; isModalContentImage = {{ $isAttachmentImage ? 'true' : 'false' }}"
                                                class="inline-flex p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.incomes.edit', $it) }}" title="Edit Pemasukan"
                                           class="p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.incomes.destroy', $it) }}"
                                              onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus Pemasukan"
                                                    class="p-2 rounded-full text-slate-500 hover:bg-rose-50 hover:text-rose-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-8 text-center text-slate-500" colspan="5">
                                    Tidak ada data untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Preview Lampiran --}}
        <div x-show="modalOpen" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 p-4"
             @click="modalOpen = false">

            <div @click.stop class="relative w-full max-w-3xl max-h-full bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="relative h-[80vh]">
                    <button @click="modalOpen = false"
                            class="absolute top-2 right-2 z-20 p-2 rounded-full bg-black/20 text-white hover:bg-black/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <template x-if="isModalContentImage">
                        <img :src="modalContentUrl" class="w-full h-full object-contain" alt="Preview Bukti">
                    </template>
                    <template x-if="!isModalContentImage">
                        <iframe :src="modalContentUrl" class="w-full h-full" frameborder="0"></iframe>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
