<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Pos Keamanan (Security)</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Log Buku Tamu (Visitor Tracking)</h2>
            </div>
            <a href="{{ route('visitors.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Catat Tamu Masuk
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="rounded-[2rem] overflow-hidden  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(183,92,28,0.1)] bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Nama Tamu</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Kontak / Kendaraan</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Unit Tujuan</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Keperluan</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Waktu Masuk</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Waktu Keluar</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($visitors as $visitor)
                            <tr class="transition duration-300 hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-[#3e342f] outfit mb-1">{{ $visitor->name }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs text-[#3e342f] outfit">{{ $visitor->phone ?? '-' }}</div>
                                    @if($visitor->vehicle_number)
                                        <span class="px-2 py-0.5 rounded bg-white text-[9px] font-black text-stone-600 uppercase mt-1 inline-block">{{ $visitor->vehicle_number }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="text-xs font-black text-[#b75c1c] outfit">
                                        {{ $visitor->unit->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs text-stone-600">{{ $visitor->purpose }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs text-stone-500">
                                        {{ \Carbon\Carbon::parse($visitor->check_in_at)->format('d M, H:i') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs text-stone-500">
                                        {{ $visitor->check_out_at ? \Carbon\Carbon::parse($visitor->check_out_at)->format('d M, H:i') : '-' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                        @if($visitor->status === 'inside') bg-amber-500/20 text-[#b75c1c]
                                        @else bg-slate-500/20 text-stone-500 @endif
                                    ">
                                        {{ $visitor->status === 'inside' ? 'DI DALAM' : 'SUDAH KELUAR' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    @if($visitor->status === 'inside')
                                    <form action="{{ route('visitors.update', $visitor->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-wider hover:bg-emerald-500/30 transition-all">
                                            Checkout
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan tamu ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg inline-flex items-center justify-center transition-all bg-rose-50 text-rose-600 hover:bg-rose-100 ml-2">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="text-center py-24">
                                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <h3 class="outfit text-xl font-black text-[#3e342f] mb-2">Buku Tamu Kosong</h3>
                                        <p class="text-sm font-bold text-stone-500">Belum ada kunjungan tamu hari ini.</p>
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
