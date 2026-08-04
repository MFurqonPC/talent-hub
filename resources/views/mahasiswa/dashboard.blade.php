<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');
        .uth-display { font-family: 'Sora', ui-sans-serif, sans-serif; letter-spacing: -0.02em; }
    </style>

    <x-slot name="header">
        <h2 class="uth-display font-bold text-2xl text-slate-800">
            Dashboard Mahasiswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Sapaan --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl text-white p-6 mb-8 shadow-lg shadow-indigo-100">
                <div class="absolute -right-10 -top-12 w-44 h-44 rounded-full bg-white/10"></div>
                <div class="absolute right-16 bottom-[-2.5rem] w-20 h-20 rounded-full bg-white/10"></div>
                <h1 class="uth-display relative text-2xl sm:text-3xl font-bold">
                    Selamat Datang, {{ $user->name }}
                </h1>
                <p class="relative mt-2 text-indigo-100">
                    Tingkatkan poinmu dengan menambahkan skill, sertifikat, dan portfolio.
                </p>
            </div>

            {{-- Ringkasan poin --}}
            @php
                $stats = [
                    ['label' => 'Total Poin', 'value' => $summary['points'], 'accent' => true],
                    ['label' => 'Skill Approved', 'value' => $summary['skills']],
                    ['label' => 'Certificate', 'value' => $summary['certificates']],
                    ['label' => 'Portfolio', 'value' => $summary['portfolios']],
                ];
            @endphp
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($stats as $stat)
                    <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6">
                        <p class="text-slate-500 text-sm">{{ $stat['label'] }}</p>
                        <h2 class="uth-display text-4xl font-bold mt-1 {{ $stat['accent'] ?? false ? 'text-indigo-600' : 'text-slate-800' }}">
                            {{ $stat['value'] }}
                        </h2>
                    </div>
                @endforeach
            </div>

            {{-- Reward & Opportunity --}}
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6">
                    <h3 class="uth-display text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/>
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>
                            </svg>
                        </span>
                        Reward yang Bisa Diklaim
                    </h3>
                    @forelse($rewards as $reward)
                        <div class="border border-slate-100 rounded-xl p-4 mb-3 flex items-center justify-between hover:border-indigo-200 transition-colors">
                            <div class="font-semibold text-slate-800">
                                {{ $reward->title }}
                            </div>
                            <span class="inline-flex items-center gap-1 text-amber-600 text-sm font-semibold">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                                </svg>
                                {{ $reward->points_required }} poin
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">
                            Belum ada reward yang bisa diklaim.
                        </p>
                    @endforelse
                </div>

                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6">
                    <h3 class="uth-display text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
                            </svg>
                        </span>
                        Opportunity Terbaru
                    </h3>
                    @forelse($opportunities as $item)
                        <div class="border border-slate-100 rounded-xl p-4 mb-3 hover:border-indigo-200 transition-colors">
                            <div class="font-semibold text-slate-800">
                                {{ $item->title }}
                            </div>
                            <div class="text-sm text-slate-500 mt-0.5">
                                {{ $item->skill_tags }}
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">
                            Belum ada opportunity.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
