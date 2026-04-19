<x-guest-layout>
    {{-- Bagian Header & Logo --}}
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-4 bg-orange-500 rounded-full shadow-xl mb-6">
           <img src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="w-12 h-12 object-contain">
        </div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Login</h2>
        <p class="text-slate-500 text-sm mt-2">Selamat datang kembali! Silakan masuk.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all duration-200 text-slate-700 placeholder-slate-400">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500 transition-all duration-200 text-slate-700"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 uppercase tracking-widest text-sm">
                Masuk Sekarang
            </button>
        </div>

        {{-- Lupa Password (Optional) --}}
        @if (Route::has('password.request'))
           
        @endif
    </form>
</x-guest-layout>