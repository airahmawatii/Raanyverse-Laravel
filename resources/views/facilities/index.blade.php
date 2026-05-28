<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Layanan Kawasan</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Fasilitas Umum</h2>
            </div>
                            @if($role === 'admin')
            <a href="{{ route('facilities.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Fasilitas
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @forelse($facilities as $facility)
                <div class="rounded-[2rem] overflow-hidden  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] transition-all hover:bg-white/10 hover:-translate-y-1 group">
                    <div class="h-48 bg-[#fdfbf7]/50 relative overflow-hidden flex items-center justify-center">
                        @if($facility->image)
                            <img src="{{ Str::startsWith($facility->image, 'http') ? $facility->image : asset('storage/' . $facility->image) }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-all">
                        @else
                            <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full bg-amber-500 text-[#3e342f] shadow-lg">
                                {{ $facility->estate->name }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="outfit text-2xl font-black text-[#3e342f] leading-tight mb-1">{{ $facility->name }}</h3>
                                <p class="text-xs font-bold text-stone-500">Jam Buka: {{ substr($facility->open_time, 0, 5) }} - {{ substr($facility->close_time, 0, 5) }}</p>
                            </div>
                        </div>

                        <p class="text-sm text-stone-500 mb-6 line-clamp-2">{{ $facility->description ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-[#fdfbf7]/50 rounded-xl p-3 border border-white/5">
                                <span class="block text-[9px] font-black uppercase tracking-widest text-stone-500 mb-1">Kapasitas Maks</span>
                                <span class="text-sm font-bold text-[#3e342f]">{{ $facility->max_capacity }} Orang</span>
                            </div>
                            <div class="bg-[#fdfbf7]/50 rounded-xl p-3 border border-white/5">
                                <span class="block text-[9px] font-black uppercase tracking-widest text-stone-500 mb-1">Tarif Booking</span>
                                <span class="text-sm font-bold text-[#b75c1c]">
                                    {{ $facility->booking_fee > 0 ? 'Rp ' . number_format($facility->booking_fee, 0, ',', '.') : 'GRATIS' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            @if($role === 'tenant' && $facility->is_bookable)
                                <a href="#" class="flex-1 flex justify-center items-center gap-2 px-4 py-3 rounded-xl font-black text-[10px] tracking-widest uppercase text-[#3e342f] transition-all bg-emerald-500 hover:bg-emerald-600">
                                    Booking Sekarang
                                </a>
                            @endif

                                            @if($role === 'admin')
                            <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus fasilitas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-3 rounded-xl font-black text-[10px] tracking-widest uppercase transition-all bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-24 rounded-[2rem] bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                    <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="outfit text-2xl font-black text-[#3e342f] mb-2">Belum Ada Fasilitas</h3>
                    <p class="text-sm font-bold text-stone-500">Kawasan ini belum mendaftarkan fasilitas umum apapun.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
