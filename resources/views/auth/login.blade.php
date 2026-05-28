<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-[#fdfbf7]">
        
        <div class="w-full max-w-sm flex flex-col items-center">
            {{-- Logo --}}
            <div class="w-20 h-20 bg-[#3e342f] rounded-[1.25rem] flex items-center justify-center mb-4 shadow-xl">
                <svg class="w-10 h-10 text-[#b75c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            
            <h1 class="playfair text-3xl font-bold text-[#3e342f] mb-1">RaanyProp</h1>
            <p class="text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-10">by RaanyVerse</p>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="w-full space-y-5">
                @csrf
                
                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-bold text-stone-500 uppercase tracking-widest ml-1">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full rounded-2xl py-3.5 px-5 bg-white border border-stone-200 text-[#3e342f] font-semibold text-sm focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all"
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <label for="password" class="text-[10px] font-bold text-stone-500 uppercase tracking-widest ml-1">Kata Sandi</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-2xl py-3.5 px-5 bg-white border border-stone-200 text-[#3e342f] font-semibold text-sm focus:outline-none focus:border-[#b75c1c] focus:ring-1 focus:ring-[#b75c1c] transition-all"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                </div>

                <div class="flex justify-end pt-1">
                    <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-stone-400 hover:text-[#b75c1c] transition-all tracking-wide">Lupa Kata Sandi?</a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full py-4 mt-4 rounded-2xl font-bold text-sm text-white transition-all hover:opacity-90 shadow-lg shadow-[rgba(183,92,28,0.25)]"
                    style="background: #b75c1c;">
                    Masuk
                </button>
            </form>
            
            <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mt-12">v1.0 - RaanyVerse</p>
        </div>
    </div>

    <style>
        .outfit { font-family: 'Outfit', sans-serif; }
        .playfair { font-family: 'Playfair Display', serif; }
        .inter { font-family: 'Inter', sans-serif; }
    </style>
</x-guest-layout>
