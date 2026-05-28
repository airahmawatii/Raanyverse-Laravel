<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Meteran Kawasan</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Pencatatan Utilitas</h2>
            </div>
                                @if($role === 'admin')
            <a href="{{ route('utility_readings.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Catat Meteran
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="rounded-[2rem] overflow-hidden  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(183,92,28,0.1)] bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Unit & Periode</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Utilitas</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Angka Meteran</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Pemakaian (Unit)</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Biaya Unit</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Total Biaya</th>
                                                    @if($role === 'admin')
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($readings as $reading)
                            <tr class="transition duration-300 hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-[#3e342f] outfit mb-1">{{ $reading->unit->name }}</div>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-500/20 text-blue-400">
                                        Periode: {{ $reading->reading_period }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                        @if($reading->utility_type === 'electricity') bg-amber-500/20 text-[#b75c1c]
                                        @else bg-sky-500/20 text-sky-400 @endif
                                    ">
                                        {{ strtoupper($reading->utility_type) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs font-bold text-stone-500">Sebelum: {{ $reading->previous_reading }}</div>
                                    <div class="text-xs font-black text-[#3e342f] mt-1">Sekarang: {{ $reading->current_reading }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-[#3e342f] outfit">{{ $reading->usage_amount }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs font-bold text-stone-500">Rp {{ number_format($reading->rate_per_unit, 0, ',', '.') }} / unit</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-black text-[#b75c1c] outfit">Rp {{ number_format($reading->total_cost, 0, ',', '.') }}</div>
                                </td>
                                                    @if($role === 'admin')
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <form action="{{ route('utility_readings.destroy', $reading->id) }}" method="POST" onsubmit="return confirm('Hapus data pencatatan utilitas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg inline-flex items-center justify-center transition-all bg-rose-50 text-rose-600 hover:bg-rose-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-24">
                                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                                        <h3 class="outfit text-xl font-black text-[#3e342f] mb-2">Belum Ada Pencatatan</h3>
                                        <p class="text-sm font-bold text-stone-500">Tidak ada pencatatan utilitas (listrik/air) yang aktif.</p>
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
</x-app-layout>
