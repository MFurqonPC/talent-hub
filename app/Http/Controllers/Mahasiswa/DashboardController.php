<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Reward;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $summary = [
            'points' => $user->points,
            'skills' => $user->skills()->where('status', 'approved')->count(),
            'certificates' => $user->certificates()->where('status', 'approved')->count(),
            'portfolios' => $user->portfolios()->where('status', 'approved')->count(),
        ];

        $rewards = Reward::where('is_active', true)
            ->where('points_required', '<=', $user->points)
            ->latest()
            ->take(3)
            ->get();

        $opportunities = Opportunity::latest()
            ->take(3)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'user',
            'summary',
            'rewards',
            'opportunities'
        ));
    }
}