<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Pusat Informasi</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Pengumuman</h2>
            </div>
                    @if($role === 'admin')
            <a href="{{ route('announcements.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Buat Pengumuman
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">
            
            @forelse($announcements as $announcement)
                <div class="rounded-[2rem] p-6 md:p-8  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] transition-all hover:bg-white/10 flex flex-col md:flex-row gap-6 relative overflow-hidden">
                    
                    {{-- Priority Indicator --}}
                    <div class="absolute top-0 left-0 w-2 h-full
                        @if($announcement->priority === 'urgent') bg-red-500
                        @elseif($announcement->priority === 'high') bg-amber-500
                        @elseif($announcement->priority === 'normal') bg-blue-500
                        @else bg-slate-500 @endif
                    "></div>

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full
                                @if($announcement->priority === 'urgent') bg-red-500/20 text-rose-600 border border-red-500/30
                                @elseif($announcement->priority === 'high') bg-amber-500/20 text-[#b75c1c] border border-amber-500/30
                                @elseif($announcement->priority === 'normal') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @else bg-slate-500/20 text-stone-500 border border-slate-500/30 @endif
                            ">
                                {{ strtoupper($announcement->priority) }}
                            </span>
                            <span class="text-xs font-bold text-stone-500">{{ $announcement->created_at->diffForHumans() }}</span>
                            @if(!$announcement->estate_id)
                                <span class="text-[10px] font-black bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full">GLOBAL</span>
                            @else
                                <span class="text-[10px] font-black bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full">{{ $announcement->estate->name }}</span>
                            @endif
                        </div>

                        <h3 class="outfit text-2xl font-black text-[#3e342f] mb-2">{{ $announcement->title }}</h3>
                        <p class="text-stone-500 text-sm leading-relaxed">{{ $announcement->content }}</p>
                    </div>

                            @if($role === 'admin')
                    <div class="flex flex-row md:flex-col justify-end gap-3 md:border-l md:border-[rgba(183,92,28,0.1)] md:pl-6">
                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-24 rounded-[2rem] bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                    <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <h3 class="outfit text-2xl font-black text-[#3e342f] mb-2">Belum Ada Pengumuman</h3>
                    <p class="text-sm font-bold text-stone-500">Tidak ada informasi terbaru saat ini.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
