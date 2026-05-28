<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('facilities.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] text-stone-500 hover:text-[#3e342f] hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Tambah <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Fasilitas</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Layanan Kawasan Properti</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-3xl mx-auto">
            <div class="rounded-[2rem] p-6 md:p-10  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                
                <form action="{{ route('facilities.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Pilih Cluster / Estate</label>
                        <select name="estate_id" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($estates as $estate)
                                <option value="{{ $estate->id }}">{{ $estate->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Nama Fasilitas</label>
                        <input type="text" name="name" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: Kolam Renang VIP">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Deskripsi Lengkap</label>
                        <textarea name="description" rows="3" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Cth: Fasilitas kolam renang outdoor dengan air hangat..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Jam Buka</label>
                            <input type="time" name="open_time" value="08:00" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Jam Tutup</label>
                            <input type="time" name="close_time" value="22:00" required class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Kapasitas Maksimal (Orang)</label>
                            <input type="number" name="max_capacity" value="10" required min="1" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Biaya Booking (Rp)</label>
                            <input type="number" name="booking_fee" value="0" required min="0" class="w-full bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] rounded-2xl px-6 py-4 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all placeholder:text-slate-600" placeholder="Isi 0 jika gratis">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-[#fdfbf7]/50 border border-[rgba(183,92,28,0.1)] p-4 rounded-2xl">
                        <input type="checkbox" name="is_bookable" id="is_bookable" value="1" checked class="w-5 h-5 rounded border-white/20 bg-[#fdfbf7] text-amber-500 focus:ring-amber-500 focus:ring-offset-0">
                        <label for="is_bookable" class="text-sm font-bold text-[#3e342f] cursor-pointer">Penyewa harus booking sebelum memakai fasilitas ini</label>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center gap-3 px-8 py-5 rounded-2xl font-black text-sm tracking-widest uppercase text-white transition-all hover:-translate-y-1"
                                style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Simpan Fasilitas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
