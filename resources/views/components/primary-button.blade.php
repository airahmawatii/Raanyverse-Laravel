<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-10 py-5 bg-amber-600 border border-amber-500/50 rounded-[2rem] font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-amber-500 hover:-translate-y-1 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-amber-500/20 transition-all shadow-2xl shadow-amber-500/20']) }}>
    {{ $slot }}
</button>
