<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('AI Recommendation') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow p-5">
                <p class="font-semibold flex items-center gap-2">✨ Rekomendasi dipersonalisasi berdasarkan skill kamu</p>
                <p class="text-indigo-100 text-sm mt-1">Sistem mencocokkan skill yang sudah terverifikasi dengan opportunity yang tersedia.</p>
            </div>

            @if (!empty($aiCareerAdvice))
                <div class="bg-white border border-indigo-100 rounded-xl shadow p-5">
                    <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">🤖 Saran Karier dari AI</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $aiCareerAdvice }}</p>
                </div>
            @endif

            {{-- Rekomendasi Opportunity --}}
            <div class="space-y-3">
                <h3 class="font-semibold text-gray-800">🎯 Opportunity yang Cocok Untukmu</h3>
                @forelse ($recommendations as $opp)
                    <div class="bg-white rounded-xl shadow p-4 flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-semibold text-gray-800">{{ $opp->title }}</h4>
                                @if ($opp->match_score > 0)
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                        {{ $opp->match_score >= 70 ? 'bg-green-100 text-green-700' : ($opp->match_score >= 40 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                        {{ $opp->match_score }}% cocok
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-500 text-sm mt-1">{{ $opp->description }}</p>
                            @if (!empty($opp->matched_skills))
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach ($opp->matched_skills as $tag)
                                        <span class="text-xs bg-green-50 text-green-700 px-2 py-0.5 rounded-full">✓ {{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if ($opp->deadline)
                                <p class="text-xs text-gray-400 mt-2">Deadline: {{ $opp->deadline->format('d M Y') }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400 text-sm">
                        Belum ada opportunity yang tersedia saat ini. Cek kembali nanti!
                    </div>
                @endforelse
            </div>

            {{-- Rekomendasi skill untuk dipelajari --}}
            @if (!empty($skillsToLearn))
                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="font-semibold text-gray-800 mb-2">📈 Skill yang Sedang Banyak Dicari</h3>
                    <p class="text-gray-500 text-xs mb-3">Berdasarkan tren opportunity yang diposting, skill ini banyak dibutuhkan tapi belum kamu miliki:</p>
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
