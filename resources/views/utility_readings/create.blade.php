<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('utility_readings.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] text-stone-500 hover:text-[#3e342f] hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Catat <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Meteran Utilitas</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Pencatatan & Terbit Tagihan Otomatis</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-3xl mx-auto">
            
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-bold">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="rounded-[2rem] p-6 md:p-10  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                
                <form action="{{ route('utility_readings.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Pilih Unit (Hanya yang Terisi)</label>
                            <select name="unit_id" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="">-- Pilih Unit --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Jenis Utilitas</label>
                            <select name="utility_type" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="electricity">Listrik (kWh)</option>
                                <option value="water">Air (m³)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Angka Meteran Baru (Current)</label>
                            <input type="number" step="0.01" name="current_reading" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] font-black text-lg focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: 1245.50">
                            <span class="text-[10px] text-stone-500 mt-1 block">* Angka meteran sebelumnya otomatis dicari oleh sistem</span>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Harga Per Unit (Rp)</label>
                            <input type="number" name="rate_per_unit" value="1500" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] font-black text-lg focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: 1500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Periode Pencatatan</label>
                        <input type="month" name="reading_period" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all" value="{{ date('Y-m') }}">
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center gap-3 px-8 py-5 rounded-2xl font-black text-sm tracking-widest uppercase text-white transition-all hover:-translate-y-1"
                                style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Simpan & Terbitkan Tagihan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
