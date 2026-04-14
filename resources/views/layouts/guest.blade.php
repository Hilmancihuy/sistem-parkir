<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .guest-bg {
                background-color: #f1f0eb;
            }

            .logo-wrapper {
                width: 56px;
                height: 56px;
                background: linear-gradient(135deg, #f97316, #ea580c);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
            }

            .logo-label {
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 0.08em;
                color: #ea580c;
                margin-top: 6px;
            }

            .card {
                background: #ffffff;
                border: 0.5px solid rgba(0, 0, 0, 0.08);
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #111827;
                margin-bottom: 4px;
            }

            .card-subtitle {
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 1.5rem;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased guest-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <!-- Logo -->
            <div class="flex flex-col items-center mb-6">
                <div class="logo-wrapper">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <p class="logo-label">{{ strtoupper(config('app.name', 'Laravel')) }}</p>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md px-4 sm:px-0">
                <div class="card">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>