@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        {{-- === Header dengan Tombol Aksi & Pencarian === --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Rencana Pembangunan
            </h1>
            <div class="mt-3 sm:mt-0 flex items-center gap-4">
                {{-- Form Pencarian --}}
                <form method="GET" class="relative">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama rencana..."
                        class="w-full md:w-64 rounded-lg border-2 border-slate-200 p-2 pl-10 text-sm focus:outline-none focus:border-indigo-500 transition">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5S 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    </div>
                </form>
                {{-- Tombol Tambah --}}
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    <span>Tambah</span>
                </a>
            </div>
        </div>

        {{-- === Kontainer Tabel === --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="border-b border-slate-200">
                        <tr>
                            <th class="text-left font-semibold text-slate-500 uppercase tracking-wider p-4">Nama Rencana</th>
                            <th class="text-left font-semibold text-slate-500 uppercase tracking-wider p-4">Status</th>
                            <th class="text-right font-semibold text-slate-500 uppercase tracking-wider p-4">Total Pengeluaran</th>
                            <th class="text-right font-semibold text-slate-500 uppercase tracking-wider p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $it)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 align-top">
                                    <div class="font-medium text-slate-800">{{ $it->name }}</div>
                                    @if($it->description)<div class="text-xs text-slate-500 mt-1">{{ $it->description }}</div>@endif
                                </td>
                                <td class="p-4 align-top">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $it->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $it->is_active ? 'Aktif' : 'Arsip' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right align-top font-semibold text-rose-600">
                                    {{-- Gunakan hasil dari withSum untuk performa --}}
                                    Rp {{ number_format($it->expenses_sum_amount ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-4 align-top">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.expenses.create') }}?category_id={{ $it->id }}" title="Tambah Pengeluaran"
                                           class="p-2 rounded-full text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $it) }}" title="Edit Rencana"
                                           class="p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $it) }}" onsubmit="return confirm('Anda yakin ingin menghapus rencana ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus Rencana" class="p-2 rounded-full text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-8 text-center text-slate-500" colspan="4">
                                    Belum ada rencana pembangunan.
                                    <a href="{{ route('admin.categories.create') }}" class="text-indigo-600 font-medium hover:underline ml-2">Buat Sekarang</a>
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
    </div>
@endsection