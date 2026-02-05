<aside class="w-64 bg-black text-white h-screen fixed z-50 shadow-2xl overflow-y-auto">

    <!-- Header / Brand -->
    <div class="p-6 border-b border-slate-700/50">
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
    </div>

    <!-- User Profile -->
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

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2"> {{-- Gunakan space-y-2 untuk jarak antar menu yang konsisten --}}
    
    <a href="{{ route('admin.dashboard') }}" 
       class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/30' : 'hover:bg-slate-700/50' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
        </svg>
        <span class="font-medium text-sm">Dashboard</span>
    </a>

    <a href="{{ route('admin.masuk') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Kendaraan Masuk</span>
    </a>

    <a href="{{ route('admin.keluar') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
        <svg class="w-5 h-5 text-slate-400 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Kendaraan Keluar</span>
    </a>

    <a href="{{ route('admin.history') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.history') ? 'bg-slate-700/50' : 'hover:bg-slate-700/50' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.history') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Riwayat Parkir</span>
    </a>

    <a href="{{ route('admin.report') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
        <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Laporan Pendapatan</span>
    </a>

    <a href="{{ route('admin.slot') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50 border-t border-slate-700/30 mt-2 pt-4">
        <svg class="w-5 h-5 text-slate-400 group-hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Slot Parkir</span>
    </a>

    <a href="{{ route('admin.users') }}" class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-700/50">
        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
        </svg>
        <span class="font-medium text-sm text-slate-300 group-hover:text-white transition-colors">Kelola Petugas</span>
    </a>
</nav>

    <!-- Logout Section -->
    <div class="absolute bottom-0 w-64 p-4 border-t border-slate-700/50 bg-slate-900/50 backdrop-blur-sm">
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