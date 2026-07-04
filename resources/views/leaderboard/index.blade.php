<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Leaderboard Mahasiswa') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Podium 3 besar --}}
            @if ($startRank === 1 && $leaderboard->count() > 0)
                <div class="grid grid-cols-3 gap-4 items-end">
                    {{-- Rank 2 --}}
                    @php $second = $leaderboard->get(1); @endphp
                    <div class="text-center">
                        @if ($second)
                            <div class="bg-white rounded-xl shadow p-4 pb-6">
                                <img src="{{ $second->profile?->photo ? Storage::url($second->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($second->name).'&background=9ca3af&color=fff' }}"
                                    class="w-14 h-14 rounded-full mx-auto object-cover border-2 border-gray-300">
                                <p class="font-semibold text-gray-800 text-sm mt-2 truncate">{{ $second->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $second->points }} pts</p>
                            </div>
                            <div class="bg-gray-300 text-white font-bold text-lg rounded-b-lg py-2">2</div>
                        @endif
                    </div>
                    {{-- Rank 1 --}}
                    @php $first = $leaderboard->get(0); @endphp
                    <div class="text-center -mt-4">
                        @if ($first)
                            <div class="bg-white rounded-xl shadow-lg p-4 pb-6 border-2 border-yellow-400">
                                <span class="text-2xl">🏆</span>
                                <img src="{{ $first->profile?->photo ? Storage::url($first->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($first->name).'&background=f59e0b&color=fff' }}"
                                    class="w-16 h-16 rounded-full mx-auto object-cover border-2 border-yellow-400 mt-1">
                                <p class="font-semibold text-gray-800 text-sm mt-2 truncate">{{ $first->name }}</p>
                                <p class="text-yellow-600 font-bold text-xs">{{ $first->points }} pts</p>
                            </div>
                            <div class="bg-yellow-400 text-white font-bold text-xl rounded-b-lg py-3">1</div>
                        @endif
                    </div>
                    {{-- Rank 3 --}}
                    @php $third = $leaderboard->get(2); @endphp
                    <div class="text-center">
                        @if ($third)
                            <div class="bg-white rounded-xl shadow p-4 pb-6">
                                <img src="{{ $third->profile?->photo ? Storage::url($third->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($third->name).'&background=b45309&color=fff' }}"
                                    class="w-14 h-14 rounded-full mx-auto object-cover border-2 border-amber-600">
                                <p class="font-semibold text-gray-800 text-sm mt-2 truncate">{{ $third->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $third->points }} pts</p>
                            </div>
                            <div class="bg-amber-600 text-white font-bold text-lg rounded-b-lg py-2">3</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Tabel ranking lengkap --}}
            <div class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 w-16">Rank</th>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Jurusan</th>
                            <th class="px-4 py-3 text-right">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($leaderboard as $i => $student)
                            <tr class="{{ auth()->id() === $student->id ? 'bg-indigo-50' : '' }}">
                                <td class="px-4 py-3 font-semibold text-gray-700">#{{ $startRank + $i }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $student->profile?->photo ? Storage::url($student->profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=6366f1&color=fff' }}"
                                            class="w-8 h-8 rounded-full object-cover">
                                        <span class="font-medium text-gray-800">
                                            {{ $student->name }}
                                            @if (auth()->id() === $student->id)
                                                <span class="text-indigo-600 text-xs">(Kamu)</span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $student->profile?->jurusan ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-indigo-600">{{ $student->points }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $leaderboard->links() }}</div>
        </div>
    </div>
</x-app-layout>
