<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-gray-500 text-sm">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_mahasiswa'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-gray-500 text-sm">Total Skill Diajukan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_skill'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-gray-500 text-sm">Total Project / Portfolio</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_project'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-400">
                    <p class="text-gray-500 text-sm">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_verification'] }}</p>
                    @if ($stats['pending_verification'] > 0)
                        <a href="{{ route('admin.verifications.index') }}"
                            class="text-xs text-indigo-600 hover:underline">Lihat pengajuan →</a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Top 5 Leaderboard --}}
                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">🏆 Top 5 Mahasiswa</h3>
                    <ul class="divide-y divide-gray-100">
                        @forelse ($topStudents as $i => $student)
                            <li class="flex items-center justify-between py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                                        {{ $i === 0 ? 'bg-yellow-400 text-white' : ($i === 1 ? 'bg-gray-300 text-white' : ($i === 2 ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-600')) }}">
                                        {{ $i + 1 }}
                                    </span>
                                    <span class="text-gray-700 text-sm">{{ $student->name }}</span>
                                </div>
                                <span class="font-semibold text-indigo-600 text-sm">{{ $student->points }} pts</span>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm py-4 text-center">Belum ada data mahasiswa.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Skill terpopuler --}}
                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">📊 Skill Terpopuler (Approved)</h3>
                    <ul class="space-y-3">
                        @forelse ($topSkills as $skill)
                            @php
                                $max = $topSkills->max('total') ?: 1;
                                $percentage = round(($skill->total / $max) * 100);
                            @endphp
                            <li>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700">{{ $skill->skill_name }}</span>
                                    <span class="text-gray-500">{{ $skill->total }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm py-4 text-center">Belum ada skill yang disetujui.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
