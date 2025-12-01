@extends('admin.layouts.app')

@section('content')
    @php
        $isEdit = $item->exists;
        $title = $isEdit ? 'Edit Rencana Pembangunan' : 'Buat Rencana Baru';
    @endphp

    <!-- Header Section -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $isEdit ? 'Perbarui detail rencana anggaran.' : 'Tambahkan pos anggaran atau proyek pembangunan baru.' }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.categories.update', $item) : route('admin.categories.store') }}"
        x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- ================== KOLOM KIRI: KONTEN UTAMA ================== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Kartu: Informasi Utama --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 space-y-6">

                        {{-- Nama Rencana --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Rencana /
                                Proyek</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}"
                                required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-slate-400 py-2.5 px-3 transition-shadow"
                                placeholder="Contoh: Pembangunan Masjid Tahap 1...">
                            <p class="mt-1 text-xs text-slate-500">Nama ini akan muncul saat memilih kategori pengeluaran.
                            </p>
                            @error('name')
                                <p class="mt-1 text-sm text-rose-600 flex items-center gap-1">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi
                                (Opsional)</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="4"
                                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-slate-400 py-2.5 px-3 transition-shadow"
                                    placeholder="Jelaskan tujuan penggunaan dana atau detail proyek ini.">{{ old('description', $item->description) }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Kartu: Target Anggaran --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Target Anggaran</h2>
                    </div>
                    <div class="p-6">
                        <label for="target_amount" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Target
                            (Rp)</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="target_amount" id="target_amount" min="0"
                                value="{{ old('target_amount', $item->target_amount) }}"
                                class="block w-full rounded-lg border-slate-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                placeholder="0">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Kosongkan jika tidak ada target spesifik.</p>
                    </div>
                </div>

            </div>

            {{-- ================== KOLOM KANAN: STATUS & AKSI ================== --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">

                {{-- Kartu: Status --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Status Rencana</h2>
                    </div>
                    <div class="p-6">
                        <div x-data="{ on: @json(old('is_active', $item->is_active ?? true)) }" class="flex items-center justify-between">
                            <span class="flex-grow flex flex-col">
                                <span class="text-sm font-medium text-slate-900" id="status-label">Status Aktif</span>
                                <span class="text-xs text-slate-500" id="status-description"
                                    x-text="on ? 'Rencana ini dapat dipilih saat input pengeluaran.' : 'Rencana diarsipkan (tidak muncul di pilihan).'"></span>
                            </span>

                            {{-- Toggle Switch --}}
                            <input type="hidden" name="is_active" :value="on ? 1 : 0">
                            <button type="button" @click="on = !on" :class="on ? 'bg-indigo-600' : 'bg-slate-200'"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                role="switch" :aria-checked="on.toString()" aria-labelledby="status-label">
                                <span aria-hidden="true" :class="on ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-100 flex flex-col gap-3">
                            <button type="submit" :disabled="isSubmitting"
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-70 disabled:cursor-wait shadow-sm transition-all">
                                <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Rencana' }}
                            </button>
                            <a href="{{ route('admin.categories.index') }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
@endsection
