<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-slate-100">
        
        {{-- Sidebar --}}
        @include('layouts.navigation')

        {{-- Main Content --}}
       <main class="md:ml-64 flex-1 transition-all duration-300">
    {{ $slot }}
</main>

    </div>
</body>
</html>
