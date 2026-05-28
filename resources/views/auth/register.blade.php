<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-6 md:p-10 relative overflow-hidden" style="background:#130f0c;">
        {{-- Grid pattern --}}
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(217,119,6,0.4) 1px, transparent 1px), linear-gradient(90deg, rgba(217,119,6,0.4) 1px, transparent 1px); background-size: 60px 60px;"></div>
        {{-- Glow blobs --}}
        <div class="absolute top-0 left-0 w-96 h-96 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(217,119,6,0.08) 0%, transparent 70%);"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(217,119,6,0.06) 0%, transparent 70%);"></div>

        <div class="max-w-7xl w-full flex flex-col lg:flex-row rounded-[2.5rem] overflow-hidden relative z-10 shadow-[0_40px_80px_rgba(0,0,0,0.4)]" style="border: 1px solid rgba(217,119,6,0.15);">
            
            {{-- Brand Side --}}
            <div class="lg:w-3/5 p-12 md:p-24 flex flex-col justify-between relative overflow-hidden border-r border-white/5" style="background: linear-gradient(135deg, rgba(217,119,6,0.04) 0%, rgba(19,15,12,0.95) 100%);">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-16">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-2xl" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); box-shadow: 0 8px 20px rgba(217,119,6,0.35);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="outfit text-3xl font-black text-white tracking-tighter">Raanyverse <span class="gradient-text">Property</span></span>
                    </div>
                   
                    <h1 class="outfit text-6xl md:text-8xl font-black text-white mb-8 tracking-tighter leading-[0.85]">Ekosistem<br/><span class="gradient-text">Baru.</span></h1>
                    <p class="text-stone-400 text-xl font-medium leading-relaxed max-w-md opacity-80">Bergabunglah dengan standar baru pengelolaan properti elit. Profesionalisme dimulai dari langkah pertama Anda.</p>
                </div>

                <div class="flex items-center gap-6 mt-20 relative z-10">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-amber-500" style="background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.15);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-2.107-7.705c-1.015-1.124-1.638-2.607-1.638-4.237a7 7 0 0114 0c0 1.63-.623 3.113-1.638 4.237m-2.107 7.705A8.962 8.962 0 0112 21c-4.478 0-8.268-3.255-9.131-7.536m2.107-7.705L7 11V7a5 5 0 0110 0v4l.036.036m0 0L20 14m-12 0l-3-3m15 3l3-3"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] mb-1">Standar Keamanan</p>
                        <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">Protokol Akses Terenkripsi</p>
                    </div>
                </div>
            </div>

            {{-- Form Side --}}
            <div class="lg:w-2/5 p-12 md:p-20 bg-[#130f0c]/98 backdrop-blur-3xl flex flex-col justify-center">
                <div class="mb-12">
                    <h2 class="outfit text-3xl font-black text-white mb-2">Daftar Akun Baru</h2>
                    <p class="text-stone-500 font-bold text-xs uppercase tracking-widest">Buat kredensial Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] ml-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-stone-700" placeholder="Nama Anda">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] ml-1">Email Pengguna</label>
                        <input id="email" type="email" name="email" :value="old('email')" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-stone-700" placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <label for="role" class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] ml-1">Daftar Sebagai</label>
                        <select id="role" name="role" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all">
                            <option value="tenant" class="bg-stone-900 text-white">Penghuni Properti (Mencari Properti)</option>
                            <option value="owner" class="bg-stone-900 text-white">Pemilik Properti (Mengelola Properti)</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="password" class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] ml-1">Kata Sandi</label>
                            <input id="password" type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-stone-700" placeholder="••••••••">
                        </div>
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[10px] font-black text-stone-500 uppercase tracking-[0.3em] ml-1">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 transition-all placeholder-stone-700" placeholder="••••••••">
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <button class="w-full py-5 text-white rounded-2xl font-black text-xs tracking-widest uppercase shadow-2xl transition-all hover:-translate-y-1 btn-primary" style="box-shadow: 0 8px 25px rgba(217,119,6,0.35);">
                        Selesaikan Pendaftaran
                    </button>

                    <div class="text-center">
                        <p class="text-[10px] font-black text-stone-600 uppercase tracking-widest leading-loose">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-amber-500 hover:text-white transition-all font-black">Masuk Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .outfit { font-family: 'Outfit', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-primary { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); }
    </style>
</x-guest-layout>
