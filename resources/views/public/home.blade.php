@extends('public.layouts.app')

@section('title', 'Beranda — Telaga Harapan')

@section('content')

    {{-- 1. HERO SECTION --}}
    {{-- Latar belakang diubah menjadi lebih gelap (slate-900) dan aksen biru dibuat lebih cerah (blue-500) --}}
    <section class="relative h-[70vh] min-h-[500px] flex items-center justify-center text-white text-center">
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover" poster="/misi2.jpeg">
            <source src="/overlay.mp4" type="video/mp4">
            Browser Anda tidak mendukung tag video.
        </video>

        {{-- WARNA DIUBAH --}}
        <div class="absolute inset-0 bg-slate-900/70"></div>

        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-4">
                {{-- WARNA DIUBAH --}}
                Membangun <span class="text-blue-500">Harapan,</span> Mewujudkan <span class="text-blue-500">Masa
                    Depan</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-slate-200">
                Sebuah inisiatif untuk membangun komunitas yang nyaman, penuh harmoni dan bermanfaat bagi seluruh masyarakat
                Telaga Harapan.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('public.transparency') }}" {{-- WARNA DIUBAH --}}
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-lg hover:bg-blue-700 transition-colors">
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
        <div class="container mx-auto px-4 gap-12 items-center justify-between flex flex-col md:flex-row"">
            <div class="order-2 lg:order-1 max-w-2xl" data-aos="fade-right" data-aos-duration="800">
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
            <div class="order-1 lg:order-2" data-aos="fade-left" data-aos-duration="800">
                <img src="/about.png" alt="Lokasi Telaga Harapan"
                    class="rounded-2xl shadow-xl w-[459px] aspect-[4/3] object-cover">
            </div>
        </div>
    </section>

    {{-- Latar belakang diubah dari blue-900 menjadi slate-900 --}}
    <section id="visi" class="relative bg-blue-900 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-14 sm:py-20">
            <div class="max-w-3xl mx-auto" data-aos="fade-up" data-aos-duration="800">
                <svg class="w-10 h-10 text-white/80 mb-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M7.17 4C4.3 6.3 3 9 3 12c0 3.31 1.79 6 5 6 2.21 0 4-1.79 4-4 0-2.02-1.5-3.67-3.47-3.95.36-1.23 1.04-2.29 2.04-3.12L7.17 4zm10 0C14.3 6.3 13 9 13 12c0 3.31 1.79 6 5 6 2.21 0 4-1.79 4-4 0-2.02-1.5-3.67-3.47-3.95.36-1.23 1.04-2.29 2.04-3.12L17.17 4z" />
                </svg>

                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight tracking-tight">
                    Menciptakan lingkungan yang asri, nyaman dan harmoni di Telaga Harapan.
                </h2>

                <p class="mt-6 text-sm sm:text-base font-semibold text-white/80">
                    Visi - 2030
                </p>
            </div>
        </div>
    </section>

    <section id="misi" class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-16 sm:py-20">
            <h3 class="text-center text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mb-10"
                data-aos="fade-up" data-aos-duration="500">
                Misi - 2030
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                <div class="relative w-full">
                    <img src="/misi1.jpg" alt="Proyek infrastruktur"
                        class="w-full aspect-[16/9] object-cover rounded-2xl shadow-xl" data-aos="fade-right"
                        data-aos-duration="800" />
                    <img src="/misi2.jpeg" alt="Instalasi EPC"
                        class="absolute right-6 -bottom-10 w-1/2 aspect-[4/3] object-cover rounded-2xl shadow-xl hidden sm:block"
                        data-aos="fade-up" data-aos-duration="800" />
                    <div class="h-10 sm:h-14"></div>
                </div>

                <div>
                    <div role="region" aria-label="Daftar Misi 2030" tabindex="0"
                        class="space-y-5 max-h-[60vh] sm:max-h-[70vh] lg:max-h-[32rem] overflow-y-auto pe-3 scroll-area scroll-slim scroll-focus"
                        data-aos="fade-up" data-aos-duration="800">
                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Merencanakan dan melaksanakan seluruh program kerja dengan suka cita mengharap ridha Allah.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Membangun Kerjasama dan gotong royong bersama warga.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Saling tegur, saling sapa, dan saling mengingatkan untuk selalu menjaga kebersihan dan
                                kelestarian lingkungan.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Menjaga persatuan dan kesatuan dengan membangun dan menjalin silaturahmi warga.
                            </p>
                        </article>

                        <article class="bg-white border border-slate-200/70 rounded-xl shadow-sm p-5 sm:p-6">
                            <p class="text-slate-700 leading-relaxed">
                                Mewariskan lingkungan yang asri sebagai warisan yang akan ditinggali oleh anak cucu kita.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STRUKTUR ORGANISASI --}}
    <section class="py-16 bg-slate-50 overflow-hidden">
        <div class="container mx-auto px-4 relative">

            {{-- Background Decoration (Optional for modern feel) --}}
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-blue-100/50 rounded-full blur-3xl -z-10 opacity-60 pointer-events-none">
            </div>

            {{-- Header Section --}}
            <div class="text-center mb-12 relative z-10">
                <span
                    class="text-blue-600 font-bold tracking-wider text-xs uppercase bg-blue-50 px-3 py-1 rounded-full border border-blue-100">Tim
                    Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mt-3 mb-2">Struktur Organisasi</h2>
                <p class="text-slate-600 max-w-lg mx-auto">Dedikasi dan kolaborasi untuk kemajuan Telaga Harapan.</p>
            </div>

            <div class="max-w-7xl mx-auto space-y-12 relative z-10">

                {{-- 1. DEWAN PENASEHAT (Modern Compact Grid) --}}
                <div>
                    <h3
                        class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center justify-center gap-4">
                        <span class="h-px w-8 bg-slate-300"></span> Dewan Penasehat <span
                            class="h-px w-8 bg-slate-300"></span>
                    </h3>

                    @php
                        $penasehat = [
                            [
                                'jabatan' => 'Kadus V',
                                'nama' => 'Jaenudin Gofur',
                                'foto' => '/jaenudin-gofur.jpg', // <-- Isi path foto di sini (simpan di folder public)
                            ],
                            [
                                'jabatan' => 'RW 011',
                                'nama' => 'Asep Ruhyana',
                                'foto' => '/asep-ruhyana.jpg',
                            ],
                            [
                                'jabatan' => 'RW 012',
                                'nama' => 'Ketua RW 012',
                                'foto' => '', // <-- Kosongkan jika belum ada foto (nanti otomatis jadi inisial)
                            ],
                            [
                                'jabatan' => 'RW 018',
                                'nama' => 'Ketua RW 018',
                                'foto' => '',
                            ],
                            [
                                'jabatan' => 'RW 019',
                                'nama' => 'Ketua RW 019',
                                'foto' => '',
                            ],
                        ];
                    @endphp

                    <div class="flex flex-wrap justify-center gap-3">
                        @foreach ($penasehat as $p)
                            <div
                                class="group bg-white border border-slate-200 hover:border-blue-300 rounded-full pl-2 pr-5 py-2 flex items-center gap-3 shadow-sm hover:shadow-md transition-all duration-300 cursor-default">

                                {{-- LOGIKA FOTO DI SINI --}}
                                <img src="{{ !empty($p['foto']) ? asset($p['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($p['nama']) . '&background=f1f5f9&color=475569&size=64&font-size=0.4' }}"
                                    alt="{{ $p['nama'] }}"
                                    class="w-10 h-10 rounded-full object-cover ring-2 ring-white group-hover:ring-blue-100 transition-all">

                                <div class="flex flex-col text-left">
                                    <span
                                        class="text-xs font-bold text-slate-700 group-hover:text-blue-700 transition-colors">
                                        {{ $p['nama'] }}
                                    </span>
                                    <span class="text-[10px] uppercase font-semibold text-slate-400">
                                        {{ $p['jabatan'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. PENGURUS INTI (Hierarchical Layout) --}}
                <div class="space-y-6">

                    {{-- Level 1: Ketua & Wakil (Hero Cards) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                        {{-- Ketua --}}
                        <div
                            class="relative group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                                </svg>
                            </div>
                            <img src="/eko-pitoyo.jpg"
                                class="w-20 h-20 rounded-full shadow-md ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all z-10">
                            <div class="z-10">
                                <div class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">Ketua Team</div>
                                <h4 class="text-xl font-bold text-slate-800">Eko Pitoyo</h4>
                                <p class="text-sm text-slate-500 mt-1">Memimpin visi dan misi.</p>
                            </div>
                        </div>

                        {{-- Wakil --}}
                        <div
                            class="relative group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-20 h-20 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                </svg>
                            </div>
                            <img src="/sujito.jpg"
                                class="w-20 h-20 rounded-full shadow-md ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all z-10">
                            <div class="z-10">
                                <div class="text-xs font-bold text-blue-500 uppercase tracking-wide mb-1">Wakil Ketua</div>
                                <h4 class="text-xl font-bold text-slate-800">Sujito</h4>
                                <p class="text-sm text-slate-500 mt-1">Mendukung operasional utama.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Level 2: Sekretaris & Bendahara (Unified Grid) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto">
                        {{-- Sekretaris --}}
                        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm relative">
                            <div class="absolute -top-3 left-4">
                                <span
                                    class="bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Sekretaris</span>
                            </div>
                            {{-- DEFINISI DATA --}}
                            @php
                                $listSekretaris = [
                                    [
                                        'nama' => 'Doni Sihono',
                                        'foto' => '/doni.jpg', // <-- Ganti dengan path foto asli
                                    ],
                                    [
                                        'nama' => 'Bagas K.H.',
                                        'foto' => '', // <-- Kosongkan jika tidak ada foto
                                    ],
                                ];
                            @endphp

                            {{-- TAMPILAN --}}
                            <div class="flex flex-col sm:flex-row gap-4 mt-2">
                                @foreach ($listSekretaris as $s)
                                    <div
                                        class="flex items-center gap-3 flex-1 p-2 rounded-lg hover:bg-slate-50 transition-colors">

                                        {{-- LOGIKA GAMBAR --}}
                                        <img src="{{ !empty($s['foto']) ? asset($s['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']) . '&background=f1f5f9&color=475569&size=48' }}"
                                            class="w-10 h-10 rounded-full object-cover">

                                        <span class="text-sm font-semibold text-slate-700">{{ $s['nama'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bendahara --}}
                        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm relative">
                            <div class="absolute -top-3 left-4">
                                <span
                                    class="bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Bendahara</span>
                            </div>
                            @php
                                $listBendahara = [
                                    [
                                        'nama' => 'Rian Gustafa',
                                        'foto' => 'rian.jpg', // <-- Isi path foto jika ada
                                    ],
                                    [
                                        'nama' => 'Sutoyo',
                                        'foto' => '/sutoyo.jpg', // <-- Kosongkan jika belum ada foto
                                    ],
                                ];
                            @endphp
                            <div class="flex flex-col sm:flex-row gap-4 mt-2">
                                @foreach ($listBendahara as $b)
                                    <div
                                        class="flex items-center gap-3 flex-1 p-2 rounded-lg hover:bg-slate-50 transition-colors">

                                        {{-- LOGIKA FOTO --}}
                                        <img src="{{ !empty($b['foto']) ? asset($b['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($b['nama']) . '&background=f1f5f9&color=475569&size=48' }}"
                                            class="w-10 h-10 rounded-full object-cover">

                                        <span class="text-sm font-semibold text-slate-700">{{ $b['nama'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. KOORDINATOR BIDANG (Cards Grid) --}}
                <div>
                    <h3
                        class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center justify-center gap-4 mt-8">
                        <span class="h-px w-8 bg-slate-300"></span> Bidang & Anggota <span
                            class="h-px w-8 bg-slate-300"></span>
                    </h3>

                    @php
                        $bidang = [
                            'Perencanaan' => [
                                ['nama' => 'Ali Wahyudi', 'foto' => 'ali.jpg'], // Contoh ada foto
                                ['nama' => 'Irpan Ariawan', 'foto' => ''], // Contoh tidak ada foto
                                ['nama' => 'Latif', 'foto' => ''],
                                ['nama' => 'Sunardi', 'foto' => '/sunardi.jpg'],
                                ['nama' => 'Ahmad Munasor.', 'foto' => '/nasor.jpg'],
                                ['nama' => 'Wisnu', 'foto' => ''],
                            ],
                            'Perlengkapan' => [
                                ['nama' => 'Jozi Ponco', 'foto' => 'jozi.jpg'],
                                ['nama' => 'Slamet Rahat', 'foto' => '/rahat.jpg'],
                                ['nama' => 'Santoso', 'foto' => ''],
                            ],
                            'Dana Usaha' => [
                                ['nama' => 'Singgih Waseso', 'foto' => '/singgih.jpg'],
                                ['nama' => 'Fauzi', 'foto' => '/fauzi.jpg'],
                                ['nama' => 'Jazuri', 'foto' => '/jazuri.jpg'],
                                ['nama' => 'Nasrudin', 'foto' => ''],
                                ['nama' => 'Josan', 'foto' => ''],
                                ['nama' => 'Ust. Nurhamid Syarif.', 'foto' => ''],
                            ],
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($bidang as $namaBidang => $listAnggota)
                            {{-- Ubah variabel jadi $listAnggota --}}
                            <div
                                class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg transition-all duration-300 flex flex-col h-full">

                                {{-- HEADER KARTU --}}
                                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">{{ $namaBidang }}</h4>
                                        <span class="text-xs text-slate-500">{{ count($listAnggota) }} Anggota</span>
                                    </div>
                                </div>

                                {{-- LIST ANGGOTA --}}
                                <ul class="space-y-3">
                                    @foreach ($listAnggota as $anggota)
                                        {{-- Loop array baru --}}
                                        <li class="flex items-center gap-3">

                                            {{-- LOGIKA FOTO --}}
                                            <img src="{{ !empty($anggota['foto']) ? asset($anggota['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($anggota['nama']) . '&background=f1f5f9&color=64748b&size=32' }}"
                                                class="w-6 h-6 rounded-full object-cover">

                                            <span class="text-sm text-slate-600 font-medium">{{ $anggota['nama'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>



    <section class="relative overflow-hidden bg-slate-50">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0">
            {{-- WARNA DIUBAH --}}
            <div class="absolute -top-24 -left-24 w-[28rem] h-[28rem] rounded-full opacity-30 blur-3xl"
                style="background: radial-gradient(60% 60% at 50% 50%, #93c5fd 0%, rgba(147,197,253,0) 60%);"></div>
            <div class="absolute -bottom-24 -right-24 w-[30rem] h-[30rem] rounded-full opacity-20 blur-3xl"
                style="background: radial-gradient(60% 60% at 50% 50%, #60a5fa 0%, rgba(96,165,250,0) 60%);"></div>
        </div>

        <div class="container mx-auto px-4 py-16 sm:py-20 relative">
            <div class="text-center max-w-3xl mx-auto">
                {{-- WARNA DIUBAH --}}
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                    Donasi & Infaq
                </span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-800">
                    Wujudkan Harapan Bersama Kami
                </h2>
                <p class="mt-3 text-slate-600">
                    Setiap donasi adalah bata pondasi untuk masa depan. Salurkan infaq/sedekah terbaik Anda untuk
                    penyelesaian
                    proyek Telaga Harapan.
                </p>
            </div>

            <div x-data="donasiCard()" class="mt-10 max-w-3xl mx-auto">
                {{-- WARNA DIUBAH --}}
                <div class="relative rounded-2xl border border-slate-200 shadow-sm bg-white/70 backdrop-blur">
                    <div class="flex items-center justify-between gap-4 px-6 py-4 border-b border-slate-200">
                        <div class="flex items-center gap-3">
                            {{-- WARNA DIUBAH --}}
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-blue-100 text-blue-700">
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
                                {{-- WARNA DIUBAH --}}
                                <p class="text-xs text-slate-500">Bank Tujuan</p>
                                <p class="text-sm font-semibold text-slate-800">
                                    Bank Mandiri
                                </p>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-center gap-2 text-xs">
                            <button type="button" @click="tab='transfer'" {{-- WARNA DIUBAH --}}
                                :class="tab === 'transfer' ? 'bg-blue-100 text-blue-800' : 'bg-transparent text-slate-600'"
                                class="px-3 py-1 rounded-full font-semibold transition">
                                Transfer
                            </button>
                            {{-- <div>
                            <button type="button" @click="tab='qr'" WARNA DIUBAH
                                :class="tab === 'qr' ? 'bg-blue-100 text-blue-800' : 'bg-transparent text-slate-600'"
                                class="px-3 py-1 rounded-full font-semibold transition">
                                QR (Opsional)
                            </button>    
                            </div> --}}

                        </div>
                    </div>

                    <div class="p-6">
                        <div x-show="tab==='transfer'" x-transition>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <p class="text-xs text-blue-600">No. Rekening</p>
                                    <div class="flex items-center justify-between gap-3">
                                        {{-- WARNA DIUBAH --}}
                                        <p
                                            class="font-semibold text-slate-800 tracking-wider tabular-nums font-mono select-all">
                                            1560 0168 86261
                                        </p>
                                        {{-- WARNA DIUBAH --}}
                                        <button type="button" @click="copy('1560016886261')"
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition">

                                            <svg x-show="!copied" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2m0 16H8V7h11z" />
                                            </svg>
                                            <svg x-show="copied" x-cloak class="w-4 h-4 text-blue-700"
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

                                <div class="space-y-2">
                                    {{-- WARNA DIUBAH --}}
                                    <p class="text-xs text-slate-500">Atas Nama</p>
                                    <p class="font-semibold text-slate-800">RD RIANA GUSTAFA HAR
                                    </p>
                                </div>
                            </div>

                            {{-- WARNA DIUBAH --}}
                            <div class="mt-6 rounded-xl border border-blue-200 bg-blue-50/80 p-4">
                                <p class="text-sm text-slate-700">
                                    Mohon tulis berita transfer: <span class="font-semibold">“Donasi Telaga Harapan”</span>
                                    agar tim kami mudah melakukan rekonsiliasi.
                                </p>
                            </div>
                        </div>

                        {{-- <div x-show="tab==='qr'" x-transition x-cloak>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                                <div
                                    class="aspect-square w-full rounded-xl border border-slate-200 bg-white/80 grid place-items-center">
                                    <span class="text-slate-600 text-sm">QRIS / QR Bank (tempatkan gambar di sini)</span>
                                </div>
                                <div class="space-y-3">
                                    <p class="text-sm text-slate-600">
                                        Scan QR untuk berdonasi via aplikasi perbankan/e-wallet yang mendukung.
                                    </p>
                                    <div class="text-xs text-slate-700">
                                        Catatan: Pastikan nama penerima <span class="font-semibold text-slate-800">Panitia
                                            Pembangunan Telaga Harapan</span>.
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-slate-200">
                        <div class="text-xs text-slate-500">
                            Konfirmasi donasi Anda agar kami dapat menerbitkan tanda terima resmi.
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="https://wa.me/628111975831?text=Assalamualaikum,%20saya%20ingin%20konfirmasi%20donasi%20untuk%20proyek%20Telaga%20Harapan."
                                target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2"
                                {{-- WARNA DIUBAH --}}
                                style="background:#2563eb; color:white; box-shadow:0 6px 16px -6px rgba(37, 99, 235, 0.4)">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28" />
                                </svg>
                                Konfirmasi via WhatsApp
                            </a>
                        </div>
                    </div>

                    <div x-show="toast" x-transition x-cloak {{-- WARNA DIUBAH --}}
                        class="pointer-events-none absolute left-1/2 -translate-x-1/2 -bottom-4 translate-y-full bg-slate-800 text-white text-sm px-4 py-2 rounded-full shadow-md">
                        Detail disalin ke clipboard
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- SECTION SARAN WARGA --}}
    <section id="saran" x-data="{
        imgModal: false,
        imgSrc: '',
        openModal(src) {
            this.imgSrc = src;
            this.imgModal = true;
            document.body.classList.add('overflow-hidden'); // Matikan scroll body
        },
        closeModal() {
            this.imgModal = false;
            setTimeout(() => this.imgSrc = '', 300); // Reset src setelah animasi
            document.body.classList.remove('overflow-hidden'); // Hidupkan scroll body
        }
    }" class="relative overflow-hidden bg-white py-16 sm:py-24">

        {{-- Background Decoration --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                class="absolute top-0 right-0 w-[40rem] h-[40rem] rounded-full bg-blue-50/50 blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[30rem] h-[30rem] rounded-full bg-slate-50/80 blur-3xl translate-y-1/3 -translate-x-1/4">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-start">

                {{-- KOLOM KIRI (FORM INPUT) --}}
                <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24">
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 p-6 sm:p-8">
                        <div class="mb-6">
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 mb-3 border border-blue-100">
                                Aspirasi Warga
                            </span>
                            <h2 class="text-2xl font-extrabold tracking-tight text-slate-800">
                                Suara Anda,<br>Semangat Kami.
                            </h2>
                            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                Kritik, saran, atau laporan Anda sangat berarti untuk pembangunan Telaga Harapan yang lebih
                                baik.
                            </p>
                        </div>

                        @if (session('success'))
                            <div id="success-alert"
                                class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 px-4 py-3 text-sm font-semibold border border-emerald-100 flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        <div id="form-alert"
                            class="hidden mb-4 rounded-xl px-4 py-3 text-sm font-semibold border flex items-center gap-2">
                        </div>

                        <form id="suggestionForm" action="{{ route('suggestion.store') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            {{-- Nama --}}
                            <div class="relative group">
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Nama
                                    (Opsional)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name"
                                        class="block w-full pl-10 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400"
                                        placeholder="Hamba Allah">
                                </div>
                            </div>

                            {{-- Pesan --}}
                            <div class="relative group">
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Pesan
                                    <span class="text-red-500">*</span></label>
                                <textarea name="message" required rows="4"
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400 resize-none"
                                    placeholder="Tuliskan saran atau masukan Anda di sini..."></textarea>
                            </div>

                            {{-- Upload Foto --}}
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Lampiran
                                    Foto (Opsional)</label>
                                <label
                                    class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-200 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-6 h-6 mb-1 text-slate-400 group-hover:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-xs text-slate-500 group-hover:text-blue-600"><span
                                                class="font-semibold">Klik untuk upload</span></p>
                                    </div>
                                    <input type="file" name="photos[]" multiple class="hidden"
                                        onchange="previewFiles(this)">
                                </label>
                                <div id="file-preview" class="mt-2 text-xs text-slate-500 truncate"></div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-white transition-all transform active:scale-[0.98] hover:shadow-lg hover:shadow-blue-500/30 bg-gradient-to-r from-blue-600 to-blue-700">
                                <span>Kirim Masukan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- KOLOM KANAN (DAFTAR SARAN) --}}
                <div class="lg:col-span-7 xl:col-span-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Tindak Lanjut</h3>
                            <p class="text-sm text-slate-500">Aspirasi yang telah didengar dan direalisasikan.</p>
                        </div>
                        <div class="hidden sm:block h-px flex-1 bg-slate-100 ml-6"></div>
                    </div>

                    @if (isset($suggestions) && $suggestions->count())
                        {{-- Masonry Layout --}}
                        <div class="columns-1 md:columns-2 gap-6 space-y-6">
                            @foreach ($suggestions as $item)
                                <div
                                    class="break-inside-avoid bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">

                                    {{-- Header Card --}}
                                    <div class="flex items-start gap-3 mb-3">
                                        {{-- Avatar --}}
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 flex items-center justify-center text-xs font-bold border border-white shadow-sm flex-shrink-0">
                                            {{ substr($item->name ? $item->name : 'A', 0, 1) }}
                                        </div>

                                        {{-- Nama & Waktu --}}
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800 truncate">
                                                {{ $item->name ? $item->name : 'Warga Telaga Harapan' }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        {{-- BADGE STATUS (Hanya Muncul Jika handled) --}}
                                        <div class="ml-auto flex-shrink-0">
                                            @if ($item->status == 'handled')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                                    <svg class="mr-1.5 w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Ditindaklanjuti
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Pesan --}}
                                    <div class="bg-slate-50/50 rounded-xl p-3 border border-slate-100/50">
                                        <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                                            "{{ $item->message }}"</p>
                                    </div>

                                    {{-- Foto Lampiran --}}
                                    {{-- Di dalam @foreach ($suggestions as $item) --}}
                                    @if ($item->photos)
                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            @foreach ($item->photos as $img)
                                                <div {{-- Panggil fungsi openModal --}}
                                                    @click="openModal('{{ asset('uploads/suggestions/' . $img) }}')"
                                                    class="group relative block overflow-hidden rounded-lg aspect-video cursor-zoom-in bg-slate-100">

                                                    <img src="{{ asset('uploads/suggestions/' . $img) }}"
                                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">

                                                    {{-- Overlay Icon --}}
                                                    <div
                                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div
                            class="text-center py-12 px-4 border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/50">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Belum Ada Masukan</h3>
                            <p class="text-sm text-slate-500 max-w-sm mx-auto mt-2">Jadilah yang pertama memberikan saran
                                untuk kemajuan lingkungan kita bersama.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 
        POPUP MODAL (TELEPORTED) 
        x-teleport="body" akan memindahkan div ini ke bagian paling bawah <body>
        saat dirender, sehingga lolos dari overflow-hidden section dan z-index aman.
    --}}
        <template x-teleport="body">
            <div x-show="imgModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/95 backdrop-blur-sm"
                @keydown.escape.window="closeModal()">

                {{-- Tombol Close --}}
                <button @click="closeModal()"
                    class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors z-[10000] p-2 bg-white/10 rounded-full hover:bg-white/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                {{-- Container Gambar --}}
                <div @click.outside="closeModal()" class="relative w-full h-full flex items-center justify-center">
                    <img :src="imgSrc" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                </div>
            </div>
        </template>
    </section>

    {{-- Script Tambahan untuk Preview Nama File saat Upload --}}
    <script>
        function previewFiles(input) {
            const preview = document.getElementById('file-preview');
            if (input.files && input.files.length > 0) {
                preview.textContent = `${input.files.length} file dipilih`;
            } else {
                preview.textContent = '';
            }
        }
    </script>

    {{-- Script Tambahan untuk Preview File --}}
    <script>
        function previewFiles(input) {
            const preview = document.getElementById('file-preview');
            if (input.files && input.files.length > 0) {
                preview.textContent = `${input.files.length} file dipilih`;
            } else {
                preview.textContent = '';
            }
        }
    </script>


    <script>
        function previewFiles(input) {
            const preview = document.getElementById('file-preview');
            if (input.files && input.files.length > 0) {
                preview.textContent = `${input.files.length} file dipilih`;
            } else {
                preview.textContent = '';
            }
        }
        document.getElementById('suggestionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const alertBox = document.getElementById('form-alert');
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.innerText = 'Mengirim...';

            const formData = new FormData(form);

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await res.json();

                if (data.success) {
                    alertBox.className =
                        'mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm font-semibold';
                    alertBox.innerText = data.message;
                    alertBox.classList.remove('hidden');

                    form.reset();
                    setTimeout(() => {
                        alertBox.classList.add('hidden');
                    }, 3000);
                }
            } catch (err) {
                alertBox.className = 'mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm font-semibold';
                alertBox.innerText = 'Terjadi kesalahan. Silakan coba lagi.';
                alertBox.classList.remove('hidden');
            }

            submitBtn.disabled = false;
            submitBtn.innerText = 'Kirim Saran';
        });

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
                flashToast() {
                    this.toast = true;
                    setTimeout(() => this.toast = false, 1800);
                }
            }
        }
    </script>

@endsection
