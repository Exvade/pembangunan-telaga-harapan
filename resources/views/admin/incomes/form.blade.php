@extends('admin.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        $isEdit = $item->exists;
        $title = $isEdit ? 'Edit Pemasukan' : 'Catat Pemasukan';
    @endphp

    <!-- Header Section -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $isEdit ? 'Perbarui data pemasukan yang sudah ada.' : 'Catat sumber dana masuk baru ke kas.' }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.incomes.index') }}"
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

    <form method="POST" enctype="multipart/form-data"
        action="{{ $isEdit ? route('admin.incomes.update', $item) : route('admin.incomes.store') }}" x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- ================== KOLOM KIRI: DETAIL TRANSAKSI ================== --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Detail Transaksi</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        {{-- Sumber Dana --}}
                        <div>
                            <label for="source" class="block text-sm font-semibold text-slate-700 mb-1">Sumber
                                Dana</label>
                            <input type="text" id="source" name="source" value="{{ old('source', $item->source) }}"
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 transition-shadow"
                                placeholder="Contoh: Donasi Warga, Iuran Bulanan, Sumbangan Hamba Allah...">
                            @error('source')
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Nominal --}}
                            <div>
                                <label for="amount"
                                    class="block text-sm font-semibold text-slate-700 mb-1">Nominal</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-slate-500 sm:text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" min="0" required
                                        value="{{ old('amount', $item->amount) }}"
                                        class="block w-full rounded-lg border-slate-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                        placeholder="0">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label for="date" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal
                                    Diterima</label>
                                <input type="date" name="date" id="date" required
                                    value="{{ old('date', $item->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3">
                                @error('date')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1">Catatan Tambahan
                                (Opsional)</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 transition-shadow"
                                placeholder="Keterangan detail mengenai pemasukan ini...">{{ old('notes', $item->notes) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================== KOLOM KANAN: BUKTI & AKSI ================== --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">

                {{-- Card: Attachment --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden" x-data="{
                    filePreview: '{{ $item->attachment_path ? Storage::url($item->attachment_path) : '' }}',
                    isImage: {{ $item->attachment_mime_type && \Illuminate\Support\Str::contains($item->attachment_mime_type, 'image') ? 'true' : 'false' }},
                    fileName: ''
                }">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Bukti Transaksi</h2>
                    </div>
                    <div class="p-6">

                        <div @click="$refs.attachmentInput.click()"
                            class="group relative w-full aspect-[4/3] rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 hover:border-indigo-400 transition-all cursor-pointer flex flex-col items-center justify-center overflow-hidden">

                            {{-- Placeholder --}}
                            <div x-show="!filePreview" class="text-center p-4">
                                <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-xs font-medium text-slate-600">Upload Bukti</p>
                                <p class="text-[10px] text-slate-400 mt-1">Struk, Bukti Transfer (Max 2MB)</p>
                            </div>

                            {{-- Image Preview --}}
                            <template x-if="filePreview && isImage">
                                <img :src="filePreview" class="absolute inset-0 w-full h-full object-contain bg-white">
                            </template>

                            {{-- File Icon Preview --}}
                            <template x-if="filePreview && !isImage">
                                <div
                                    class="absolute inset-0 w-full h-full flex flex-col items-center justify-center bg-white p-4">
                                    <svg class="h-12 w-12 text-indigo-500 mb-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-xs text-center text-slate-600 font-medium truncate w-full"
                                        x-text="fileName || 'File Terlampir'"></p>
                                </div>
                            </template>

                            {{-- Overlay on Hover --}}
                            <div x-show="filePreview"
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                <span
                                    class="opacity-0 group-hover:opacity-100 bg-white/90 text-slate-700 text-xs font-semibold px-2 py-1 rounded shadow-sm transition-opacity">Ganti
                                    File</span>
                            </div>
                        </div>

                        {{-- Hidden Input --}}
                        <input type="file" name="attachment" class="hidden" x-ref="attachmentInput"
                            @change="
                                   const file = $event.target.files[0]; 
                                   if(file) { 
                                       fileName = file.name;
                                       isImage = file.type.startsWith('image/'); 
                                       if(isImage){
                                           const reader = new FileReader(); 
                                           reader.onload = (e) => { filePreview = e.target.result }; 
                                           reader.readAsDataURL(file);
                                       } else {
                                           filePreview = 'true'; // trigger non-image view
                                       }
                                   }
                               ">

                        @if ($item->attachment_path)
                            <div class="mt-3 text-center">
                                <a href="{{ Storage::url($item->attachment_path) }}" target="_blank"
                                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium underline flex items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Lihat file saat ini
                                </a>
                            </div>
                        @endif
                        @error('attachment')
                            <p class="mt-2 text-xs text-center text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Card: Actions --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <button type="submit" :disabled="isSubmitting"
                        class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-70 disabled:cursor-wait shadow-sm transition-all mb-3">
                        <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pemasukan' }}
                    </button>
                    <a href="{{ route('admin.incomes.index') }}"
                        class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>
@endsection
