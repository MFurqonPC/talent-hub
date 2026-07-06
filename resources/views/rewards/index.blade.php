<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reward Catalog') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">{{ $errors->first() }}</div>
            @endif

            {{-- Info poin --}}
            <div class="bg-indigo-600 text-white rounded-xl shadow p-5 flex justify-between items-center">
                <div>
                    <p class="text-indigo-100 text-sm">Poin Kamu Saat Ini</p>
                    <p class="text-3xl font-bold">{{ $myPoints }} pts</p>
                </div>
                <span class="text-4xl">🎁</span>
            </div>

            {{-- Katalog reward --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($rewards as $reward)
                    @php $canClaim = $myPoints >= $reward->points_required; @endphp
                    <div class="bg-white rounded-xl shadow overflow-hidden {{ !$canClaim ? 'opacity-70' : '' }}">
                        <img src="{{ $reward->image ? Storage::url($reward->image) : 'https://ui-avatars.com/api/?name='.urlencode($reward->title).'&background=e0e7ff&color=4f46e5&size=256' }}"
                            class="w-full h-32 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="font-semibold text-gray-800">{{ $reward->title }}</h3>
                            <p class="text-gray-500 text-xs line-clamp-2">{{ $reward->description }}</p>
                            <div class="flex justify-between items-center pt-1">
                                <span class="text-indigo-600 font-bold text-sm">{{ $reward->points_required }} pts</span>
                                <span class="text-gray-400 text-xs">Stok: {{ $reward->stock }}</span>
                            </div>
                            <form action="{{ route('mahasiswa.rewards.claim', $reward) }}" method="POST"
                                onsubmit="return confirm('Klaim reward ini dengan {{ $reward->points_required }} poin?')">
                                @csrf
                                <button type="submit" {{ !$canClaim ? 'disabled' : '' }}
                                    class="w-full mt-2 text-sm font-medium py-2 rounded-lg
                                    {{ $canClaim ? 'bg-indigo-600 hover:bg-indigo-700 text-white' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                                    {{ $canClaim ? 'Klaim Sekarang' : 'Poin Belum Cukup' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm col-span-3 text-center py-8">Belum ada reward tersedia saat ini.</p>
                @endforelse
            </div>

            {{-- Riwayat klaim --}}
            <div class="bg-white rounded-xl shadow p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Riwayat Klaim Saya</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-gray-500 text-xs uppercase border-b">
                            <tr>
                                <th class="py-2 pr-4">Reward</th>
                                <th class="py-2 pr-4">Poin</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2">Tanggal Klaim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($myClaims as $claim)
                                <tr>
                                    <td class="py-2 pr-4 font-medium text-gray-800">{{ $claim->reward->title ?? '-' }}</td>
                                    <td class="py-2 pr-4 text-gray-600">{{ $claim->reward->points_required ?? '-' }}</td>
                                    <td class="py-2 pr-4">
                                        @php
                                            $badge = ['pending' => 'bg-yellow-100 text-yellow-700', 'approved' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-green-100 text-green-700'][$claim->status];
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($claim->status) }}</span>
                                    </td>
                                    <td class="py-2 text-gray-500 text-xs">{{ $claim->claimed_at?->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-4 text-center text-gray-400">Belum pernah klaim reward.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
