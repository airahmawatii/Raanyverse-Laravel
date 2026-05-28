<x-app-layout>
    <x-slot name="header">
        <h2 class="outfit text-3xl font-black text-[#3e342f]">Tambah Cluster</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] p-8 md:p-12 ">
                <form action="{{ route('estates.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Nama Cluster</label>
                        <input type="text" name="name" required class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Daerah (Region)</label>
                        <select name="region_id" required class="w-full bg-[#fdfbf7] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all appearance-none">
                            <option value="">Pilih Daerah</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Deskripsi Lengkap (Opsional)</label>
                        <textarea name="description" rows="3" class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-stone-500 uppercase tracking-widest mb-2">Alamat (Opsional)</label>
                        <input type="text" name="address" class="w-full bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-xl px-4 py-3 text-[#3e342f] focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all">
                    </div>
                    <div class="pt-6 border-t border-[rgba(183,92,28,0.1)]">
                        <button type="submit" class="w-full py-4 rounded-xl font-black text-xs tracking-widest uppercase text-white transition-all hover:opacity-90" style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                            Simpan Cluster
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
