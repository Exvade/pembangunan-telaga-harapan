@extends('admin.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="bg-slate-50 min-h-screen p-4 sm:p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                {{ $item->exists ? 'Edit Berita' : 'Tambah Berita' }}
            </h1>
        </div>

        <form method="POST" enctype="multipart/form-data"
            action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
            x-data="{ isSubmitting: false }" @submit="isSubmitting=true" id="newsForm">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ================== KIRI: KONTEN ================== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Kartu: Judul + Isi --}}
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

                            {{-- Isi (Trix) --}}
                            <div>
                                <label for="body-content" class="block text-sm font-semibold mb-1 text-slate-700">Isi
                                    Berita</label>
                                <div
                                    class="mt-1 trix-container rounded-lg border-2 border-slate-200 focus-within:border-indigo-500 transition overflow-hidden">
                                    <input id="body" type="hidden" name="body"
                                        value="{{ old('body', $item->body) }}">
                                    <trix-editor input="body" id="body-content" class="trix-content"></trix-editor>
                                </div>
                                @error('body')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Kartu: Dokumentasi Kegiatan --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-slate-800">Dokumentasi Kegiatan</h2>

                            {{-- Tombol pilih berkas (selalu ada) --}}
                            <div class="flex items-center gap-2">
                                <input id="mediaInput" type="file" multiple accept="image/*,video/*" class="hidden"
                                    @change="/* ditangani oleh handleUpload di script */">
                                <button type="button"
                                    class="px-3 py-2 rounded-lg bg-slate-800 text-white text-sm font-semibold hover:bg-slate-900"
                                    onclick="document.getElementById('mediaInput').click()">
                                    + Tambah Media
                                </button>
                            </div>
                        </div>

                        {{-- Info batas --}}
                        <p class="text-xs text-slate-500 mb-4">
                            Maksimal <span id="maxMedia">10</span> media per berita. Format: gambar (JPG/PNG/WebP/GIF)
                            &amp; video (MP4/QuickTime/WebM).
                            Ukuran maks 5&nbsp;MB per file.
                        </p>

                        {{-- Grid media --}}
                        <div id="mediaGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @php $countExisting = 0; @endphp
                            @foreach ($item->media ?? collect() as $m)
                                @php
                                    $countExisting++;
                                    $url = $m->file_path ? Storage::url($m->file_path) : null;
                                    $isImage = $m->type === 'image';
                                    $isVideo = $m->type === 'video';
                                @endphp
                                <div class="group relative border border-slate-200 rounded-lg overflow-hidden bg-white"
                                    data-media-id="{{ $m->id }}">
                                    {{-- Media preview --}}
                                    @if ($isImage && $url)
                                        <img src="{{ $url }}" class="w-full h-32 object-cover" alt="media">
                                    @elseif($isVideo && $url)
                                        <video class="w-full h-32 object-cover" preload="metadata" controls>
                                            <source src="{{ $url }}" type="{{ $m->mime_type ?? 'video/mp4' }}">
                                        </video>
                                    @else
                                        <div
                                            class="w-full h-32 bg-slate-100 flex items-center justify-center text-xs text-slate-500">
                                            Media</div>
                                    @endif

                                    {{-- Tombol hapus (client-side remove + tandai untuk delete) --}}
                                    <button type="button"
                                        class="absolute top-2 right-2 p-1.5 rounded-full bg-white/80 text-rose-600 hover:bg-white shadow"
                                        title="Hapus media" onclick="removeMediaItem({{ $m->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        {{-- Container hidden inputs untuk delete --}}
                        <div id="deleteMediaContainer"></div>

                        {{-- Loader garis upload --}}
                        <div id="uploadBar" class="hidden mt-4">
                            <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                <div id="uploadBarFill" class="h-2 bg-indigo-600 w-0"></div>
                            </div>
                            <p id="uploadBarText" class="text-xs text-slate-500 mt-2">Mengunggah...</p>
                        </div>
                    </div>
                </div>

                {{-- ================== KANAN: META ================== --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Status --}}
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

                    {{-- Cover --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200" x-data="{ imagePreview: '{{ $item->cover_path ? Storage::url($item->cover_path) : '' }}' }">
                        <label class="block text-sm font-semibold mb-2 text-slate-700">Cover (opsional)</label>
                        <div @click="$refs.coverInput.click()"
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-md cursor-pointer hover:border-indigo-500 transition">
                            <div class="space-y-1 text-center">
                                <template x-if="!imagePreview">
                                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </template>
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="mx-auto max-h-40 rounded-md object-contain">
                                </template>
                                <div class="flex text-sm justify-center text-slate-600">
                                    <p class="pl-1" x-text="imagePreview ? 'Ganti gambar' : 'Upload file'"></p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, WEBP maks 2MB</p>
                            </div>
                        </div>
                        <input type="file" name="cover" accept="image/*" class="hidden" x-ref="coverInput"
                            @change="const f=$event.target.files[0]; if(!f) return; const r=new FileReader(); r.onload=(e)=>{ imagePreview=e.target.result }; r.readAsDataURL(f)">

                        @error('cover')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol aksi --}}
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

            {{-- Fallback input untuk create (non-AJAX) --}}
            <input id="mediaFallbackInput" type="file" name="media_files[]" class="hidden" multiple
                accept="image/*,video/*">
            {{-- Container preview sementara untuk create --}}
            <div id="createPreviewContainer" class="hidden mt-4"></div>

        </form>
    </div>

    {{-- ===== CSS kecil utk Trix ===== --}}
    <style>
        .trix-container trix-editor {
            border: none !important;
            box-shadow: none !important;
            padding: 0;
        }

        .trix-content {
            min-height: 300px;
            height: auto;
            padding: .75rem;
        }

        .trix-toolbar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
    </style>

    {{-- ====== SCRIPT: definisi handleUpload & removeMediaItem ====== --}}
    <script>
        // Konstanta
        const MAX_MEDIA = 10;
        const ALLOWED_MIME = [
            'image/jpeg', 'image/png', 'image/webp', 'image/gif',
            'video/mp4', 'video/quicktime', 'video/webm'
        ];

        // Elemen yang dipakai
        const mediaInput = document.getElementById('mediaInput');
        const mediaGrid = document.getElementById('mediaGrid');
        const uploadBar = document.getElementById('uploadBar');
        const uploadBarFill = document.getElementById('uploadBarFill');
        const uploadBarText = document.getElementById('uploadBarText');
        const deleteHiddenBox = document.getElementById('deleteMediaContainer');
        const createFallback = document.getElementById('mediaFallbackInput');
        const createPrevWrap = document.getElementById('createPreviewContainer');

        // Hitung existing
        function currentMediaCount() {
            return mediaGrid.querySelectorAll('[data-media-id]').length +
                mediaGrid.querySelectorAll('[data-temp="1"]').length;
        }

        // Preview helper
        function buildCard({
            id = null,
            url = '',
            type = 'image',
            mime = ''
        }) {
            const wrap = document.createElement('div');
            wrap.className = 'group relative border border-slate-200 rounded-lg overflow-hidden bg-white';
            if (id) wrap.dataset.mediaId = id;
            else wrap.dataset.temp = '1';

            let inner = '';
            if (type === 'image') {
                inner += `<img src="${url}" class="w-full h-32 object-cover" alt="media">`;
            } else if (type === 'video') {
                inner +=
                    `<video class="w-full h-32 object-cover" preload="metadata" controls><source src="${url}" type="${mime || 'video/mp4'}"></video>`;
            } else {
                inner +=
                    `<div class="w-full h-32 bg-slate-100 flex items-center justify-center text-xs text-slate-500">Media</div>`;
            }
            // tombol hapus hanya untuk media yang sudah punya id (tersimpan)
            inner += `
    <button type="button"
            class="absolute top-2 right-2 p-1.5 rounded-full bg-white/80 text-rose-600 hover:bg-white shadow"
            title="Hapus media"
            ${id ? `onclick="removeMediaItem(${id})"` : `onclick="this.closest('[data-temp]').remove()"`}>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
      </svg>
    </button>
  `;
            wrap.innerHTML = inner;
            return wrap;
        }

        // Hapus visual + tandai untuk delete (tanpa AJAX)
        window.removeMediaItem = function(id) {
            const card = mediaGrid.querySelector(`[data-media-id="${id}"]`);
            if (card) card.remove();
            // sisipkan hidden input agar dihapus saat submit
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_media_ids[]';
            input.value = String(id);
            deleteHiddenBox.appendChild(input);
        };

        // ===== UPLOAD HANDLER =====
        window.handleUpload = async function() {
            const files = Array.from(mediaInput.files || []);
            if (!files.length) return;

            // Halaman create? -> fallback non-AJAX
            const IS_EDIT = {{ $item->exists ? 'true' : 'false' }};

            // Filter mime & hitung batas
            const valid = files.filter(f => ALLOWED_MIME.includes(f.type));
            const rejected = files.filter(f => !ALLOWED_MIME.includes(f.type));
            if (rejected.length) {
                alert('Hanya gambar (jpg/png/webp/gif) dan video (mp4/mov/webm) yang diperbolehkan.');
            }

            const existing = currentMediaCount();
            const allowedCount = Math.max(0, MAX_MEDIA - existing);
            if (allowedCount <= 0) {
                alert('Batas media sudah mencapai 10 item.');
                mediaInput.value = '';
                return;
            }

            const toUpload = valid.slice(0, allowedCount);

            if (!IS_EDIT) {
                // CREATE PAGE: tampilkan preview dan tambahkan ke input fallback
                createPrevWrap.classList.remove('hidden');
                toUpload.forEach(f => {
                    // tambahkan ke fallback input
                    // sayangnya kita tidak bisa programmatically append ke FileList; jadi kita pakai input asli (name="media_files[]") yg memang ada
                    // Solusi: ganti id mediaFallbackInput di atas menjadi input "media_files[]" dan kliknya diarahkan ke situ jika create.
                });

                // Trik: saat CREATE, kita ganti input target agar file benar-benar ikut terkirim.
                // Pindahkan file2 dari mediaInput ke input name="media_files[]"
                const dt = new DataTransfer();
                const fallbackEl = document.getElementById('mediaFallbackInput');
                const dt2 = new DataTransfer();
                // masukkan file yang valid ke fallbackEl
                toUpload.forEach(f => dt2.items.add(f));
                fallbackEl.files = dt2.files;

                // Tampilkan preview card sementara (client-side)
                toUpload.forEach(f => {
                    const url = URL.createObjectURL(f);
                    const type = f.type.startsWith('image/') ? 'image' : 'video';
                    mediaGrid.appendChild(buildCard({
                        id: null,
                        url,
                        type,
                        mime: f.type
                    }));
                });

                mediaInput.value = '';
                return;
            }

            // EDIT PAGE: AJAX upload
            const formData = new FormData();
            toUpload.forEach(f => formData.append('media_files[]', f));

            uploadBar.classList.remove('hidden');
            uploadBarFill.style.width = '0%';
            uploadBarText.textContent = 'Mengunggah...';

            try {
                const res = await fetch("{{ $item->exists ? route('admin.news.media.store', $item) : '' }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                });

                if (!res.ok) {
                    const text = await res.text().catch(() => '');
                    throw new Error(text || 'Gagal mengunggah.');
                }

                const json = await res.json();
                if (!json.ok) {
                    throw new Error(json.error || 'Gagal mengunggah.');
                }

                // Tambah ke grid
                (json.items || []).forEach(it => {
                    mediaGrid.appendChild(buildCard({
                        id: it.id,
                        url: it.url,
                        type: it.type,
                        mime: it.mime
                    }));
                });

                uploadBarFill.style.width = '100%';
                uploadBarText.textContent = 'Selesai.';
                setTimeout(() => uploadBar.classList.add('hidden'), 600);

            } catch (err) {
                alert(err.message || 'Upload gagal.');
                uploadBar.classList.add('hidden');
            } finally {
                mediaInput.value = '';
            }
        };

        // Hubungkan event change ke handler (agar tak tergantung inline attribute)
        document.addEventListener('DOMContentLoaded', () => {
            if (mediaInput) {
                mediaInput.addEventListener('change', () => window.handleUpload());
            }
        });
    </script>

    {{-- Trix (CDN) jika belum dimasukkan di layout --}}
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endsection
