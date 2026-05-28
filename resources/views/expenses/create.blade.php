<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('expenses.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] text-stone-500 hover:text-[#3e342f] hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Catat <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Pengeluaran</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Biaya Operasional & Keuangan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-3xl mx-auto">
            <div class="rounded-[2rem] p-6 md:p-10  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                
                <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Tanggal Pengeluaran</label>
                            <input type="date" name="expense_date" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all" value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Kategori Biaya</label>
                            <select name="category" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="operational">Operasional</option>
                                <option value="maintenance">Perawatan/Perbaikan (Maintenance)</option>
                                <option value="salary">Gaji Karyawan</option>
                                <option value="utility">Tagihan Utilitas (Listrik/Air)</option>
                                <option value="tax">Pajak</option>
                                <option value="other">Lain-lain</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Judul Pengeluaran</label>
                        <input type="text" name="title" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: Gaji Security Bulan Mei">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Nominal (Rp)</label>
                        <input type="number" name="amount" required min="0" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] font-black text-xl focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="500000">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Keterangan / Detail</label>
                        <textarea name="description" rows="3" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Tulis rincian pengeluaran di sini..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Terkait Cluster / Estate (Opsional)</label>
                        <select name="estate_id" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                            <option value="">Pengeluaran Pusat / General</option>
                            @foreach($estates as $estate)
                                <option value="{{ $estate->id }}">{{ $estate->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center gap-3 px-8 py-5 rounded-2xl font-black text-sm tracking-widest uppercase text-white transition-all hover:-translate-y-1"
                                style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Simpan Pengeluaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
