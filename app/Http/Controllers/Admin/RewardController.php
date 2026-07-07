<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\RewardClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::latest()->get();

        // Klaim yang perlu ditindaklanjuti admin, ditampilkan sebagai tab terpisah
        $claims = RewardClaim::with(['student', 'reward'])
            ->latest()
            ->get();

        return view('admin.rewards.index', compact('rewards', 'claims'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'points_required' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reward-images', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Reward::create($validated);

        return back()->with('success', 'Reward berhasil ditambahkan.');
    }

    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'points_required' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }
            $validated['image'] = $request->file('image')->store('reward-images', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $reward->update($validated);

        return back()->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward)
    {
        if ($reward->image) {
            Storage::disk('public')->delete($reward->image);
        }
        $reward->delete();

        return back()->with('success', 'Reward berhasil dihapus.');
    }

    /**
     * Update status klaim reward: pending -> approved -> completed.
     * Admin manual konfirmasi setelah reward fisik/digital diserahkan ke mahasiswa.
     */
    public function updateClaimStatus(Request $request, RewardClaim $claim)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,completed'],
        ]);

        $claim->update(['status' => $validated['status']]);

        return back()->with('success', "Status klaim '{$claim->reward->title}' diupdate jadi " . ucfirst($validated['status']) . ".");
    }
}
