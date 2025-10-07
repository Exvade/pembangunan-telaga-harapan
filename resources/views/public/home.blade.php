@extends('public.layouts.app')

@section('title', 'Beranda — Telaga Harapan')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="relative h-[60vh] min-h-[400px] flex items-center justify-center text-white text-center">
        <img src="https://images.unsplash.com/photo-1581362512130-a151b988f002?q=80&w=2070&auto=format&fit=crop"
             alt="Pembangunan Telaga Harapan"
             class="absolute inset-0 w-full h-full object-cover">
        
        <div class="absolute inset-0 bg-slate-800/70"></div>

        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-4">
                Membangun Harapan, Mewujudkan Masa Depan
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-slate-200">
                Sebuah inisiatif untuk membangun pusat komunitas dan peribadatan yang bermanfaat bagi seluruh masyarakat Telaga Harapan.
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <img src="https://images.unsplash.com/photo-1563911302283-d2b118e56363?q=80&w=1974&auto=format&fit=crop" 
                     alt="Lokasi Telaga Harapan"
                     class="rounded-2xl shadow-xl w-full h-full object-cover">
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
                        Menjadi pusat peradaban Islam yang modern, mandiri, dan menjadi sumber inspirasi serta manfaat bagi masyarakat luas.
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

    {{-- 4. STRUKTUR ORGANISASI --}}
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-slate-800">
                    Struktur Organisasi
                </h2>
                <p class="mt-2 text-slate-600 max-w-xl mx-auto">
                    Tim yang berdedikasi untuk mewujudkan cita-cita bersama di Telaga Harapan.
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                
                {{-- DEWAN PENASEHAT --}}
                <div class="mb-12">
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-6">Dewan Penasehat</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-8 text-center">
                        <div>
                            <p class="font-semibold text-slate-800">Kepala Dusun V</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Ketua RW 011</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Ketua RW 012</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Ketua RW 018</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">Ketua RW 019</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-12">
                    {{-- PIMPINAN INTI --}}
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-8">Pimpinan Inti</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-md mx-auto">
                        <div class="text-center">
                            <img src="https://ui-avatars.com/api/?name=Eko+Pitoyo&background=random" alt="Eko Pitoyo" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover shadow-md">
                            <h4 class="font-semibold text-slate-800">Eko Pitoyo</h4>
                            <p class="text-sm text-slate-500">Ketua Team</p>
                        </div>
                        <div class="text-center">
                            <img src="https://ui-avatars.com/api/?name=Sujito&background=random" alt="Sujito" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover shadow-md">
                            <h4 class="font-semibold text-slate-800">Sujito</h4>
                            <p class="text-sm text-slate-500">Wakil Ketua</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-10 max-w-lg mx-auto">
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-slate-800 mb-2 text-center">Bendahara</h4>
                            <ul class="text-sm text-slate-600 space-y-1 text-center">
                                <li>RD. Riana Gustafa H.</li>
                                <li>Sutoyo</li>
                            </ul>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-slate-800 mb-2 text-center">Sekretaris</h4>
                            <ul class="text-sm text-slate-600 space-y-1 text-center">
                                <li>Doni Syhono</li>
                                <li>Bagas Kakatya H.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                {{-- KOORDINATOR BIDANG --}}
                <div class="mt-16">
                    <h3 class="text-xl font-semibold text-slate-700 text-center mb-8">Koordinator Bidang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Bidang Perencanaan --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                            <h4 class="font-semibold text-slate-800 mb-3">Bidang Perencanaan</h4>
                            <ul class="text-sm text-slate-600 space-y-1.5">
                                <li>Ali Wahyudi</li>
                                <li>Rifan</li>
                                <li>Latif</li>
                                <li>Sunardi</li>
                                <li>Nasor</li>
                                <li>Wisnu</li>
                            </ul>
                        </div>
                         {{-- Bidang Perlengkapan & Pelaksanaan --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                            <h4 class="font-semibold text-slate-800 mb-3">Bidang Perlengkapan & Pelaksanaan</h4>
                            <ul class="text-sm text-slate-600 space-y-1.5">
                                <li>Jozhi Ponco</li>
                                <li>Slamet Rahat</li>
                                <li>Santoso</li>
                            </ul>
                        </div>
                         {{-- Bidang Dana Usaha --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                            <h4 class="font-semibold text-slate-800 mb-3">Bidang Dana Usaha</h4>
                            <ul class="text-sm text-slate-600 space-y-1.5">
                                <li>Singgih</li>
                                <li>Fauzi</li>
                                <li>Jazuri</li>
                                <li>Nasrudin</li>
                                <li>Josan</li>
                                <li>Ust. Nur Hamidz Syarif</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection