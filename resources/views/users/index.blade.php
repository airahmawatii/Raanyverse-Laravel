<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <h2 class="outfit text-3xl font-black text-[#3e342f]">Kelola <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b75c1c] to-[#a65319]">Pengguna</span></h2>
                <p class="text-xs font-bold text-stone-500 uppercase tracking-widest mt-1">Manajemen Akun Pemilik & Penghuni</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-6">
            
            @if(session('success'))
            <div class="px-6 py-4 rounded-2xl bg-[rgba(183,92,28,0.1)] border border-[rgba(183,92,28,0.2)] text-[#b75c1c] text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)] rounded-[2.5rem] overflow-hidden ">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(183,92,28,0.1)] bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Pengguna</th>
                                <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Role</th>
                                <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest">Bergabung Pada</th>
                                <th class="px-8 py-5 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($users as $user)
                            <tr class="hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-[#b75c1c] font-black">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[#3e342f]">{{ $user->name }}</p>
                                            <p class="text-xs text-stone-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                        {{ $user->role === 'owner' ? 'bg-sky-500/20 text-sky-400' : 'bg-lime-500/20 text-lime-400' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                        @if($user->status === 'approved') bg-amber-500/20 text-[#b75c1c] 
                                        @elseif($user->status === 'pending') bg-yellow-500/20 text-yellow-400 
                                        @elseif($user->status === 'rejected') bg-red-500/20 text-rose-600 
                                        @else bg-slate-500/20 text-stone-500 @endif">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-stone-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        @if($user->role === 'owner' && $user->status === 'pending')
                                            <form action="{{ route('users.approve', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-xl bg-[rgba(183,92,28,0.1)] text-[#b75c1c] hover:bg-[rgba(183,92,28,0.2)] transition-all title='Setujui Pendaftaran'">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('users.reject', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-xl bg-orange-500/10 text-orange-400 hover:bg-orange-500/20 transition-all title='Tolak Pendaftaran'">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait (booking, tagihan) mungkin ikut terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition-all" title="Hapus Pengguna">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center">
                                    <p class="text-stone-500 font-bold italic">Belum ada pengguna terdaftar.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="px-8 py-5 border-t border-white/5 bg-white/2">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
