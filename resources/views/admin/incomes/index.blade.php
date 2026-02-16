@extends('admin.layouts.app')

@section('content')
    {{-- Container Utama dengan Alpine Data untuk Modal --}}
    <div x-data="{ modalOpen: false, modalContentUrl: '' }" @keydown.escape.window="modalOpen = false" x-cloak>

        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Data Pemasukan</h1>
                <p class="mt-1 text-sm text-slate-500">Rekapitulasi sumber dana dan riwayat uang masuk.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.incomes.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Catat Pemasukan
                </a>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 mb-6">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Filter Periode</h2>
            <form method="GET" class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="w-full sm:flex-1">
                    <label for="from" class="block text-sm font-medium text-slate-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="from" id="from" value="{{ $from }}"
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="w-full sm:flex-1">
                    <label for="to" class="block text-sm font-medium text-slate-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="to" id="to" value="{{ $to }}"
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                        Filter
                    </button>
                    <a href="{{ route('admin.incomes.index') }}"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Sumber Dana</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th scope="col"
                                class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Nominal</th>
                            <th scope="col"
                                class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Bukti</th>
                            <th scope="col" class="relative px-6 py-4">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($items as $it)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L9 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $it->source ?? 'Tidak ada sumber' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $it->date ? $it->date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-bold bg-emerald-50 text-emerald-700">
                                        + Rp {{ number_format($it->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($it->attachment_path)
                                        <button type="button"
                                            @click="modalOpen = true; modalContentUrl = '{{ asset('media/' . $it->attachment_path) }}'"
                                            class="inline-flex items-center justify-center p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors border border-slate-200 shadow-sm"
                                            title="Lihat Bukti Foto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    @else
                                        {{-- UX: Ikon abu-abu halus jika foto tidak ada --}}
                                        <div class="flex justify-center" title="Tidak ada bukti">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-200"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.incomes.edit', $it) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.incomes.destroy', $it) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemasukan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                            <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M16 17l-4 4m0 0l-4-4m4 4V3" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-slate-900">Belum ada data pemasukan</h3>
                                        <p class="mt-1 text-sm text-slate-500">Silakan sesuaikan filter tanggal atau tambah
                                            data baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="px-6 py-4 bg-white border-t border-slate-200">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Preview Gambar (Alpine.js) --}}
        <div x-show="modalOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4"
            @click="modalOpen = false">

            <div @click.stop
                class="relative bg-white rounded-xl shadow-2xl overflow-hidden max-w-3xl w-full max-h-[85vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Bukti Transaksi</h3>
                    <button @click="modalOpen = false" class="text-slate-400 hover:text-rose-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-2 bg-slate-50 flex-grow overflow-auto flex items-center justify-center">
                    <img :src="modalContentUrl" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-sm"
                        alt="Preview">
                </div>
            </div>
        </div>

    </div>
@endsection
