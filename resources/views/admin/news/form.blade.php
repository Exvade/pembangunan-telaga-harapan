@extends('admin.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                {{ $item->exists ? 'Edit Berita' : 'Tambah Berita' }}
            </h1>
        </div>

        <form method="POST" enctype="multipart/form-data"
            action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
            x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KIRI: KONTEN UTAMA --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="space-y-6">
                            {{-- Judul --}}
                            <div>
                                <label for="title" class="block text-sm font-semibold mb-1 text-slate-700">Judul</label>
                                <input id="title" name="title" value="{{ old('title', $item->title) }}" required
                                    class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                                    placeholder="Masukkan judul berita...">
                                @error('title')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Isi Berita dengan Trix Editor --}}
                            <div>
                                <label for="body-content" class="block text-sm font-semibold mb-1 text-slate-700">Isi
                                    Berita</label>

                                <div
                                    class="mt-1 trix-container rounded-lg border-2 border-slate-200 focus-within:border-indigo-500 transition overflow-hidden">
                                    <input id="body" type="hidden" name="body"
                                        value="{{ old('body', $item->body) }}">
                                    <trix-editor input="body" id="body-content"></trix-editor>
                                </div>

                                @error('body')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: SIDEBAR META & AKSI --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Kotak Status --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <label for="status" class="block text-sm font-semibold mb-2 text-slate-700">Status</label>
                        <div class="relative">
                            <select name="status" id="status"
                                class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 pr-10 focus:outline-none focus:border-indigo-500 transition appearance-none">
                                @foreach (['draft' => 'Draft', 'published' => 'Published'] as $k => $v)
                                    <option value="{{ $k }}" @selected(old('status', $item->status ?? 'draft') === $k)>{{ $v }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a.75.75 0 01.53.22l3.5 3.5a.75.75 0 01-1.06 1.06L10 4.81 6.53 8.28a.75.75 0 01-1.06-1.06l3.5-3.5A.75.75 0 0110 3zm-3.72 9.28a.75.75 0 011.06 0L10 15.19l2.67-2.91a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 010-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('status')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kotak Cover --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200" x-data="{ imagePreview: '{{ $item->cover_path ? Storage::url($item->cover_path) : '' }}' }">
                        <label class="block text-sm font-semibold mb-2 text-slate-700">Cover (opsional)</label>
                        <div @click="$refs.coverInput.click()"
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-md cursor-pointer hover:border-indigo-500 transition">
                            <div class="space-y-1 text-center">
                                <template x-if="!imagePreview"><svg class="mx-auto h-12 w-12 text-slate-400"
                                        stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg></template>
                                <template x-if="imagePreview"><img :src="imagePreview"
                                        class="mx-auto max-h-40 rounded-md object-contain"></template>
                                <div class="flex text-sm justify-center text-slate-600">
                                    <p class="pl-1" x-text="imagePreview ? 'Ganti gambar' : 'Upload file'"></p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <input type="file" name="cover" accept="image/*" class="hidden" x-ref="coverInput"
                            @change="const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result }; reader.readAsDataURL($event.target.files[0])">
                        @error('cover')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- === [MODERNIZED] Dokumentasi Kegiatan === --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4"
                        x-data="{ tab: 'upload' }">
                        <h3 class="font-semibold text-slate-800">Dokumentasi Kegiatan</h3>

                        {{-- Tab Headers --}}
                        <div class="border-b border-slate-200">
                            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                                <button type="button" @click.prevent="tab = 'upload'"
                                    :class="tab === 'upload' ?
                                        'border-indigo-500 text-indigo-600' :
                                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                                    class="flex items-center gap-2 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H5.5z" />
                                        <path d="M9 13.5l1 1 1-1M10 8v7" />
                                    </svg>
                                    Upload Media
                                </button>
                                <button type="button" @click.prevent="tab = 'embed'"
                                    :class="tab === 'embed' ?
                                        'border-indigo-500 text-indigo-600' :
                                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                                    class="flex items-center gap-2 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A.5.5 0 0014 7.5v5a.5.5 0 00.553.494l2-1A.5.5 0 0017 11.5v-3a.5.5 0 00-.447-.494l-2-1z" />
                                    </svg>
                                    Embed Video
                                </button>
                            </nav>
                        </div>

                        {{-- Tab Content --}}
                        <div class="pt-4">
                            {{-- 1. Upload multiple files --}}
                            <div x-show="tab === 'upload'" x-data="{
                                isDragging: false,
                                previews: [],
                                handleFiles(files) {
                                    this.previews = [];
                                    Array.from(files).forEach(file => {
                                        let reader = new FileReader();
                                        reader.onload = (e) => {
                                            let url = e.target.result;
                                            let type = 'image';
                                            if (file.type.startsWith('video/')) {
                                                type = 'video';
                                            } else if (file.type === 'application/pdf') {
                                                type = 'pdf';
                                            } else if (!file.type.startsWith('image/')) {
                                                type = 'file';
                                            }
                                            this.previews.push({ url: url, name: file.name, type: type });
                                        };
                                        reader.readAsDataURL(file);
                                    });
                                }
                            }">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Upload Media (bisa
                                    banyak)</label>

                                <div @click.prevent="$refs.fileInput.click()" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files); $refs.fileInput.files = $event.dataTransfer.files"
                                    :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <span
                                                class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">Upload
                                                file</span>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-slate-500">Format: JPG/PNG/WebP/PDF/MP4/WebM. Maks 12MB.
                                        </p>
                                    </div>
                                </div>
                                <input type="file" name="media_files[]" multiple x-ref="fileInput"
                                    @change="handleFiles($event.target.files)"
                                    accept="image/*,application/pdf,video/mp4,video/webm" class="hidden">

                                {{-- Previews --}}
                                <div x-show="previews.length > 0" class="mt-4 grid grid-cols-3 sm:grid-cols-4 gap-3">
                                    <template x-for="(preview, index) in previews" :key="index">
                                        <div
                                            class="relative aspect-square bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                                            <template x-if="preview.type === 'image'">
                                                <img :src="preview.url" :alt="preview.name"
                                                    class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="preview.type !== 'image'">
                                                <div class="flex flex-col items-center justify-center h-full p-2">
                                                    <svg x-show="preview.type === 'video'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-500"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A.5.5 0 0014 7.5v5a.5.5 0 00.553.494l2-1A.5.5 0 0017 11.5v-3a.5.5 0 00-.447-.494l-2-1z" />
                                                    </svg>
                                                    <svg x-show="preview.type === 'pdf'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5 2a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7.414A2 2 0 0016.414 6L12 1.586A2 2 0 0010.586 1H7a2 2 0 00-2 1zm.293 11.707a1 1 0 010-1.414L7.586 10l-2.293-2.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 1.414L10.414 10l2.293 2.293a1 1 0 01-1.414 1.414L9 11.414l-2.293 2.293a1 1 0 01-1.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <svg x-show="preview.type === 'file'"
                                                        xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-500"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <div
                                                class="absolute bottom-0 left-0 right-0 p-1.5 bg-black bg-opacity-60 text-white text-xs truncate">
                                                <span x-text="preview.name"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                @error('media_files.*')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- 2. Tambah embed video (YouTube/Vimeo) --}}
                            <div x-show="tab === 'embed'">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Tambah Video
                                    (YouTube/Vimeo)</label>
                                <div class="relative">
                                    <textarea name="embed_urls" rows="3" placeholder="Tempel URL video di sini (satu URL per baris)"
                                        class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 pl-9 focus:outline-none focus:border-indigo-500 transition">{{ old('embed_urls') }}</textarea>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-start pl-3 pt-3 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                            <path
                                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                        </svg>
                                    </div>
                                </div>

                                <p class="text-xs text-slate-500 mt-1">Contoh: https://www.youtube.com/watch?v=xxxx atau
                                    https://vimeo.com/xxxx</p>
                            </div>
                        </div>


                        {{-- 3. Daftar media yang sudah ada (edit caption/urutan, hapus) --}}
                        @if ($item->exists && $item->media()->exists())
                            <div class="border-t pt-4 mt-4">
                                <h4 class="text-sm font-semibold text-slate-700 mb-3">Media Terlampir</h4>
                                <div class="space-y-4 max-h-[420px] overflow-auto pr-2 -mr-2">
                                    @foreach ($item->media as $m)
                                        <div
                                            class="bg-slate-50 border border-slate-200 rounded-lg p-3 flex flex-col sm:flex-row items-start gap-4">
                                            {{-- Preview --}}
                                            <div
                                                class="w-full sm:w-28 h-20 bg-slate-200 rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @if ($m->type === 'image' && $m->file_path)
                                                    <img src="{{ Storage::url($m->file_path) }}"
                                                        class="w-full h-full object-cover" alt="">
                                                @elseif($m->type === 'video' && $m->file_path)
                                                    <span class="text-xs text-slate-600 p-2 text-center">Video
                                                        Upload</span>
                                                @elseif($m->type === 'video' && $m->embed_url)
                                                    <span class="text-xs text-slate-600 p-2 text-center">Video
                                                        Embed</span>
                                                @elseif($m->type === 'file')
                                                    <span class="text-xs text-slate-600 p-2 text-center">File
                                                        (PDF)
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Fields --}}
                                            <div class="flex-1 w-full space-y-3">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Caption</label>
                                                        <input name="media[{{ $m->id }}][caption]"
                                                            value="{{ old("media.$m->id.caption", $m->caption) }}"
                                                            placeholder="Caption (opsional)"
                                                            class="w-full border border-slate-300 rounded p-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Credit</label>
                                                        <input name="media[{{ $m->id }}][credit]"
                                                            value="{{ old("media.$m->id.credit", $m->credit) }}"
                                                            placeholder="Credit (opsional)"
                                                            class="w-full border border-slate-300 rounded p-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 items-center">
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Urutan</label>
                                                        <input type="number"
                                                            name="media[{{ $m->id }}][sort_order]"
                                                            value="{{ old("media.$m->id.sort_order", $m->sort_order) }}"
                                                            class="w-full border border-slate-300 rounded p-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                                    </div>
                                                    <div class="flex items-center gap-2 pt-4">
                                                        <input type="checkbox" id="feat-{{ $m->id }}"
                                                            name="media[{{ $m->id }}][is_featured]" value="1"
                                                            @checked(old("media.$m->id.is_featured", $m->is_featured))
                                                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                                                        <label for="feat-{{ $m->id }}"
                                                            class="text-sm text-slate-700">Unggulan</label>
                                                    </div>
                                                    <div class="text-right pt-4">
                                                        <label
                                                            class="inline-flex items-center gap-1.5 text-sm text-rose-600 hover:text-rose-800 cursor-pointer">
                                                            <input type="checkbox" name="media_delete[]"
                                                                value="{{ $m->id }}"
                                                                class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500">
                                                            Hapus
                                                            </labe>
                                                    </div>
                                                </div>

                                                @if ($m->file_path)
                                                    <a href="{{ Storage::url($m->file_path) }}" target="_blank"
                                                        class="text-xs text-blue-600 underline hover:text-blue-800">
                                                        Lihat Berkas
                                                    </a>
                                                @elseif($m->embed_url)
                                                    <a href="{{ $m->embed_url }}" target="_blank"
                                                        class="text-xs text-blue-600 underline hover:text-blue-800">
                                                        Lihat Video Asli
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>


                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3">
                        <button type="submit" :disabled="isSubmitting"
                            class="w-full inline-flex justify-center items-center gap-2 p-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors disabled:bg-indigo-400 disabled:cursor-not-allowed">
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
                        <a href="{{ route('admin.news.index') }}"
                            class="w-full p-2 border-2 border-slate-200 rounded-lg text-sm text-center font-semibold bg-white hover:bg-slate-50 transition-colors">Batal</a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- CSS Tambahan untuk Trix Editor --}}
    <style>
        .trix-container trix-editor {
            border: none !important;
            box-shadow: none !important;
            padding: 0;
        }

        .trix-content {
            min-height: 300px;
            height: auto;
            padding: 0.75rem;
        }

        .trix-toolbar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Styling scrollbar di daftar media */
        .max-h-\[420px\]::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-\[420px\]::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .max-h-\[420px\]::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .max-h-\[420px\]::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
