@extends('public.layouts.app')
@section('title', $item->title . ' — Telaga Harapan')

@section('content')
    @php
        // HAPUS use Illuminate\Support\Facades\Storage; KARENA KITA TIDAK PAKAI LAGI

        // Siapkan data media untuk lightbox
        $mediaItems = ($item->media ?? collect())
            ->filter(fn($m) => in_array($m->type, ['image', 'video']))
            ->map(
                fn($m) => [
                    'id' => $m->id,
                    'type' => $m->type, // image|video
                    // PERBAIKAN 1: Ganti Storage::url() jadi asset('media/...')
                    'url' => $m->file_path ? asset('media/' . $m->file_path) : null,
                    'mime' => $m->mime_type,
                    'embedUrl' => $m->embed_url ?? null,
                ],
            )
            ->values();
    @endphp

    <div class="bg-slate-50" x-data="galleryLightbox({ items: @js($mediaItems) })" @keydown.window.escape="close()"
        @keydown.window.arrow-right.prevent="next()" @keydown.window.arrow-left.prevent="prev()">
        <div class="container mx-auto px-4 py-16 sm:py-20">
            <div class="mb-8">
                <a href="{{ route('public.news.index') }}"
                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke semua berita
                </a>
            </div>

            {{-- Grid Utama 2 Kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- KIRI: KONTEN ARTIKEL UTAMA --}}
                <article class="lg:col-span-2">
                    {{-- Header Artikel --}}
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-800">
                            {{ $item->title }}
                        </h1>
                        <p class="mt-3 text-sm text-slate-500">
                            Dipublikasikan pada {{ $item->published_at?->format('d F Y') }}
                        </p>
                    </div>

                    {{-- PERBAIKAN 2: Gambar Sampul Utama --}}
                    @if ($item->cover_path)
                        <img src="{{ asset('media/' . $item->cover_path) }}"
                            class="rounded-2xl shadow-lg mt-8 mb-8 w-full aspect-video object-cover"
                            alt="Cover: {{ $item->title }}">
                    @endif

                    {{-- Isi Artikel --}}
                    <div class="prose prose-lg prose-slate max-w-none mt-8">
                        {!! $item->body !!}
                    </div>

                    {{-- === Dokumentasi Kegiatan (Grid + Lightbox) === --}}
                    @if ($item->media->count())
                        <div id="dokumentasi" class="mt-12">
                            <h2 class="text-2xl font-bold text-slate-800 mb-4">Dokumentasi Kegiatan</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($item->media as $idx => $m)
                                    @php
                                        $isImage = $m->type === 'image' && $m->file_path;
                                        $isVideoFile = $m->type === 'video' && $m->file_path;
                                        $isVideoEmbed = $m->type === 'video' && $m->embed_url;

                                        // PERBAIKAN 3: Thumbnail Dokumentasi
                                        $thumbUrl = $m->file_path ? asset('media/' . $m->file_path) : null;
                                    @endphp

                                    <button type="button"
                                        class="group bg-white border border-slate-200 rounded-xl overflow-hidden text-left"
                                        @click="open({{ $idx }})">
                                        @if ($isImage && $thumbUrl)
                                            <img loading="lazy" decoding="async" src="{{ $thumbUrl }}"
                                                alt="Foto kegiatan"
                                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                        @elseif ($isVideoFile && $thumbUrl)
                                            <div class="relative">
                                                <video class="w-full h-48 object-cover" preload="metadata" muted>
                                                    <source src="{{ $thumbUrl }}"
                                                        type="{{ $m->mime_type ?? 'video/mp4' }}">
                                                </video>
                                                <span class="absolute inset-0 grid place-items-center">
                                                    <span
                                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-black/60 text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24">
                                                            <g fill="none" fill-rule="evenodd">
                                                                <path
                                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                                <path fill="currentColor"
                                                                    d="M5.669 4.76a1.47 1.47 0 0 1 2.04-1.177c1.062.454 3.442 1.533 6.462 3.276c3.021 1.744 5.146 3.267 6.069 3.958c.788.591.79 1.763.001 2.356c-.914.687-3.013 2.19-6.07 3.956c-3.06 1.766-5.412 2.832-6.464 3.28c-.906.387-1.92-.2-2.038-1.177c-.138-1.142-.396-3.735-.396-7.237c0-3.5.257-6.092.396-7.235" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </div>
                                        @elseif ($isVideoEmbed)
                                            <div class="w-full h-48 bg-black grid place-items-center text-white text-sm">
                                                Video Tertanam
                                            </div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </article>

                {{-- KANAN: SIDEBAR ESTETIS --}}
                <aside class="lg:col-span-1 space-y-8">
                    {{-- Widget 1: Bagikan Artikel --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Bagikan Artikel Ini</h3>
                        <div class="flex items-center gap-2">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' - ' . route('public.news.show', $item->slug)) }}"
                                target="_blank"
                                class="flex-1 text-center py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors font-semibold text-sm">WhatsApp</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('public.news.show', $item->slug) }}"
                                target="_blank"
                                class="p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ route('public.news.show', $item->slug) }}&text={{ urlencode($item->title) }}"
                                target="_blank"
                                class="p-2 rounded-lg bg-slate-800 text-white hover:bg-slate-900 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                            <div x-data="{ copied: false }">
                                <button
                                    @click="navigator.clipboard.writeText('{{ route('public.news.show', $item->slug) }}'); copied=true; setTimeout(()=>copied=false,1500)"
                                    class="p-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition-colors">
                                    <svg x-show="!copied" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                    </svg>
                                    <svg x-show="copied" x-cloak class="w-5 h-5 text-emerald-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Widget 2: Kategori --}}
                    @if ($item->category)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-800 mb-3">Kategori</h3>
                            <a href="#"
                                class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold hover:bg-indigo-200 transition-colors">
                                {{ $item->category->name }}
                            </a>
                        </div>
                    @endif

                    {{-- Widget 3: Berita Lainnya --}}
                    @if ($others->count())
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Baca Juga</h3>
                            <ul class="space-y-4">
                                @foreach ($others as $n)
                                    <li>
                                        <a href="{{ route('public.news.show', $n->slug) }}"
                                            class="group flex items-start gap-4">
                                            @if ($n->cover_path)
                                                {{-- PERBAIKAN 4: Gambar Sidebar --}}
                                                <img src="{{ asset('media/' . $n->cover_path) }}"
                                                    class="w-20 h-16 object-cover rounded-lg flex-shrink-0"
                                                    alt="Cover: {{ $n->title }}">
                                            @else
                                                <div class="w-20 h-16 bg-slate-200 rounded-lg flex-shrink-0"></div>
                                            @endif
                                            <div>
                                                <p class="text-xs text-slate-500">
                                                    {{ $n->published_at?->format('d M Y') }}
                                                </p>
                                                <h4
                                                    class="font-semibold text-sm text-slate-800 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                                    {{ $n->title }}
                                                </h4>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>

            </div>
        </div>

        {{-- ================= LIGHTBOX POPUP (modern) ================= --}}
        <template x-if="openState">
            <div class="fixed inset-0 z-50 bg-black/90 backdrop-blur-sm p-4 flex items-center justify-center"
                x-transition.opacity @click.self="close()">

                <div class="absolute top-4 right-4 z-10 flex items-center gap-4">
                    <span x-text="`${index + 1} / ${items.length}`" class="text-sm font-medium text-white/70"
                        x-cloak></span>
                    <button @click="close()"
                        class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors"
                        aria-label="Tutup">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative w-full max-w-5xl" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 scale-95">

                    <div class="bg-black rounded-lg overflow-hidden shadow-2xl">
                        <div class="relative">
                            {{-- Image: gunakan x-if + :key untuk remount --}}
                            <template x-if="isImage()">
                                <img :key="'img-' + currentId()" :src="currentItem()?.url"
                                    class="w-full max-h-[85vh] object-contain" alt="Dokumentasi">
                            </template>

                            {{-- Video file: x-if + :key + x-ref untuk reset & load --}}
                            <template x-if="isVideoFile()">
                                <video :key="'vid-file-' + currentId()" x-ref="videoEl"
                                    class="w-full max-h-[85vh] object-contain" controls preload="metadata">
                                    <template x-if="currentItem()?.url">
                                        <source :src="currentItem()?.url" :type="currentItem()?.mime || 'video/mp4'">
                                    </template>
                                    Browser Anda tidak mendukung video.
                                </video>
                            </template>

                            {{-- Video embed: x-if + :key untuk remount iframe --}}
                            <template x-if="isVideoEmbed()">
                                <div class="aspect-video w-full bg-black">
                                    <iframe :key="'vid-embed-' + currentId()" :src="embedUrl(currentItem()?.embedUrl)"
                                        class="w-full h-full" frameborder="0"
                                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Prev / Next --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10" x-cloak>
                    <div class="flex items-center gap-3 p-2 rounded-full bg-white/10 backdrop-blur-sm">
                        <button @click.stop="prev()"
                            class="p-3 rounded-full text-white hover:bg-white/20 transition-colors"
                            aria-label="Sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click.stop="next()"
                            class="p-3 rounded-full text-white hover:bg-white/20 transition-colors"
                            aria-label="Berikutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- ====== Alpine Lightbox Helper (fix video reload) ====== --}}
    <script>
        function galleryLightbox({
            items
        }) {
            return {
                items: Array.isArray(items) ? items : [],
                index: 0,
                openState: false,

                open(i = 0) {
                    if (!this.items.length) return;
                    this.index = Math.max(0, Math.min(i, this.items.length - 1));
                    this.openState = true;
                    document.body.classList.add('overflow-hidden');
                    this.$nextTick(() => this.prepareMedia());
                },
                close() {
                    this.pauseVideo();
                    this.openState = false;
                    document.body.classList.remove('overflow-hidden');
                },
                next() {
                    if (!this.items.length) return;
                    this.pauseVideo();
                    this.index = (this.index + 1) % this.items.length;
                    this.$nextTick(() => this.prepareMedia());
                },
                prev() {
                    if (!this.items.length) return;
                    this.pauseVideo();
                    this.index = (this.index - 1 + this.items.length) % this.items.length;
                    this.$nextTick(() => this.prepareMedia());
                },

                currentItem() {
                    return this.items[this.index] || null;
                },
                currentId() {
                    return this.currentItem()?.id ?? this.index;
                },

                isImage() {
                    const it = this.currentItem();
                    return it && it.type === 'image' && it.url;
                },
                isVideoFile() {
                    const it = this.currentItem();
                    return it && it.type === 'video' && it.url && !it.embedUrl;
                },
                isVideoEmbed() {
                    const it = this.currentItem();
                    return it && it.type === 'video' && it.embedUrl;
                },

                pauseVideo() {
                    const v = this.$refs.videoEl;
                    if (v) {
                        try {
                            v.pause();
                        } catch (e) {}
                        try {
                            v.currentTime = 0;
                        } catch (e) {}
                    }
                },
                prepareMedia() {
                    // Untuk video file: force reload source supaya siap diputar
                    const v = this.$refs.videoEl;
                    if (v && this.isVideoFile()) {
                        try {
                            // Pastikan <source> sudah terpasang dari template (x-if) lalu load
                            v.load();
                            // Tidak autoplay; user bisa klik play.
                            // Jika ingin auto-play setelah next (dianggap user gesture), boleh aktifkan:
                            // v.play().catch(()=>{});
                        } catch (e) {}
                    }
                },

                // Normalisasi embed YouTube
                embedUrl(raw) {
                    try {
                        const u = new URL(raw);
                        if (u.hostname.includes('youtube.com')) {
                            const v = u.searchParams.get('v');
                            return v ? `https://www.youtube.com/embed/${v}` : raw;
                        }
                        if (u.hostname.includes('youtu.be')) {
                            return `https://www.youtube.com/embed/${u.pathname.replace('/', '')}`;
                        }
                        return raw;
                    } catch {
                        return raw;
                    }
                },
            }
        }
    </script>
@endsection
