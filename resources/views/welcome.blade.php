<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Talent Hub') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-white">

    {{-- Navbar sederhana --}}
    <nav class="border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                    </svg>
                </div>
                <span class="font-semibold text-gray-800">University Talent Hub</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg shadow-sm">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-gradient-to-b from-indigo-50 to-white">
        <div class="max-w-4xl mx-auto px-6 py-16 sm:py-24 text-center">
            <span class="inline-flex items-center gap-1.5 bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-5">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/>
                </svg>
                Platform Talenta Mahasiswa
            </span>
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-900 leading-tight">
                Petakan, Kembangkan, dan<br class="hidden sm:block">
                Tampilkan Talentamu.
            </h1>
            <p class="text-gray-500 mt-5 text-base sm:text-lg max-w-2xl mx-auto">
                University Talent Hub membantu mahasiswa mendokumentasikan skill, sertifikat, dan portofolio —
                sekaligus membuka peluang lewat sistem poin, leaderboard, reward, dan rekomendasi opportunity berbasis AI.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm">
                    Daftar sebagai Mahasiswa
                </a>
                <a href="{{ route('login') }}"
                    class="w-full sm:w-auto text-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium px-6 py-3 rounded-lg">
                    Sudah punya akun? Masuk
                </a>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="max-w-6xl mx-auto px-6 py-16">
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-10">
            Semua yang Kamu Butuhkan, Satu Platform
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $features = [
                    [
                        'icon' => '<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 5v5l4 2"/>',
                        'title' => 'Skill & Sertifikat',
                        'desc' => 'Ajukan skill, sertifikat, dan portofolio untuk diverifikasi admin, dapatkan poin.',
                    ],
                    [
                        'icon' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
                        'title' => 'Leaderboard',
                        'desc' => 'Pantau ranking mahasiswa paling aktif dan berprestasi di kampusmu.',
                    ],
                    [
                        'icon' => '<path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>',
                        'title' => 'Reward Menarik',
                        'desc' => 'Tukarkan poin yang terkumpul dengan reward dari kampus.',
                    ],
                    [
                        'icon' => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>',
                        'title' => 'AI Recommendation',
                        'desc' => 'Dapatkan rekomendasi opportunity yang sesuai dengan skill kamu secara otomatis.',
                    ],
                    [
                        'icon' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 3v2a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3"/><path d="M9 12h6M9 16h6"/>',
                        'title' => 'Talent Profile',
                        'desc' => 'Tampilkan profil profesionalmu lengkap dengan pencapaian yang terverifikasi.',
                    ],
                    [
                        'icon' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
                        'title' => 'Ditemukan Kampus',
                        'desc' => 'Admin & unit kegiatan mahasiswa bisa menemukanmu berdasarkan skill yang dibutuhkan.',
                    ],
                ];
            @endphp
            @foreach ($features as $f)
                <div class="border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            {!! $f['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA bawah --}}
    <section class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
        <div class="max-w-3xl mx-auto px-6 py-14 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3">Siap Menunjukkan Talentamu?</h2>
            <p class="text-indigo-100 mb-7">Daftar sekarang, lengkapi profil, dan mulai kumpulkan poin dari pencapaianmu.</p>
            <a href="{{ route('register') }}"
                class="inline-block bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg shadow-sm hover:bg-indigo-50">
                Daftar Gratis
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="text-center py-6 text-gray-400 text-xs">
        &copy; {{ date('Y') }} University Talent Hub. All rights reserved.
    </footer>

</body>
</html>
