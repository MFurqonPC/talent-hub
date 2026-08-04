<x-app-layout>
    <x-slot name="header">
        <h2 class="uth-display font-bold text-lg sm:text-xl text-slate-800 leading-tight">{{ __('Talent Profile') }}</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{-- Ringkasan Talenta --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl shadow-lg shadow-indigo-100 text-white p-6">
                <div class="absolute -right-8 -top-10 w-36 h-36 rounded-full bg-white/10"></div>
                <div class="relative flex items-center gap-4">
                    <img src="{{ $profile->photo ? Storage::url($profile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=ffffff&color=4f46e5' }}"
                        alt="Foto profil" class="w-20 h-20 rounded-full object-cover border-2 border-white/60">
                    <div>
                        <h3 class="uth-display text-lg font-bold">{{ $user->name }}</h3>
                        <p class="text-indigo-100 text-sm">{{ $profile->jurusan ?? 'Jurusan belum diisi' }} @if($profile->angkatan) · Angkatan {{ $profile->angkatan }} @endif</p>
                        <span class="inline-flex items-center gap-1 mt-2 bg-white/15 text-white font-semibold text-sm px-2.5 py-1 rounded-full">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                            </svg>
                            {{ $summary['points'] }} Poin
                        </span>
                    </div>
                </div>

                <div class="relative grid grid-cols-3 gap-3 mt-6">
                    <div class="bg-white/10 rounded-xl py-3 text-center">
                        <p class="uth-display text-2xl font-bold">{{ $summary['skills_approved'] }}</p>
                        <p class="text-xs text-indigo-100">Skill Terverifikasi</p>
                    </div>
                    <div class="bg-white/10 rounded-xl py-3 text-center">
                        <p class="uth-display text-2xl font-bold">{{ $summary['certificates_approved'] }}</p>
                        <p class="text-xs text-indigo-100">Sertifikat Terverifikasi</p>
                    </div>
                    <div class="bg-white/10 rounded-xl py-3 text-center">
                        <p class="uth-display text-2xl font-bold">{{ $summary['portfolios_approved'] }}</p>
                        <p class="text-xs text-indigo-100">Portfolio Terverifikasi</p>
                    </div>
                </div>
            </div>

            {{-- Form edit profil --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="uth-display font-semibold text-slate-800 mb-4">Lengkapi Profil</h3>
                <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto Profil</label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                            class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-medium hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-400 mt-1">Format JPG/PNG, maks 2MB.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">NIM</label>
                            <input type="text" name="nim" value="{{ old('nim', $profile->nim) }}"
                                class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Angkatan</label>
                            <input type="text" name="angkatan" value="{{ old('angkatan', $profile->angkatan) }}"
                                placeholder="Contoh: 2022"
                                class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $profile->jurusan) }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Bio Singkat</label>
                        <textarea name="bio" rows="3" placeholder="Ceritakan minat, keahlian, atau tujuan kariermu..."
                            class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm shadow-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
