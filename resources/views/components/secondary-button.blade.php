<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-10 py-5 bg-white border border-slate-200 rounded-[2rem] font-black text-[10px] text-slate-600 uppercase tracking-[0.2em] shadow-xl shadow-slate-200/50 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-600 hover:-translate-y-1 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-amber-500/10 transition-all']) }}>
    {{ $slot }}
</button>
