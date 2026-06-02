<nav x-data="{ open: false }" class="bg-[#3e342f] text-white lg:w-72 lg:h-screen flex-shrink-0 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-[rgba(255,255,255,0.05)] shadow-xl z-50 overflow-hidden">
    
    {{-- Top Bar / Mobile Header --}}
    <div class="flex items-center justify-between px-6 py-4 lg:py-8 lg:justify-center border-b border-[rgba(255,255,255,0.05)] lg:border-none shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl flex items-center justify-center text-white group-hover:scale-105 transition-all duration-300" style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); box-shadow: 0 4px 15px rgba(183, 92, 28, 0.4);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <span class="playfair text-xl md:text-2xl font-bold tracking-tight text-white leading-none">Raany<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Prop</span></span>
        </a>

        {{-- Mobile Toggle --}}
        <div class="lg:hidden">
            <button @click="open = !open" class="p-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition-all">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    @php
        $role = Auth::user()->role;
    @endphp

    {{-- Main Navigation --}}
    <div :class="{'block': open, 'hidden': !open}" class="lg:flex flex-col flex-grow px-4 lg:px-6 py-4 overflow-y-auto space-y-6 custom-scrollbar">
        
        {{-- ==== SUPER ADMIN MENU ==== --}}
        @if($role === 'admin')
            
            {{-- Utama --}}
            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-2">Utama</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Dashboard
                </a>
            </div>

            {{-- Manajemen Aset & Penjualan --}}
            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-2 mt-4">Aset & Penjualan</p>
                <a href="{{ route('regions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('regions.*') || request()->routeIs('estates.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Kawasan & Cluster
                </a>
                <a href="{{ route('units.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('units.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Unit Properti
                </a>
                <a href="{{ route('leads.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('leads.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Calon Penyewa
                </a>
                <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('bookings.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Pesanan Sewa
                </a>
            </div>

            {{-- Keuangan & Operasional --}}
            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-2 mt-4">Keuangan & Operasional</p>
                <a href="{{ route('billings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('billings.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tagihan & Invoice
                </a>
                <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('expenses.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    Pengeluaran Bisnis
                </a>
                <a href="{{ route('complaints.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('complaints.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Komplain Tenant
                </a>
                <a href="{{ route('maintenances.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('maintenances.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Perbaikan
                </a>
            </div>

            {{-- Pengaturan Sistem --}}
            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-2 mt-4">Pengaturan Sistem</p>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Pengguna & Akses
                </a>
                <a href="{{ route('activities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('activities.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Log Aktivitas
                </a>
            </div>

        {{-- ==== OWNER MENU ==== --}}
        @elseif($role === 'owner')
            <div class="space-y-1.5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Dashboard Laba
                </a>
                <a href="{{ route('billings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('billings.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Laporan Keuangan
                </a>
                <a href="{{ route('units.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('units.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Aset Properti
                </a>
                <a href="{{ route('activities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('activities.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Log Audit Aktivitas
                </a>
            </div>

        {{-- ==== TENANT MENU ==== --}}
        @else
            <div class="space-y-1.5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Beranda
                </a>
                <a href="{{ route('bookings.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('bookings.create') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Sewa Unit Baru
                </a>
                <a href="{{ route('billings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('billings.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Tagihan Saya
                </a>
                <a href="{{ route('complaints.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('complaints.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Laporan Kendala
                </a>
                <a href="{{ route('maintenances.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('maintenances.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Perbaikan
                </a>
                <a href="{{ route('activities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('activities.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Log Aktivitas Saya
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-[#b75c1c] text-white shadow-[0_4px_15px_rgba(183,92,28,0.3)]' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil
                </a>
            </div>
        @endif
    </div>

    {{-- User Profile Area (Bottom of Sidebar) --}}
    <div :class="{'block': open, 'hidden': !open}" class="lg:block p-4 lg:p-6 bg-[#352c28] border-t border-[rgba(255,255,255,0.05)] shrink-0">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-black text-lg shadow-[0_4px_10px_rgba(0,0,0,0.3)] border-2 border-stone-600" style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-xs font-bold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-[#b75c1c] truncate mt-0.5">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold text-stone-400 hover:text-white hover:bg-white/5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Aplikasi
            </button>
        </form>
    </div>

    <style>
        /* Custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</nav>
