<x-app-layout>
    <x-slot name="header">
        <h2 class="uth-display font-bold text-xl text-slate-800 leading-tight">{{ __('Portfolio Saya') }}</h2>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false, editing: null, editForm: {} }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

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

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                <p class="text-slate-500 text-sm">Isi link (GitHub/Behance/dll) atau unggah file sebagai bukti portfolio.</p>
                <button @click="showModal = true"
                    class="inline-flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold shadow-sm shadow-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 whitespace-nowrap">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    Tambah Portfolio
                </button>
            </div>

            @php
                $pfBadge = [
                    'pending' => 'bg-amber-100 text-amber-700',
                    'approved' => 'bg-green-100 text-green-700',
                    'rejected' => 'bg-red-100 text-red-700',
                ];
            @endphp

            {{-- Tabel: desktop --}}
            <div class="hidden sm:block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Bukti</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($portfolios as $pf)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $pf->title }}</td>
                                <td class="px-4 py-3 text-slate-600 capitalize">{{ $pf->category }}</td>
                                <td class="px-4 py-3 space-x-2">
                                    @if ($pf->link)<a href="{{ $pf->link }}" target="_blank" class="text-indigo-600 hover:underline">Link</a>@endif
                                    @if ($pf->file_path)<a href="{{ Storage::url($pf->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">File</a>@endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $pfBadge[$pf->status] }}">{{ ucfirst($pf->status) }}</span>
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $pf->point_value }}</td>
                                <td class="px-4 py-3">
                                    @if ($pf->status === 'pending')
                                        <div class="flex items-center gap-3">
                                            <button
                                                @click="showModal = true; editing = {{ $pf->id }}; editForm = { title: {{ Js::from($pf->title) }}, category: {{ Js::from($pf->category) }}, description: {{ Js::from($pf->description) }}, link: {{ Js::from($pf->link) }} }"
                                                class="text-indigo-600 hover:underline text-xs">
                                                Edit
                                            </button>
                                            <form action="{{ route('mahasiswa.portfolios.destroy', $pf) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline text-xs">Batalkan</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-slate-400">Belum ada portfolio yang diajukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Card list: mobile --}}
            <div class="sm:hidden space-y-3">
                @forelse ($portfolios as $pf)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $pf->title }}</p>
                                <p class="text-slate-500 text-xs capitalize">{{ $pf->category }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $pfBadge[$pf->status] }}">
                                {{ ucfirst($pf->status) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100 text-sm">
                            <span class="font-semibold text-slate-800">{{ $pf->point_value }} poin</span>
                            <div class="space-x-2">
                                @if ($pf->link)<a href="{{ $pf->link }}" target="_blank" class="text-indigo-600 text-xs">Link</a>@endif
                                @if ($pf->file_path)<a href="{{ Storage::url($pf->file_path) }}" target="_blank" class="text-indigo-600 text-xs">File</a>@endif
                            </div>
                        </div>
                        @if ($pf->status === 'pending')
                            <div class="flex items-center gap-4 mt-3">
                                <button
                                    @click="showModal = true; editing = {{ $pf->id }}; editForm = { title: {{ Js::from($pf->title) }}, category: {{ Js::from($pf->category) }}, description: {{ Js::from($pf->description) }}, link: {{ Js::from($pf->link) }} }"
                                    class="text-indigo-600 text-xs font-medium">Edit</button>
                                <form action="{{ route('mahasiswa.portfolios.destroy', $pf) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 text-xs font-medium">Batalkan</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center text-slate-400 text-sm">
                        Belum ada portfolio yang diajukan.
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-end sm:items-center justify-center z-50 p-0 sm:p-4">
            <div @click.away="showModal = false" class="bg-white rounded-t-2xl sm:rounded-2xl shadow-lg w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="uth-display text-lg font-bold text-slate-800 mb-4" x-text="editing ? 'Edit Portfolio' : 'Tambah Portfolio'"></h3>

                {{-- Form Tambah --}}
                <form x-show="!editing" action="{{ route('mahasiswa.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul Portfolio</label>
                        <input type="text" name="title" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500" placeholder="Contoh: Landing Page UMKM">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select name="category" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="personal">Personal</option>
                            <option value="freelance">Freelance</option>
                            <option value="industri">Industri</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (opsional)</label>
                        <textarea name="description" rows="2" class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Link (GitHub, Behance, dll)</label>
                        <input type="url" name="link" class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Atau Unggah File</label>
                        <input type="file" name="file_path" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-medium hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-400 mt-1">Isi salah satu: Link atau File. Maks 2MB.</p>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 pt-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2.5 rounded-lg text-slate-600 hover:bg-slate-100 text-sm font-medium">Batal</button>
                        <button type="submit" class="px-4 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm shadow-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Ajukan Portfolio</button>
                    </div>
                </form>

                {{-- Form Edit (dinamis, method PUT) --}}
                <template x-if="editing">
                    <form :action="'/mahasiswa/portfolios/' + editing" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Judul Portfolio</label>
                            <input type="text" name="title" x-model="editForm.title" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                            <select name="category" x-model="editForm.category" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500">
                                <option value="personal">Personal</option>
                                <option value="freelance">Freelance</option>
                                <option value="industri">Industri</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (opsional)</label>
                            <textarea name="description" x-model="editForm.description" rows="2" class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Link (GitHub, Behance, dll)</label>
                            <input type="url" name="link" x-model="editForm.link" class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500" placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ganti File (opsional)</label>
                            <input type="file" name="file_path" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-medium hover:file:bg-indigo-100">
                            <p class="text-xs text-slate-400 mt-1">Kosongkan kalau tidak ingin mengganti file lama. Wajib isi Link ATAU sudah ada file sebelumnya.</p>
                        </div>
                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 pt-2">
                            <button type="button" @click="showModal = false" class="px-4 py-2.5 rounded-lg text-slate-600 hover:bg-slate-100 text-sm font-medium">Batal</button>
                            <button type="submit" class="px-4 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm shadow-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Update Portfolio</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
