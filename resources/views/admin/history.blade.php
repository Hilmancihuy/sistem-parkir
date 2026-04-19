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
                {{-- Hanya Admin yang bisa melihat tombol Bersihkan Semua --}}
                    @if(auth()->user()->hasRole('admin') && $histories->count() > 0)
                        <form action="{{ route('admin.history.destroyAll') }}" method="POST" id="deleteAllForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteAll()" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-200 transition">
                                Bersihkan Semua Riwayat
                            </button>
                        </form>
                    @endif
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
    @if(auth()->user()->hasRole('admin'))
        {{-- Tombol Hapus Satuan Hanya Muncul di Akun Admin --}}
        <form action="{{ route('admin.history.destroy', $h->id) }}" method="POST" id="deleteForm-{{ $h->id }}">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete('{{ $h->id }}', '{{ $h->plate_number }}')" class="text-red-500 text-sm font-semibold hover:underline">
                Hapus
            </button>
        </form>
    @else
        {{-- Jika Petugas, tampilkan label atau biarkan kosong --}}
        <span class="text-gray-400 text-xs">No Action</span>
    @endif
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400 italic">Belum ada riwayat transaksi selesai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6 px-4 pb-4">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Konfirmasi Hapus Satuan
    function confirmDelete(id, plate) {
        Swal.fire({
            title: 'Hapus Riwayat?',
            text: "Data parkir kendaraan " + plate + " akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Red-500
            cancelButtonColor: '#6b7280', // Gray-500
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        })
    }

    // Konfirmasi Hapus Semua
    function confirmDeleteAll() {
        Swal.fire({
            title: 'Bersihkan Semua Riwayat?',
            text: "Seluruh data transaksi yang sudah selesai akan dihapus permanen!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Bersihkan Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllForm').submit();
            }
        })
    }

    // Notifikasi Sukses (Jika ada session success)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>