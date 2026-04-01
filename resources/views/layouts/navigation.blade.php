<div x-data="{ open: false }">
    <div class="fixed top-0 left-0 z-50 md:hidden p-4">
        <button @click="open = !open" class="p-2 bg-slate-800 text-white rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!open">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="open" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="open" 
         x-transition:enter="transition opacity-ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition opacity-ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false" 
         class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-sm">
    </div>

    <aside 
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="w-64 bg-black text-white h-screen fixed top-0 left-0 z-50 shadow-2xl overflow-y-auto transition-transform duration-300 md:translate-x-0">

        <div class="p-6 border-b border-slate-700/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2.5 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold tracking-tight">Sistem Parkir</h1>
                        <p class="text-xs text-slate-400">Management</p>
                    </div>
                </div>
                <button @click="open = false" class="md:hidden text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                </button>
            </div>
        </div>

        <div class="p-6 border-b border-slate-700/50 bg-slate-800/50">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-full shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-slate-900 rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-2">
            @role('admin')
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/30' : 'hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.report') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Laporan</span>
            </a>
            @endrole

            @role('petugas')
            <a href="{{ route('petugas.dashboard') }}" 
               class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('petugas.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/30' : 'hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('petugas.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            @endrole

            @hasanyrole('admin|petugas')
            @php
                $routeMasuk = Auth::user()->hasRole('admin') ? route('admin.masuk') : route('petugas.masuk');
                $routeKeluar = Auth::user()->hasRole('admin') ? route('admin.keluar') : route('petugas.keluar');
                $routeHistory = Auth::user()->hasRole('admin') ? route('admin.history') : route('petugas.history');
            @endphp

            <a href="{{ $routeMasuk }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Masuk</span>
            </a>

            <a href="{{ $routeKeluar }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Keluar</span>
            </a>

            <a href="{{ $routeHistory }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Riwayat</span>
            </a>
            @endhasanyrole

            @role('admin')
            <div class="pt-4 mt-2 border-t border-slate-700/30">
                <a href="{{ route('admin.slot') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium text-sm text-slate-300 group-hover:text-white">Slot Parkir</span>
                </a>

                <a href="{{ route('admin.users') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span class="font-medium text-sm text-slate-300 group-hover:text-white">Petugas</span>
                </a>
            </div>
            @endrole
        </nav>

        <div class="sticky bottom-0 w-full p-4 border-t border-slate-700/50 bg-slate-900 shadow-[0_-4px_10px_rgba(0,0,0,0.3)]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="group flex items-center space-x-3 w-full px-4 py-3 rounded-xl transition-all duration-200 hover:bg-red-500/10 border border-transparent hover:border-red-500/30">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium text-sm text-slate-300 group-hover:text-red-500 transition-colors">Logout</span>
                </button>
            </form>
        </div>
    </aside>
</div>