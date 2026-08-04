<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="University Talent Hub — dokumentasikan skill, sertifikat, dan portofolio mahasiswa. Kumpulkan poin, naik leaderboard, klaim reward, dan temukan opportunity lewat rekomendasi AI.">
    <title>{{ config('app.name', 'University Talent Hub') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Sora', ui-sans-serif, sans-serif;
            --font-body: 'Inter', ui-sans-serif, sans-serif;
            --font-mono: 'JetBrains Mono', ui-monospace, monospace;
            --ink: #211E4B;
            --gold: #B4791F;
        }
        body { font-family: var(--font-body); background-color: #FAFAF8; }
        .uth-display { font-family: var(--font-display); letter-spacing: -0.02em; }
        .uth-mono { font-family: var(--font-mono); font-variant-numeric: tabular-nums; letter-spacing: -0.01em; }

        .uth-dotgrid {
            background-image: radial-gradient(rgba(33, 30, 75, 0.14) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        .uth-card-float { animation: uth-float 7s ease-in-out infinite; }
        .uth-card-float-delay { animation: uth-float 7s ease-in-out infinite; animation-delay: 1.6s; }
        @keyframes uth-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .uth-reveal { opacity: 0; transform: translateY(18px); transition: opacity .6s ease, transform .6s ease; }
        .uth-reveal.uth-visible { opacity: 1; transform: translateY(0); }

        @media (prefers-reduced-motion: reduce) {
            .uth-card-float, .uth-card-float-delay { animation: none; }
            .uth-reveal { opacity: 1; transform: none; transition: none; }
        }

        .uth-connector {
            background-image: repeating-linear-gradient(90deg, #D7C9A8 0, #D7C9A8 5px, transparent 5px, transparent 12px);
            height: 2px;
        }
        .uth-connector-v {
            background-image: repeating-linear-gradient(180deg, #E2E8F0 0, #E2E8F0 5px, transparent 5px, transparent 12px);
            width: 2px;
        }
        .uth-perforation {
            background-image: repeating-linear-gradient(90deg, #E2E4EE 0, #E2E4EE 6px, transparent 6px, transparent 13px);
            height: 1.5px;
        }
    </style>
</head>
<body class="font-sans text-[#211E4B] antialiased">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-40 bg-[#FAFAF8]/85 backdrop-blur border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 min-w-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 rounded-lg">
                <div class="w-9 h-9 shrink-0 rounded-lg bg-[#211E4B] flex items-center justify-center text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.65"/>
                    </svg>
                </div>
                <span class="uth-display font-bold text-[#211E4B] truncate">
                    <span class="sm:hidden">UTH</span>
                    <span class="hidden sm:inline">University Talent Hub</span>
                </span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-[#211E4B] px-2.5 sm:px-3 py-2 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-indigo-500">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-[#4338CA] hover:bg-[#3730A3] px-3.5 sm:px-4 py-2.5 rounded-lg shadow-sm shadow-indigo-900/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 whitespace-nowrap">
                    Daftar<span class="hidden sm:inline"> Sekarang</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-50/60 via-[#FAFAF8] to-[#FAFAF8]">
        <div class="absolute inset-0 uth-dotgrid [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative max-w-6xl mx-auto px-6 py-16 sm:py-24 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            {{-- Kolom teks --}}
            <div class="text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 bg-[#FBF0DC] text-[#8A5A16] text-xs font-semibold px-3 py-1 rounded-full mb-5">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                    </svg>
                    Sistem Talenta &amp; Reward Mahasiswa
                </span>
                <h1 class="uth-display text-4xl sm:text-5xl font-bold text-[#211E4B] leading-[1.1]">
                    Petakan, kembangkan, dan
                    <span class="bg-gradient-to-r from-indigo-700 to-violet-600 bg-clip-text text-transparent">tampilkan talentamu.</span>
                </h1>
                <p class="text-slate-500 mt-5 text-base sm:text-lg max-w-xl mx-auto lg:mx-0">
                    University Talent Hub membantu mahasiswa mendokumentasikan skill, sertifikat, dan portofolio —
                    sekaligus membuka peluang lewat sistem poin, leaderboard, reward, dan rekomendasi opportunity berbasis AI.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 mt-8">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto text-center bg-[#4338CA] hover:bg-[#3730A3] text-white font-semibold px-6 py-3 rounded-lg shadow-md shadow-indigo-900/15 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Daftar sebagai Mahasiswa
                    </a>
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto text-center bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-medium px-6 py-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Sudah punya akun? Masuk
                    </a>
                </div>
            </div>

            {{-- Kolom visual: kartu talenta (signature element) --}}
            <div class="relative h-[420px] hidden lg:block" aria-hidden="true">
                <div class="uth-card-float-delay absolute top-2 right-4 w-44 rounded-xl bg-white shadow-lg shadow-indigo-900/10 border border-slate-100 p-3.5">
                    <div class="flex items-center gap-1.5 text-emerald-700">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <span class="text-xs font-semibold">Sertifikat Diverifikasi</span>
                    </div>
                    <p class="uth-mono text-[11px] text-slate-400 mt-1.5">+5 poin ditambahkan</p>
                </div>

                <div class="uth-card-float absolute inset-x-0 bottom-0 mx-auto w-[300px] rounded-[20px] bg-white shadow-2xl shadow-indigo-900/15 border border-slate-100 overflow-hidden">
                    <div class="p-5 pb-4">
                        <div class="flex items-center justify-between mb-3.5">
                            <span class="uth-mono text-[10px] font-semibold uppercase tracking-widest text-slate-400">Kartu Talenta</span>
                            <svg class="w-4 h-4 text-[#211E4B]/25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 shrink-0 rounded-full bg-[#211E4B] text-white flex items-center justify-center font-semibold text-sm uth-display">
                                RA
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 text-sm truncate">Rania Adjani</p>
                                <p class="text-slate-400 text-xs truncate">D3 Teknik Informatika</p>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            <span class="text-[11px] bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full">UI/UX Design</span>
                            <span class="text-[11px] bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full">Public Speaking</span>
                            <span class="text-[11px] bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full">React JS</span>
                        </div>
                    </div>

                    <div class="uth-perforation"></div>

                    <div class="p-5 pt-4 bg-slate-50/70">
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="uth-mono text-[10px] font-semibold uppercase tracking-widest text-slate-400">Total Poin</p>
                                <p class="uth-display uth-mono text-2xl font-bold text-[#211E4B] mt-0.5">128</p>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-[#FBF0DC] text-[#8A5A16] text-xs font-bold px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/>
                                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>
                                </svg>
                                Peringkat #4
                            </span>
                        </div>
                        <div class="mt-3.5">
                            <div class="flex justify-between uth-mono text-[10px] text-slate-400 mb-1">
                                <span class="uppercase tracking-widest">Reward berikutnya</span>
                                <span>128 / 150</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-slate-200 overflow-hidden">
                                <div class="h-full w-[85%] rounded-full bg-gradient-to-r from-indigo-600 to-violet-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center max-w-2xl mx-auto mb-12 uth-reveal">
            <h2 class="uth-display text-2xl sm:text-3xl font-bold text-[#211E4B]">
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
                        'title' => 'Skill &amp; Sertifikat',
                        'desc' => 'Ajukan skill, sertifikat, dan portofolio untuk diverifikasi admin, dapatkan poin.',
                    ],
                    [
                        'group' => 'Kompetisi', 'groupColor' => 'gold',
                        'icon' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
                        'title' => 'Leaderboard',
                        'desc' => 'Pantau ranking mahasiswa paling aktif dan berprestasi di kampusmu.',
                    ],
                    [
                        'group' => 'Kompetisi', 'groupColor' => 'gold',
                        'icon' => '<path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>',
                        'title' => 'Reward Menarik',
                        'desc' => 'Tukarkan poin yang terkumpul dengan reward dari kampus.',
                    ],
                    [
                        'group' => 'Peluang', 'groupColor' => 'violet',
                        'icon' => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/><circle cx="12" cy="12" r="4"/>',
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
                        'desc' => 'Admin &amp; unit kegiatan mahasiswa bisa menemukanmu berdasarkan skill yang dibutuhkan.',
                    ],
                ];
                $groupClasses = [
                    'indigo' => ['icon' => 'bg-indigo-50 text-indigo-700', 'dot' => 'bg-indigo-500', 'label' => 'text-indigo-700'],
                    'gold'   => ['icon' => 'bg-[#FBF0DC] text-[#8A5A16]', 'dot' => 'bg-[#B4791F]', 'label' => 'text-[#8A5A16]'],
                    'violet' => ['icon' => 'bg-violet-50 text-violet-700', 'dot' => 'bg-violet-500', 'label' => 'text-violet-700'],
                ];
            @endphp
            @foreach ($features as $f)
                @php($gc = $groupClasses[$f['groupColor']])
                <div class="uth-reveal border border-slate-200 rounded-xl p-6 bg-white hover:shadow-lg hover:shadow-slate-200/60 hover:-translate-y-0.5 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-lg {{ $gc['icon'] }} flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $f['icon'] !!}
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1.5 uth-mono text-[10px] font-semibold uppercase tracking-widest {{ $gc['label'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $gc['dot'] }}"></span>
                            {{ $f['group'] }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-slate-800 mb-1">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Cara Kerja --}}
    <section class="bg-white border-y border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="text-center max-w-2xl mx-auto mb-14 uth-reveal">
                <h2 class="uth-display text-2xl sm:text-3xl font-bold text-[#211E4B]">Cara kerjanya</h2>
                <p class="text-slate-500 mt-3">Empat tahap dari melengkapi profil sampai naik ke puncak leaderboard.</p>
            </div>

            @php
                $steps = [
                    ['n' => '01', 'title' => 'Lengkapi Profil', 'desc' => 'Isi data diri dan profil talentamu sebagai fondasi.'],
                    ['n' => '02', 'title' => 'Ajukan Bukti', 'desc' => 'Unggah skill, sertifikat, dan portofolio untuk diajukan.'],
                    ['n' => '03', 'title' => 'Diverifikasi Admin', 'desc' => 'Tim kampus meninjau dan menyetujui setiap pengajuan.'],
                    ['n' => '04', 'title' => 'Poin &amp; Leaderboard', 'desc' => 'Poin bertambah, posisimu naik, reward siap diklaim.'],
                ];
            @endphp

            {{-- Mobile: vertical timeline --}}
            <div class="sm:hidden space-y-0">
                @foreach ($steps as $i => $s)
                    <div class="uth-reveal flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center uth-mono font-bold text-xs
                                {{ $i === count($steps) - 1 ? 'bg-[#B4791F] text-white' : 'bg-[#211E4B] text-white' }}">
                                {{ $s['n'] }}
                            </div>
                            @if (!$loop->last)
                                <div class="uth-connector-v flex-1 my-1"></div>
                            @endif
                        </div>
                        <div class="pb-8">
                            <h3 class="font-semibold text-slate-800">{{ $s['title'] }}</h3>
                            <p class="text-slate-500 text-sm mt-1">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop: horizontal --}}
            <div class="relative hidden sm:grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-4">
                <div class="hidden lg:block absolute top-6 left-[12.5%] right-[12.5%] uth-connector"></div>
                @foreach ($steps as $i => $s)
                    <div class="uth-reveal relative text-left">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center uth-mono font-bold text-sm relative z-10
                            {{ $i === count($steps) - 1 ? 'bg-[#B4791F] text-white' : 'bg-[#211E4B] text-white' }}">
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
    <section class="relative bg-[#FAFAF8] overflow-hidden">
        <div class="absolute inset-0 uth-dotgrid opacity-70 [mask-image:radial-gradient(ellipse_55%_45%_at_15%_50%,#000_35%,transparent_100%)]"></div>

        <div class="relative max-w-4xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-start uth-reveal">
                <div class="md:col-span-3 space-y-5">
                    <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 21h8M12 17v4"/>
                            <path d="M7 4h10v6a5 5 0 0 1-10 0V4Z"/>
                            <path d="M7 6H4a1 1 0 0 0-1 1 4 4 0 0 0 4 4"/>
                            <path d="M17 6h3a1 1 0 0 1 1 1 4 4 0 0 1-4 4"/>
                        </svg>
                        Tentang Project Ini
                    </span>
                    <h2 class="uth-display text-2xl sm:text-3xl font-bold text-[#211E4B] leading-tight">
                        Dibangun untuk TopRank Logic AI Development #3
                    </h2>
                    <p class="text-slate-500 leading-relaxed">
                        University Talent Hub adalah <span class="font-medium text-slate-700">Minimum Viable Product (MVP)</span> yang
                        menjawab study case kompetisi <span class="font-medium text-slate-700">TopRank Logic AI Development #3</span>:
                        membangun ekosistem talenta mahasiswa berbasis gamifikasi — dari verifikasi skill &amp; portofolio,
                        sistem poin dan leaderboard, katalog reward, hingga rekomendasi opportunity berbasis AI.
                    </p>
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach (['Laravel', 'Blade', 'Tailwind CSS', 'AI Recommendation'] as $tech)
                            <span class="uth-mono text-[11px] font-medium bg-white border border-slate-200 text-slate-600 px-3 py-1 rounded-full">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2 rounded-2xl bg-white border border-dashed border-slate-300 shadow-sm">
                    <div class="p-5 space-y-4">
                        <span class="inline-flex items-center gap-1 uth-mono text-[10px] font-semibold uppercase tracking-widest text-[#8A5A16]">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            Peserta Hackathon
                        </span>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-[#211E4B] text-white flex items-center justify-center font-semibold uth-display flex-shrink-0">
                                MF
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 text-sm uth-display truncate">Mohammad Furqon Putra Choir</p>
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
    <section class="relative bg-[#211E4B] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-[0.07] uth-dotgrid" style="background-image: radial-gradient(#fff 1.5px, transparent 1.5px);"></div>
        <div class="relative max-w-3xl mx-auto px-6 py-16 text-center uth-reveal">
            <h2 class="uth-display text-2xl sm:text-3xl font-bold mb-3">Siap menunjukkan talentamu?</h2>
            <p class="text-indigo-100/80 mb-7">Daftar sekarang, lengkapi profil, dan mulai kumpulkan poin dari pencapaianmu.</p>
            <a href="{{ route('register') }}"
                class="inline-block bg-white text-[#211E4B] font-semibold px-6 py-3 rounded-lg shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                Daftar Gratis
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#FAFAF8] border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-[#211E4B] flex items-center justify-center text-white">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                        <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.65"/>
                    </svg>
                </div>
                <span class="uth-display text-sm font-semibold text-[#211E4B]">University Talent Hub</span>
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
