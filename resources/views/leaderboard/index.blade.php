<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');
        .uth-display { font-family: 'Sora', ui-sans-serif, sans-serif; letter-spacing: -0.02em; }
    </style>

    <x-slot name="header">
        <h2 class="uth-display font-bold text-xl text-slate-800 leading-tight">{{ __('Leaderboard Mahasiswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Podium 3 besar --}}
            @if ($startRank === 1 && $leaderboard->count() > 0)
                <div class="grid grid-cols-3 gap-4 items-end">
                    {{-- Rank 2 --}}
                    @php $second = $leaderboard->get(1); @endphp
                    <div class="text-center">
                        @if ($second)
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 pb-6">
                                <img src="{{ $second->profile?->photo ? Storage::url($second->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($second->name).'&background=9ca3af&color=fff' }}"
                                    class="w-14 h-14 rounded-full mx-auto object-cover border-2 border-slate-300">
                                <p class="font-semibold text-slate-800 text-sm mt-2 truncate">{{ $second->name }}</p>
                                <p class="text-slate-500 text-xs">{{ $second->points }} pts</p>
                            </div>
                            <div class="uth-display bg-slate-300 text-white font-bold text-lg rounded-b-xl py-2">2</div>
                        @endif
                    </div>
                    {{-- Rank 1 --}}
                    @php $first = $leaderboard->get(0); @endphp
                    <div class="text-center -mt-4">
                        @if ($first)
                            <div class="bg-white rounded-2xl shadow-lg shadow-amber-100 p-4 pb-6 border-2 border-amber-400">
                                <svg class="w-7 h-7 mx-auto text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 21h8M12 17v4"/>
                                    <path d="M7 4h10v6a5 5 0 0 1-10 0V4Z"/>
                                    <path d="M7 6H4a1 1 0 0 0-1 1 4 4 0 0 0 4 4"/>
                                    <path d="M17 6h3a1 1 0 0 1 1 1 4 4 0 0 1-4 4"/>
                                </svg>
                                <img src="{{ $first->profile?->photo ? Storage::url($first->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($first->name).'&background=f59e0b&color=fff' }}"
                                    class="w-16 h-16 rounded-full mx-auto object-cover border-2 border-amber-400 mt-1">
                                <p class="font-semibold text-slate-800 text-sm mt-2 truncate">{{ $first->name }}</p>
                                <p class="text-amber-600 font-bold text-xs">{{ $first->points }} pts</p>
                            </div>
                            <div class="uth-display bg-amber-500 text-white font-bold text-xl rounded-b-xl py-3">1</div>
                        @endif
                    </div>
                    {{-- Rank 3 --}}
                    @php $third = $leaderboard->get(2); @endphp
                    <div class="text-center">
                        @if ($third)
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 pb-6">
                                <img src="{{ $third->profile?->photo ? Storage::url($third->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($third->name).'&background=b45309&color=fff' }}"
                                    class="w-14 h-14 rounded-full mx-auto object-cover border-2 border-amber-700">
                                <p class="font-semibold text-slate-800 text-sm mt-2 truncate">{{ $third->name }}</p>
                                <p class="text-slate-500 text-xs">{{ $third->points }}</p>
                            </div>
                            <div class="uth-display bg-amber-700 text-white font-bold text-lg rounded-b-xl py-2">3</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Tabel ranking lengkap --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 w-16">Rank</th>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Jurusan</th>
                            <th class="px-4 py-3 text-right">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($leaderboard as $i => $student)
                            <tr class="{{ auth()->id() === $student->id ? 'bg-indigo-50/60' : '' }}">
                                <td class="px-4 py-3 font-semibold text-slate-700">#{{ $startRank + $i }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $student->profile?->photo ? Storage::url($student->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=6366f1&color=fff' }}"
                                            class="w-8 h-8 rounded-full object-cover">
                                        <span class="font-medium text-slate-800">
                                            {{ $student->name }}
                                            @if (auth()->id() === $student->id)
                                                <span class="text-indigo-600 text-xs">(Kamu)</span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-500">{{ $student->profile?->jurusan ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-indigo-600">{{ $student->points }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $leaderboard->links() }}</div>
        </div>
    </div>
</x-app-layout>
