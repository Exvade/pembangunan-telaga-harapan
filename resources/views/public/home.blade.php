@extends('public.layouts.app')

@section('title', 'Beranda — Telaga Harapan')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="relative h-[60vh] min-h-[400px] flex items-center justify-center text-white text-center">
        <img src="https://images.unsplash.com/photo-1581362512130-a151b988f002?q=80&w=2070&auto=format&fit=crop"
            alt="Pembangunan Telaga Harapan" class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-slate-800/70"></div>

        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-4">
                Membangun Harapan, Mewujudkan Masa Depan
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-slate-200">
                Sebuah inisiatif untuk membangun pusat komunitas dan peribadatan yang bermanfaat bagi seluruh masyarakat
                Telaga Harapan.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('public.transparency') }}"
                    class="px-6 py-3 bg-white text-slate-900 rounded-lg text-sm font-semibold shadow-lg hover:bg-slate-200 transition-colors">
                    Lihat Laporan Transparansi
                </a>
                <a href="#tentang-kami"
                    class="px-6 py-3 border border-white/50 text-white rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors">
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>

    {{-- 2. TENTANG KAMI --}}
    <section id="tentang-kami" class="py-16 sm:py-20 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl font-bold tracking-tight text-slate-800 mb-4">
                    Tentang Kami
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>
                        Team Pembangunan Telaga Harapan adalah tim kerja yang dibentuk oleh warga Perumahan Telaga Harapan
                        untuk merencanakan, mengelola, dan mengawasi proyek-proyek pembangunan lingkungan. Kami bekerja
                        berdasarkan asas transparansi, akuntabilitas, dan partisipasi warga.
                    </p>
                    <p>
                        Fokus kami meliputi perbaikan infrastruktur dasar, peningkatan kualitas ruang publik, keamanan
                        lingkungan, serta program keberlanjutan. Setiap keputusan diambil melalui musyawarah, dengan laporan
                        perkembangan yang dipublikasikan berkala agar seluruh warga dapat memantau progres dan penggunaan
                        anggaran.
                    </p>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <img src="https://images.unsplash.com/photo-1563911302283-d2b118e56363?q=80&w=1974&auto=format&fit=crop"
                    alt="Lokasi Telaga Harapan" class="rounded-2xl shadow-xl w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- ===== Visi 2030 (Banner) ===== -->
    <section id="visi" class="relative bg-green-900 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-14 sm:py-20">
            <div class="max-w-3xl mx-auto">
                <!-- Icon kutip -->
                <svg class="w-10 h-10 text-white/80 mb-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M7.17 4C4.3 6.3 3 9 3 12c0 3.31 1.79 6 5 6 2.21 0 4-1.79 4-4 0-2.02-1.5-3.67-3.47-3.95.36-1.23 1.04-2.29 2.04-3.12L7.17 4zm10 0C14.3 6.3 13 9 13 12c0 3.31 1.79 6 5 6 2.21 0 4-1.79 4-4 0-2.02-1.5-3.67-3.47-3.95.36-1.23 1.04-2.29 2.04-3.12L17.17 4z" />
                </svg>

                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight tracking-tight">
                    Mewujudkan lingkungan Perumahan Telaga Harapan yang tertata, aman, berkelanjutan, dan partisipatif—di
                    mana setiap warga merasa bangga tinggal dan tumbuh bersama.
                </h2>

                <p class="mt-6 text-sm sm:text-base font-semibold text-white/80">
                    Visi - 2030
                </p>
            </div>
        </div>
    </section>



    <!-- ====== MISI 2030 (kolase + daftar misi scrollable TANPA dummy bar) ====== -->
    <section id="misi" class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-16 sm:py-20">
            <h3 class="text-center text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mb-10">
                Misi - 2030
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                <!-- Kolase gambar -->
                <div class="relative w-full">
                    <img src="/images/visi-misi/hero-a.jpg" alt="Proyek infrastruktur"
                        class="w-full aspect-[16/9] object-cover rounded-2xl shadow-xl" />
                    <img src="/images/visi-misi/hero-b.jpg" alt="Instalasi EPC"
                        class="absolute right-6 -bottom-10 w-1/2 aspect-[4/3] object-cover rounded-2xl shadow-xl hidden sm:block" />
                    <div class="h-10 sm:h-14"></div>
                </div>

                <!-- Daftar misi (scrollable nyata) -->
                <div>
                    <div role="region" aria-label="Daftar Misi 2030" tabindex="0"
                        class="space-y-5 max-h-[60vh] sm:max-h-[70vh] lg:max-h-[32rem] overflow-y-auto pe-3 scroll-area scroll-slim scroll-focus">
                        <!-- Kartu-kartu misi -->
                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Perencanaan terbuka dengan melibatkan warga pada tiap tahap: identifikasi kebutuhan,
                                prioritas, dan evaluasi.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Eksekusi proyek yang disiplin—tepat mutu, waktu, dan anggaran.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Transparansi anggaran melalui laporan periodik yang mudah diakses dan dipahami.
                            </p>
                        </article>

                        <!-- Tambah misi sesuka hati -->
                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Peningkatan infrastruktur (jalan, drainase, penerangan, ruang terbuka) secara bertahap dan
                                berstandar.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Keamanan & ketertiban lewat koordinasi dengan pengurus RT/RW, satpam, dan warga.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Keberlanjutan lingkungan: program penghijauan, pengelolaan sampah, dan efisiensi sumber
                                daya.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Kolaborasi & gotong royong: mendorong partisipasi, donasi, dan kerja bakti terjadwal.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-slate-800">Struktur Organisasi</h2>
                <p class="mt-2 text-slate-600 max-w-xl mx-auto">Tim yang berdedikasi untuk mewujudkan cita-cita bersama di
                    Telaga Harapan.</p>
            </div>

            <div class="max-w-6xl mx-auto space-y-16">
                {{-- DEWAN PENASEHAT --}}
                <div>
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-6">Dewan Penasehat</h3>
                    <div class="flex flex-wrap justify-center gap-3">
                        <span
                            class="bg-white border border-slate-200 rounded-full px-4 py-1.5 text-sm font-medium text-slate-700">Kepala
                            Dusun V</span>
                        <span
                            class="bg-white border border-slate-200 rounded-full px-4 py-1.5 text-sm font-medium text-slate-700">Ketua
                            RW 011</span>
                        <span
                            class="bg-white border border-slate-200 rounded-full px-4 py-1.5 text-sm font-medium text-slate-700">Ketua
                            RW 012</span>
                        <span
                            class="bg-white border border-slate-200 rounded-full px-4 py-1.5 text-sm font-medium text-slate-700">Ketua
                            RW 018</span>
                        <span
                            class="bg-white border border-slate-200 rounded-full px-4 py-1.5 text-sm font-medium text-slate-700">Ketua
                            RW 019</span>
                    </div>
                </div>

                {{-- PIMPINAN INTI --}}
                <div>
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-8">Pimpinan Inti</h3>
                    {{-- Ketua --}}
                    <div class="max-w-xs mx-auto text-center mb-8">
                        <img src="https://ui-avatars.com/api/?name=Eko+Pitoyo&background=cbd5e1&color=1e293b&size=128"
                            alt="Eko Pitoyo" class="w-28 h-28 rounded-full mx-auto mb-3 object-cover shadow-md">
                        <h4 class="text-lg font-semibold text-slate-800">Eko Pitoyo</h4>
                        <p class="text-sm text-indigo-600 font-semibold">Ketua Team</p>
                    </div>
                    {{-- Wakil, Bendahara, Sekretaris --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-center">
                            <img src="https://ui-avatars.com/api/?name=Sujito&background=cbd5e1&color=1e293b&size=96"
                                alt="Sujito" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover">
                            <h4 class="font-semibold text-slate-800">Sujito</h4>
                            <p class="text-sm text-slate-500">Wakil Ketua</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-center">
                            <h4 class="font-semibold text-slate-800 mb-2">Bendahara</h4>
                            <p class="text-sm text-slate-600">RD. Riana Gustafa H.</p>
                            <p class="text-sm text-slate-600">Sutoyo</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-center">
                            <h4 class="font-semibold text-slate-800 mb-2">Sekretaris</h4>
                            <p class="text-sm text-slate-600">Doni Syhono</p>
                            <p class="text-sm text-slate-600">Bagas Kakatya H.</p>
                        </div>
                    </div>
                </div>

                {{-- KOORDINATOR BIDANG --}}
                <div>
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-8">Koordinator Bidang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $bidang = [
                                'Perencanaan' => ['Ali Wahyudi', 'Rifan', 'Latif', 'Sunardi', 'Nasor', 'Wisnu'],
                                'Perlengkapan & Pelaksanaan' => ['Jozhi Ponco', 'Slamet Rahat', 'Santoso'],
                                'Dana Usaha' => [
                                    'Singgih',
                                    'Fauzi',
                                    'Jazuri',
                                    'Nasrudin',
                                    'Josan',
                                    'Ust. Nur Hamidz Syarif',
                                ],
                            ];
                        @endphp
                        @foreach ($bidang as $namaBidang => $anggota)
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                                <h4 class="font-semibold text-slate-800 mb-4">Bidang {{ $namaBidang }}</h4>
                                <div class="space-y-4">
                                    @foreach ($anggota as $nama)
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=e2e8f0&color=334155&size=64"
                                                alt="{{ $nama }}" class="w-10 h-10 rounded-full object-cover">
                                            <span class="text-sm text-slate-600">{{ $nama }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA DONASI (Green Nature) ====== -->
    <section class="relative overflow-hidden">
        <!-- Nature halos -->
        <div aria-hidden="true" class="pointer-events-none absolute inset-0">
            <div class="absolute -top-24 -left-24 w-[28rem] h-[28rem] rounded-full opacity-30 blur-3xl"
                style="background: radial-gradient(60% 60% at 50% 50%, #cfe4d8 0%, rgba(207,228,216,0) 60%);"></div>
            <div class="absolute -bottom-24 -right-24 w-[30rem] h-[30rem] rounded-full opacity-25 blur-3xl"
                style="background: radial-gradient(60% 60% at 50% 50%, #a7c4b5 0%, rgba(167,196,181,0) 60%);"></div>
        </div>

        <div class="container mx-auto px-4 py-16 sm:py-20 relative">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                    style="background:#e7f1eb; color:#255745">
                    Donasi & Infaq
                </span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-[#1f2e26]">
                    Wujudkan Harapan Bersama Kami
                </h2>
                <p class="mt-3 text-[#4b6255]">
                    Setiap donasi adalah bata untuk masa depan. Salurkan infaq/sedekah terbaik Anda untuk penyelesaian
                    proyek Telaga Harapan.
                </p>
            </div>

            <!-- Kartu Donasi -->
            <div x-data="donasiCard()" class="mt-10 max-w-3xl mx-auto">
                <div class="relative rounded-2xl border border-[#d7e5dc] shadow-sm bg-white/70 backdrop-blur">
                    <!-- Top bar -->
                    <div class="flex items-center justify-between gap-4 px-6 py-4 border-b border-[#e3efe7]">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                                style="background:#e7f1eb; color:#2f6d3c">
                                <!-- bank icon -->
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <g fill="none">
                                        <path
                                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="m12.67 2.217l8.5 4.75A1.5 1.5 0 0 1 22 8.31v1.44c0 .69-.56 1.25-1.25 1.25H20v8h1a1 1 0 1 1 0 2H3a1 1 0 1 1 0-2h1v-8h-.75C2.56 11 2 10.44 2 9.75V8.31c0-.522.27-1.002.706-1.274l8.623-4.819a1.5 1.5 0 0 1 1.342 0ZM18 11H6v8h3v-6h2v6h2v-6h2v6h3zm-6-6.882l-8 4.5V9h16v-.382zM12 6a1 1 0 1 1 0 2a1 1 0 0 1 0-2" />
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-[#607a6b]">Bank Tujuan</p>
                                <p class="text-sm font-semibold text-[#1f2e26]">
                                    Bank Syariah Indonesia (BSI)
                                </p>
                            </div>
                        </div>

                        <!-- Switch metode (opsional) -->
                        <div class="hidden sm:flex items-center gap-2 text-xs">
                            <button type="button" @click="tab='transfer'"
                                :class="tab === 'transfer' ? 'bg-[#e7f1eb] text-[#255745]' : 'bg-transparent text-[#4b6255]'"
                                class="px-3 py-1 rounded-full font-semibold transition">
                                Transfer
                            </button>
                            <button type="button" @click="tab='qr'"
                                :class="tab === 'qr' ? 'bg-[#e7f1eb] text-[#255745]' : 'bg-transparent text-[#4b6255]'"
                                class="px-3 py-1 rounded-full font-semibold transition">
                                QR (Opsional)
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <!-- TRANSFER -->
                        <div x-show="tab==='transfer'" x-transition>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Rekening -->
                                <div class="space-y-2">
                                    <p class="text-xs text-[#607a6b]">No. Rekening</p>
                                    <div class="flex items-center justify-between gap-3">
                                        <p
                                            class="font-semibold text-[#1f2e26] tracking-wider tabular-nums font-mono select-all">
                                            1234 5678 9012
                                        </p>
                                        <button type="button" @click="copy('123456789012')"
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-[#d7e5dc] text-sm font-semibold text-[#255745] hover:bg-[#e7f1eb] transition">

                                            <svg x-show="!copied" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2m0 16H8V7h11z" />
                                            </svg>
                                            <svg x-show="copied" x-cloak class="w-4 h-4 text-[#2f6d3c]"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 0 1 0 1.414l-7.25 7.25a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8.75 11.79l6.543-6.497a1 1 0 0 1 1.414 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <span x-show="!copied">Salin</span>
                                            <span x-show="copied" x-cloak>Tersalin</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Atas Nama -->
                                <div class="space-y-2">
                                    <p class="text-xs text-[#607a6b]">Atas Nama</p>
                                    <p class="font-semibold text-[#1f2e26]">Panitia Pembangunan Telaga Harapan</p>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="mt-6 rounded-xl border border-[#e3efe7] bg-[#f5fbf7] p-4">
                                <p class="text-sm text-[#2f4037]">
                                    Mohon tulis berita transfer: <span class="font-semibold">“Donasi Telaga Harapan”</span>
                                    agar tim kami mudah melakukan rekonsiliasi.
                                </p>
                            </div>
                        </div>

                        <!-- QR (Opsional) -->
                        <div x-show="tab==='qr'" x-transition x-cloak>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                                <div
                                    class="aspect-square w-full rounded-xl border border-[#d7e5dc] bg-white/80 grid place-items-center">
                                    <!-- Ganti dengan QR asli -->
                                    <span class="text-[#607a6b] text-sm">QRIS / QR Bank (tempatkan gambar di sini)</span>
                                </div>
                                <div class="space-y-3">
                                    <p class="text-sm text-[#374b41]">
                                        Scan QR untuk berdonasi via aplikasi perbankan/e-wallet yang mendukung. Nominal akan
                                        terisi otomatis (jika diatur).
                                    </p>
                                    <div class="text-xs text-[#607a6b]">
                                        Catatan: Pastikan nama penerima <span class="font-semibold text-[#2f4037]">Panitia
                                            Pembangunan Telaga Harapan</span>.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer actions -->
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-[#e3efe7]">
                        <div class="text-xs text-[#607a6b]">
                            Konfirmasi donasi Anda agar kami dapat menerbitkan tanda terima resmi.
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="https://wa.me/6285156098261?text=Assalamualaikum,%20saya%20ingin%20konfirmasi%20donasi%20untuk%20proyek%20Telaga%20Harapan."
                                target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm
                      transition focus:outline-none focus:ring-2 focus:ring-offset-2"
                                style="background:#2f6d3c; color:#f0f9f4; box-shadow:0 6px 16px -6px rgba(47,109,60,.35)">
                                <!-- WhatsApp icon -->
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28" />
                                </svg>
                                Konfirmasi via WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Toast copied -->
                    <div x-show="toast" x-transition x-cloak
                        class="pointer-events-none absolute left-1/2 -translate-x-1/2 -bottom-4 translate-y-full
                    bg-[#1f2e26] text-white text-sm px-4 py-2 rounded-full shadow-md">
                        Detail disalin ke clipboard
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function donasiCard() {
            return {
                tab: 'transfer',
                copied: false,
                toast: false,
                copy(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copied = true;
                        this.flashToast();
                        setTimeout(() => this.copied = false, 1600);
                    });
                },
                copyAll() {
                    const detail = [
                        'Bank: Bank Syariah Indonesia (BSI)',
                        'No. Rekening: 123456789012',
                        'Atas Nama: Panitia Pembangunan Telaga Harapan',
                        'Berita: Donasi Telaga Harapan'
                    ].join('\\n');
                    navigator.clipboard.writeText(detail).then(() => this.flashToast());
                },
                flashToast() {
                    this.toast = true;
                    setTimeout(() => this.toast = false, 1800);
                }
            }
        }
    </script>

@endsection
