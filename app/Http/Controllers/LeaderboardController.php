<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    /**
     * Leaderboard dipakai bersama oleh role admin & mahasiswa (view yang sama),
     * karena requirement soal menyebutkan kedua role bisa "Melihat leaderboard".
     */
    public function index()
    {
        $perPage = 20;

        $leaderboard = User::mahasiswa()
            ->with('profile')
            ->orderByDesc('points')
            ->paginate($perPage);

        // Hitung ranking global yang benar walau sedang di halaman ke-2, ke-3, dst.
        $startRank = ($leaderboard->currentPage() - 1) * $perPage + 1;

        return view('leaderboard.index', compact('leaderboard', 'startRank'));
    }
}
