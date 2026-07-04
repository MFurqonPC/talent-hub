<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /**
     * Tampilkan seluruh pengajuan (skill, sertifikat, portfolio) yang masih pending.
     */
    public function index()
    {
        $pendingSkills = Skill::with('student')->pending()->latest()->get();
        $pendingCertificates = Certificate::with('student')->pending()->latest()->get();
        $pendingPortfolios = Portfolio::with('student')->pending()->latest()->get();

        return view('admin.verifications.index', compact(
            'pendingSkills', 'pendingCertificates', 'pendingPortfolios'
        ));
    }

    // ===================== SKILL =====================

    public function approveSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'points' => ['required', 'integer', 'min:0', 'max:100'],
        ], ['points.required' => 'Poin wajib diisi sebelum menyetujui.']);

        if ($skill->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($skill, $validated) {
            $skill->update([
                'status' => 'approved',
                'point_value' => $validated['points'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            $skill->student()->increment('points', $validated['points']);

            PointHistory::create([
                'student_id' => $skill->student_id,
                'source_type' => 'skill',
                'source_id' => $skill->id,
                'points' => $validated['points'],
                'note' => "Skill '{$skill->skill_name}' disetujui oleh admin.",
            ]);
        });

        return back()->with('success', 'Skill disetujui dan poin telah diberikan.');
    }

    public function rejectSkill(Skill $skill)
    {
        if ($skill->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        $skill->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Skill ditolak.');
    }

    // ===================== CERTIFICATE =====================

    public function approveCertificate(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'points' => ['required', 'integer', 'min:0', 'max:100'],
        ], ['points.required' => 'Poin wajib diisi sebelum menyetujui.']);

        if ($certificate->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($certificate, $validated) {
            $certificate->update([
                'status' => 'approved',
                'point_value' => $validated['points'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            $certificate->student()->increment('points', $validated['points']);

            PointHistory::create([
                'student_id' => $certificate->student_id,
                'source_type' => 'certificate',
                'source_id' => $certificate->id,
                'points' => $validated['points'],
                'note' => "Sertifikat '{$certificate->title}' ({$certificate->category}) disetujui oleh admin.",
            ]);
        });

        return back()->with('success', 'Sertifikat disetujui dan poin telah diberikan.');
    }

    public function rejectCertificate(Certificate $certificate)
    {
        if ($certificate->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        $certificate->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Sertifikat ditolak.');
    }

    // ===================== PORTFOLIO =====================

    public function approvePortfolio(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'points' => ['required', 'integer', 'min:0', 'max:100'],
        ], ['points.required' => 'Poin wajib diisi sebelum menyetujui.']);

        if ($portfolio->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($portfolio, $validated) {
            $portfolio->update([
                'status' => 'approved',
                'point_value' => $validated['points'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            $portfolio->student()->increment('points', $validated['points']);

            PointHistory::create([
                'student_id' => $portfolio->student_id,
                'source_type' => 'portfolio',
                'source_id' => $portfolio->id,
                'points' => $validated['points'],
                'note' => "Portfolio '{$portfolio->title}' ({$portfolio->category}) disetujui oleh admin.",
            ]);
        });

        return back()->with('success', 'Portfolio disetujui dan poin telah diberikan.');
    }

    public function rejectPortfolio(Portfolio $portfolio)
    {
        if ($portfolio->status !== 'pending') {
            return back()->withErrors('Pengajuan ini sudah diproses sebelumnya.');
        }

        $portfolio->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Portfolio ditolak.');
    }
}
