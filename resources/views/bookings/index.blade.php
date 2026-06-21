<x-app-layout>
    <x-slot name="header">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] mb-2 block text-[#b75c1c]">Alur Kerja</span>
            <h2 class="playfair font-bold text-4xl text-[#3e342f] leading-none tracking-tight">Pemesanan</h2>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto">
            <div class="rounded-[2rem] overflow-hidden bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-stone-100 bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="#b75c1c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Penyewa
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="#b75c1c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Unit Properti
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="#b75c1c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Masa Sewa
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr class="transition duration-300 border-b border-stone-50 hover:bg-stone-50">
                                {{-- Penyewa --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-sm text-[#3e342f] flex-shrink-0"
                                             style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); shadow-[0_4px_15px_rgba(183,92,28,0.3)];">
                                            {{ substr($booking->tenant->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-base font-bold text-[#3e342f] playfair">{{ $booking->tenant->name }}</div>
                                            <div class="text-[9px] text-stone-400 font-bold mt-0.5">{{ $booking->tenant->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Unit --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-bold text-[#3e342f] playfair">{{ $booking->unit->name }}</div>
                                    <div class="text-[9px] font-bold uppercase tracking-widest mt-1 text-[#b75c1c]">{{ $booking->unit->type }}</div>
                                </td>
                                {{-- Masa Sewa --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-bold text-[#3e342f]">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</div>
                                    <div class="text-[9px] text-stone-400 font-bold mt-0.5 uppercase tracking-widest">s/d {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</div>
                                </td>
                                {{-- Status --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @php
                                        $styles = [
                                            'pending'  => 'background:#fef3c7;color:#d97706;border:1px solid #fde68a;',
                                            'approved' => 'background:#d1fae5;color:#059669;border:1px solid #a7f3d0;',
                                            'rejected' => 'background:#fee2e2;color:#dc2626;border:1px solid #fecaca;',
                                        ];
                                        $st = $styles[$booking->status] ?? '';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-bold uppercase tracking-widest" style="{{ $st }}">
                                        {{ $booking->status === 'approved' ? 'DISETUJUI' : ($booking->status === 'pending' ? 'MENUNGGU' : 'DITOLAK') }}
                                    </span>
                                </td>
                                {{-- Aksi --}}
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    @if(auth()->user()->role === 'admin')
                                        @if($booking->status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-5 py-2.5 rounded-xl text-[9px] font-bold uppercase tracking-widest text-[#3e342f] transition-all hover:-translate-y-0.5"
                                                    style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); box-shadow: 0 4px 15px rgba(183,92,28,0.3);">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-5 py-2.5 rounded-xl text-[9px] font-bold uppercase tracking-widest transition-all text-rose-600 bg-rose-50 border border-rose-200 hover:bg-rose-100">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <div class="flex items-center justify-end gap-2">
                                            @if($booking->status === 'approved')
                                            <a href="{{ route('bookings.contract', $booking->id) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-[9px] font-bold uppercase tracking-widest transition-all text-[#3e342f] hover:-translate-y-0.5" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(183,92,28,0.3);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Kontrak PDF
                                            </a>
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-50 border border-emerald-200">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            @else
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-rose-50 border border-rose-200">
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    @else
                                        <div class="text-stone-400 font-bold text-xs">-</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($bookings->isEmpty())
                <div class="text-center py-20">
                    <p class="text-stone-500 font-bold text-xs uppercase tracking-widest">Tidak ada permintaan pemesanan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <style>.outfit { font-family: 'Outfit', sans-serif; } .playfair { font-family: 'Playfair Display', serif; }</style>
</x-app-layout>
