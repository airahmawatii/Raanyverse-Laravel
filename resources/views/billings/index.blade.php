<x-app-layout>
    <x-slot name="header">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] mb-2 block text-[#b75c1c]">Keuangan</span>
            <h2 class="playfair font-bold text-4xl text-[#3e342f] leading-none tracking-tight">Tagihan & Pembayaran</h2>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Form Buat Tagihan --}}
            @if(auth()->user()->role !== 'tenant')
            <div class="rounded-[2rem] overflow-hidden bg-white shadow-sm border border-[rgba(183,92,28,0.1)]">
                <div class="px-8 py-5 flex items-center gap-3 border-b border-stone-100 bg-[#fdfbf7]">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-[#3e342f]" style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="playfair font-bold text-lg text-[#3e342f] uppercase tracking-widest flex-1">Buat Tagihan Baru</h3>
                    <a href="{{ route('billings.export') }}" class="px-6 py-2 rounded-xl bg-[rgba(183,92,28,0.1)] text-[#b75c1c] text-[10px] font-bold uppercase tracking-widest hover:bg-[rgba(183,92,28,0.2)] transition-all">Export Laporan (CSV)</a>
                </div>
                <div class="p-8">
                    <form action="{{ route('billings.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-5 items-end">
                        @csrf
                        @php
                            $inputStyle = "width:100%; border-radius:0.75rem; padding:0.85rem 1rem; font-size:0.875rem; font-weight:600; color:#3e342f; background:#fdfbf7; border:1px solid #e7e5e4; outline:none; transition:all .2s;";
                            $labelStyle = "display:block; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:8px; color:#78716c;";
                        @endphp
                        <div>
                            <label style="{{ $labelStyle }}">Penyewa</label>
                            <select name="tenant_id" required style="{{ $inputStyle }}">
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="{{ $labelStyle }}">Unit Properti</label>
                            <select name="unit_id" required style="{{ $inputStyle }}">
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="{{ $labelStyle }}">Jumlah (Rp)</label>
                            <input type="number" name="amount" required placeholder="1500000" style="{{ $inputStyle }}">
                        </div>
                        <div>
                            <label style="{{ $labelStyle }}">Periode</label>
                            <input type="text" name="period" required placeholder="Oktober 2024" style="{{ $inputStyle }}">
                        </div>
                        <div>
                            <label style="{{ $labelStyle }}">Jatuh Tempo</label>
                            <input type="date" name="due_date" required style="{{ $inputStyle }}">
                        </div>
                        <div>
                            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
                                style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%); box-shadow: 0 4px 15px rgba(183,92,28,0.3);">
                                Buat Tagihan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Tabel Tagihan --}}
            <div class="rounded-[2rem] overflow-hidden bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-stone-100 bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Penyewa / Unit</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Tagihan</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Terbayar</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Jatuh Tempo</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @foreach($billings as $billing)
                            <tr class="transition duration-300 hover:bg-stone-50">
                                {{-- Penyewa / Unit --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm text-[#3e342f] flex-shrink-0"
                                             style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                                            {{ substr($billing->tenant->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-[#3e342f] playfair">{{ $billing->tenant->name }}</div>
                                            <div class="text-[9px] font-bold uppercase tracking-widest mt-0.5 text-[#b75c1c]">{{ $billing->unit->name }} · {{ $billing->period }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Tagihan --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-bold text-[#3e342f] outfit">Rp {{ number_format($billing->amount, 0, ',', '.') }}</div>
                                    <div class="text-[9px] text-stone-500 font-bold mt-0.5 uppercase tracking-widest">Sisa: Rp {{ number_format($billing->amount - $billing->paid_amount, 0, ',', '.') }}</div>
                                    @if($billing->fine_amount > 0)
                                    <div class="text-[10px] text-rose-600 font-black mt-1 uppercase tracking-wider flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Denda: Rp {{ number_format($billing->fine_amount, 0, ',', '.') }}
                                    </div>
                                    @endif
                                </td>
                                {{-- Terbayar + Progress --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-bold outfit text-emerald-600">Rp {{ number_format($billing->paid_amount, 0, ',', '.') }}</div>
                                    <div class="w-24 h-1.5 rounded-full mt-2 overflow-hidden bg-stone-100">
                                        <div class="h-full rounded-full" style="width:{{ ($billing->amount > 0) ? ($billing->paid_amount / $billing->amount * 100) : 0 }}%; background: linear-gradient(90deg, #b75c1c, #a65319);"></div>
                                    </div>
                                </td>
                                {{-- Jatuh Tempo --}}
                                <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-stone-500">
                                    {{ $billing->due_date ? \Carbon\Carbon::parse($billing->due_date)->format('d M Y') : '-' }}
                                </td>
                                {{-- Status --}}
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @php
                                        $stMap = [
                                            'paid'    => 'background:#d1fae5;color:#059669;border:1px solid #a7f3d0;',
                                            'overdue' => 'background:#fee2e2;color:#e11d48;border:1px solid #fecaca;',
                                            'unpaid'  => 'background:#fee2e2;color:#dc2626;border:1px solid #fecaca;',
                                        ];
                                        $stStyle = $stMap[$billing->status] ?? '';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-bold uppercase tracking-widest" style="{{ $stStyle }}">
                                        {{ $billing->status === 'paid' ? 'LUNAS' : ($billing->status === 'overdue' ? 'OVERDUE' : 'BELUM BAYAR') }}
                                    </span>
                                </td>
                                {{-- Aksi --}}
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    @if(auth()->user()->role !== 'tenant')
                                        @if($billing->status === 'unpaid')
                                        <form action="{{ route('billings.update', $billing->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Tandai tagihan ini sebagai lunas?');">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="px-5 py-2.5 rounded-xl text-[9px] font-bold uppercase tracking-widest text-[#3e342f] transition-all hover:-translate-y-0.5"
                                                style="background: linear-gradient(135deg, #b75c1c 0%, #a65319 100%);">
                                                Tandai Lunas
                                            </button>
                                        </form>
                                        @else
                                        <div class="flex items-center justify-end gap-2">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-50 border border-emerald-100">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <a href="{{ route('billings.receipt', $billing->id) }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center bg-amber-50 border border-amber-200 hover:bg-amber-100 text-amber-700 transition-all" title="Unduh Kuitansi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </a>
                                        </div>
                                        @endif
                                    @else
                                        @if($billing->status === 'unpaid')
                                        <button type="button" onclick="payWithDuitku({{ $billing->id }})" class="px-5 py-2.5 rounded-xl text-[9px] font-bold uppercase tracking-widest transition-all hover:-translate-y-0.5 shadow-sm text-blue-600 bg-blue-50 border border-blue-200 hover:bg-blue-100">
                                            Bayar Sekarang
                                        </button>
                                        @else
                                        <div class="flex items-center justify-end gap-2">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-50 border border-emerald-100">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <a href="{{ route('billings.receipt', $billing->id) }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center bg-amber-50 border border-amber-200 hover:bg-amber-100 text-amber-700 transition-all" title="Unduh Kuitansi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($billings->isEmpty())
                <div class="text-center py-20">
                    <p class="text-stone-500 font-bold text-xs uppercase tracking-widest">Belum ada tagihan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        function payWithDuitku(billingId) {
            const btn = event.target;
            const originalText = btn.innerText;
            btn.innerText = 'MEMPROSES...';
            btn.disabled = true;

            fetch(`/billings/${billingId}/snap`)
                .then(response => response.json())
                .then(data => {
                    btn.innerText = originalText;
                    btn.disabled = false;

                    if (data.success && data.payment_url) {
                        // Redirect directly to Duitku Sandbox / Passport Checkout URL
                        window.location.href = data.payment_url;
                    } else {
                        alert("Gagal memproses pembayaran Duitku: " + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    console.error('Error:', error);
                    alert("Terjadi kesalahan jaringan.");
                });
        }
    </script>
    <style>.outfit { font-family: 'Outfit', sans-serif; } .playfair { font-family: 'Playfair Display', serif; }</style>
</x-app-layout>
