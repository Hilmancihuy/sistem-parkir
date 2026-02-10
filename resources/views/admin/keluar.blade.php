<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kendaraan Keluar</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


        <div class="mb-6">
                <form action="{{ route('admin.keluar') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari Plat Nomor (Contoh: B 1234...)" 
                        class="w-full md:w-1/3 rounded-xl border-gray-300 focus:ring-orange-500 uppercase font-bold">
                    <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-900 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.keluar') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-xl hover:bg-gray-300 transition flex items-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

        {{-- Notifikasi Berhasil --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center justify-between animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold">Transaksi Berhasil!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                </div>
            @endif


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                                <th class="p-4">Plat Nomor</th>
                                <th class="p-4">Jenis</th>
                                <th class="p-4">Slot</th>
                                <th class="p-4">Waktu Masuk</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($parkings as $p)
                           <tr class="hover:bg-gray-50 transition">
    <td class="p-4 font-bold uppercase text-lg text-gray-800">{{ $p->plate_number }}</td>
    <td class="p-4 text-gray-600">{{ $p->vehicle->name }}</td>
    <td class="p-4 text-sm text-gray-500">
        {{ $p->entry_time }}<br>
        <span class="text-xs text-orange-500 font-medium">
            Durasi: {{ \Carbon\Carbon::parse($p->entry_time)->diffInHours(now()) }} Jam
        </span>
    </td>
    <td class="p-4 text-center">
        @php
    $entry = \Carbon\Carbon::parse($p->entry_time);
    $now = now();
    
    // Hitung jam bulat untuk estimasi tarif di layar
    $hours = (int) $entry->diffInHours($now);
    $currentBill = $p->vehicle->price + ($hours * 1000);
@endphp


        
        <form action="{{ route('admin.keluar.update', $p->id) }}" method="POST" 
              onsubmit="return confirm('Konfirmasi Pembayaran Rp {{ number_format($currentBill, 0, ',', '.') }}?')">
            @csrf
            @method('PATCH')
            <div class="flex flex-col items-center gap-1">
                <span class="text-sm font-bold text-blue-700">
                    Rp {{ number_format($currentBill, 0, ',', '.') }}
                </span>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl font-bold shadow-md transition w-full">
                    BAYAR & KELUAR
                </button>
            </div>
        </form>
    </td>
</tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 italic">Tidak ada kendaraan yang sedang parkir.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>