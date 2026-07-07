<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * List skill milik mahasiswa yang sedang login.
     */
    public function index()
    {
        $skills = Skill::where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('mahasiswa.skills.index', compact('skills'));
    }

    /**
     * Simpan skill baru (status default: pending, menunggu verifikasi admin).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:100'],
            'evidence_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'skill_name.required' => 'Nama skill wajib diisi.',
            'evidence_file.mimes' => 'File bukti harus berformat PDF/JPG/PNG.',
            'evidence_file.max' => 'Ukuran file bukti maksimal 2MB.',
        ]);

        $path = null;
        if ($request->hasFile('evidence_file')) {
            $path = $request->file('evidence_file')->store('skill-evidence', 'public');
        }

        Skill::create([
            'student_id' => auth()->id(),
            'skill_name' => $validated['skill_name'],
            'level' => $validated['level'] ?? null,
            'evidence_file' => $path,
            'status' => 'pending',
            'point_value' => 0,
        ]);

        return redirect()
            ->route('mahasiswa.skills.index')
            ->with('success', 'Skill berhasil diajukan, menunggu verifikasi admin.');
    }

    /**
     * Update skill yang masih pending. Skill yang sudah approved/rejected
     * tidak boleh diubah demi menjaga integritas poin.
     */
    public function update(Request $request, Skill $skill)
    {
        abort_unless($skill->student_id === auth()->id(), 403);
        abort_unless($skill->status === 'pending', 403, 'Skill yang sudah diverifikasi tidak dapat diubah.');

        $validated = $request->validate([
            'skill_name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:100'],
            'evidence_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'skill_name.required' => 'Nama skill wajib diisi.',
            'evidence_file.mimes' => 'File bukti harus berformat PDF/JPG/PNG.',
            'evidence_file.max' => 'Ukuran file bukti maksimal 2MB.',
        ]);

        if ($request->hasFile('evidence_file')) {
            if ($skill->evidence_file) {
                Storage::disk('public')->delete($skill->evidence_file);
            }
            $validated['evidence_file'] = $request->file('evidence_file')->store('skill-evidence', 'public');
        }

        $skill->update([
            'skill_name' => $validated['skill_name'],
            'level' => $validated['level'] ?? null,
            'evidence_file' => $validated['evidence_file'] ?? $skill->evidence_file,
        ]);

        return redirect()
            ->route('mahasiswa.skills.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }

    /**
     * (Opsional) Mahasiswa hanya boleh menghapus skill yang masih pending,
     * skill yang sudah approved/rejected tidak boleh diubah demi menjaga integritas poin.
     */
    public function destroy(Skill $skill)
    {
        abort_unless($skill->student_id === auth()->id(), 403);
        abort_unless($skill->status === 'pending', 403, 'Skill yang sudah diverifikasi tidak dapat dihapus.');

        $skill->delete();

        return back()->with('success', 'Pengajuan skill dibatalkan.');
    }
}
