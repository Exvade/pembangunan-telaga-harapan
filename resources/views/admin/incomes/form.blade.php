@extends('admin.layouts.app')

@php
    // Gunakan FQN agar aman di Blade
    $isAttachmentImage = $item->attachment_mime_type
        ? \Illuminate\Support\Str::contains($item->attachment_mime_type, 'image')
        : false;
@endphp

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                {{ $item->exists ? 'Edit Pemasukan' : 'Tambah Pemasukan' }}
            </h1>
        </div>

        <form method="POST" enctype="multipart/form-data"
              action="{{ $item->exists ? route('admin.incomes.update', $item) : route('admin.incomes.store') }}"
              x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @if ($item->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- KIRI: KONTEN UTAMA --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="space-y-6">
                            {{-- Sumber --}}
                            <div>
                                <label for="source" class="block text-sm font-semibold mb-1 text-slate-700">Sumber (opsional)</label>
                                <input id="source" name="source" value="{{ old('source', $item->source) }}"
                                       class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                                       placeholder="Contoh: Donasi dari Hamba Allah">
                                @error('source') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Nominal --}}
                            <div>
                                <label for="amount" class="block text-sm font-semibold mb-1 text-slate-700">Nominal (Rp)</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-slate-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" min="0"
                                           value="{{ old('amount', $item->amount) }}" required
                                           class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 pl-8 focus:outline-none focus:border-indigo-500 transition"
                                           placeholder="0">
                                </div>
                                @error('amount') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                {{-- Tanggal --}}
                                <div>
                                    <label for="date" class="block text-sm font-semibold mb-1 text-slate-700">Tanggal Diterima</label>
                                    <input type="date" name="date" id="date" required
                                           value="{{ old('date', $item->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                                           class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition">
                                    @error('date') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- (Kosongkan kolom kanan agar layout rapi) --}}
                                <div class="hidden sm:block"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: SIDEBAR META & LAMPIRAN --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Kotak Catatan --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <label for="notes" class="block text-sm font-semibold mb-1 text-slate-700">Catatan (opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                                  placeholder="Catatan tambahan jika ada...">{{ old('notes', $item->notes) }}</textarea>
                    </div>

                    {{-- Kotak Lampiran --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200"
                         x-data="{ filePreview: '{{ $item->attachment_path ? Storage::url($item->attachment_path) : '' }}', isImage: {{ $isAttachmentImage ? 'true' : 'false' }} }">
                        <label class="block text-sm font-semibold mb-2 text-slate-700">Lampiran Bukti (opsional)</label>
                        <div @click="$refs.attachmentInput.click()"
                             class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-md cursor-pointer hover:border-indigo-500 transition">
                            <div class="space-y-1 text-center">
                                <template x-if="!filePreview">
                                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </template>
                                <template x-if="filePreview && isImage">
                                    <img :src="filePreview" class="mx-auto max-h-40 rounded-md object-contain">
                                </template>
                                <template x-if="filePreview && !isImage">
                                    <div class="mx-auto text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-xs">File terlampir</p>
                                    </div>
                                </template>
                                <p class="text-sm text-slate-600" x-text="filePreview ? 'Ganti file' : 'Upload file'"></p>
                                <p class="text-xs text-slate-500">JPG, PNG, PDF, maks 2MB</p>
                            </div>
                        </div>
                        <input type="file" name="attachment" class="hidden" x-ref="attachmentInput"
                               @change="const file = $event.target.files[0]; if(file) { isImage = file.type.startsWith('image/'); const reader = new FileReader(); reader.onload = (e) => { filePreview = e.target.result }; reader.readAsDataURL(file); } else { filePreview = ''; isImage = false; }">
                        @if ($item->attachment_path)
                            <a class="text-indigo-600 underline text-xs mt-2 inline-block" target="_blank"
                               href="{{ Storage::url($item->attachment_path) }}">Lihat file saat ini</a>
                        @endif
                        @error('attachment') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3">
                        <button type="submit" :disabled="isSubmitting"
                                class="w-full inline-flex justify-center items-center gap-2 p-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg shadow-sm hover:bg-emerald-700 transition-colors disabled:bg-emerald-400 disabled:cursor-not-allowed">
                            <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ $item->exists ? 'Simpan Perubahan' : 'Simpan' }}</span>
                        </button>
                        <a href="{{ route('admin.incomes.index') }}"
                           class="w-full p-2 border-2 border-slate-200 rounded-lg text-sm text-center font-semibold bg-white hover:bg-slate-50 transition-colors">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
