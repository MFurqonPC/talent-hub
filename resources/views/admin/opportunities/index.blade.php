<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Posting Opportunity') }}</h2>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <p class="text-gray-600 text-sm">Opportunity yang diposting di sini akan otomatis dicocokkan (AI Recommendation) ke mahasiswa berdasarkan skill_tags.</p>
                <button @click="showModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">+ Post Opportunity</button>
            </div>

            <div class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Skill Tags</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($opportunities as $opp)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $opp->title }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    @foreach ($opp->tagsArray() as $tag)
                                        <span class="inline-block bg-indigo-50 text-indigo-600 text-xs px-2 py-0.5 rounded-full mr-1 mb-1">{{ $tag }}</span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $opp->deadline?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.opportunities.destroy', $opp) }}" method="POST" onsubmit="return confirm('Hapus opportunity ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada opportunity yang diposting.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Post Opportunity Baru</h3>
                <form action="{{ route('admin.opportunities.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Dibutuhkan Videografer untuk Event Kampus">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Tags (pisahkan koma)</label>
                        <input type="text" name="skill_tags" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="videografi,editing,adobe premiere">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deadline (opsional)</label>
                        <input type="date" name="deadline" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">Posting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
