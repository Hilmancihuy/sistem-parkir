<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kendaraan Keluar</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


        <div class="mb-6">
                <form action="{{ route('admin.keluar') }}" method="GET" 
      class="flex flex-col md:flex-row gap-2">
    <input type="text" name="search" value="{{ request('search') }}" 
        placeholder="Cari Plat Nomor (Contoh: B 1234...)" 
        class="w-full md:w-1/3 rounded-xl border-gray-300 focus:ring-orange-500 uppercase font-bold">

    <div class="flex gap-2">
        <button type="submit" class="w-full md:w-auto bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-900 transition flex items-center justify-center">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.keluar') }}" 
               class="w-full md:w-auto bg-gray-200 text-gray-700 px-6 py-2 rounded-xl hover:bg-gray-300 transition text-center">
                Reset
            </a>
        @endif
    </div>
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

            <div class="md:hidden space-y-4">
    @forelse($parkings as $p)
        @php
            $entry = \Carbon\Carbon::parse($p->entry_time);
            $hours = (int) $entry->diffInHours(now());
            $basePrice = $p->vehicle->price ?? 0;
            $currentBill = $basePrice + ($hours * 1000);
        @endphp

        <div class="bg-white p-4 rounded-xl shadow border">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-lg">{{ $p->plate_number }}</h3>
                <span class="text-xs px-2 py-1 rounded-full 
                    {{ ($p->slot->type ?? '') == 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                    {{ $p->slot->type ?? 'N/A' }}
                </span>
            </div>

            <p class="text-sm text-gray-500">
                {{ $p->vehicle->name ?? 'N/A' }}
            </p>

            <p class="text-sm mt-1">
                Masuk: {{ \Carbon\Carbon::parse($p->entry_time)->format('H:i') }} WIB
            </p>

            <p class="text-xs text-orange-500 mb-2">
                Durasi: {{ $hours }} Jam
            </p>

            <div class="flex justify-between items-center">
                <span class="font-bold text-blue-700">
                    Rp {{ number_format($currentBill, 0, ',', '.') }}
                </span>

                <form action="{{ route('admin.keluar.update', $p->id) }}" method="POST"
                      onsubmit="return confirm('Konfirmasi Pembayaran Rp {{ number_format($currentBill, 0, ',', '.') }}?')">
                    @csrf
                    @method('PATCH')
                    <button class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs">
                        Bayar
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-400">Tidak ada kendaraan.</p>
    @endforelse
</div>
                <div class="hidden md:block overflow-x-auto">
                    
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
                    {{-- Plat Nomor --}}
                    <td class="p-4 font-bold uppercase text-lg text-gray-800">
                        {{ $p->plate_number }}
                    </td>

                    {{-- Jenis Kendaraan --}}
                    <td class="p-4 text-gray-600">
                        {{ $p->vehicle->name ?? 'N/A' }}
                    </td>

                    {{-- Menampilkan Area Slot --}}
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ ($p->slot->type ?? '') == 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            Area {{ $p->slot->type ?? 'N/A' }}
                        </span>
                    </td>

                    {{-- Waktu Masuk (Menggunakan entry_time sesuai database Anda) --}}
                    <td class="p-4 text-sm text-gray-500">
                        <div class="font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($p->entry_time)->format('H:i') }} WIB
                        </div>
                        <span class="text-xs text-orange-500 font-medium">
                            Durasi: {{ \Carbon\Carbon::parse($p->entry_time)->diffInHours(now()) }} Jam
                        </span>
                    </td>

                    {{-- Aksi & Hitung Tarif --}}
                    <td class="p-4">
                        @php
                            $entry = \Carbon\Carbon::parse($p->entry_time);
                            $now = now();
                            $hours = (int) $entry->diffInHours($now);
                            
                            // Tarif: Harga dasar + (jam tambahan * 1000)
                            $basePrice = $p->vehicle->price ?? 0;
                            $currentBill = $basePrice + ($hours * 1000);
                        @endphp

                        <form action="{{ route('admin.keluar.update', $p->id) }}" method="POST" class="form-bayar">
                            @csrf
                            @method('PATCH')
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-blue-700">
                                    Rp {{ number_format($currentBill, 0, ',', '.') }}
                                </span>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-bold shadow-md transition w-full text-xs uppercase">
                                    BAYAR & KELUAR
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-400 italic">Tidak ada kendaraan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.querySelectorAll('.form-bayar').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let harga = this.querySelector('span')?.innerText || 'Total';

        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: `Bayar ${harga}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Bayar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>