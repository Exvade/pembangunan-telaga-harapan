@extends('admin.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        $isEdit = $item->exists;
        $title = $isEdit ? 'Edit Berita' : 'Buat Berita Baru';
    @endphp

    <!-- Header Section -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $isEdit ? 'Perbarui informasi dan konten berita.' : 'Tulis artikel atau pengumuman baru untuk warga.' }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.news.index') }}"
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
        action="{{ $isEdit ? route('admin.news.update', $item) : route('admin.news.store') }}" x-data="{ isSubmitting: false }"
        @submit="isSubmitting=true" id="newsForm">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- ================== KOLOM KIRI: KONTEN UTAMA ================== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Kartu: Editor Konten --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 space-y-6">

                        {{-- Judul --}}
                        <div>
                            <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Judul
                                Artikel</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}"
                                required
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-slate-400 py-2.5 px-3 transition-shadow"
                                placeholder="Contoh: Kegiatan Kerja Bakti RT 01...">
                            @error('title')
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

                        {{-- Trix Editor --}}
                        <div>
                            <label for="body-content" class="block text-sm font-semibold text-slate-700 mb-1">Isi
                                Berita</label>
                            <div class="prose-sm max-w-none">
                                <input id="body" type="hidden" name="body" value="{{ old('body', $item->body) }}">
                                <div
                                    class="rounded-lg border border-slate-300 shadow-sm overflow-hidden focus-within:ring-1 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                                    <trix-editor input="body" id="body-content"
                                        class="trix-content min-h-[300px] border-none px-4 py-3 focus:outline-none"></trix-editor>
                                </div>
                            </div>
                            @error('body')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Kartu: Galeri / Dokumentasi --}}
                <div id="media-section" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-slate-800">Galeri Dokumentasi</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Maksimal 10 foto/video (Max 5MB per file)</p>
                        </div>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <span id="mediaCountDisplay">0</span>/10 Item
                        </span>
                    </div>

                    <div class="p-6">
                        {{-- Upload Area (Dropzone Style) --}}
                        <div class="mb-6">
                            <input id="mediaInput" type="file" multiple accept="image/*,video/*" class="hidden"
                                @change="window.handleUpload()">

                            <div id="dropzoneArea" onclick="document.getElementById('mediaInput').click()"
                                class="group relative block w-full rounded-lg border-2 border-dashed border-slate-300 p-8 text-center hover:border-indigo-500 hover:bg-indigo-50/50 transition-all cursor-pointer">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium text-slate-700">
                                        <span class="text-indigo-600">Klik untuk upload</span> atau drag and drop
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG, MP4 up to 30MB</p>
                                </div>
                            </div>

                            {{-- Progress Bar --}}
                            <div id="uploadBar" class="hidden mt-4">
                                <div class="flex justify-between text-xs text-slate-600 mb-1">
                                    <span id="uploadBarText">Mengunggah...</span>
                                    <span id="uploadPercent">0%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div id="uploadBarFill"
                                        class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Grid Media --}}
                        <div id="mediaGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach ($item->media ?? collect() as $m)
                                @php
                                    $url = $m->file_path ? asset('media/' . $m->file_path) : null;
                                    $isImage = $m->type === 'image';
                                    $isVideo = $m->type === 'video';
                                @endphp
                                <div class="group relative aspect-square rounded-lg border border-slate-200 bg-slate-50 overflow-hidden"
                                    data-media-id="{{ $m->id }}">
                                    @if ($isImage && $url)
                                        <img src="{{ $url }}"
                                            class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                            alt="media">
                                    @elseif($isVideo && $url)
                                        <video class="h-full w-full object-cover" preload="metadata">
                                            <source src="{{ $url }}" type="{{ $m->mime_type ?? 'video/mp4' }}">
                                        </video>
                                        <div
                                            class="absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none">
                                            <svg class="w-8 h-8 text-white opacity-80" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Overlay & Delete Button --}}
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors">
                                    </div>
                                    <button type="button" onclick="removeMediaItem({{ $m->id }})"
                                        class="absolute top-2 right-2 p-1.5 rounded-full bg-white/90 text-rose-600 shadow-sm opacity-0 group-hover:opacity-100 hover:bg-rose-50 hover:text-rose-700 transition-all transform scale-90 group-hover:scale-100"
                                        title="Hapus media">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
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
                    </div>
                </div>

            </div>

            {{-- ================== KOLOM KANAN: META & AKSI ================== --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-24">

                {{-- Kartu: Publish --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Status Publikasi</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="status"
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih
                                Status</label>
                            <select name="status" id="status"
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                @foreach (['draft' => 'Draft (Simpan Konsep)', 'published' => 'Published (Tayangkan)'] as $k => $v)
                                    <option value="{{ $k }}" @selected(old('status', $item->status ?? 'draft') === $k)>{{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                            <button type="submit" :disabled="isSubmitting"
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-70 disabled:cursor-wait shadow-sm transition-all">
                                <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
                            </button>
                            <a href="{{ route('admin.news.index') }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kartu: Cover Image --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden"
                    x-data="{ imagePreview: '{{ $item->cover_path ? asset('media/' . $item->cover_path) : '' }}' }">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h2 class="text-sm font-semibold text-slate-800">Gambar Sampul</h2>
                    </div>
                    <div class="p-6">
                        <div @click="$refs.coverInput.click()"
                            class="group relative w-full h-48 rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 hover:border-indigo-400 transition-all cursor-pointer flex flex-col items-center justify-center overflow-hidden">

                            {{-- Placeholder --}}
                            <div x-show="!imagePreview" class="text-center p-4">
                                <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <p class="mt-2 text-xs font-medium text-slate-600">Upload Cover</p>
                            </div>

                            {{-- Preview Image --}}
                            <img x-show="imagePreview" :src="imagePreview"
                                class="absolute inset-0 w-full h-full object-cover">

                            {{-- Hover Overlay --}}
                            <div x-show="imagePreview"
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                <p
                                    class="text-white opacity-0 group-hover:opacity-100 text-xs font-semibold bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                    Ganti Gambar</p>
                            </div>
                        </div>

                        <input type="file" name="cover" accept="image/*" class="hidden" x-ref="coverInput"
                            @change="const f=$event.target.files[0]; if(f){ const r=new FileReader(); r.onload=(e)=>{ imagePreview=e.target.result }; r.readAsDataURL(f) }">

                        <p class="mt-2 text-xs text-center text-slate-500">
                            Disarankan rasio 16:9, Max 2MB.
                        </p>
                        @error('cover')
                            <p class="mt-2 text-xs text-center text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

        </div>

        {{-- Fallback input untuk create (non-AJAX) --}}
        <input id="mediaFallbackInput" type="file" name="media_files[]" class="hidden" multiple
            accept="image/*,video/*">

        {{-- Container preview sementara untuk create (hidden, logic only) --}}
        <div id="createPreviewContainer" class="hidden"></div>
    </form>


    {{-- Trix Custom Style --}}
    <style>
        .trix-toolbar {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 0.75rem;
        }

        .trix-content {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .trix-button {
            background-color: white !important;
            border: 1px solid #cbd5e1 !important;
        }

        .trix-button.trix-active {
            background-color: #e0e7ff !important;
            border-color: #6366f1 !important;
            color: #4338ca !important;
        }
    </style>
    <div id="tempFilesContainer"></div>

    {{-- SCRIPT MEDIA HANDLING (Sama, dengan sedikit penyesuaian UI) --}}
    <script>
        // ================= KONFIGURASI =================
        const MAX_MEDIA = 10;
        const MAX_SIZE_MB = 30;
        const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'video/mp4', 'video/quicktime',
            'video/webm'
        ];

        // ================= ELEMENT UI =================
        const mediaInput = document.getElementById('mediaInput');
        const mediaGrid = document.getElementById('mediaGrid');
        const uploadBar = document.getElementById('uploadBar');
        const uploadBarFill = document.getElementById('uploadBarFill');
        const uploadBarText = document.getElementById('uploadBarText');
        const uploadPercent = document.getElementById('uploadPercent');
        const mediaCountDisplay = document.getElementById('mediaCountDisplay');
        const tempFilesContainer = document.getElementById('tempFilesContainer');
        const deleteHiddenBox = document.getElementById('deleteMediaContainer');
        const dropzoneArea = document.getElementById('dropzoneArea');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Flag Global untuk mencegah intervensi user saat upload
        let isUploading = false;

        // ================= FUNGSI BANTUAN =================

        function updateMediaCount() {
            const count = mediaGrid.querySelectorAll('[data-media-id], [data-temp-path]').length;
            if (mediaCountDisplay) mediaCountDisplay.textContent = count;
        }
        updateMediaCount(); // Init

        function buildCard({
            id = null,
            url = '',
            type = 'image',
            mime = '',
            tempPath = null
        }) {
            const wrap = document.createElement('div');
            wrap.className =
                'group relative aspect-square rounded-lg border border-slate-200 bg-slate-50 overflow-hidden animate-fade-in';

            if (tempPath) wrap.dataset.tempPath = tempPath;
            if (id) wrap.dataset.mediaId = id;

            let inner = '';
            if (type === 'image') {
                inner +=
                    `<img src="${url}" class="h-full w-full object-cover transition-transform group-hover:scale-105" alt="media">`;
            } else if (type === 'video') {
                inner += `<video class="h-full w-full object-cover"><source src="${url}" type="${mime || 'video/mp4'}"></video>
                      <div class="absolute inset-0 flex items-center justify-center bg-black/20 pointer-events-none">
                          <svg class="w-8 h-8 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                      </div>`;
            }

            inner += `
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
            <button type="button" 
                onclick="removeTempOrPermanent(this, ${id})"
                class="absolute top-2 right-2 p-1.5 rounded-full bg-white/90 text-rose-600 shadow-sm opacity-0 group-hover:opacity-100 hover:bg-rose-50 hover:text-rose-700 transition-all transform scale-90 group-hover:scale-100" title="Hapus">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
            </button>`;

            wrap.innerHTML = inner;
            return wrap;
        }

        window.removeMediaItem = function(id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_media_ids[]';
            input.value = String(id);
            deleteHiddenBox.appendChild(input);
        };

        window.removeTempOrPermanent = function(btn, id) {
            if (isUploading) return; // Cegah hapus saat upload berjalan

            const card = btn.closest('div.group');
            if (id) {
                removeMediaItem(id);
            } else if (card.dataset.tempPath) {
                const input = document.querySelector(`input[value*="${card.dataset.tempPath}"]`);
                if (input) input.remove();
            }
            card.remove();
            updateMediaCount();
        };

        // ================= FUNGSI UTAMA HANDLER =================

        window.handleUpload = async function() {
            // 1. CEK STATUS LOCK
            if (isUploading) return;

            const files = Array.from(mediaInput.files || []);
            if (!files.length) return;

            // Reset Input agar change event bisa trigger lagi untuk file sama nanti
            // Tapi kita simpan dulu referensi files nya

            const IS_EDIT = {{ $isEdit ? 'true' : 'false' }};

            // 2. FILTER & VALIDASI
            const validFiles = [];
            for (const f of files) {
                if (!ALLOWED_MIME.includes(f.type)) {
                    alert(`File ${f.name} ditolak. Format salah.`);
                    continue;
                }
                if (f.size > (MAX_SIZE_MB * 1024 * 1024)) {
                    alert(`File ${f.name} terlalu besar (> ${MAX_SIZE_MB}MB).`);
                    continue;
                }
                validFiles.push(f);
            }

            if (!validFiles.length) {
                mediaInput.value = '';
                return;
            }

            const currentCount = mediaGrid.querySelectorAll('[data-media-id], [data-temp-path]').length;
            if (currentCount + validFiles.length > MAX_MEDIA) {
                alert(`Maksimal 10 media. Anda hanya bisa menambah ${Math.max(0, MAX_MEDIA - currentCount)} lagi.`);
                mediaInput.value = '';
                return;
            }

            // 3. LOCK INTERFACE
            isUploading = true;
            mediaInput.disabled = true; // Matikan input file
            dropzoneArea.classList.add('cursor-not-allowed', 'opacity-70'); // Visual disable
            loadingOverlay.classList.remove('hidden'); // Tampilkan overlay loading di dropzone
            loadingOverlay.classList.add('flex');

            // Reset Progress Bar Visual
            uploadBar.classList.remove('hidden');
            uploadBarFill.style.width = '0%';
            uploadPercent.textContent = '0%';
            uploadBarText.textContent = `Mengunggah 0/${validFiles.length} item...`;

            let completed = 0;
            const total = validFiles.length;
            const uploadUrl = IS_EDIT ?
                "{{ $isEdit ? route('admin.news.media.store', $item) : '' }}" :
                "{{ route('admin.news.media.temp') }}";

            // 4. PROSES UPLOAD SEQUENTIAL (Satu per satu agar stabil)
            try {
                for (const [index, file] of validFiles.entries()) {
                    const formData = new FormData();
                    // Sesuaikan nama field dengan Controller
                    const fieldName = IS_EDIT ? 'media_files[]' : 'file';
                    formData.append(fieldName, file);

                    try {
                        const res = await fetch(uploadUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const json = await res.json();
                        if (!json.ok) throw new Error(json.error || 'Gagal upload');

                        // Render Hasil
                        if (IS_EDIT) {
                            (json.items || []).forEach(it => {
                                mediaGrid.appendChild(buildCard({
                                    id: it.id,
                                    url: it.url,
                                    type: it.type,
                                    mime: it.mime
                                }));
                            });
                        } else {
                            const d = json.data;
                            mediaGrid.appendChild(buildCard({
                                id: null,
                                url: d.url,
                                type: d.type,
                                mime: d.mime,
                                tempPath: d.path
                            }));

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'temp_files[]';
                            input.value = JSON.stringify({
                                path: d.path,
                                type: d.type,
                                mime: d.mime
                            });
                            tempFilesContainer.appendChild(input);
                        }

                    } catch (err) {
                        console.error(err);
                        alert(`Gagal upload ${file.name}: ${err.message}`);
                    }

                    // Update Progress per file
                    completed++;
                    const percent = Math.round((completed / total) * 100);

                    // Animasi Smooth
                    uploadBarFill.style.width = `${percent}%`;
                    uploadPercent.textContent = `${percent}%`;
                    uploadBarText.textContent = `Mengunggah ${completed}/${total} item...`;
                }
            } finally {
                // 5. UNLOCK INTERFACE (Apapun yang terjadi, kembalikan state)

                // Pastikan bar penuh visual 100% sebelum hilang
                uploadBarFill.style.width = '100%';
                uploadPercent.textContent = '100%';
                uploadBarText.textContent = 'Selesai!';

                updateMediaCount();

                // Delay sebentar agar user melihat "100%" & "Selesai"
                setTimeout(() => {
                    isUploading = false;
                    mediaInput.value = ''; // Clear input fisik
                    mediaInput.disabled = false; // Enable input

                    dropzoneArea.classList.remove('cursor-not-allowed', 'opacity-70');
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.classList.remove('flex');

                    // Sembunyikan bar perlahan
                    uploadBar.classList.add('hidden');
                }, 800); // Delay 0.8 detik
            }
        };
    </script>
@endsection
