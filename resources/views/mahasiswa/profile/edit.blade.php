<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Talent Profile') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

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

            {{-- Ringkasan Talenta --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $profile->photo ? Storage::url($profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=6366f1&color=fff' }}"
                        alt="Foto profil" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $profile->jurusan ?? 'Jurusan belum diisi' }} @if($profile->angkatan) · Angkatan {{ $profile->angkatan }} @endif</p>
                        <p class="text-indigo-600 font-semibold text-sm mt-1">{{ $summary['points'] }} Poin</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                    <div class="bg-gray-50 rounded-lg py-3">
                        <p class="text-2xl font-bold text-gray-800">{{ $summary['skills_approved'] }}</p>
                        <p class="text-xs text-gray-500">Skill Terverifikasi</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg py-3">
                        <p class="text-2xl font-bold text-gray-800">{{ $summary['certificates_approved'] }}</p>
                        <p class="text-xs text-gray-500">Sertifikat Terverifikasi</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg py-3">
                        <p class="text-2xl font-bold text-gray-800">{{ $summary['portfolios_approved'] }}</p>
                        <p class="text-xs text-gray-500">Portfolio Terverifikasi</p>
                    </div>
                </div>
            </div>

            {{-- Form edit profil --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Lengkapi Profil</h3>
                <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="w-full text-sm text-gray-600">
                        <p class="text-xs text-gray-400 mt-1">Format JPG/PNG, maks 2MB.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                            <input type="text" name="nim" value="{{ old('nim', $profile->nim) }}"
                                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                            <input type="text" name="angkatan" value="{{ old('angkatan', $profile->angkatan) }}"
                                placeholder="Contoh: 2022"
                                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $profile->jurusan) }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio Singkat</label>
                        <textarea name="bio" rows="3" placeholder="Ceritakan minat, keahlian, atau tujuan kariermu..."
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
