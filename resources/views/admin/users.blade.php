<x-app-layout>
    {{-- Inisialisasi Alpine.js untuk Modal --}}
    <div x-data="{ openEditModal: false, currentUser: {} }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Petugas</h2>
        </x-slot>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Form Tambah (Kiri) --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-fit">
                        <h3 class="font-bold text-gray-700 mb-4">Tambah Petugas Baru</h3>
                        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" required 
            class="w-full px-4 py-3 text-base rounded-xl border-gray-300 focus:ring-orange-500 focus:border-orange-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required 
            class="w-full px-4 py-3 text-base rounded-xl border-gray-300 focus:ring-orange-500 focus:border-orange-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required 
            class="w-full px-4 py-3 text-base rounded-xl border-gray-300 focus:ring-orange-500 focus:border-orange-500">
    </div>

    <button type="submit" 
        class="w-full bg-orange-500 text-white py-3 rounded-xl font-bold text-base hover:bg-orange-600 transition">
        Simpan Akun
    </button>
</form>
                    </div>

                    {{-- Tabel Petugas (Kanan) --}}
                    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                                <tr>
                                    <th class="p-4">Nama</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 font-medium text-gray-700">{{ $user->name }}</td>
                                    <td class="p-4 text-gray-500">{{ $user->email }}</td>
                                    <td class="p-4 flex justify-center gap-3">
                                        {{-- Tombol Edit --}}
                                        <button @click="openEditModal = true; currentUser = {{ json_encode($user) }}" 
                                                class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Tombol Hapus dengan SweetAlert --}}
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')"
                                                        class="text-red-500 hover:text-red-700 transition">
                                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT PETUGAS --}}
        <div x-show="openEditModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
             x-cloak>
            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl" @click.away="openEditModal = false">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Edit Data Petugas</h2>
                
                <form :action="'/admin/users/' + currentUser.id" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" x-model="currentUser.name" required 
                                   class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" x-model="currentUser.email" required 
                                   class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Kosongkan jika tidak diganti)</label>
                            <input type="password" name="password" 
                                   class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" @click="openEditModal = false" class="text-gray-500 font-medium">Batal</button>
                        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-orange-600 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CSS untuk x-cloak agar modal tidak kedip saat refresh --}}
    <style> [x-cloak] { display: none ! immigrant; } </style>

    <script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Petugas?',
            text: "Akun " + name + " akan dihapus permanen dan tidak bisa login lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316', // Warna orange sesuai tema Anda
            cancelButtonColor: '#64748b', // Warna slate
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            borderRadius: '1.5rem'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika user klik Ya
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
</x-app-layout>