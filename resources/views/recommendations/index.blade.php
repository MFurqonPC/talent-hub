<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');
        .uth-display { font-family: 'Sora', ui-sans-serif, sans-serif; letter-spacing: -0.02em; }
    </style>

    <x-slot name="header">
        <h2 class="uth-display font-bold text-xl text-slate-800 leading-tight">{{ __('AI Recommendation') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-2xl shadow-lg shadow-indigo-100 p-6">
                <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full bg-white/10"></div>
                <div class="absolute -right-2 top-10 w-14 h-14 rounded-full bg-white/10"></div>
                <p class="uth-display font-semibold flex items-center gap-2 relative">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>
                    </svg>
                    Rekomendasi dipersonalisasi berdasarkan skill kamu
                </p>
                <p class="text-indigo-100 text-sm mt-1 relative">Sistem mencocokkan skill yang sudah terverifikasi dengan opportunity yang tersedia.</p>
            </div>

            @if (!empty($aiCareerAdvice))
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
                    <h3 class="uth-display font-semibold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="8" width="18" height="12" rx="2"/>
                                <circle cx="8.5" cy="14" r="1.5" fill="currentColor" stroke="none"/>
                                <circle cx="15.5" cy="14" r="1.5" fill="currentColor" stroke="none"/>
                                <path d="M12 8V4M9 4h6"/>
                            </svg>
                        </span>
                        Saran Karier dari AI
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $aiCareerAdvice }}</p>
                </div>
            @endif

            {{-- Rekomendasi Opportunity --}}
            <div class="space-y-3">
                <h3 class="uth-display font-semibold text-slate-800 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="6"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </span>
                    Opportunity yang Cocok Untukmu
                </h3>
                @forelse ($recommendations as $opp)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all p-5 flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="font-semibold text-slate-800">{{ $opp->title }}</h4>
                                @if ($opp->match_score > 0)
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                        {{ $opp->match_score >= 70 ? 'bg-green-100 text-green-700' : ($opp->match_score >= 40 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                        {{ $opp->match_score }}% cocok
                                    </span>
                                @endif
                            </div>
                            <p class="text-slate-500 text-sm mt-1">{{ $opp->description }}</p>
                            @if (!empty($opp->matched_skills))
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach ($opp->matched_skills as $tag)
                                        <span class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-700 px-2 py-0.5 rounded-full">
                                            <svg class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            @if ($opp->deadline)
                                <p class="text-xs text-slate-400 mt-2">Deadline: {{ $opp->deadline->format('d M Y') }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 text-center text-slate-400 text-sm">
                        Belum ada opportunity yang tersedia saat ini. Cek kembali nanti!
                    </div>
                @endforelse
            </div>

            {{-- Rekomendasi skill untuk dipelajari --}}
            @if (!empty($skillsToLearn))
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="uth-display font-semibold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 17l6-6 4 4 8-8"/>
                                <path d="M17 7h4v4"/>
                            </svg>
                        </span>
                        Skill yang Sedang Banyak Dicari
                    </h3>
                    <p class="text-slate-500 text-xs mb-3">Berdasarkan tren opportunity yang diposting, skill ini banyak dibutuhkan tapi belum kamu miliki:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($skillsToLearn as $skill)
                            <span class="bg-indigo-50 text-indigo-600 text-sm px-3 py-1 rounded-full capitalize">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
