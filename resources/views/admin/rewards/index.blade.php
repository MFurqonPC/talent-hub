<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reward Management') }}</h2>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false, editing: null, form: {} }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                <p class="text-gray-600 text-sm">Kelola daftar reward yang bisa diklaim mahasiswa dengan poin mereka.</p>
                <button @click="showModal = true; editing = null"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
                    + Tambah Reward
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($rewards as $reward)
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <img src="{{ $reward->image ? Storage::url($reward->image) : 'https://ui-avatars.com/api/?name='.urlencode($reward->title).'&background=e0e7ff&color=4f46e5&size=256' }}"
                            class="w-full h-32 object-cover">
                        <div class="p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold text-gray-800">{{ $reward->title }}</h3>
                                @if (!$reward->is_active)
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Nonaktif</span>
                                @endif
                            </div>
                            <p class="text-gray-500 text-xs line-clamp-2">{{ $reward->description }}</p>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-indigo-600 font-bold text-sm">{{ $reward->points_required }} pts</span>
                                <span class="text-gray-500 text-xs">Stok: {{ $reward->stock }}</span>
                            </div>
                            <div class="flex gap-2 pt-2">
                                <button
                                    @click="showModal = true; editing = {{ $reward->id }}; form = { title: {{ Js::from($reward->title) }}, description: {{ Js::from($reward->description) }}, points_required: {{ $reward->points_required }}, stock: {{ $reward->stock }}, is_active: {{ $reward->is_active ? 'true' : 'false' }} }"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium py-1.5 rounded-lg">
                                    Edit
                                </button>
                                <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST"
                                    onsubmit="return confirm('Hapus reward ini?')" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button class="w-full bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium py-1.5 rounded-lg">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm col-span-3 text-center py-8">Belum ada reward. Tambahkan reward pertama!</p>
                @endforelse
            </div>
        </div>

        {{-- Modal tambah/edit --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4" x-text="editing ? 'Edit Reward' : 'Tambah Reward'"></h3>

                {{-- Form Create --}}
                <form x-show="!editing" action="{{ route('admin.rewards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Reward</label>
                        <input type="text" name="title" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Voucher Kantin 20rb">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin Dibutuhkan</label>
                            <input type="number" name="points_required" min="1" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" name="stock" min="0" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (opsional)</label>
                        <input type="file" name="image" accept=".jpg,.jpeg,.png" class="w-full text-sm text-gray-600">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="is_active" checked class="rounded border-gray-300 text-indigo-600"> Aktif (tampil di katalog mahasiswa)
                    </label>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">Simpan</button>
                    </div>
                </form>

                {{-- Form Edit (dinamis per reward, method PUT) --}}
                <template x-if="editing">
                    <form :action="'/admin/rewards/' + editing" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Reward</label>
                            <input type="text" name="title" x-model="form.title" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" x-model="form.description" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Poin Dibutuhkan</label>
                                <input type="number" name="points_required" x-model="form.points_required" min="1" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                <input type="number" name="stock" x-model="form.stock" min="0" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (opsional)</label>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png" class="w-full text-sm text-gray-600">
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_active" x-model="form.is_active" class="rounded border-gray-300 text-indigo-600"> Aktif (tampil di katalog mahasiswa)
                        </label>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-sm">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">Update</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
