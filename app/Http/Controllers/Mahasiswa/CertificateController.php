<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('mahasiswa.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:lokal,regional,nasional,internasional'],
            'file_path' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'title.required' => 'Nama sertifikat wajib diisi.',
            'category.required' => 'Kategori sertifikat wajib dipilih.',
            'file_path.required' => 'File sertifikat wajib diunggah sebagai bukti.',
        ]);

        $path = $request->file('file_path')->store('certificates', 'public');

        Certificate::create([
            'student_id' => auth()->id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'file_path' => $path,
            'status' => 'pending',
            'point_value' => 0,
        ]);

        return redirect()
            ->route('mahasiswa.certificates.index')
            ->with('success', 'Sertifikat berhasil diajukan, menunggu verifikasi admin.');
    }

    public function destroy(Certificate $certificate)
    {
        abort_unless($certificate->student_id === auth()->id(), 403);
        abort_unless($certificate->status === 'pending', 403, 'Sertifikat yang sudah diverifikasi tidak dapat dihapus.');

        $certificate->delete();

        return back()->with('success', 'Pengajuan sertifikat dibatalkan.');
    }
}
