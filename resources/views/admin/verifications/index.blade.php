<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ tab: 'skill' }">
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

            {{-- Tabs --}}
            <div class="flex gap-2 border-b border-gray-200">
                <button @click="tab = 'skill'"
                    :class="tab === 'skill' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-2 text-sm font-medium border-b-2">
                    Skill <span class="ml-1 text-xs bg-gray-100 rounded-full px-2 py-0.5">{{ $pendingSkills->count() }}</span>
                </button>
                <button @click="tab = 'certificate'"
                    :class="tab === 'certificate' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-2 text-sm font-medium border-b-2">
                    Sertifikat <span class="ml-1 text-xs bg-gray-100 rounded-full px-2 py-0.5">{{ $pendingCertificates->count() }}</span>
                </button>
                <button @click="tab = 'portfolio'"
                    :class="tab === 'portfolio' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-2 text-sm font-medium border-b-2">
                    Portfolio <span class="ml-1 text-xs bg-gray-100 rounded-full px-2 py-0.5">{{ $pendingPortfolios->count() }}</span>
                </button>
            </div>

            {{-- TAB: SKILL --}}
            <div x-show="tab === 'skill'" x-cloak class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Skill</th>
                            <th class="px-4 py-3">Level</th>
                            <th class="px-4 py-3">Bukti</th>
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
                                        <a href="{{ Storage::url($skill->evidence_file) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.verifications.skills.approve', $skill) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="points" min="0" max="100" value="1" required
                                                class="w-16 rounded-lg border-gray-300 text-sm py-1 px-2">
                                            <button type="submit" onclick="return confirm('Setujui skill ini?')"
                                                class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.verifications.skills.reject', $skill) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                            @csrf
                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium px-3 py-1.5 rounded-lg">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada pengajuan skill pending. 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TAB: CERTIFICATE --}}
            <div x-show="tab === 'certificate'" x-cloak class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">File</th>
                            <th class="px-4 py-3 w-64">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingCertificates as $cert)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800">{{ $cert->student->name }}</div>
                                    <div class="text-gray-400 text-xs">{{ $cert->student->email }}</div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $cert->title }}</td>
                                <td class="px-4 py-3 text-gray-600 capitalize">{{ $cert->category }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ Storage::url($cert->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.verifications.certificates.approve', $cert) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="points" min="0" max="100" value="{{ $cert->defaultPoint() }}" required
                                                class="w-16 rounded-lg border-gray-300 text-sm py-1 px-2">
                                            <button type="submit" onclick="return confirm('Setujui sertifikat ini?')"
                                                class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.verifications.certificates.reject', $cert) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                            @csrf
                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium px-3 py-1.5 rounded-lg">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada pengajuan sertifikat pending. 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TAB: PORTFOLIO --}}
            <div x-show="tab === 'portfolio'" x-cloak class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Mahasiswa</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Bukti</th>
                            <th class="px-4 py-3 w-64">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingPortfolios as $pf)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800">{{ $pf->student->name }}</div>
                                    <div class="text-gray-400 text-xs">{{ $pf->student->email }}</div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $pf->title }}</td>
                                <td class="px-4 py-3 text-gray-600 capitalize">{{ $pf->category }}</td>
                                <td class="px-4 py-3 space-x-2">
                                    @if ($pf->link)
                                        <a href="{{ $pf->link }}" target="_blank" class="text-indigo-600 hover:underline">Link</a>
                                    @endif
                                    @if ($pf->file_path)
                                        <a href="{{ Storage::url($pf->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">File</a>
                                    @endif
                                    @if (!$pf->link && !$pf->file_path)
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.verifications.portfolios.approve', $pf) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="points" min="0" max="100" value="{{ $pf->defaultPoint() }}" required
                                                class="w-16 rounded-lg border-gray-300 text-sm py-1 px-2">
                                            <button type="submit" onclick="return confirm('Setujui portfolio ini?')"
                                                class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.verifications.portfolios.reject', $pf) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                            @csrf
                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium px-3 py-1.5 rounded-lg">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada pengajuan portfolio pending. 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
