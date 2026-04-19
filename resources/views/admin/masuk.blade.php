<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Kendaraan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <h3 class="text-lg font-bold text-gray-700 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Formulir Registrasi Parkir
                    </h3>

                    {{-- Notifikasi Sukses --}}
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm animate-pulse">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                            {{-- Notifikasi Gagal/Error Validasi --}}
                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-bold">Terjadi Kesalahan:</span>
                                    </div>
                                    <ul class="list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                    <form method="POST" action="{{ route('admin.masuk') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi (Plat)</label>
                                <input type="text" name="plate_number" id="plate_number" class="form-control" required 
                                    class="w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm text-xl font-bold uppercase"
                                    placeholder="Contoh: B 1234 ABC">
                            </div>  

                          <script>
    setInterval(function() {
        fetch('/api/get-plat-antrian')
            .then(response => response.json())
            .then(data => {
               if (data && data.plate_number) {
    // Isi plat nomor
    document.getElementById('plate_number').value = data.plate_number;
    
    // Pilih kategori otomatis berdasarkan data.type (mobil/motor)
    let selectKategori = document.querySelector('select[name="category_id"]');
    if (selectKategori && data.type) {
        for (let i = 0; i < selectKategori.options.length; i++) {
            // Mencari kata 'mobil' atau 'motor' di dalam pilihan dropdown
            if (selectKategori.options[i].text.toLowerCase().includes(data.type.toLowerCase())) {
                selectKategori.selectedIndex = i;
                break;
                            }
                        }
                    }

                    // 3. Otomatis Pilih Area Parkir
                    // Gunakan select[name="slot_id"] sesuai form Anda
                    let selectArea = document.querySelector('select[name="slot_id"]');
                    if (selectArea) {
                       if (selectArea && data.type) {
    for (let i = 0; i < selectArea.options.length; i++) {

        let text = selectArea.options[i].text.toLowerCase();

        if (data.type === 'mobil' && text.includes('mobil')) {
            selectArea.selectedIndex = i;
            break;
        }

        if (data.type === 'motor' && text.includes('motor')) {
            selectArea.selectedIndex = i;
            break;
        }
    }
}
                    }

                    console.log('Form otomatis terisi untuk: ' + data.plate_number);
                }
            })
            .catch(error => console.error('Error:', error));
    }, 2000); // Cek setiap 2 detik
</script>

                            <div>
                                <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori Kendaraan</label>
                                <select name="category_id" required class="w-full border-gray-300 rounded-md">
        <option value="">Pilih Jenis Kendaraan</option>
        @foreach($vehicles as $v)
            <option value="{{ $v->id }}">
                {{ $v->name }} - Rp {{ number_format($v->price, 0, ',', '.') }}
            </option>
        @endforeach
    </select>
                            </div>

<select name="slot_id" required class="w-full border-gray-300 rounded-md">
    <option value="">-- Pilih Area --</option>
    @foreach($areas as $a)
        <option value="{{ $a->id }}">
            Area {{ strtoupper($a->type) }} (Sisa: {{ $a->capacity - $a->used }} Slot)
        </option>
    @endforeach
</select>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                                Reset Form
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-lg shadow-lg shadow-orange-500/30 hover:from-orange-600 hover:to-orange-700 transition transform hover:-translate-y-1">
                                SIMPAN & CETAK KARCIS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>