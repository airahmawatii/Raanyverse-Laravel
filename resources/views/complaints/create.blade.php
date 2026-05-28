<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Ajukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Komplain</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Laporan Kerusakan Fasilitas</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] p-10  relative overflow-hidden">
                <!-- Decorative Glow -->
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-[rgba(183,92,28,0.1)] rounded-full blur-[100px] pointer-events-none"></div>

                <form action="{{ route('complaints.store') }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Unit/Properti Anda</label>
                        <select name="unit_id" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                            @if(isset($myRentals) && count($myRentals) > 0)
                                @foreach($myRentals as $rental)
                                    <option value="{{ $rental->unit->id }}">{{ $rental->unit->name }} ({{ $rental->unit->type }})</option>
                                @endforeach
                            @else
                                <option value="">-- Anda belum menyewa properti mana pun --</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Deskripsi Kerusakan / Keluhan</label>
                        <textarea name="description" rows="5" required placeholder="Contoh: AC kurang dingin, air mati, atau lampu putus..."
                            class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all"></textarea>
                    </div>

                    <div class="pt-6 border-t border-[rgba(183,92,28,0.1)]">
                        <button type="submit" class="w-full py-5 rounded-2xl text-sm font-black uppercase tracking-widest text-[#3e342f] transition-all transform hover:-translate-y-1 hover:shadow-[0_10px_40px_-10px_rgba(16,185,129,0.5)]"
                                style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                            Kirim Laporan Komplain
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
