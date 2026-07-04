<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan Skill') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl overflow-x-auto" x-data="{ rejectId: null }">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Skill</th>
                            <th class="px-4 py-3">Level</th>
                            <th class="px-4 py-3">Bukti</th>
                            <th class="px-4 py-3">Diajukan</th>
                            <th class="px-4 py-3 w-64">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingSkills as $skill)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800">{{ $skill->student->name }}</div>
                                    <div class="text-gray-400 text-xs">{{ $skill->student->email }}</div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $skill->skill_name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $skill->level ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if ($skill->evidence_file)
                                        <a href="{{ Storage::url($skill->evidence_file) }}" target="_blank"
                                            class="text-indigo-600 hover:underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $skill->created_at->diffForHumans() }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        {{-- Form approve dengan input poin --}}
                                        <form action="{{ route('admin.verifications.skills.approve', $skill) }}"
                                            method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="points" min="0" max="100" value="1" required
                                                class="w-16 rounded-lg border-gray-300 text-sm py-1 px-2">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg"
                                                onclick="return confirm('Setujui skill ini dan berikan poin?')">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form action="{{ route('admin.verifications.skills.reject', $skill) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tolak pengajuan skill ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                    Tidak ada pengajuan skill yang menunggu verifikasi. 🎉
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
