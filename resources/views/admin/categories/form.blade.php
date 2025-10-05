@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                {{ $item->exists ? 'Edit Kategori' : 'Tambah Kategori' }}
            </h1>
        </div>

        <form method="POST"
            action="{{ $item->exists ? route('admin.categories.update', $item) : route('admin.categories.store') }}"
            x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KIRI: KONTEN UTAMA --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="space-y-6">
                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold mb-1 text-slate-700">Nama</label>
                                <input id="name" name="name" value="{{ old('name', $item->name) }}" required
                                    class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                                    placeholder="Contoh: Pembangunan Masjid, Santunan Yatim, dll.">
                                @error('name')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="description" class="block text-sm font-semibold mb-1 text-slate-700">Deskripsi
                                    (opsional)</label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                                    placeholder="Jelaskan secara singkat tujuan dari kategori atau rencana ini.">{{ old('description', $item->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: SIDEBAR META & AKSI --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Kotak Target Dana --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <label for="target_amount" class="block text-sm font-semibold mb-1 text-slate-700">Target Dana
                            (opsional)</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="target_amount" id="target_amount" min="0"
                                value="{{ old('target_amount', $item->target_amount) }}"
                                class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 pl-8 focus:outline-none focus:border-indigo-500 transition"
                                placeholder="0">
                        </div>
                    </div>

                    {{-- Kotak Status --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div x-data="{ on: @json(old('is_active', $item->is_active ?? true)) }" class="flex items-center justify-between">
                            <span class="flex-grow flex flex-col">
                                <span class="text-sm font-semibold text-slate-700" id="status-label">Status</span>
                                <span class="text-xs text-slate-500" id="status-description"
                                    x-text="on ? 'Aktif' : 'Diarsipkan'"></span>
                            </span>
                            <input type="hidden" name="is_active" :value="on ? 1 : 0">
                            <button type="button" @click="on = !on" :class="on ? 'bg-indigo-600' : 'bg-slate-200'"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                role="switch" :aria-checked="on.toString()" aria-labelledby="status-label"
                                aria-describedby="status-description">
                                <span :class="on ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3">
                        <button type="submit" :disabled="isSubmitting"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors disabled:bg-indigo-400 disabled:cursor-not-allowed">
                            <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ $item->exists ? 'Simpan Perubahan' : 'Simpan' }}</span>
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="w-full px-4 py-2 border-2 border-slate-200 rounded-lg text-sm text-center font-semibold bg-white hover:bg-slate-50 transition-colors">Batal</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
