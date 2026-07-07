<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sertifikat Saya') }}</h2>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false, editing: null, editForm: {} }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                <p class="text-gray-600 text-sm">Poin sertifikat ditentukan berdasarkan kategori setelah disetujui admin.</p>
                <button @click="showModal = true; editing = null" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">+ Tambah Sertifikat</button>
            </div>

            <div class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">File</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($certificates as $cert)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $cert->title }}</td>
                                <td class="px-4 py-3 text-gray-600 capitalize">{{ $cert->category }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ Storage::url($cert->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat File</a>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $badge = ['pending' => 'bg-yellow-100 text-yellow-700', 'approved' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700'][$cert->status];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($cert->status) }}</span>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ $cert->point_value }}</td>
                                <td class="px-4 py-3">
                                    @if ($cert->status === 'pending')
                                        <div class="flex items-center gap-3">
                                            <button
                                                @click="showModal = true; editing = {{ $cert->id }}; editForm = { title: {{ Js::from($cert->title) }}, category: {{ Js::from($cert->category) }} }"
                                                class="text-indigo-600 hover:underline text-xs">
                                                Edit
                                            </button>
                                            <form action="{{ route('mahasiswa.certificates.destroy', $cert) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline text-xs">Batalkan</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada sertifikat yang diajukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal tambah/edit sertifikat --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4" x-text="editing ? 'Edit Sertifikat' : 'Tambah Sertifikat'"></h3>

                {{-- Form Tambah --}}
                <form x-show="!editing" action="{{ route('mahasiswa.certificates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Sertifikat</label>
                        <input type="text" name="title" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Sertifikat Lomba Web Design">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="lokal">Lokal</option>
                            <option value="regional">Regional</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Sertifikat</label>
                        <input type="file" name="file_path" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-600">
                        <p class="text-xs text-gray-400 mt-1">Format PDF/JPG/PNG, maks 2MB.</p>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">Ajukan Sertifikat</button>
                    </div>
                </form>

                {{-- Form Edit (dinamis, method PUT) --}}
                <template x-if="editing">
                    <form :action="'/mahasiswa/certificates/' + editing" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Sertifikat</label>
                            <input type="text" name="title" x-model="editForm.title" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category" x-model="editForm.category" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="lokal">Lokal</option>
                                <option value="regional">Regional</option>
                                <option value="nasional">Nasional</option>
                                <option value="internasional">Internasional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti File (opsional)</label>
                            <input type="file" name="file_path" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm text-gray-600">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan kalau tidak ingin mengganti file lama.</p>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showModal = false" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-sm">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">Update Sertifikat</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
