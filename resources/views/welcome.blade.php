<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Talent Hub') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --font-display: 'Sora', ui-sans-serif, sans-serif; --font-body: 'Inter', ui-sans-serif, sans-serif; }
        body { font-family: var(--font-body); }
        .uth-display { font-family: var(--font-display); letter-spacing: -0.02em; }

        .uth-dotgrid {
            background-image: radial-gradient(rgba(79, 70, 229, 0.16) 1.5px, transparent 1.5px);
            background-size: 22px 22px;
        }

        .uth-card-float { animation: uth-float 6s ease-in-out infinite; }
        .uth-card-float-delay { animation: uth-float 6s ease-in-out infinite; animation-delay: 1.4s; }
        @keyframes uth-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .uth-reveal { opacity: 0; transform: translateY(18px); transition: opacity .6s ease, transform .6s ease; }
        .uth-reveal.uth-visible { opacity: 1; transform: translateY(0); }

        @media (prefers-reduced-motion: reduce) {
            .uth-card-float, .uth-card-float-delay { animation: none; }
            .uth-reveal { opacity: 1; transform: none; transition: none; }
        }

        .uth-path-line {
            background-image: repeating-linear-gradient(90deg, #c7d2fe 0, #c7d2fe 6px, transparent 6px, transparent 14px);
            height: 2px;
        }
    </style>
</head>
<body class="font-sans text-slate-900 antialiased bg-white">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                    </svg>
                </div>
                <span class="uth-display font-bold text-slate-900">University Talent Hub</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-indigo-500">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2.5 rounded-lg shadow-sm shadow-indigo-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50/70 via-white to-white">
        <div class="absolute inset-0 uth-dotgrid [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-16 sm:py-24 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            {{-- Kolom teks --}}
            <div class="text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-5">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/>
                    </svg>
                    Platform Talenta Mahasiswa
                </span>
                <h1 class="uth-display text-4xl sm:text-5xl font-bold text-slate-900 leading-[1.1]">
                    Petakan, kembangkan, dan
                    <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">tampilkan talentamu.</span>
                </h1>
                <p class="text-slate-500 mt-5 text-base sm:text-lg max-w-xl mx-auto lg:mx-0">
                    University Talent Hub membantu mahasiswa mendokumentasikan skill, sertifikat, dan portofolio —
                    sekaligus membuka peluang lewat sistem poin, leaderboard, reward, dan rekomendasi opportunity berbasis AI.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 mt-8">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md shadow-indigo-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Daftar sebagai Mahasiswa
                    </a>
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto text-center bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-medium px-6 py-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Sudah punya akun? Masuk
                    </a>
                </div>
            </div>

            {{-- Kolom visual: mockup kartu talenta --}}
            <div class="relative h-80 sm:h-96 hidden sm:block" aria-hidden="true">
                <div class="uth-card-float-delay absolute top-2 right-2 sm:right-6 w-40 rounded-xl bg-white shadow-lg shadow-indigo-100 border border-slate-100 p-3">
                    <div class="flex items-center gap-1.5 text-amber-600">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/>
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>
                        </svg>
                        <span class="text-xs font-semibold">Sertifikat Diverifikasi</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">+5 poin ditambahkan</p>
                </div>

                <div class="uth-card-float absolute bottom-2 left-1/2 -translate-x-1/2 sm:left-0 sm:translate-x-0 w-64 rounded-2xl bg-white shadow-xl shadow-indigo-100 border border-slate-100 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-semibold text-sm uth-display">
                            RA
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Rania Adjani</p>
                            <p class="text-slate-400 text-xs">D3 Teknik Informatika</p>
                        </div>
                        <span class="ml-auto inline-flex items-center gap-1 bg-amber-50 text-amber-600 text-xs font-bold px-2 py-1 rounded-full">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                            </svg>
                            128 pts
                        </span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-[11px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full">UI/UX Design</span>
                        <span class="text-[11px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full">Public Speaking</span>
                        <span class="text-[11px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full">React JS</span>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-[11px] text-slate-400 mb-1">
                            <span>Menuju reward berikutnya</span>
                            <span>128 / 150</span>
                        </div>
                        <div class="h-1.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full w-[85%] rounded-full bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center max-w-2xl mx-auto mb-12 uth-reveal">
            <h2 class="uth-display text-2xl sm:text-3xl font-bold text-slate-900">
                Semua yang kamu butuhkan, satu platform
            </h2>
            <p class="text-slate-500 mt-3">
                Dari membangun portofolio, bersaing sehat lewat poin, hingga ditemukan oleh kampus dan peluang baru.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $features = [
                    [
                        'group' => 'Portofolio', 'groupColor' => 'indigo',
                        'icon' => '<path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 5v5l4 2"/>',
                        'title' => 'Skill & Sertifikat',
                        'desc' => 'Ajukan skill, sertifikat, dan portofolio untuk diverifikasi admin, dapatkan poin.',
                    ],
                    [
                        'group' => 'Kompetisi', 'groupColor' => 'amber',
                        'icon' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
                        'title' => 'Leaderboard',
                        'desc' => 'Pantau ranking mahasiswa paling aktif dan berprestasi di kampusmu.',
                    ],
                    [
                        'group' => 'Kompetisi', 'groupColor' => 'amber',
                        'icon' => '<path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>',
                        'title' => 'Reward Menarik',
                        'desc' => 'Tukarkan poin yang terkumpul dengan reward dari kampus.',
                    ],
                    [
                        'group' => 'Peluang', 'groupColor' => 'violet',
                        'icon' => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>',
                        'title' => 'AI Recommendation',
                        'desc' => 'Dapatkan rekomendasi opportunity yang sesuai dengan skill kamu secara otomatis.',
                    ],
                    [
                        'group' => 'Portofolio', 'groupColor' => 'indigo',
                        'icon' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 3v2a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3"/><path d="M9 12h6M9 16h6"/>',
                        'title' => 'Talent Profile',
                        'desc' => 'Tampilkan profil profesionalmu lengkap dengan pencapaian yang terverifikasi.',
                    ],
                    [
                        'group' => 'Peluang', 'groupColor' => 'violet',
                        'icon' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
                        'title' => 'Ditemukan Kampus',
                        'desc' => 'Admin & unit kegiatan mahasiswa bisa menemukanmu berdasarkan skill yang dibutuhkan.',
                    ],
                ];
                $groupClasses = [
                    'indigo' => 'bg-indigo-50 text-indigo-600',
                    'amber'  => 'bg-amber-50 text-amber-600',
                    'violet' => 'bg-violet-50 text-violet-600',
                ];
            @endphp
            @foreach ($features as $f)
                <div class="uth-reveal border border-slate-100 rounded-xl p-6 hover:shadow-lg hover:shadow-slate-100 hover:-translate-y-0.5 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-11 h-11 rounded-lg {{ $groupClasses[$f['groupColor']] }} flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $f['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">{{ $f['group'] }}</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-1">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 text-sm">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Cara Kerja --}}
    <section class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="text-center max-w-2xl mx-auto mb-14 uth-reveal">
                <h2 class="uth-display text-2xl sm:text-3xl font-bold text-slate-900">Cara kerjanya</h2>
                <p class="text-slate-500 mt-3">Dari melengkapi profil sampai naik ke puncak leaderboard.</p>
            </div>

            @php
                $steps = [
                    ['n' => '01', 'title' => 'Lengkapi Profil', 'desc' => 'Isi data diri dan profil talentamu sebagai fondasi.'],
                    ['n' => '02', 'title' => 'Ajukan Bukti', 'desc' => 'Unggah skill, sertifikat, dan portofolio untuk diajukan.'],
                    ['n' => '03', 'title' => 'Diverifikasi Admin', 'desc' => 'Tim kampus meninjau dan menyetujui setiap pengajuan.'],
                    ['n' => '04', 'title' => 'Poin & Leaderboard', 'desc' => 'Poin bertambah, posisimu naik, reward siap diklaim.'],
                ];
            @endphp

            <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-4">
                <div class="hidden lg:block absolute top-6 left-[12.5%] right-[12.5%] uth-path-line"></div>
                @foreach ($steps as $i => $s)
                    <div class="uth-reveal relative text-center lg:text-left">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold uth-display text-sm mx-auto lg:mx-0 relative z-10
                            {{ $i === count($steps) - 1 ? 'bg-amber-500 text-white' : 'bg-indigo-600 text-white' }}">
                            {{ $s['n'] }}
                        </div>
                        <h3 class="font-semibold text-slate-800 mt-4">{{ $s['title'] }}</h3>
                        <p class="text-slate-500 text-sm mt-1">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tentang / Latar belakang --}}
    <section class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 uth-dotgrid opacity-60 [mask-image:radial-gradient(ellipse_55%_45%_at_15%_50%,#000_35%,transparent_100%)]"></div>

        <div class="relative max-w-4xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-start uth-reveal">
                <div class="md:col-span-3 space-y-5">
                    <span class="inline-flex items-center gap-1.5 bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 21h8M12 17v4"/>
                            <path d="M7 4h10v6a5 5 0 0 1-10 0V4Z"/>
                            <path d="M7 6H4a1 1 0 0 0-1 1 4 4 0 0 0 4 4"/>
                            <path d="M17 6h3a1 1 0 0 1 1 1 4 4 0 0 1-4 4"/>
                        </svg>
                        Tentang Project Ini
                    </span>
                    <h2 class="uth-display text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                        Dibangun untuk TopRank Logic AI Development #3
                    </h2>
                    <p class="text-slate-500 leading-relaxed">
                        University Talent Hub adalah <span class="font-medium text-slate-700">Minimum Viable Product (MVP)</span> yang
                        menjawab study case kompetisi <span class="font-medium text-slate-700">TopRank Logic AI Development #3</span>:
                        membangun ekosistem talenta mahasiswa berbasis gamifikasi — dari verifikasi skill & portofolio,
                        sistem poin dan leaderboard, katalog reward, hingga rekomendasi opportunity berbasis AI.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach (['Laravel', 'Blade', 'Tailwind CSS', 'AI Recommendation'] as $tech)
                            <span class="text-xs font-medium bg-slate-100 text-slate-600 px-3 py-1 rounded-full">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-700 p-[1px] shadow-lg shadow-indigo-100">
                    <div class="bg-white rounded-2xl p-5 space-y-4 h-full">
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold uppercase tracking-wide text-indigo-600">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            Peserta Hackathon
                        </span>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-semibold uth-display flex-shrink-0">
                                MF
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm uth-display">Mohammad Furqon Putra Choir</p>
                                <p class="text-slate-500 text-xs">D3 Teknik Informatika</p>
                            </div>
                        </div>
                        <p class="text-slate-400 text-xs leading-relaxed border-t border-slate-100 pt-3">
                            Merancang dan membangun University Talent Hub secara solo selama TopRank Logic AI Development #3 berlangsung.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA bawah --}}
    <section class="bg-gradient-to-br from-indigo-600 to-violet-700 text-white">
        <div class="max-w-3xl mx-auto px-6 py-16 text-center uth-reveal">
            <h2 class="uth-display text-2xl sm:text-3xl font-bold mb-3">Siap menunjukkan talentamu?</h2>
            <p class="text-indigo-100 mb-7">Daftar sekarang, lengkapi profil, dan mulai kumpulkan poin dari pencapaianmu.</p>
            <a href="{{ route('register') }}"
                class="inline-block bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                Daftar Gratis
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                    </svg>
                </div>
                <span class="uth-display text-sm font-semibold text-slate-700">University Talent Hub</span>
            </div>
            <p class="text-slate-400 text-xs text-center sm:text-right">
                &copy; {{ date('Y') }} University Talent Hub. Dibuat oleh Mohammad Furqon Putra Choir untuk TopRank Logic AI Development #3.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var els = document.querySelectorAll('.uth-reveal');
            if ('IntersectionObserver' in window) {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('uth-visible');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });
                els.forEach(function (el) { io.observe(el); });
            } else {
                els.forEach(function (el) { el.classList.add('uth-visible'); });
            }
        });
    </script>

</body>
</html>
