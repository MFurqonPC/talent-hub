<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'University Talent Hub') }}</title>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root { --font-display: 'Sora', ui-sans-serif, sans-serif; --font-body: 'Inter', ui-sans-serif, sans-serif; }
            body { font-family: var(--font-body); }
            .uth-display { font-family: var(--font-display); letter-spacing: -0.02em; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @if (isset($header))
                <header class="bg-white border-b border-slate-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
