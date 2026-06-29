<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="outfit text-4xl font-black text-[#3e342f]">Katalog <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Properti</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-2">Temukan Properti Impian Anda</p>
            </div>
            <div class="hidden md:flex items-center gap-2 bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-full px-4 py-2">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-[#b75c1c] uppercase tracking-widest">Tersedia {{ \App\Models\Unit::where('status', 'available')->count() }} Properti</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($units as $unit)
                    <div class="group bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2rem] overflow-hidden  transition-all hover:border-amber-500/30 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(16,185,129,0.2)] flex flex-col">
                        {{-- Image Section --}}
                        <div class="h-64 bg-black/40 relative overflow-hidden">
                            @if($unit->image)
                                <img src="{{ Str::startsWith($unit->image, 'http') ? $unit->image : asset('storage/' . $unit->image) }}" alt="{{ $unit->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 bg-[#fdfbf7]/50">
                                    <svg class="w-16 h-16 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">No Image</span>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            <div class="absolute top-4 right-4">
                                @if($unit->status === 'available')
                                    <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-500/90 text-[#3e342f] shadow-lg backdrop-blur-sm">
                                        TERSEDIA
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest bg-red-500/90 text-[#3e342f] shadow-lg backdrop-blur-sm">
                                        TERISI
                                    </span>
                                @endif
                            </div>

                            {{-- Type Badge --}}
                            <div class="absolute bottom-4 left-4">
                                <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-black/60 text-[#3e342f] backdrop-blur-md border border-white/20">
                                    {{ $unit->type }} ROOM
                                </span>
                            </div>
                        </div>

                        {{-- Content Section --}}
                        <div class="p-8 flex-1 flex flex-col">
                            <h3 class="outfit text-3xl font-black text-[#3e342f] mb-2">{{ $unit->name }}</h3>
                            <div class="flex items-end gap-2 mb-8">
                                <span class="outfit text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Rp {{ number_format($unit->price, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-black text-stone-500 uppercase tracking-widest mb-2">/ bulan</span>
                            </div>

                            <div class="mt-auto">
                                @if($unit->status === 'available')
                                    <form action="{{ route('bookings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                        {{-- We use a default 1 month for now to make it easy for testing --}}
                                        <input type="hidden" name="start_date" value="{{ now()->addDays(1)->format('Y-m-d') }}">
                                        <input type="hidden" name="end_date" value="{{ now()->addMonth()->addDays(1)->format('Y-m-d') }}">
                                        
                                        <button type="submit" class="w-full py-4 rounded-xl font-black text-xs tracking-widest uppercase text-white transition-all hover:opacity-90 flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                                            Booking Sekarang
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full py-4 rounded-xl font-black text-xs tracking-widest uppercase text-stone-500 bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-24 bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[3rem]">
                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <h3 class="outfit text-2xl font-black text-[#3e342f] mb-2">Belum Ada Properti</h3>
                        <p class="text-sm font-bold text-stone-500">Saat ini pemilik belum menambahkan properti.</p>
                    </div>
                @endforelse
            </div>
            @if($units->hasPages())
            <div class="mt-8">
                {{ $units->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
