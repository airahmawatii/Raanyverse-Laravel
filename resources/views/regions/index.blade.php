<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 w-full">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" class="text-[#b75c1c] block text-[10px] font-black uppercase tracking-[0.3em] mb-2">Manajemen Wilayah</span>
                <h2 class="outfit font-black text-4xl text-[#3e342f] leading-none tracking-tight">Data Daerah / Region</h2>
            </div>
            <a href="{{ route('regions.create') }}" class="flex items-center gap-2 px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase text-white transition-all hover:-translate-y-1"
               style="background: linear-gradient(135deg, #d97706 0%, #92400e 100%); box-shadow: 0 8px 20px rgba(183,92,28,0.3);">
                Tambah Daerah
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-2">
        <div class="max-w-7xl mx-auto">
            <div class="rounded-[2rem] overflow-hidden  bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)] border border-[rgba(183,92,28,0.1)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[rgba(183,92,28,0.1)] bg-[#fdfbf7]">
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest">Nama Daerah</th>
                                <th class="px-8 py-6 text-[10px] font-black text-stone-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($regions as $region)
                            <tr class="transition duration-300 group hover:bg-white shadow-[0_4px_20px_rgba(62,52,47,0.03)]">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-base font-black text-[#3e342f] outfit">{{ $region->name }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('regions.edit', $region->id) }}" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-[rgba(183,92,28,0.1)] text-[#b75c1c] border border-[rgba(183,92,28,0.2)] hover:bg-[rgba(183,92,28,0.2)]">
                                            Edit
                                        </a>
                                        <form action="{{ route('regions.destroy', $region->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus daerah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100">
                                                Del
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2">
                                    <div class="text-center py-24 text-stone-500 font-black text-xs uppercase tracking-widest">Belum ada daerah.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
