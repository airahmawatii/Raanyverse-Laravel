<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Modul CRM</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Calon Penyewa (Leads Pipeline)</h2>
            </div>
            <a href="{{ route('leads.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Leads
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
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Nama / Kontak</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Unit Minat</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Status Pipeline</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Tanggal Survei</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Catatan</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($leads as $lead)
                            <tr class="transition duration-300 hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-[#3e342f] outfit mb-1">{{ $lead->name }}</div>
                                    <div class="text-[10px] font-bold text-stone-500">{{ $lead->phone }} | {{ $lead->email ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="text-xs font-black text-[#3e342f] outfit">
                                        {{ $lead->interestedUnit ? $lead->interestedUnit->name : 'Semua Unit' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                        @if($lead->status === 'deal') bg-emerald-500/20 text-emerald-400
                                        @elseif($lead->status === 'lost') bg-rose-500/20 text-rose-400
                                        @elseif($lead->status === 'survey') bg-sky-500/20 text-sky-400
                                        @elseif($lead->status === 'negotiation') bg-amber-500/20 text-[#b75c1c]
                                        @else bg-slate-500/20 text-stone-500 @endif
                                    ">
                                        {{ strtoupper($lead->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs font-bold text-stone-600">
                                        {{ $lead->survey_date ? \Carbon\Carbon::parse($lead->survey_date)->format('d M Y') : 'Belum Terjadwal' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs text-stone-500 max-w-xs truncate">{{ $lead->notes ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right space-x-2">
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="w-8 h-8 rounded-lg inline-flex items-center justify-center transition-all bg-[rgba(183,92,28,0.1)] text-[#b75c1c] hover:bg-[rgba(183,92,28,0.2)]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lead ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg inline-flex items-center justify-center transition-all bg-rose-50 text-rose-600 hover:bg-rose-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center py-24">
                                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <h3 class="outfit text-xl font-black text-[#3e342f] mb-2">Belum Ada Calon Penyewa</h3>
                                        <p class="text-sm font-bold text-stone-500">Mulai catat calon pelanggan Anda di pipeline CRM ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($leads->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2">
                {{-- Info data --}}
                <p class="text-xs font-bold text-stone-400">
                    Menampilkan <span class="text-[#3e342f]">{{ $leads->firstItem() }}–{{ $leads->lastItem() }}</span>
                    dari <span class="text-[#3e342f]">{{ $leads->total() }}</span> calon penyewa
                </p>

                {{-- Tombol halaman --}}
                <div class="flex items-center gap-1">
                    {{-- Prev --}}
                    @if($leads->onFirstPage())
                        <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-stone-300 bg-[#fdfbf7] border border-stone-100 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $leads->previousPageUrl() }}" class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-stone-500 bg-white border border-[rgba(183,92,28,0.15)] shadow-sm hover:bg-[rgba(183,92,28,0.07)] hover:text-[#b75c1c] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($leads->getUrlRange(max(1, $leads->currentPage()-2), min($leads->lastPage(), $leads->currentPage()+2)) as $page => $url)
                        @if($page == $leads->currentPage())
                            <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-[10px] font-black text-white"
                                  style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 4px 12px rgba(183,92,28,0.3);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-[10px] font-black text-stone-500 bg-white border border-[rgba(183,92,28,0.15)] shadow-sm hover:bg-[rgba(183,92,28,0.07)] hover:text-[#b75c1c] transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($leads->hasMorePages())
                        <a href="{{ $leads->nextPageUrl() }}" class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-stone-500 bg-white border border-[rgba(183,92,28,0.15)] shadow-sm hover:bg-[rgba(183,92,28,0.07)] hover:text-[#b75c1c] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-stone-300 bg-[#fdfbf7] border border-stone-100 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
