<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'University Talent Hub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">
        {{-- Kiri: branding panel (disembunyikan di mobile) --}}
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 text-white flex-col justify-between p-10 lg:p-16">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center text-white">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                    </svg>
                </div>
                <span class="font-semibold text-lg">University Talent Hub</span>
            </div>

            <div class="space-y-4">
                <h1 class="text-3xl lg:text-4xl font-bold leading-tight">
                    Petakan, Kembangkan, dan<br class="hidden lg:block"> Tampilkan Talentamu.
                </h1>
                <p class="text-indigo-100 text-sm lg:text-base max-w-md">
                    Satu platform untuk mengelola skill, sertifikat, dan portofolio mahasiswa —
                    lengkap dengan sistem poin, leaderboard, dan rekomendasi opportunity berbasis AI.
                </p>
            </div>

            <p class="text-indigo-200 text-xs">&copy; {{ date('Y') }} University Talent Hub. All rights reserved.</p>
        </div>

        {{-- Kanan: form auth --}}
        <div class="flex-1 flex flex-col items-center justify-center bg-gray-50 p-6 sm:p-10">
            <div class="md:hidden flex items-center gap-2 mb-8">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                    </svg>
                </div>
                <span class="font-semibold text-gray-800">University Talent Hub</span>
            </div>

            <div class="w-full sm:max-w-md bg-white shadow-lg rounded-2xl p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
