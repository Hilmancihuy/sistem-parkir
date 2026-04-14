<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Kendaraan Parkir</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $totalParkir }}</h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

               <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Slot Tersedia</p>
                        {{-- Menghitung total sisa slot dari collection $areas --}}
                        <h3 class="text-3xl font-bold text-green-600">
                            {{ $areas->sum(fn($a) => $a->capacity - $a->used) }}
                        </h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Pendapatan Hari Ini</p>
                            <h3 class="text-3xl font-bold text-blue-600">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

           <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    @foreach($areas as $area)
        @php
            // Hitung persentase agar bar bisa berjalan
            $percentage = $area->capacity > 0 ? ($area->used / $area->capacity) * 100 : 0;
            $colorClass = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-orange-500' : 'bg-green-500');
        @endphp

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-gray-500 text-sm uppercase font-bold">Area {{ $area->type }}</h4>
                <span class="text-sm font-bold {{ str_replace('bg-', 'text-', $colorClass) }}">
                    {{ number_format($percentage, 0) }}% Terisi
                </span>
            </div>
            
            <div class="w-full bg-gray-100 rounded-full h-4">
                <div class="{{ $colorClass }} h-4 rounded-full transition-all duration-1000" 
                     style="width: {{ $percentage }}%"></div>
            </div>
            
            <div class="flex justify-between mt-2 text-xs text-gray-400">
                <span>Terisi: {{ $area->used }}</span>
                <span>Kapasitas: {{ $area->capacity }}</span>
            </div>
        </div>
    @endforeach
</div>

            {{-- Tabel Aktivitas Terakhir --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-700">Aktivitas Parkir Terakhir</h3>
    </div>

    {{-- Tambahkan div overflow-x-auto agar tabel tetap rapi di layar HP --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-600 text-sm">
                <tr>
                    <th class="p-4">Plat Nomor</th>
                    <th class="p-4">Jenis</th>
                    <th class="p-4">Slot</th>
                    <th class="p-4">Waktu Masuk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentParkings as $parking)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-xl font-bold uppercase text-gray-800">
                        {{ $parking->plate_number ?? 'N/A' }}
                    </td>
                    <td class="p-4 text-gray-600">
                        {{ $parking->vehicle->name ?? 'N/A' }}
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ ($parking->slot->type ?? '') == 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            Area {{ $parking->slot->type ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-500 text-sm">
                        {{ \Carbon\Carbon::parse($parking->entry_time)->format('H:i') }} WIB
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-400 italic">Belum ada aktivitas parkir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bagian Navigasi Paging --}}
    <div class="p-4 bg-gray-50 border-t border-gray-100">
        {{ $recentParkings->links() }}
    </div>
</div>
        </div>
    </div>
</x-app-layout>