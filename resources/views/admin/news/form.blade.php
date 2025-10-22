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

                    {{-- === Dokumentasi Kegiatan === --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                        <h3 class="font-semibold text-slate-800">Dokumentasi Kegiatan</h3>

                        {{-- Upload multiple files --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Upload Media (bisa banyak)</label>
                            <input type="file" name="media_files[]" multiple
                                accept="image/*,application/pdf,video/mp4,video/webm"
                                class="w-full text-sm border-2 border-slate-200 rounded-lg p-2">
                            <p class="text-xs text-slate-500 mt-1">Format: JPG/PNG/WebP/PDF/MP4/WebM. Maks 12MB per file.
                            </p>
                            @error('media_files.*')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tambah embed video (YouTube/Vimeo) --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tambah Video
                                (YouTube/Vimeo)</label>
                            <textarea name="embed_urls" rows="2" placeholder="Tempel URL video di sini (satu URL per baris)"
                                class="w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition">{{ old('embed_urls') }}</textarea>
                            <p class="text-xs text-slate-500 mt-1">Contoh: https://www.youtube.com/watch?v=xxxx atau
                                https://vimeo.com/xxxx</p>
                        </div>

                        {{-- Daftar media yang sudah ada (edit caption/urutan, hapus) --}}
                        @if ($item->exists && $item->media()->exists())
                            <div class="border-t pt-3">
                                <h4 class="text-sm font-semibold text-slate-700 mb-3">Media Terlampir</h4>
                                <div class="space-y-3 max-h-[420px] overflow-auto pr-1">
                                    @foreach ($item->media as $m)
                                        <div class="flex items-start gap-3 border rounded-lg p-3">
                                            {{-- Preview --}}
                                            <div
                                                class="w-24 h-16 bg-slate-100 rounded flex items-center justify-center overflow-hidden">
                                                @if ($m->type === 'image' && $m->file_path)
                                                    <img src="{{ Storage::url($m->file_path) }}"
                                                        class="w-full h-full object-cover" alt="">
                                                @elseif($m->type === 'video' && $m->file_path)
                                                    <span class="text-xs text-slate-600">Video Upload</span>
                                                @elseif($m->type === 'video' && $m->embed_url)
                                                    <span class="text-xs text-slate-600">Video Embed</span>
                                                @elseif($m->type === 'file')
                                                    <span class="text-xs text-slate-600">File</span>
                                                @endif
                                            </div>

                                            {{-- Fields --}}
                                            <div class="flex-1 grid grid-cols-1 gap-2">
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Caption</label>
                                                        <input name="media[{{ $m->id }}][caption]"
                                                            value="{{ old("media.$m->id.caption", $m->caption) }}"
                                                            class="w-full border rounded p-2 text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Credit</label>
                                                        <input name="media[{{ $m->id }}][credit]"
                                                            value="{{ old("media.$m->id.credit", $m->credit) }}"
                                                            class="w-full border rounded p-2 text-sm">
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-3 gap-2 items-center">
                                                    <div>
                                                        <label class="block text-xs text-slate-500 mb-1">Urutan</label>
                                                        <input type="number"
                                                            name="media[{{ $m->id }}][sort_order]"
                                                            value="{{ old("media.$m->id.sort_order", $m->sort_order) }}"
                                                            class="w-full border rounded p-2 text-sm" />
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <input type="checkbox" id="feat-{{ $m->id }}"
                                                            name="media[{{ $m->id }}][is_featured]" value="1"
                                                            @checked(old("media.$m->id.is_featured", $m->is_featured))>
                                                        <label for="feat-{{ $m->id }}" class="text-sm">Tandai
                                                            unggulan</label>
                                                    </div>
                                                    <div class="text-right">
                                                        <label
                                                            class="inline-flex items-center gap-2 text-sm text-rose-700">
                                                            <input type="checkbox" name="media_delete[]"
                                                                value="{{ $m->id }}">
                                                            Hapus
                                                        </label>
                                                    </div>
                                                </div>

                                                @if ($m->file_path)
                                                    <a href="{{ Storage::url($m->file_path) }}" target="_blank"
                                                        class="text-xs text-blue-600 underline">
                                                        Lihat Berkas
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
    </style>
@endsection
