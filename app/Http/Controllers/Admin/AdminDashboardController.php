<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Certificate & Portfolio di-guard dengan class_exists supaya dashboard
        // tetap jalan walau modul sertifikat/portfolio belum dibuat.
        // Begitu App\Models\Certificate & App\Models\Portfolio sudah ada,
        // baris ini otomatis ikut menghitung tanpa perlu diubah.
        $certificateModel = 'App\Models\Certificate';
        $portfolioModel = 'App\Models\Portfolio';

        $totalCertificate = class_exists($certificateModel) ? $certificateModel::count() : 0;
        $totalPortfolio = class_exists($portfolioModel) ? $portfolioModel::count() : 0;
        $pendingCertificate = class_exists($certificateModel) ? $certificateModel::where('status', 'pending')->count() : 0;
        $pendingPortfolio = class_exists($portfolioModel) ? $portfolioModel::where('status', 'pending')->count() : 0;

        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_skill' => Skill::count(),
            'total_certificate' => $totalCertificate,
            'total_portfolio' => $totalPortfolio,
            'total_project' => $totalPortfolio, // "project mahasiswa" pada soal dipetakan ke jumlah portfolio
            'pending_verification' => Skill::where('status', 'pending')->count()
                + $pendingCertificate
                + $pendingPortfolio,
        ];

        $topStudents = User::where('role', 'mahasiswa')
            ->orderByDesc('points')
            ->take(5)
            ->get(['id', 'name', 'points']);

        // Data sederhana untuk chart distribusi skill (5 skill terbanyak diajukan)
        $topSkills = Skill::selectRaw('skill_name, count(*) as total')
            ->where('status', 'approved')
            ->groupBy('skill_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'topStudents', 'topSkills'));
    }
}
