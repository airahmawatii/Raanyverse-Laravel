<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Modul Finansial</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Pengeluaran Operasional</h2>
            </div>
                                @if($role === 'admin')
            <a href="{{ route('expenses.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Catat Pengeluaran
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="rounded-[2rem] p-6  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-red-500/20 text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-1">Total Pengeluaran</p>
                        <p class="text-2xl font-black text-[#3e342f] outfit">Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] overflow-hidden  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(183,92,28,0.1)] bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Tanggal & Kategori</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Keterangan</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Nominal</th>
                                                    @if($role === 'admin')
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($expenses as $expense)
                            <tr class="transition duration-300 hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-[#3e342f] outfit mb-1">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</div>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-500/20 text-[#b75c1c]">
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-[#3e342f] outfit mb-1">{{ $expense->title }}</div>
                                    <div class="text-[10px] font-bold text-stone-500 max-w-xs truncate">{{ $expense->description }}</div>
                                    @if($expense->estate_id)
                                        <div class="text-[9px] font-black uppercase tracking-widest text-emerald-400 mt-2">@ {{ $expense->estate->name }}</div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-black text-rose-600 outfit">- Rp {{ number_format($expense->amount, 0, ',', '.') }}</div>
                                </td>
                                                    @if($role === 'admin')
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Hapus data pengeluaran ini?');">
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
                                <td colspan="4">
                                    <div class="text-center py-24">
                                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                                        <h3 class="outfit text-xl font-black text-[#3e342f] mb-2">Belum Ada Pengeluaran</h3>
                                        <p class="text-sm font-bold text-stone-500">Tidak ada data operasional yang tercatat.</p>
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
