<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col text-center md:text-left">
            <span class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mb-2">Operasional Teknis</span>
            <h2 class="outfit font-black text-4xl text-slate-900 leading-none tracking-tight">
                {{ __('Permintaan Pemeliharaan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-white overflow-hidden">
                <div class="bg-[#fdfbf7] px-6 md:px-10 py-6 md:py-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <h3 class="text-xl font-black text-[#3e342f] outfit uppercase tracking-[0.2em] inline-flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-600 text-[#3e342f] rounded-[1.25rem] flex items-center justify-center shadow-xl shadow-orange-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.121 2.121 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        </div>
                        Antrean Pemeliharaan Fasilitas
                    </h3>
                    <span class="text-[9px] text-stone-500 font-black tracking-widest uppercase bg-white px-5 py-2 rounded-full border border-slate-700 italic">Sistem Inti Aktif</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-10 py-8 text-[10px] font-black text-stone-500 uppercase tracking-[0.3em]">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Pengaju Permintaan
                                    </div>
                                </th>
                                <th class="px-10 py-8 text-[10px] font-black text-stone-500 uppercase tracking-[0.3em]">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        Deskripsi Masalah
                                    </div>
                                </th>
                                <th class="px-10 py-8 text-[10px] font-black text-stone-500 uppercase tracking-[0.3em]">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Status
                                    </div>
                                </th>
                                <th class="px-10 py-8 text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] text-right">Tata Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($maintenances as $maintenance)
                            <tr class="hover:bg-amber-50/30 transition duration-500 group">
                                <td class="px-10 py-8 whitespace-nowrap">
                                    <div class="text-lg font-black text-slate-900 outfit leading-none">{{ $maintenance->tenant->name }}</div>
                                    <div class="text-[9px] text-amber-600 mt-2 font-black uppercase tracking-[0.2em] bg-amber-50 px-3 py-1 rounded-lg border border-amber-100 inline-block">UNIT {{ $maintenance->unit->name }}</div>
                                </td>
                                <td class="px-10 py-8 min-w-[400px]">
                                    <div class="p-6 bg-slate-50 rounded-[1.5rem] border border-slate-100 group-hover:bg-white group-hover:border-amber-100 transition duration-500 shadow-sm relative overflow-hidden">
                                        <div class="absolute top-0 left-0 w-1 h-full bg-orange-500/20"></div>
                                        <p class="text-sm text-slate-600 leading-relaxed font-bold italic tracking-tight">"{{ $maintenance->description }}"</p>
                                    </div>
                                </td>
                                <td class="px-10 py-8 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100 shadow-amber-100/50',
                                            'approved' => 'bg-indigo-50 text-indigo-600 border-indigo-100 shadow-indigo-100/50',
                                            'completed' => 'bg-amber-50 text-amber-600 border-amber-100 shadow-amber-100/50',
                                            'rejected' => 'bg-slate-50 text-stone-500 border-slate-100'
                                        ];
                                        $style = $statusStyles[$maintenance->status] ?? 'bg-white text-gray-800';
                                    @endphp
                                    <span class="px-6 py-2 inline-flex text-[9px] font-black rounded-xl border {{ $style }} uppercase tracking-[0.2em] shadow-sm">
                                        {{ str_replace('_', ' ', $maintenance->status === 'approved' ? 'SEDANG DIKERJAKAN' : ($maintenance->status === 'pending' ? 'DALAM ANTRIAN' : ($maintenance->status === 'completed' ? 'SELESAI' : 'DIBATALKAN'))) }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 whitespace-nowrap text-right">
                                    @if(!in_array($maintenance->status, ['completed', 'rejected']))
                                        <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST" class="inline-block relative">
                                            @csrf
                                            @method('PUT')
                                            <div class="relative inline-block">
                                                <select name="status" onchange="this.form.submit()" class="text-[9px] font-black text-slate-900 rounded-xl border-slate-200 py-3 pl-5 pr-12 shadow-sm focus:border-amber-500 focus:ring-amber-500 cursor-pointer appearance-none bg-white hover:border-amber-300 transition uppercase tracking-[0.2em]">
                                                    <option disabled selected>UPDATE STATUS...</option>
                                                    <option value="approved" class="font-black text-indigo-600">TUGASKAN TEKNISI</option>
                                                    <option value="completed" class="font-black text-amber-600">TANDAI SELESAI</option>
                                                    <option value="rejected" class="font-black text-rose-600">BATALKAN TUGAS</option>
                                                </select>
                                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-stone-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="flex justify-end pr-4">
                                            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($maintenances->isEmpty())
                <div class="text-center py-32 bg-slate-50/50">
                    <div class="w-20 h-20 bg-white border border-slate-100 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-xl shadow-slate-200/50">
                        <svg class="w-10 h-10 text-[#b75c1c]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-stone-500 font-black uppercase tracking-widest text-sm outfit">Integritas Aset: 100%. Tidak ada pemeliharaan yang pending.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
