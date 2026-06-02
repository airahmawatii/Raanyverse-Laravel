<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kuitansi Resmi - PropVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .outfit { font-family: 'Outfit', sans-serif; }
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#fcfaf6] text-[#3e342f] outfit min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-8 md:p-10 border border-[#b75c1c]/10 shadow-[0_10px_40px_rgba(62,52,47,0.04)] text-center relative overflow-hidden">
        {{-- Decorative Top Line --}}
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#b75c1c] to-[#a65319]"></div>

        {{-- Success Checkmark Icon with Premium Ripple effect --}}
        <div class="mx-auto w-24 h-24 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-6 relative">
            <span class="absolute w-24 h-24 rounded-full bg-emerald-500/10 animate-ping"></span>
            <svg class="w-12 h-12 text-emerald-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="playfair text-3xl font-bold mb-2">Kuitansi Terverifikasi</h1>
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 inline-block px-5 py-1.5 rounded-full border border-emerald-200 mb-8">
            Dinyatakan SAH & LUNAS
        </p>

        {{-- Verification details grid --}}
        <div class="space-y-4 text-left bg-[#fdfbf7] p-6 rounded-[2rem] border border-[#e7e5e4] mb-8">
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">No. Invoice</span>
                <span class="text-sm font-bold text-[#3e342f]">BILL-{{ $billing->id }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Nama Penyewa</span>
                <span class="text-sm font-bold text-[#3e342f]">{{ $billing->tenant->name }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Unit Properti</span>
                <span class="text-sm font-bold text-[#b75c1c] uppercase tracking-wide">{{ $billing->unit->name }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Periode Sewa</span>
                <span class="text-sm font-semibold text-[#3e342f]">{{ $billing->period }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Tanggal Lunas</span>
                <span class="text-sm font-semibold text-[#3e342f]">{{ $billing->updated_at->format('d M Y') }}</span>
            </div>
            @if($billing->fine_amount > 0)
            <div class="flex justify-between items-center border-b border-stone-100 pb-3">
                <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Denda Terbayar</span>
                <span class="text-sm font-black text-rose-600">Rp {{ number_format($billing->fine_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center pt-2">
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Total Pembayaran</span>
                <span class="text-lg font-black text-[#b75c1c]">Rp {{ number_format($billing->amount + $billing->fine_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <p class="text-[10px] text-stone-400 leading-relaxed max-w-xs mx-auto mb-6">
            Sistem PropVerse menjamin data kuitansi di atas adalah valid, sah, serta diterbitkan secara resmi oleh pihak pengelola kawasan properti.
        </p>

        {{-- Branding Footer --}}
        <div class="border-t border-stone-100 pt-6">
            <a href="/" class="playfair text-xl font-bold text-[#b75c1c]">
                Prop<span class="text-[#3e342f]">Verse</span>
            </a>
            <span class="block text-[8px] font-bold text-stone-400 uppercase tracking-widest mt-1">Integrated Micro-ERP & Property Management</span>
        </div>
    </div>

</body>
</html>
