<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('announcements.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] text-stone-500 hover:text-[#3e342f] hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Buat <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Pengumuman</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Siarkan Informasi ke Penghuni</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-3xl mx-auto">
            <div class="rounded-[2rem] p-6 md:p-10  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                
                <form action="{{ route('announcements.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Judul Pengumuman</label>
                        <input type="text" name="title" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: Pemadaman Listrik Sementara">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Pesan Informasi</label>
                        <textarea name="content" rows="4" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Tuliskan isi pengumuman secara detail..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Target Cluster (Opsional)</label>
                            <select name="estate_id" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="">Global (Seluruh Properti)</option>
                                @foreach($estates as $estate)
                                    <option value="{{ $estate->id }}">{{ $estate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Tingkat Prioritas</label>
                            <select name="priority" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="normal">Normal (Biasa)</option>
                                <option value="low">Rendah (Low)</option>
                                <option value="high">Tinggi (High)</option>
                                <option value="urgent">Mendesak (Urgent!)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] p-4 rounded-2xl">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 rounded border-white/20 bg-[#fdfbf7] text-amber-500 focus:ring-amber-500 focus:ring-offset-0">
                        <label for="is_active" class="text-sm font-bold text-[#3e342f] cursor-pointer">Aktifkan pengumuman ini sekarang</label>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center gap-3 px-8 py-5 rounded-2xl font-black text-sm tracking-widest uppercase text-white transition-all hover:-translate-y-1"
                                style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            Siarkan Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
