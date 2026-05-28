<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h2 class="playfair font-bold text-4xl text-[#3e342f] leading-none tracking-tight">
                        Pengaturan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Profil</span>
                    </h2>
                    <p class="text-[10px] font-bold text-stone-500 uppercase tracking-[0.1em] mt-1">Kelola data personal dan keamanan akun Anda</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-2 md:px-6">
        <div class="max-w-7xl mx-auto space-y-12">
            
            <div class="grid gap-12">
                <div class="bg-white p-8 md:p-12 rounded-[2rem] border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-white p-8 md:p-12 rounded-[2rem] border border-[rgba(183,92,28,0.1)] shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-rose-50 p-8 md:p-12 rounded-[2rem] border border-rose-100 shadow-[0_4px_20px_rgba(244,63,94,0.03)]">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style> .playfair { font-family: 'Playfair Display', serif; } </style>
</x-app-layout>
