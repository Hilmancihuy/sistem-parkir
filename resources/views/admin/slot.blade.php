<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kapasitas Area Parkir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian Statistik / Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($slots as $slot)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Area {{ $slot->type }}</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $slot->used }} / {{ $slot->capacity }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Kendaraan Terisi</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-xl text-orange-600">
                            @if($slot->type == 'motor')
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2zM5 13h14"/></svg>
                            @endif
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                   @php
    // Proteksi: Jika capacity 0, maka percentage 0. Jika tidak, lakukan pembagian.
    $percentage = $slot->capacity > 0 ? ($slot->used / $slot->capacity) * 100 : 0;
    
    $color = $percentage > 90 ? 'bg-red-500' : ($percentage > 70 ? 'bg-orange-500' : 'bg-green-500');
@endphp
                    <div class="w-full bg-gray-100 rounded-full h-3 mb-6">
                        <div class="{{ $color }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>

                    {{-- Form Update Kapasitas --}}
                    <form action="{{ route('admin.slot.update', $slot->id) }}" method="POST" class="flex items-end gap-2">
                        @csrf
                        @method('PUT')
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-400 mb-1">Ubah Total Kapasitas</label>
                            <input type="number" name="capacity" value="{{ $slot->capacity }}" class="w-full border-gray-200 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-900 transition">
                            Simpan
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Pesan Peringatan --}}
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Sistem akan otomatis menghalangi registrasi kendaraan masuk jika <strong>Jumlah Terisi</strong> sudah mencapai <strong>Kapasitas</strong>.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>