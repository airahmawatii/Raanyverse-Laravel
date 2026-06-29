<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('units.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] text-stone-500 hover:text-[#3e342f] hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Properti</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Perbarui Detail Unit Properti</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] p-8 md:p-12 ">
                <form action="{{ route('units.update', $unit->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Blok <span class="text-rose-500">*</span></label>
                            <input type="text" name="blok" value="{{ $unit->blok }}" required class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Nomor Unit <span class="text-rose-500">*</span></label>
                            <input type="text" name="nomor_unit" value="{{ $unit->nomor_unit }}" required class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Nama Khusus (Opsional)</label>
                            <input type="text" name="name" value="{{ $unit->name != ('Blok ' . $unit->blok . ' No. ' . $unit->nomor_unit) ? $unit->name : '' }}" class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Property / Cluster</label>
                            <select name="estate_id" required class="w-full bg-[#fdfbf7] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="">Pilih Cluster</option>
                                @foreach($estates as $estate)
                                    <option value="{{ $estate->id }}" {{ $unit->estate_id == $estate->id ? 'selected' : '' }}>{{ $estate->name }} ({{ $estate->region->name ?? 'Tanpa Daerah' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Jenis Properti</label>
                            <select name="property_type" required class="w-full bg-[#fdfbf7] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="rumah" {{ $unit->property_type == 'rumah' ? 'selected' : '' }}>Rumah</option>
                                <option value="ruko" {{ $unit->property_type == 'ruko' ? 'selected' : '' }}>Ruko</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Tipe Unit</label>
                            <select name="type" required class="w-full bg-[#fdfbf7] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                                <option value="standar" {{ $unit->type == 'standar' ? 'selected' : '' }}>Standar</option>
                                <option value="deluxe" {{ $unit->type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                <option value="premium" {{ $unit->type == 'premium' ? 'selected' : '' }}>Premium</option>
                                @if(!in_array($unit->type, ['standar', 'deluxe', 'premium']))
                                    <option value="{{ $unit->type }}" selected>{{ $unit->type }} (Kustom/Lama)</option>
                                @endif
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Harga (Per Bulan/Tahun)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-stone-500 font-bold">Rp</span>
                                <input type="number" name="price" value="{{ (int)$unit->price }}" required class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl pl-12 pr-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Status</label>
                        <select name="status" class="w-full bg-[#fdfbf7] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                            <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="occupied" {{ $unit->status == 'occupied' ? 'selected' : '' }}>Terisi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Foto Unit Saat Ini</label>
                        @if($unit->image)
                            <div class="mb-4 rounded-xl overflow-hidden border border-[rgba(183,92,28,0.1)]" style="max-width: 300px;">
                                <img src="{{ Str::startsWith($unit->image, 'http') ? $unit->image : asset('storage/' . $unit->image) }}" alt="{{ $unit->name }}" class="w-full h-auto object-cover">
                            </div>
                        @else
                            <p class="text-sm text-stone-500 mb-4 italic">Belum ada foto.</p>
                        @endif

                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Ganti Foto (Opsional)</label>
                        <div x-data="{ fileName: '' }" class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] border-dashed rounded-xl px-4 py-8 text-center hover:bg-white/10 transition-all relative">
                            <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            
                            <div x-show="!fileName">
                                <svg class="w-8 h-8 text-stone-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm font-bold text-stone-600">Klik atau drag foto baru ke sini</p>
                                <p class="text-[10px] text-stone-500 mt-1">Maksimal 2MB (JPG, PNG)</p>
                            </div>

                            <div x-show="fileName" style="display: none;">
                                <svg class="w-8 h-8 text-[#b75c1c] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm font-bold text-[#b75c1c]" x-text="fileName"></p>
                                <p class="text-[10px] text-stone-500 mt-1">Gambar siap diunggah</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-[rgba(183,92,28,0.1)]">
                        <button type="submit" class="w-full py-4 rounded-xl font-black text-xs tracking-widest uppercase text-white transition-all hover:opacity-90" style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                            Perbarui Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
