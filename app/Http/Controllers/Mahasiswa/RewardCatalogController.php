<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\RewardClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardCatalogController extends Controller
{
    public function index()
    {
        $rewards = Reward::active()->latest()->get();

        // Riwayat klaim mahasiswa yang sedang login, untuk ditampilkan di bawah katalog
        $myClaims = RewardClaim::with('reward')
            ->where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('mahasiswa.rewards.index', [
            'rewards' => $rewards,
            'myClaims' => $myClaims,
            'myPoints' => auth()->user()->points,
        ]);
    }

    public function claim(Reward $reward)
    {
        $user = auth()->user();

        if (!$reward->is_active) {
            return back()->withErrors('Reward ini sudah tidak aktif.');
        }
        if ($user->points < $reward->points_required) {
            return back()->withErrors('Poin kamu tidak cukup untuk klaim reward ini.');
        }
        if ($reward->stock <= 0) {
            return back()->withErrors('Stok reward ini sudah habis.');
        }

        DB::transaction(function () use ($user, $reward) {
            // Lock row reward supaya aman dari race condition saat banyak mahasiswa klaim bersamaan
            $lockedReward = Reward::where('id', $reward->id)->lockForUpdate()->first();

            if ($lockedReward->stock <= 0) {
                abort(422, 'Stok reward baru saja habis.');
            }

            $user->decrement('points', $reward->points_required);
            $lockedReward->decrement('stock');

            RewardClaim::create([
                'student_id' => $user->id,
                'reward_id' => $reward->id,
                'status' => 'pending',
                'claimed_at' => now(),
            ]);
        });

        return back()->with('success', "Berhasil klaim reward '{$reward->title}'! Tunjukkan riwayat klaim ke admin untuk pengambilan.");
    }
}
