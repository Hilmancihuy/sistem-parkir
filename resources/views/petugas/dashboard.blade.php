<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Utama
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
                <h4 class="text-gray-500 text-sm font-medium uppercase font-bold">Area {{ $area->type }}</h4>
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
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700">Aktivitas Parkir Terakhir</h3>
                </div>
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
    @foreach($recentParkings as $parking)
    <tr class="hover:bg-gray-50 transition">
        {{-- Menampilkan Plat Nomor --}}
        <td class="p-4 text-xl font-bold uppercase text-gray-800">{{ $parking->plate_number ?? 'N/A' }}</td>
        
        {{-- Menampilkan Nama Kendaraan --}}
        <td class="p-4 text-gray-600">{{ $parking->vehicle->name ?? 'N/A' }}</td>
        
        {{-- MENGUBAH SLOT CODE MENJADI AREA TYPE --}}
        <td class="p-4">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $parking->slot->type == 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                Area {{ $parking->slot->type ?? 'N/A' }}
            </span>
        </td>
        
        {{-- Menampilkan Jam Masuk --}}
        <td class="p-4 text-gray-500 text-sm">
            {{ \Carbon\Carbon::parse($parking->entry_time)->format('H:i') }} WIB
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>