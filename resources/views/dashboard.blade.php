<x-app-layout>

    <div class="py-10 px-2">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- 1. ADMIN / SUPER ADMIN VIEW --}}
            @if($role === 'admin')
            <div class="mb-8">
                <h2 class="text-[#3e342f] text-3xl font-bold playfair mb-2">Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Enterprise</span></h2>
                <p class="text-stone-500 text-sm font-semibold">Ringkasan Operasional Properti & Kawasan</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
                @foreach([
                    ['label' => 'Total Properti',   'value' => $totalUnits,       'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => '#b75c1c'],
                    ['label' => 'Tersedia',      'value' => $availableUnits,   'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                      'color' => '#059669'],
                    ['label' => 'Terisi',        'value' => $occupiedUnits,    'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',                                                                              'color' => '#dc2626'],
                    ['label' => 'Laporan Aktif', 'value' => $totalComplaints,  'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',          'color' => '#d97706'],
                ] as $stat)
                <div class="p-8 rounded-[2rem] transition-all hover:-translate-y-1 bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <div class="flex justify-between items-center mb-5">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-[rgba(183,92,28,0.08)]">
                            <svg class="w-5 h-5" fill="none" stroke="{{ $stat['color'] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                        </div>
                        <span class="text-[9px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Live</span>
                    </div>
                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                    <p class="outfit text-4xl font-bold text-[#3e342f] tracking-tighter">{{ $stat['value'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="p-8 rounded-[2rem] bg-emerald-50 border border-emerald-100 shadow-sm">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Pendapatan Platform</p>
                    <p class="outfit text-3xl font-bold text-[#3e342f] tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-rose-50 border border-rose-100 shadow-sm">
                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mb-1">Pengeluaran Operasional</p>
                    <p class="outfit text-3xl font-bold text-[#3e342f] tracking-tighter">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-amber-50 border border-amber-100 shadow-sm">
                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1">Laba Bersih (Net Profit)</p>
                    <p class="outfit text-3xl font-bold text-[#3e342f] tracking-tighter">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Activity --}}
                <div class="lg:col-span-2 p-10 rounded-[2.5rem] space-y-8 bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="playfair text-2xl font-bold text-[#3e342f]">Aktivitas Terbaru</h3>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Log Sistem Global</p>
                        </div>
                        <div class="w-3 h-3 rounded-full animate-pulse bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                    </div>
                    <div class="space-y-6">
                        @forelse($recentActivities as $activity)
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-[#b75c1c]"></div>
                            <div class="absolute left-[3px] top-4 bottom-0 w-px bg-stone-200"></div>
                            <p class="text-sm font-semibold text-[#3e342f]">{{ $activity->description }}</p>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">{{ $activity->user->name }} · {{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <p class="text-stone-400 font-bold text-xs uppercase tracking-widest">Belum ada aktivitas.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="p-8 rounded-[2rem] bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                        <h4 class="playfair text-xl font-bold text-[#3e342f] mb-5">Status Pembayaran</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-stone-500 uppercase tracking-widest">Tagihan Lunas</span>
                                <span class="outfit text-2xl font-bold text-[#3e342f]">{{ $paidBillingsCount }}/{{ $totalBillingsCount }}</span>
                            </div>
                            <div class="w-full rounded-full h-1.5 bg-stone-100">
                                <div class="h-1.5 rounded-full bg-gradient-to-r from-[#b75c1c] to-[#a65319]" style="width: {{ $financialProgress }}%;"></div>
                            </div>
                            <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest text-right">{{ $financialProgress }}% Tuntas</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- 2. OWNER VIEW --}}
            @if($role === 'owner')
            <!-- Header Profil -->
            <div class="mb-8">
                <h2 class="text-[#3e342f] text-3xl font-bold playfair mb-2">Laporan Finansial <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Investor</span></h2>
                <p class="text-stone-500 text-sm font-semibold">Ringkasan Laba Rugi (P&L) Keseluruhan Kawasan</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="rounded-[2rem] p-8 bg-emerald-50 border border-emerald-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 text-emerald-500/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-2">Total Pendapatan (Revenue)</p>
                        <h3 class="text-4xl font-bold text-[#3e342f] outfit mb-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-sm font-semibold text-emerald-600">Dari {{ $paidBillingsCount }} Tagihan Lunas</p>
                    </div>
                </div>

                <div class="rounded-[2rem] p-8 bg-rose-50 border border-rose-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 text-rose-500/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-widest text-rose-600 mb-2">Total Pengeluaran (Expense)</p>
                        <h3 class="text-4xl font-bold text-[#3e342f] outfit mb-2">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        <p class="text-sm font-semibold text-rose-600">Operasional & Gaji</p>
                    </div>
                </div>

                <div class="rounded-[2rem] p-8 bg-amber-50 border border-amber-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 text-amber-500/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-widest text-amber-600 mb-2">Laba Bersih (Net Profit)</p>
                        <h3 class="text-4xl font-bold text-[#3e342f] outfit mb-2">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                        <p class="text-sm font-semibold text-amber-600">Margin Finansial Keseluruhan</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- 3. TENANT VIEW --}}
            @if($role === 'tenant')
            
            @if($myUnpaidBillings->count() > 0)
            <div class="p-6 rounded-[2rem] bg-rose-50 border border-rose-200 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-rose-100 text-rose-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="outfit font-bold text-[#3e342f] text-lg">Tagihan Menunggu Pembayaran!</h4>
                        <p class="text-xs font-semibold text-rose-600 mt-1">Anda memiliki {{ $myUnpaidBillings->count() }} tagihan sejumlah Rp {{ number_format($myUnpaidBillings->sum('amount'), 0, ',', '.') }} yang belum dilunasi.</p>
                    </div>
                </div>
                <a href="{{ route('billings.index') }}" class="w-full md:w-auto px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-[10px] text-white text-center transition-all shadow-[0_4px_15px_rgba(244,63,94,0.3)] hover:-translate-y-1" style="background: linear-gradient(135deg, #f43f5e 0%, #ea580c 100%);">
                    Bayar Sekarang
                </a>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- My Room --}}
                <div class="p-10 rounded-[2.5rem] bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <h3 class="playfair text-2xl font-bold text-[#3e342f] mb-6">Properti Saya</h3>
                    @if($myRoom)
                    <div class="space-y-4">
                        <p class="outfit text-5xl font-bold text-[#b75c1c]">{{ $myRoom->name }}</p>
                        <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">{{ $myRoom->type }} Room</p>
                        <div class="pt-6">
                            <span class="px-4 py-2 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-bold uppercase">Berakhir: {{ $myRoomEndDate }}</span>
                        </div>
                    </div>
                    @else
                    <p class="text-stone-400 font-semibold italic">Anda belum memiliki properti aktif.</p>
                    @endif
                </div>

                {{-- Complaints List --}}
                <div class="p-10 rounded-[2.5rem] bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="playfair text-2xl font-bold text-[#3e342f]">Riwayat Laporan</h3>
                        <a href="{{ route('complaints.create') }}" class="px-6 py-2 rounded-xl bg-[#b75c1c] text-white text-[10px] font-bold uppercase tracking-widest hover:bg-[#a65319] transition-all text-center">Buat Laporan</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($myComplaints as $complaint)
                        <div class="flex items-center gap-6 p-6 rounded-[1.5rem] bg-[#fdfbf7] border border-stone-100">
                            <div class="w-12 h-12 rounded-xl bg-[rgba(183,92,28,0.1)] flex items-center justify-center text-[#b75c1c]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-[#3e342f]">{{ $complaint->description }}</p>
                                <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest mt-1">{{ $complaint->created_at->format('d M Y') }}</p>
                            </div>
                            <span class="text-[9px] font-bold uppercase text-[#b75c1c]">{{ $complaint->status }}</span>
                        </div>
                        @empty
                        <p class="text-stone-400 font-semibold italic text-center py-10">Belum ada laporan kendala.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    <style>
        .outfit { font-family: 'Outfit', sans-serif; }
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</x-app-layout>
