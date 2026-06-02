<x-app-layout>
    <x-slot name="header">
        <div>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Layanan & Pemeliharaan</span>
            <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Laporan Kendala</h2>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto">
            @if(auth()->user()->role === 'tenant')
            <div class="flex justify-end mb-6">
                <a href="{{ route('complaints.create') }}" class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-[#3e342f] transition-all hover:-translate-y-1 shadow-[0_4px_15px_rgba(183,92,28,0.3)] flex items-center gap-2"
                    style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Buat Laporan Baru
                </a>
            </div>
            @endif

            <div class="rounded-[2rem] overflow-hidden" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(16,185,129,0.1);">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(16,185,129,0.08);">
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Penyewa
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Deskripsi Masalah</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                            <tr class="transition duration-300" style="border-bottom: 1px solid rgba(16,185,129,0.05);"
                                onmouseover="this.style.background='rgba(16,185,129,0.03)'"
                                onmouseout="this.style.background='transparent'">
                                {{-- Penyewa --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm text-[#3e342f] flex-shrink-0"
                                             style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%);">
                                            {{ substr($complaint->tenant->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-[#3e342f] outfit">{{ $complaint->tenant->name }}</div>
                                            <div class="text-[9px] font-black uppercase tracking-widest mt-0.5" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">{{ $complaint->unit->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Deskripsi --}}
                                <td class="px-8 py-6" style="min-width:320px;">
                                    <p class="text-sm text-stone-500 leading-relaxed italic">"{{ $complaint->description }}"</p>
                                    @if($complaint->image_url)
                                    <div class="mt-2">
                                        <a href="{{ $complaint->image_url }}" target="_blank" class="inline-block rounded-lg overflow-hidden border border-stone-200 shadow-sm hover:opacity-80 transition-opacity">
                                            <img src="{{ $complaint->image_url }}" alt="Bukti Kendala" class="w-16 h-16 object-cover">
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                {{-- Status --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @php
                                        $stMap = [
                                            'pending'   => 'background:rgba(251,191,36,0.1);color:#fbbf24;border:1px solid rgba(251,191,36,0.2);',
                                            'approved'  => 'background:rgba(14,165,233,0.1);color:#d97706;border:1px solid rgba(14,165,233,0.2);',
                                            'completed' => 'background:rgba(20,184,166,0.1);color:#2dd4bf;border:1px solid rgba(20,184,166,0.2);',
                                            'rejected'  => 'background:rgba(100,116,139,0.1);color:#64748b;border:1px solid rgba(100,116,139,0.2);',
                                        ];
                                        $stStyle = $stMap[$complaint->status] ?? '';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest" style="{{ $stStyle }}">
                                        {{ $complaint->status === 'pending' ? 'MENUNGGU' : ($complaint->status === 'approved' ? 'DIPROSES' : ($complaint->status === 'completed' ? 'SELESAI' : 'DITOLAK')) }}
                                    </span>
                                </td>
                                {{-- Tindakan --}}
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    @if(auth()->user()->role !== 'tenant')
                                        @if(!in_array($complaint->status, ['completed', 'rejected']))
                                        <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <div class="flex items-center justify-end gap-1">
                                                <select name="status" onchange="this.form.submit()"
                                                    class="rounded-xl text-[9px] font-black uppercase tracking-widest py-2.5 pl-4 pr-8 cursor-pointer appearance-none"
                                                    style="background:rgba(16,185,129,0.06); color:#d97706; border:1px solid rgba(16,185,129,0.15); outline:none;">
                                                    <option disabled selected style="background:#0d1b2e;">Ubah Status...</option>
                                                    <option value="approved" style="background:#0d1b2e;">Proses Perbaikan</option>
                                                    <option value="completed" style="background:#0d1b2e;">Selesaikan</option>
                                                    <option value="rejected" style="background:#0d1b2e;">Tolak</option>
                                                </select>
                                            </div>
                                        </form>
                                        @else
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center ml-auto" style="background:rgba(20,184,166,0.1); border:1px solid rgba(20,184,166,0.2);">
                                            <svg class="w-4 h-4" fill="none" stroke="#2dd4bf" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        @endif
                                    @else
                                        <div class="text-stone-500 font-bold text-xs">-</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($complaints->isEmpty())
                <div class="text-center py-20">
                    <p class="text-slate-600 font-black text-xs uppercase tracking-widest">Tidak ada laporan kendala.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <style>.outfit { font-family: 'Outfit', sans-serif; }</style>
</x-app-layout>
