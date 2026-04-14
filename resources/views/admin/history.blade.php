<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Parkir Selesai</h2>
        
    </x-slot>

    {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            

            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                {{-- Tombol Hapus Semua --}}
            @if($histories->count() > 0)
                <form action="{{ route('admin.history.destroyAll') }}" method="POST" onsubmit="return confirm('Hapus semua riwayat permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-200 transition">
                        Bersihkan Semua Riwayat
                    </button>
                </form>
            @endif

            <div class="md:hidden space-y-4">
    @forelse($histories as $h)
        @php
            $entry = \Carbon\Carbon::parse($h->entry_time);
            $exit = \Carbon\Carbon::parse($h->exit_time);
            $duration = $entry->diffForHumans($exit, true);
        @endphp

        <div class="bg-white p-4 rounded-xl shadow border">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-lg uppercase">
                    {{ $h->plate_number }}
                </h3>

                <span class="text-xs px-2 py-1 bg-slate-100 rounded-full">
                    {{ $h->vehicle->name }}
                </span>
            </div>

            <p class="text-sm text-gray-500">
                Durasi: {{ $duration }}
            </p>

            <div class="text-xs mt-2">
                <p class="text-gray-500">In: {{ $h->entry_time }}</p>
                <p class="text-red-400">Out: {{ $h->exit_time }}</p>
            </div>

            <div class="flex justify-between items-center mt-3">
                <span class="font-bold text-orange-600">
                    Rp {{ number_format($h->total_price, 0, ',', '.') }}
                </span>

                <form action="{{ route('admin.history.destroy', $h->id) }}" method="POST"
                      onsubmit="return confirm('Hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-400">Belum ada riwayat.</p>
    @endforelse
</div>
               <div class="hidden md:block overflow-x-auto">
    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="pb-4 px-4 font-medium">Plat Nomor</th>
                                <th class="pb-4 px-4 font-medium">Jenis</th>
                                <th class="pb-4 px-4 font-medium">Durasi</th>
                                <th class="pb-4 px-4 font-medium">Masuk - Keluar</th>
                                <th class="pb-4 px-4 font-medium text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($histories as $h)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4 font-bold text-gray-700 uppercase">{{ $h->plate_number }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold">
                                        {{ $h->vehicle->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">
                                    @php
                                        $entry = \Carbon\Carbon::parse($h->entry_time);
                                        $exit = \Carbon\Carbon::parse($h->exit_time);
                                        echo $entry->diffForHumans($exit, true);
                                    @endphp
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-xs text-gray-500">In: {{ $h->entry_time }}</div>
                                    <div class="text-xs text-red-400">Out: {{ $h->exit_time }}</div>
                                </td>
                                <td class="py-4 px-4 text-right font-bold text-orange-600">
                                    Rp {{ number_format($h->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    {{-- Tombol Hapus Per Baris --}}
                                    <form action="{{ route('admin.history.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400 italic">Belum ada riwayat transaksi selesai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>