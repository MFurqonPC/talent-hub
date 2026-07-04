<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo / Brand --}}
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mahasiswa.profile.edit') }}" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L1 8.5L12 14L21 9.7V16.5H23V8.5L12 3Z" fill="currentColor"/>
                                <path d="M5 11.5V16.5C5 16.5 7.5 19 12 19C16.5 19 19 16.5 19 16.5V11.5L12 15L5 11.5Z" fill="currentColor" opacity="0.7"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800 hidden sm:inline">University Talent Hub</span>
                    </a>
                </div>

                {{-- Desktop Nav Links --}}
                <div class="hidden lg:ml-8 lg:flex lg:space-x-1 lg:items-center">
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link-uth :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link-uth>
                        <x-nav-link-uth :href="route('admin.verifications.index')" :active="request()->routeIs('admin.verifications.*')">Verifikasi</x-nav-link-uth>
                        <x-nav-link-uth :href="route('admin.rewards.index')" :active="request()->routeIs('admin.rewards.*')">Reward</x-nav-link-uth>
                        <x-nav-link-uth :href="route('admin.opportunities.index')" :active="request()->routeIs('admin.opportunities.*')">Opportunity</x-nav-link-uth>
                        <x-nav-link-uth :href="route('admin.leaderboard')" :active="request()->routeIs('admin.leaderboard')">Leaderboard</x-nav-link-uth>
                    @else
                        <x-nav-link-uth :href="route('mahasiswa.profile.edit')" :active="request()->routeIs('mahasiswa.profile.*')">Profil</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.skills.index')" :active="request()->routeIs('mahasiswa.skills.*')">Skill</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.certificates.index')" :active="request()->routeIs('mahasiswa.certificates.*')">Sertifikat</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.portfolios.index')" :active="request()->routeIs('mahasiswa.portfolios.*')">Portfolio</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.leaderboard')" :active="request()->routeIs('mahasiswa.leaderboard')">Leaderboard</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.rewards.index')" :active="request()->routeIs('mahasiswa.rewards.*')">Reward</x-nav-link-uth>
                        <x-nav-link-uth :href="route('mahasiswa.recommendations.index')" :active="request()->routeIs('mahasiswa.recommendations.*')">Rekomendasi</x-nav-link-uth>
                    @endif
                </div>
            </div>

            {{-- Right side: points badge + user dropdown --}}
            <div class="hidden lg:flex lg:items-center lg:gap-4">
                @if (auth()->user()->role === 'mahasiswa')
                    <div class="flex items-center gap-1.5 bg-indigo-50 text-indigo-700 text-sm font-semibold px-3 py-1.5 rounded-full">
                        <span>⭐</span> {{ auth()->user()->points }} pts
                    </div>
                @endif

                <div class="relative" x-data="{ userMenu: false }">
                    <button @click="userMenu = !userMenu" @click.away="userMenu = false"
                        class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="userMenu" x-cloak x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pengaturan Akun</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile hamburger --}}
            <div class="flex items-center lg:hidden">
                @if (auth()->user()->role === 'mahasiswa')
                    <div class="flex items-center gap-1 bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full mr-2">
                        ⭐ {{ auth()->user()->points }}
                    </div>
                @endif
                <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="lg:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @if (auth()->user()->role === 'admin')
                <x-nav-link-uth mobile :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('admin.verifications.index')" :active="request()->routeIs('admin.verifications.*')">Verifikasi</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('admin.rewards.index')" :active="request()->routeIs('admin.rewards.*')">Reward</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('admin.opportunities.index')" :active="request()->routeIs('admin.opportunities.*')">Opportunity</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('admin.leaderboard')" :active="request()->routeIs('admin.leaderboard')">Leaderboard</x-nav-link-uth>
            @else
                <x-nav-link-uth mobile :href="route('mahasiswa.profile.edit')" :active="request()->routeIs('mahasiswa.profile.*')">Profil</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.skills.index')" :active="request()->routeIs('mahasiswa.skills.*')">Skill</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.certificates.index')" :active="request()->routeIs('mahasiswa.certificates.*')">Sertifikat</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.portfolios.index')" :active="request()->routeIs('mahasiswa.portfolios.*')">Portfolio</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.leaderboard')" :active="request()->routeIs('mahasiswa.leaderboard')">Leaderboard</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.rewards.index')" :active="request()->routeIs('mahasiswa.rewards.*')">Reward</x-nav-link-uth>
                <x-nav-link-uth mobile :href="route('mahasiswa.recommendations.index')" :active="request()->routeIs('mahasiswa.recommendations.*')">Rekomendasi</x-nav-link-uth>
            @endif
            <div class="border-t border-gray-100 pt-2 mt-2">
                <div class="px-3 py-1 text-xs text-gray-400">{{ auth()->user()->name }}</div>
                <x-nav-link-uth mobile :href="route('profile.edit')" :active="false">Pengaturan Akun</x-nav-link-uth>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>