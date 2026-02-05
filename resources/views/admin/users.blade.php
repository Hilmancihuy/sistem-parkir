<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Petugas</h2>
    </x-slot>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl">
        {{ session('success') }}
    </div>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-fit">
                    <h3 class="font-bold text-gray-700 mb-4">Tambah Petugas Baru</h3>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" required class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required class="w-full rounded-xl border-gray-300 focus:ring-orange-500">
                        </div>
                        <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-xl font-bold hover:bg-orange-600 transition">
                            Simpan Akun
                        </button>
                    </form>
                </div>

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
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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
</x-app-layout>