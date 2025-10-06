@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        {{-- === Header (Tetap Sama) === --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                Rencana Pembangunan
            </h1>
            <div class="mt-3 sm:mt-0 flex items-center gap-4">
                <form method="GET" class="relative">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama kategori..."
                        class="w-full md:w-64 rounded-lg border border-slate-300 py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                </form>
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Tambah</span>
                </a>
            </div>
        </div>

        {{-- === Kontainer Tabel === --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100">
  <tr>
    <th class="text-left p-3">Nama</th>
    <th class="text-left p-3">Status</th>
    <th class="text-right p-3">Total Pengeluaran</th>
    <th class="text-right p-3">Aksi</th>
  </tr>
</thead>
<tbody>
  @forelse($items as $it)
    @php
      $ex = $it->expenses()->sum('amount');
    @endphp
    <tr class="border-t">
      <td class="p-3">
        <div class="font-medium">{{ $it->name }}</div>
        @if($it->description)<div class="text-slate-500 text-xs">{{ $it->description }}</div>@endif
      </td>
      <td class="p-3">
        <span class="px-2 py-1 rounded text-xs {{ $it->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
          {{ $it->is_active ? 'Aktif' : 'Arsip' }}
        </span>
      </td>
      <td class="p-3 text-right">Rp {{ number_format($ex,0,',','.') }}</td>
      <td class="p-3 text-right">
        <a href="{{ route('admin.expenses.create') }}?category_id={{ $it->id }}" class="text-orange-600">+ Pengeluaran</a>
        <span class="mx-1">|</span>
        <a href="{{ route('admin.categories.edit',$it) }}" class="text-blue-600">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy',$it) }}" class="inline" onsubmit="return confirm('Hapus kategori?')">
          @csrf @method('DELETE')
          <button class="text-red-600 ml-2">Hapus</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="4" class="p-3">Belum ada kategori.</td></tr>
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
