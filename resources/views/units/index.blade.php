<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] mb-2 block text-[#b75c1c]">Enterprise Management</span>
                <h2 class="playfair font-bold text-4xl text-[#3e342f] leading-none tracking-tight">Data Unit Properti</h2>
            </div>
            <a href="{{ route('units.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); box-shadow: 0 4px 15px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Unit
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- 📊 ENTERPRISE DASHBOARD WIDGETS --}}
            @php
                $totalUnits = \App\Models\Unit::count();
                $availableUnits = \App\Models\Unit::where('status', 'available')->count();
                $occupiedUnits = \App\Models\Unit::where('status', 'occupied')->count();
                $totalEstates = \App\Models\Estate::count();
                $estates = \App\Models\Estate::withCount(['units' => function($q) { $q->where('status', 'available'); }])->get();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-6 border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.02)]">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-1">Total Aset</div>
                    <div class="text-3xl font-black text-[#3e342f] playfair">{{ $totalUnits }}</div>
                </div>
                <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 shadow-[0_4px_20px_rgba(16,185,129,0.05)]">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 mb-1">Tersedia (Kosong)</div>
                    <div class="text-3xl font-black text-emerald-600 playfair">{{ $availableUnits }}</div>
                </div>
                <div class="bg-rose-50 rounded-2xl p-6 border border-rose-100 shadow-[0_4px_20px_rgba(244,63,94,0.05)]">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-rose-600 mb-1">Terisi (Disewa)</div>
                    <div class="text-3xl font-black text-rose-600 playfair">{{ $occupiedUnits }}</div>
                </div>
                <div class="bg-[#fdfbf7] rounded-2xl p-6 border border-stone-200 shadow-[0_4px_20px_rgba(62,52,47,0.02)]">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-[#b75c1c] mb-1">Total Cluster/Perum</div>
                    <div class="text-3xl font-black text-[#b75c1c] playfair">{{ $totalEstates }}</div>
                </div>
            </div>

            {{-- 📊 ASSET LIST TABLE --}}
            <div class="rounded-[2rem] overflow-hidden bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="px-8 py-5 border-b border-stone-100 bg-[#fdfbf7] flex justify-between items-center">
                    <h3 class="playfair font-bold text-lg text-[#3e342f] uppercase tracking-widest">Daftar Inventaris Properti</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-stone-100 bg-white">
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Nama Unit & Kategori
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Harga Sewa
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Status & Penyewa Aktif
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @forelse($units as $unit)
                            <tr class="transition duration-300 group hover:bg-stone-50">
                                {{-- Nama Kamar & Gambar --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-lg text-[#b75c1c] flex-shrink-0 overflow-hidden bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)]">
                                            @if($unit->image)
                                                <img src="{{ Str::startsWith($unit->image, 'http') ? $unit->image : asset('storage/' . $unit->image) }}" alt="{{ $unit->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($unit->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-base font-bold text-[#3e342f] playfair">
                                                @if($unit->blok && $unit->nomor_unit)
                                                    Blok {{ $unit->blok }} No. {{ $unit->nomor_unit }}
                                                    @if($unit->name && $unit->name != ('Blok ' . $unit->blok . ' No. ' . $unit->nomor_unit))
                                                        <span class="text-[10px] text-stone-500 ml-1">({{ $unit->name }})</span>
                                                    @endif
                                                @else
                                                    {{ $unit->name }}
                                                @endif
                                            </div>
                                            <div class="text-[9px] font-bold uppercase tracking-widest mt-1 text-[#b75c1c]">
                                                {{ $unit->estate->name ?? 'Tanpa Cluster' }} • Tipe: {{ $unit->type }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Harga --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-lg font-bold text-[#3e342f] outfit">Rp {{ number_format($unit->price, 0, ',', '.') }}</div>
                                    <div class="text-[9px] text-stone-400 font-bold uppercase tracking-widest mt-1">per bulan</div>
                                </td>
                                {{-- Status & Penyewa Aktif --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($unit->status === 'available')
                                        <span class="px-4 py-1.5 rounded-xl text-[9px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            TERSEDIA
                                        </span>
                                    @else
                                        @php
                                            $activeRental = \App\Models\Rental::where('unit_id', $unit->id)->with('tenant')->first();
                                        @endphp
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="px-4 py-1.5 rounded-xl text-[9px] font-bold uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100">
                                                TERISI
                                            </span>
                                            @if($activeRental && $activeRental->tenant)
                                                <span class="text-[9px] font-bold text-stone-500">Penyewa: {{ $activeRental->tenant->name }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                {{-- Aksi --}}
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('units.edit', $unit->id) }}"
                                           class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-[rgba(183,92,28,0.1)] text-[#b75c1c] border border-[rgba(183,92,28,0.2)] hover:bg-[rgba(183,92,28,0.2)]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Hapus properti ini? Semua data terkait properti ini mungkin akan hilang.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center py-24">
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 bg-[rgba(183,92,28,0.05)] border border-[rgba(183,92,28,0.1)] text-stone-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <p class="text-stone-400 font-bold text-xs uppercase tracking-widest">Belum ada properti yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>.outfit { font-family: 'Outfit', sans-serif; } .playfair { font-family: 'Playfair Display', serif; }</style>
</x-app-layout>
