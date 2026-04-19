<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <script src="https://cdn.tailwindcss.com"></script>
        <title>{{ config('app.name', 'SmartPark') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900">
        {{-- Background dengan gradasi warna gelap dan orange --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#e2e1e1]">
            
            {{-- Elemen dekoratif cahaya di background --}}
            <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-orange-600/10 blur-[120px]"></div>
                <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-600/10 blur-[120px]"></div>
            </div>

            <div class="w-full sm:max-w-md px-6 py-4 relative z-10">
                {{-- Kartu Login dengan efek Glassmorphism --}}
                <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100">
                    <div class="p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>

                {{-- Footer Kecil --}}
                <p class="text-center mt-8 text-slate-500 text-xs font-medium tracking-widest uppercase">
                    &copy; {{ date('Y') }} SmartPark Management System
                </p>
            </div>
        </div>
    </body>
</html>