<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Request <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Maintenance</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Layanan Perbaikan & Perawatan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] p-10 relative overflow-hidden">
                <!-- Decorative Glow -->
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-[rgba(183,92,28,0.1)] rounded-full blur-[100px] pointer-events-none"></div>

                <form action="{{ route('maintenances.store') }}" method="POST" class="space-y-6 relative z-10">
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
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Kebutuhan Maintenance</label>
                        <textarea name="description" rows="5" required placeholder="Contoh: Permintaan cuci AC bulanan, perbaikan saluran air, pengecatan ulang..."
                            class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all"></textarea>
                    </div>

                    <div class="pt-6 border-t border-[rgba(183,92,28,0.1)]">
                        <button type="submit" class="w-full py-5 rounded-2xl text-sm font-black uppercase tracking-widest text-white transition-all transform hover:-translate-y-1 shadow-[0_10px_20px_-10px_rgba(183,92,28,0.5)]"
                                style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                            Kirim Request Maintenance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
