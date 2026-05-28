<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Log <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Sistem</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Pemantauan Aktivitas Aplikasi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto space-y-8">

            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] p-8 md:p-12  relative overflow-hidden">
                {{-- Decorative glow --}}
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-[rgba(183,92,28,0.1)] blur-3xl rounded-full pointer-events-none"></div>

                <div class="space-y-8 relative z-10">
                    @forelse($activities as $activity)
                    <div class="relative pl-10 md:pl-12 group">
                        {{-- Timeline line --}}
                        @if(!$loop->last)
                        <div class="absolute left-[11px] md:left-[15px] top-8 bottom-[-2rem] w-[2px] bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] group-hover:bg-[rgba(183,92,28,0.2)] transition-colors"></div>
                        @endif
                        
                        {{-- Timeline dot --}}
                        <div class="absolute left-0 md:left-1 top-1.5 w-6 h-6 rounded-full bg-white border-2 border-[#b75c1c] flex items-center justify-center shadow-[0_0_15px_rgba(183,92,28,0.3)]">
                            <div class="w-2 h-2 rounded-full bg-[#b75c1c]"></div>
                        </div>

                        <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-stone-100 rounded-2xl p-5 hover:border-[rgba(183,92,28,0.3)] transition-all hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 mb-2">
                                <h4 class="text-sm font-bold text-[#3e342f]">{{ $activity->action }}</h4>
                                <span class="text-[9px] font-black text-[#b75c1c] bg-[rgba(183,92,28,0.1)] px-3 py-1 rounded-full uppercase tracking-widest">
                                    {{ $activity->module }}
                                </span>
                            </div>
                            <p class="text-xs text-stone-500 leading-relaxed mb-3">{{ $activity->description }}</p>
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1.5 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $activity->user->name ?? 'System' }}
                                </div>
                                <div class="w-1 h-1 rounded-full bg-slate-600"></div>
                                <div class="flex items-center gap-1.5 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] flex items-center justify-center text-stone-500 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-stone-500 font-bold text-sm">Belum ada aktivitas yang tercatat.</p>
                    </div>
                    @endforelse
                </div>

                @if($activities->hasPages())
                <div class="mt-8 pt-6 border-t border-stone-100">
                    {{ $activities->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
