<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800">
        Dashboard Mahasiswa
    </h2>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto px-6">

        <div class="bg-indigo-600 rounded-xl text-white p-6 mb-8">
            <h1 class="text-3xl font-bold">
                Selamat Datang, {{ $user->name }}
            </h1>

            <p class="mt-2 text-indigo-100">
                Tingkatkan poinmu dengan menambahkan skill, sertifikat, dan portfolio.
            </p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500">Total Poin</p>
                <h2 class="text-4xl font-bold text-indigo-600">
                    {{ $summary['points'] }}
                </h2>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500">Skill Approved</p>
                <h2 class="text-4xl font-bold">
                    {{ $summary['skills'] }}
                </h2>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500">Certificate</p>
                <h2 class="text-4xl font-bold">
                    {{ $summary['certificates'] }}
                </h2>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500">Portfolio</p>
                <h2 class="text-4xl font-bold">
                    {{ $summary['portfolios'] }}
                </h2>
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-6 mt-8">

            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-xl font-bold mb-4">
                    Reward yang Bisa Diklaim
                </h3>

                @forelse($rewards as $reward)

                    <div class="border rounded-lg p-4 mb-3">
                        <div class="font-semibold">
                            {{ $reward->title }}
                        </div>

                        <div class="text-gray-500">
                            {{ $reward->points_required }} poin
                        </div>
                    </div>

                @empty

                    <p class="text-gray-500">
                        Belum ada reward yang bisa diklaim.
                    </p>

                @endforelse

            </div>

            <div class="bg-white shadow rounded-xl p-6">

                <h3 class="text-xl font-bold mb-4">
                    Opportunity Terbaru
                </h3>

                @forelse($opportunities as $item)

                    <div class="border rounded-lg p-4 mb-3">

                        <div class="font-semibold">
                            {{ $item->title }}
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ $item->skill_tags }}
                        </div>

                    </div>

                @empty

                    <p class="text-gray-500">
                        Belum ada opportunity.
                    </p>

                @endforelse

            </div>

        </div>

    </div>
</div>

</x-app-layout>