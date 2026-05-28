<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h2 class="playfair text-3xl font-bold text-[#3e342f]">Form <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Pemesanan</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Sewa Properti Baru</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-2">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)] rounded-[2.5rem] p-10 relative overflow-hidden">
                <!-- Decorative Glow -->
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-[rgba(183,92,28,0.05)] rounded-full blur-[100px] pointer-events-none"></div>

                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    
                    @if(request('unit_id'))
                        <input type="hidden" name="unit_id" value="{{ request('unit_id') }}">
                    @else
                    <div>
                        <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Pilih Properti</label>
                        <select name="unit_id" required class="w-full bg-[#fdfbf7] border border-stone-200 rounded-2xl px-6 py-4 text-[#3e342f] font-semibold focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none shadow-sm">
                            <option value="">-- Pilih Properti Tersedia --</option>
                            @foreach(\App\Models\Unit::where('status', 'available')->get() as $unit)
                                <option value="{{ $unit->id }}">
                                    @if($unit->blok && $unit->nomor_unit)
                                        Blok {{ $unit->blok }} No. {{ $unit->nomor_unit }} {{ $unit->name && $unit->name != ('Blok '.$unit->blok.' No. '.$unit->nomor_unit) ? '('.$unit->name.')' : '' }}
                                    @else
                                        {{ $unit->name }}
                                    @endif
                                    - Rp {{ number_format($unit->price, 0, ',', '.') }}/bulan
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Tanggal Mulai Masuk</label>
                            <input type="date" name="start_date" required min="{{ date('Y-m-d') }}"
                                class="w-full bg-[#fdfbf7] border border-stone-200 rounded-2xl px-6 py-4 text-[#3e342f] font-semibold focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-stone-500 uppercase tracking-widest mb-2">Lama Sewa (Bulan)</label>
                            <select name="duration" required class="w-full bg-[#fdfbf7] border border-stone-200 rounded-2xl px-6 py-4 text-[#3e342f] font-semibold focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none shadow-sm">
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan (Diskon 5%)</option>
                                <option value="6">6 Bulan (Diskon 10%)</option>
                                <option value="12">1 Tahun (Diskon 15%)</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-stone-100">
                        <button type="submit" class="w-full py-5 rounded-2xl text-sm font-bold uppercase tracking-widest text-[#3e342f] transition-all transform hover:-translate-y-1 shadow-[0_4px_15px_rgba(183,92,28,0.3)] hover:shadow-[0_8px_25px_rgba(183,92,28,0.4)]"
                                style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                            Kirim Permintaan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style> .playfair { font-family: 'Playfair Display', serif; } </style>
</x-app-layout>
