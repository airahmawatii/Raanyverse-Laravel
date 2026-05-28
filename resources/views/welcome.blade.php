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
                    Sistem ERP properti premium untuk menyatukan pencatatan tagihan utilitas, pembukuan keuangan owner, booking fasilitas umum, pengelolaan log visitor, serta logistik paket kurir pos satpam.
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
                                <span class="text-2xl font-bold text-[#b75c1c] playfair">+Rp 148,250,000</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase bg-[rgba(183,92,28,0.1)] text-[#b75c1c]">Kas Aman</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-[#fdfbf7] border border-stone-100">
                                <span class="text-[9px] font-bold text-stone-500 uppercase tracking-widest block mb-1">Hunian Aktif</span>
                                <span class="text-xl font-bold text-[#3e342f]">92.4% <span class="text-xs text-stone-400 font-normal">/ Unit</span></span>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#fdfbf7] border border-stone-100">
                                <span class="text-[9px] font-bold text-stone-500 uppercase tracking-widest block mb-1">Pos Tamu Hari Ini</span>
                                <span class="text-xl font-bold text-[#b75c1c]">12 Log <span class="text-xs text-stone-400 font-normal">/ Buku</span></span>
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
                    {{-- Premium Fallback Mock Property 1 --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Villa Modern" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Grand Galaxy Residence</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Townhouse Minimalis Tipe A</h3>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>2 K.Tidur</span>
                                <span>2 K.Mandi</span>
                                <span>2 Lantai</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 12.000.000 <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
                            </div>
                        </div>
                    </div>

                    {{-- Mock 2 --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80" alt="Apartment Modern" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Royal Signature Boulevard</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Executive Ruko Premium</h3>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>1 Kantor</span>
                                <span>2 Toilet</span>
                                <span>3 Lantai</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 25.000.000 <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Mock 3 --}}
                    <div class="card">
                        <div class="h-60 overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80" alt="Villa Modern" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-white/90 text-emerald-600 shadow-sm backdrop-blur-sm">Tersedia</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[9px] font-bold text-[#b75c1c] uppercase tracking-widest block mb-1">Cendana Hills Estate</span>
                                <h3 class="playfair text-2xl font-bold text-[#3e342f] leading-tight">Vila Kebun Luxury Tipe Gold</h3>
                            </div>
                            <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                <span>3 K.Tidur</span>
                                <span>3 K.Mandi</span>
                                <span>1 Kolam</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <div>
                                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                    <span class="text-lg font-bold text-[#3e342f]">Rp 35.000.000 <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
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
                                </div>
                                <div class="flex justify-between items-center text-xs text-stone-500 border-t border-stone-100 pt-4">
                                    <span>Tipe: {{ $unit->type }}</span>
                                    <span>Cluster: {{ $unit->estate->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <div>
                                        <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest block">Harga Sewa</span>
                                        <span class="text-lg font-bold text-[#3e342f]">Rp {{ number_format($unit->price_per_month, 0, ',', '.') }} <span class="text-xs font-normal text-stone-400">/ bln</span></span>
                                    </div>
                                    <a href="{{ route('login') }}" class="btn-primary px-4 py-2.5 rounded-xl font-bold text-[9px] tracking-widest uppercase">Ajukan Sewa</a>
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
                        'title' => 'Akuntansi Laba/Rugi & Pengeluaran',
                        'desc' => 'Lacak profit bersih, pencatatan biaya perawatan pompa/kebun, serta grafik laba finansial lunas secara langsung.'
                    ],
                    [
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                        'title' => 'Pencatatan Utilitas & Auto-Billing',
                        'desc' => 'Cukup input angka meteran air/listrik bulanan, sistem otomatis menghitung tarif pemakaian dan menerbitkan tagihan.'
                    ],
                    [
                        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        'title' => 'CRM Leads & Pipeline Penjualan',
                        'desc' => 'Daftarkan calon prospek penyewa, atur janji survei unit, hingga deals penyewaan properti secara rapi.'
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'title' => 'Pos Satpam & Log Buku Tamu',
                        'desc' => 'Log masuk tamu lengkap dengan nopol kendaraan, unit tujuan, serta tombol keluar check-out otomatis oleh satpam.'
                    ],
                    [
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'title' => 'Logistik Penerimaan Paket Kurir',
                        'desc' => 'Menerima dan mencatat paket belanjaan tenant di resepsionis pos utama, terekam aman hingga serah terima selesai.'
                    ],
                    [
                        'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                        'title' => 'Booking Fasilitas Umum',
                        'desc' => 'Manajemen clubhouse, sewa lapangan, lengkap dengan biaya operasional sewa kawasan.'
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
    <footer class="bg-[#3e342f] py-12 relative z-10">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#b75c1c] flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="playfair text-lg font-bold text-white">RaanyProp</span>
            </div>
            <p class="text-[9px] font-bold uppercase tracking-widest text-stone-400">© 2026 RaanyProp — Hak Cipta Dilindungi</p>
        </div>
    </footer>
</body>
</html>
