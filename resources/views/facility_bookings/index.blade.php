<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block text-[#b75c1c]">Layanan Kawasan</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Reservasi Fasilitas</h2>
            </div>
            <a href="{{ route('facilities.index') }}" class="flex items-center gap-2 px-6 py-3 rounded-xl font-black text-[10px] tracking-widest uppercase text-[#b75c1c] bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] hover:bg-[rgba(183,92,28,0.2)] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Kelola Fasilitas
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
            <div class="mb-6 px-6 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Stats Bar --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                @php
                    $pending   = $bookings->where('status', 'pending')->count();
                    $approved  = $bookings->where('status', 'approved')->count();
                    $rejected  = $bookings->where('status', 'rejected')->count();
                    $cancelled = $bookings->where('status', 'cancelled')->count();
                @endphp
                @foreach([
                    ['label' => 'Menunggu',   'count' => $pending,   'color' => 'amber'],
                    ['label' => 'Disetujui',  'count' => $approved,  'color' => 'emerald'],
                    ['label' => 'Ditolak',    'count' => $rejected,  'color' => 'rose'],
                    ['label' => 'Dibatalkan', 'count' => $cancelled, 'color' => 'stone'],
                ] as $stat)
                <div class="p-5 rounded-2xl bg-white border border-[rgba(183,92,28,0.1)] shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-1">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-black text-[#3e342f] outfit">{{ $stat['count'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="rounded-[2rem] overflow-hidden bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-stone-100 bg-[#fdfbf7]">
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Penyewa</th>
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Fasilitas</th>
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Tanggal & Waktu</th>
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Tamu</th>
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-stone-50 transition-colors">
                                {{-- Penyewa --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-sm text-white shrink-0"
                                             style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                                            {{ substr($booking->tenant->name ?? '?', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[#3e342f]">{{ $booking->tenant->name ?? 'N/A' }}</p>
                                            <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest">{{ $booking->tenant->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Fasilitas --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <p class="text-sm font-bold text-[#3e342f]">{{ $booking->facility->name ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-[#b75c1c] font-black uppercase tracking-widest mt-0.5">{{ $booking->facility->estate->name ?? '' }}</p>
                                </td>
                                {{-- Tanggal & Waktu --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <p class="text-sm font-bold text-[#3e342f]">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="text-[10px] text-stone-400 font-bold mt-0.5">
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </p>
                                </td>
                                {{-- Tamu --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-[#3e342f]">{{ $booking->guest_count }} orang</span>
                                </td>
                                {{-- Status --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @php
                                        $stMap = [
                                            'pending'   => 'background:#fef3c7;color:#d97706;border:1px solid #fde68a;',
                                            'approved'  => 'background:#d1fae5;color:#059669;border:1px solid #a7f3d0;',
                                            'rejected'  => 'background:#fee2e2;color:#dc2626;border:1px solid #fecaca;',
                                            'cancelled' => 'background:#f5f5f4;color:#78716c;border:1px solid #e7e5e4;',
                                        ];
                                        $stLabel = [
                                            'pending'   => 'MENUNGGU',
                                            'approved'  => 'DISETUJUI',
                                            'rejected'  => 'DITOLAK',
                                            'cancelled' => 'DIBATALKAN',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest"
                                          style="{{ $stMap[$booking->status] ?? '' }}">
                                        {{ $stLabel[$booking->status] ?? strtoupper($booking->status) }}
                                    </span>
                                </td>
                                {{-- Aksi --}}
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    @if($role === 'admin' && $booking->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('facility_bookings.updateStatus', $booking->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-white transition-all hover:-translate-y-0.5"
                                                style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('facility_bookings.updateStatus', $booking->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Tolak reservasi ini?');">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-all">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                    @elseif($role === 'admin' && $booking->status === 'approved')
                                    <form action="{{ route('facility_bookings.updateStatus', $booking->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Batalkan reservasi yang sudah disetujui ini?');">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit"
                                            class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-stone-500 bg-stone-50 border border-stone-200 hover:bg-stone-100 transition-all">
                                            Batalkan
                                        </button>
                                    </form>
                                    @else
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-stone-50 border border-stone-100 ml-auto">
                                        <svg class="w-4 h-4 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <svg class="w-12 h-12 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-stone-400 font-bold text-sm">Belum ada reservasi fasilitas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>.outfit { font-family: 'Outfit', sans-serif; }</style>
</x-app-layout>
