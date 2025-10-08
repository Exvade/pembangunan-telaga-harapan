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
                    Tentang Telaga Harapan
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat.
                    </p>
                    <p>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <img src="https://images.unsplash.com/photo-1563911302283-d2b118e56363?q=80&w=1974&auto=format&fit=crop"
                    alt="Lokasi Telaga Harapan" class="rounded-2xl shadow-xl w-full h-full object-cover">
            </div>
        </div>
    </section>

    {{-- 3. VISI & MISI --}}
    <section class="py-16 sm:py-20 bg-slate-800 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold tracking-tight mb-10">
                Visi & Misi Kami
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-4xl mx-auto">
                {{-- Visi --}}
                <div class="text-left p-8 bg-slate-700/50 rounded-2xl">
                    <h3 class="text-2xl font-semibold mb-3">Visi</h3>
                    <p class="text-slate-300">
                        Menjadi pusat peradaban Islam yang modern, mandiri, dan menjadi sumber inspirasi serta manfaat bagi
                        masyarakat luas.
                    </p>
                </div>
                {{-- Misi --}}
                <div class="text-left p-8 bg-slate-700/50 rounded-2xl">
                    <h3 class="text-2xl font-semibold mb-3">Misi</h3>
                    <ul class="list-disc list-inside space-y-2 text-slate-300">
                        <li>Membangun sarana ibadah yang nyaman dan representatif.</li>
                        <li>Menyelenggarakan kegiatan pendidikan dan dakwah.</li>
                        <li>Mengembangkan program sosial untuk kesejahteraan umat.</li>
                        <li>Menjalin kemitraan strategis untuk kemajuan bersama.</li>
                    </ul>
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

    {{-- 5. BAGIAN BARU: CALL TO ACTION (DONASI) --}}
    <section class="bg-slate-800">
        <div class="container mx-auto px-4 py-16 sm:py-20 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white">Wujudkan Harapan Bersama Kami</h2>
            <p class="mt-3 text-slate-300 max-w-2xl mx-auto">
                Setiap donasi Anda adalah bata untuk membangun masa depan. Salurkan infaq dan sedekah terbaik Anda untuk
                penyelesaian proyek Telaga Harapan.
            </p>

            {{-- Ganti dengan informasi rekening Anda --}}
            <div class="mt-8 max-w-md mx-auto bg-slate-700/50 p-6 rounded-2xl text-left space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-300">Bank Tujuan</span>
                    <span class="font-semibold text-white">Bank Syariah Indonesia (BSI)</span>
                </div>
                <div x-data="{ copied: false }" class="flex justify-between items-center">
                    <div>
                        <span class="text-sm text-slate-300">No. Rekening</span>
                        <p id="rekening" class="font-semibold text-white tracking-wider">1234 5678 9012</p>
                    </div>
                    <button
                        @click="navigator.clipboard.writeText('123456789012'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="p-2 rounded-lg bg-slate-600 hover:bg-slate-500 transition-colors">
                        <svg x-show="!copied" class="w-5 h-5 text-slate-200" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015.25 1.5h-1.052a2.25 2.25 0 00-2.25 2.25v1.5M7.5 18.75a3.375 3.375 0 003.375-3.375H10.5a1.125 1.125 0 011.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H7.5Z" />
                        </svg>
                        <svg x-show="copied" x-cloak class="w-5 h-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-300">Atas Nama</span>
                    <span class="font-semibold text-white">Panitia Pembangunan Telaga Harapan</span>
                </div>
            </div>

            <div class="mt-8">
                <a href="https://wa.me/NOMOR_WA?text=Assalamualaikum,%20saya%20ingin%20konfirmasi%20donasi%20untuk%20proyek%20Telaga%20Harapan."
                    target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-500 text-slate-900 rounded-lg text-sm font-semibold shadow-lg hover:bg-cyan-400 transition-colors">
                    Konfirmasi Donasi via WhatsApp
                </a>
            </div>
        </div>
    </section>

@endsection
