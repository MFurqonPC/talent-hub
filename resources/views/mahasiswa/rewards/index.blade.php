<x-app-layout>
    <x-slot name="header">
        <h2 class="uth-display font-bold text-lg sm:text-xl text-slate-800 leading-tight">{{ __('Reward Catalog') }}</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">{{ $errors->first() }}</div>
            @endif

            {{-- Info poin --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-2xl shadow-lg shadow-indigo-100 p-6 flex justify-between items-center">
                <div class="absolute -right-6 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
                <div class="relative">
                    <p class="text-indigo-100 text-sm">Poin Kamu Saat Ini</p>
                    <p class="uth-display text-3xl font-bold">{{ $myPoints }} pts</p>
                </div>
                <div class="relative w-14 h-14 rounded-xl bg-white/15 flex items-center justify-center">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 12v9H4v-9"/>
                        <path d="M2 7h20v5H2z"/>
                        <path d="M12 22V7"/>
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7Z"/>
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7Z"/>
                    </svg>
                </div>
            </div>

            {{-- Katalog reward --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($rewards as $reward)
                    @php $canClaim = $myPoints >= $reward->points_required; @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden {{ !$canClaim ? 'opacity-70' : '' }}">
                        <img src="{{ $reward->image ? Storage::url($reward->image) : 'https://ui-avatars.com/api/?name='.urlencode($reward->title).'&background=e0e7ff&color=4f46e5&size=256' }}"
                            class="w-full h-32 object-cover">
                        <div class="p-4 space-y-2">
                            <h3 class="font-semibold text-slate-800">{{ $reward->title }}</h3>
                            <p class="text-slate-500 text-xs line-clamp-2">{{ $reward->description }}</p>
                            <div class="flex justify-between items-center pt-1">
                                <span class="inline-flex items-center gap-1 text-amber-600 font-bold text-sm">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                                    </svg>
                                    {{ $reward->points_required }} pts
                                </span>
                                <span class="text-slate-400 text-xs">Stok: {{ $reward->stock }}</span>
                            </div>
                            <form action="{{ route('mahasiswa.rewards.claim', $reward) }}" method="POST"
                                onsubmit="return confirm('Klaim reward ini dengan {{ $reward->points_required }} poin?')">
                                @csrf
                                <button type="submit" {{ !$canClaim ? 'disabled' : '' }}
                                    class="w-full mt-2 text-sm font-semibold py-2.5 rounded-lg transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500
                                    {{ $canClaim ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-100' : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}">
                                    {{ $canClaim ? 'Klaim Sekarang' : 'Poin Belum Cukup' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm col-span-3 text-center py-8">Belum ada reward tersedia saat ini.</p>
                @endforelse
            </div>

            {{-- Riwayat klaim --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="uth-display font-semibold text-slate-800 mb-4">Riwayat Klaim Saya</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-slate-500 text-xs uppercase border-b border-slate-100">
                            <tr>
                                <th class="py-2 pr-4">Reward</th>
                                <th class="py-2 pr-4">Poin</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2">Tanggal Klaim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($myClaims as $claim)
                                <tr>
                                    <td class="py-2 pr-4 font-medium text-slate-800">{{ $claim->reward->title ?? '-' }}</td>
                                    <td class="py-2 pr-4 text-slate-600">{{ $claim->reward->points_required ?? '-' }}</td>
                                    <td class="py-2 pr-4">
                                        @php
                                            $badge = ['pending' => 'bg-amber-100 text-amber-700', 'approved' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-green-100 text-green-700'][$claim->status];
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($claim->status) }}</span>
                                    </td>
                                    <td class="py-2 text-slate-500 text-xs">{{ $claim->claimed_at?->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-4 text-center text-slate-400">Belum pernah klaim reward.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
