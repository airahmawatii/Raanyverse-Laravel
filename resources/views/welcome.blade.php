<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RaanyProp - Premium Property Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        .playfair { font-family: 'Playfair Display', serif; }
        .inter  { font-family: 'Inter', sans-serif; }

        html, body { background: #fdfbf7; color: #3e342f; }

        /* Terracotta & Dark Brown Palette */
        .gradient-text { background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-primary   { background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); color: white; transition: all .3s ease; box-shadow: 0 4px 15px rgba(183, 92, 28, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(183, 92, 28, 0.4); }
        .btn-outline   { border: 1.5px solid rgba(183, 92, 28, 0.35); color: #b75c1c; transition: all .3s ease; }
        .btn-outline:hover { background: rgba(183, 92, 28, 0.08); border-color: #b75c1c; color: #a65319; }

        /* Navbar glass */
        .nav-glass { background: rgba(253, 251, 247, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(183, 92, 28, 0.15); box-shadow: 0 4px 30px rgba(62, 52, 47, 0.05); }

        /* Feature cards & property cards */
        .card { background: #ffffff; border: 1px solid rgba(183, 92, 28, 0.1); border-radius: 1.5rem; transition: all .35s ease; overflow: hidden; box-shadow: 0 4px 20px rgba(62, 52, 47, 0.03); }
        .card:hover { transform: translateY(-6px); border-color: rgba(183, 92, 28, 0.3); box-shadow: 0 10px 30px rgba(62, 52, 47, 0.08); }

        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .float { animation: float 5s ease-in-out infinite; }
        @keyframes pulse-slow { 0%,100%{opacity:.7} 50%{opacity:1} }
        .pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
    </style>
</head>
<body class="inter overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 inset-x-0 z-50 px-4 md:px-8 pt-5">
        <div class="max-w-6xl mx-auto flex justify-between items-center nav-glass px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-[#3e342f] shadow-md">
                    <svg class="w-5 h-5 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="playfair text-xl font-bold tracking-tight text-[#3e342f]">RaanyProp</span>
            </div>
            
            <div class="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-widest text-stone-500">
                <a href="#properti" class="hover:text-[#b75c1c] transition-all">List Properti</a>
                <a href="#fitur" class="hover:text-[#b75c1c] transition-all">Fitur Utama</a>
            </div>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl font-bold text-[10px] tracking-widest uppercase">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary px-6 py-2.5 rounded-xl font-bold text-[10px] tracking-widest uppercase">Masuk Aplikasi</a>
                @endauth
            @endif
        </div>
    </nav>

    {{-- HERO --}}
    <section class="relative min-h-screen flex items-center overflow-hidden bg-[#fdfbf7]">
        <div class="relative z-10 max-w-6xl mx-auto px-6 w-full pt-36 pb-24 grid lg:grid-cols-12 gap-12 items-center">
            
            {{-- Left: Text --}}
            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full" style="background: rgba(183, 92, 28, 0.08); border: 1px solid rgba(183, 92, 28, 0.2);">
                    <span class="w-2 h-2 rounded-full pulse-slow bg-[#b75c1c]"></span>
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-[#b75c1c]">Modern Property Management</span>
                </div>

                <h1 class="playfair text-5xl md:text-7xl font-bold tracking-tight text-[#3e342f] leading-[1.1]">
                    Kawasan Properti<br>
                    Terkelola dengan<br>
                    <span class="gradient-text">Sempurna.</span>
                </h1>

                <p class="text-stone-500 text-base md:text-lg font-medium leading-relaxed max-w-lg">
                    Sistem ERP properti premium untuk mengotomatisasi booking unit, sinkronisasi Google Calendar, reservasi fasilitas kawasan, pembukuan arus kas keuangan owner, tagihan IPL/Sewa otomatis, denda harian, dan kepatuhan perlindungan data.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('login') }}" class="btn-primary px-8 py-4 rounded-xl font-bold text-xs tracking-widest uppercase">
                        Buka Dashboard Admin →
                    </a>
                    <a href="#properti" class="btn-outline px-8 py-4 rounded-xl font-bold text-xs tracking-widest uppercase">
                        Lihat Unit Tersedia
                    </a>
                </div>
            </div>

            {{-- Right: Premium UI --}}
            <div class="lg:col-span-6 float hidden md:block">
                <div class="rounded-[2rem] p-6 md:p-8 bg-white shadow-[0_20px_50px_rgba(62,52,47,0.08)] border border-[rgba(183,92,28,0.1)] relative overflow-hidden">
                    {{-- Mock UI Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-stone-300"></span>
                            <span class="w-3 h-3 rounded-full bg-stone-200"></span>
                            <span class="w-3 h-3 rounded-full bg-[#b75c1c]"></span>
                        </div>
                        <div class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Enterprise Panel Live</div>
                    </div>

                    {{-- Mock UI Widgets --}}
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl bg-[#fdfbf7] border border-stone-100 flex justify-between items-center">
                            <div>
                                <span class="text-[9px] font-bold text-stone-500 uppercase tracking-widest block mb-1">Total Pendapatan Bersih</span>
                                <span class="text-2xl font-bold text-[#b75c1c] playfair">+Rp 148.250.000</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase bg-[rgba(183,92,28,0.1)] text-[#b75c1c]">Kas Aman</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-[#fdfbf7] border border-stone-100">
                                <span class="text-[9px] font-bold text-stone-500 uppercase tracking-widest block mb-1">Hunian Aktif</span>
                                <span class="text-xl font-bold text-[#3e342f]">92,4% <span class="text-xs text-stone-400 font-normal">/ Unit</span></span>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#fdfbf7] border border-stone-100">
                                <span class="text-[9px] font-bold text-stone-500 uppercase tracking-widest block mb-1">Keluhan Maintenance</span>
                                <span class="text-xl font-bold text-[#b75c1c]">0 Aktif <span class="text-xs text-stone-400 font-normal">/ Log</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- BROWSE PROPERTIES / CLUSTERS --}}
    <section id="properti" class="py-28 relative bg-white">
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16 space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#b75c1c]">Katalog Properti Tersedia</span>
                <h2 class="playfair text-4xl md:text-5xl font-bold tracking-tight text-[#3e342f]">
                    Jelajahi <span class="gradient-text">Koleksi Hunian & Ruko</span> Terbaik
                </h2>
                <p class="text-stone-500 text-base md:text-lg max-w-2xl mx-auto">Lihat unit-unit yang siap huni atau disewa saat ini di berbagai lokasi cluster mewah kami.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($units->isEmpty())
                    {{-- Premium Fallback Mock Property 1 (Rumah - Beli) --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Rumah Cluster" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                            <span class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-[#b75c1c]/90 text-white shadow-sm backdrop-blur-sm">Rumah</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Raanyverse Cluster Mutiara</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Rumah Cluster Tipe 36/72</h3>
                                <p class="text-stone-500 text-xs mt-2 leading-relaxed">Rumah cluster modern 2 lantai di kawasan perumahan Karawang Barat. Akses mudah ke tol Karawang, dekat pusat perbelanjaan, sekolah internasional, dan fasilitas kesehatan terpercaya.</p>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>2 K.Tidur</span>
                                <span>2 K.Mandi</span>
                                <span>LB 72 m²</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Beli</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 650.000.000</span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Pembelian</a>
                            </div>
                        </div>
                    </div>

                    {{-- Mock 2 (Ruko - Sewa) --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80" alt="Ruko Komersial" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                            <span class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-blue-600/90 text-white shadow-sm backdrop-blur-sm">Ruko</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Raanyverse Ruko Boulevard</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Ruko Komersial 2 Lantai</h3>
                                <p class="text-stone-500 text-xs mt-2 leading-relaxed">Ruko strategis 2 lantai di kawasan bisnis Telukjambe Timur, Karawang. Ideal untuk kantor, toko retail, apotek, atau kafe. Akses langsung jalan utama, area parkir luas, listrik 3.500 VA.</p>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>LT 60 m²</span>
                                <span>LB 120 m²</span>
                                <span>2 Lantai</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 18.000.000 <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Mock 3 (Rumah - Beli) --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80" alt="Rumah Premium" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                            <span class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-[#b75c1c]/90 text-white shadow-sm backdrop-blur-sm">Rumah</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Raanyverse Cluster Diamond</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Rumah Premium Tipe 54/120</h3>
                                <p class="text-stone-500 text-xs mt-2 leading-relaxed">Rumah premium hook 2 lantai dalam cluster eksklusif Karawang Timur. Fasilitas lengkap: kolam renang cluster, jogging track, CCTV 24 jam, one gate system. Sertifikat SHM siap proses KPR.</p>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>3 K.Tidur</span>
                                <span>2 K.Mandi</span>
                                <span>LB 120 m²</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Beli</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 1.250.000.000</span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Pembelian</a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Dynamically loaded available units --}}
                    @foreach($units as $unit)
                        <div class="card">
                            <div class="h-60 overflow-hidden relative">
                                @php
                                    $images = [
                                        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                                        'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80',
                                        'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80',
                                        'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=800&q=80',
                                        'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80'
                                    ];
                                    $imgUrl = $images[$loop->index % count($images)];
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $unit->name }}" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                                <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">{{ $unit->estate->name ?? 'Kawasan Elite' }}</span>
                                    <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">{{ $unit->name }}</h3>
                                    <p class="text-stone-500 text-xs mt-2 leading-relaxed">Unit properti berkualitas premium tipe {{ $unit->type }} yang berlokasi strategis di cluster {{ $unit->estate->name ?? 'Elite' }}. Memiliki sirkulasi udara yang baik, pencahayaan alami optimal, dan fasilitas lengkap yang siap menunjang kenyamanan tinggal Anda.</p>
                                </div>
                                <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                    <span>Tipe: {{ $unit->type }}</span>
                                    <span>Cluster: {{ $unit->estate->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <div>
                                        @if(strtolower($unit->property_type ?? '') === 'rumah')
                                            <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Beli</span>
                                            <span class="text-lg font-bold text-[#3e342f]">Rp {{ number_format($unit->price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                            <span class="text-lg font-bold text-[#3e342f]">Rp {{ number_format($unit->price, 0, ',', '.') }} <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                        @endif
                                    </div>
                                    @if(strtolower($unit->property_type ?? '') === 'rumah')
                                        <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Pembelian</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- CORE ECOSYSTEM FEATURES --}}
    <section id="fitur" class="py-28 relative bg-[#fdfbf7]">
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20 space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#b75c1c]">Modul Terintegrasi</span>
                <h2 class="playfair text-4xl md:text-5xl font-bold tracking-tight text-[#3e342f]">
                    Ekosistem <span class="gradient-text">ERP Property</span> Terlengkap
                </h2>
                <p class="text-stone-500 text-base md:text-lg max-w-2xl mx-auto">Divisi operasional, kasir keuangan, sales pipeline, hingga pos keamanan bersatu dalam satu ekosistem terpadu.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php $features = [
                    [
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'Laba/Rugi, Arus Kas & Pengeluaran',
                        'desc' => 'Visualisasi tren arus kas riil, laba bersih otomatis, dan pencatatan biaya pengeluaran operasional kawasan demi transparansi tanpa fraud.'
                    ],
                    [
                        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        'title' => 'CRM Leads & Manajemen Prospek',
                        'desc' => 'Pencatatan data calon penyewa potensial yang tertarik pada unit tertentu guna mengoptimalkan proses survei lokasi serta negosiasi sewa.'
                    ],
                    [
                        'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                        'title' => 'Booking Online & Google Calendar Sync',
                        'desc' => 'Sistem booking anti-double booking, pengunggahan berkas digital KTP tenant, serta sinkronisasi otomatis jadwal sewa ke Google Calendar.'
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'title' => 'Smart Billing & Payment Gateway',
                        'desc' => 'Penerbitan tagihan bulanan berkala (IPL/Sewa), biaya admin flat, hitungan denda harian otomatis, dan integrasi Duitku API Sandbox.'
                    ],
                    [
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'title' => 'Reservasi Fasilitas Umum',
                        'desc' => 'Manajemen pemesanan fasilitas bersama kawasan (kolam renang, tenis, dll) lengkap dengan pembatasan kapasitas dan jam operasional.'
                    ],
                    [
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                        'title' => 'Complaint Hub & Vendor Workflow',
                        'desc' => 'Pusat pengaduan keluhan kerusakan unit berbasis unggah bukti foto Cloudinary dengan penugasan vendor perbaikan oleh tim pengelola.'
                    ]
                ]; @endphp
                @foreach($features as $f)
                <div class="card p-8 space-y-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-2 bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)]">
                        <svg class="w-6 h-6 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $f['icon'] }}"/></svg>
                    </div>
                    <h3 class="playfair text-xl font-bold text-[#3e342f] leading-tight">{{ $f['title'] }}</h3>
                    <p class="text-stone-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CALL TO ACTION --}}
    <section class="py-24 relative overflow-hidden bg-white border-t border-stone-100">
        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center space-y-6">
            <h2 class="playfair text-4xl md:text-5xl font-bold tracking-tight text-[#3e342f]">
                Siap Mengelola Kawasan<br>Properti <span class="gradient-text">Secara Pintar?</span>
            </h2>
            <p class="text-stone-500 text-base md:text-lg max-w-xl mx-auto">Akses sistem administrasi real estate modern dalam satu platform terpadu skala nasional.</p>
            <div class="pt-6">
                <a href="{{ route('login') }}" class="btn-primary inline-block px-12 py-5 rounded-2xl font-bold text-xs tracking-widest uppercase">
                    Masuk Ke Dashboard Demo →
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-[#3e342f] text-[#fdfbf7] py-16 relative z-10 border-t border-stone-800">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 mb-12">
            {{-- Col 1: Brand --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#b75c1c] flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="playfair text-lg font-bold text-white">RaanyProp</span>
                </div>
                <p class="text-stone-400 text-xs leading-relaxed max-w-xs">
                    Sistem ERP properti premium untuk mengotomatisasi booking unit, sinkronisasi Google Calendar, reservasi fasilitas kawasan, pembukuan keuangan owner, denda harian, dan tagihan IPL/Sewa otomatis.
                </p>
            </div>
            
            {{-- Col 2: Support Contact --}}
            <div class="space-y-4">
                <h4 class="playfair text-base font-bold text-white tracking-wide">Kontak Support</h4>
                <ul class="space-y-2 text-xs text-stone-400">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:raanyverseproperti@gmail.com" class="hover:text-white transition-all">raanyverseproperti@gmail.com</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:+6289601784887" class="hover:text-white transition-all">+62 896-0178-4887</a>
                    </li>
                </ul>
            </div>
            
            {{-- Col 3: Address --}}
            <div class="space-y-4">
                <h4 class="playfair text-base font-bold text-white tracking-wide">Alamat Usaha</h4>
                <div class="flex gap-2 text-xs text-stone-400">
                    <svg class="w-5 h-5 text-[#b75c1c] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="leading-relaxed">
                        Jl. Ronggo Waluyo Sirnabaya, Puseurjaya, Kec. Telukjambe Timur, Kabupaten Karawang, Jawa Barat 41361
                    </p>
                </div>
            </div>
        </div>
        
        <div class="max-w-6xl mx-auto px-6 pt-8 border-t border-stone-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] font-bold uppercase tracking-widest text-stone-500">© 2026 RaanyProp — Hak Cipta Dilindungi</p>
            <div class="flex gap-4 text-[10px] font-bold uppercase tracking-widest text-stone-500">
                <span class="text-[#b75c1c]">Payment Secured by Duitku Sandbox</span>
            </div>
        </div>
    </footer>
</body>
</html>
