<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TalentProfileController extends Controller
{
    /**
     * Tampilkan form edit profil + ringkasan talenta
     * (poin, jumlah skill/sertifikat/portfolio yang approved).
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new StudentProfile(['user_id' => $user->id]);

        $summary = [
            'points' => $user->points,
            'skills_approved' => $user->skills()->where('status', 'approved')->count(),
            'certificates_approved' => $user->certificates()->where('status', 'approved')->count(),
            'portfolios_approved' => $user->portfolios()->where('status', 'approved')->count(),
        ];

        return view('mahasiswa.profile.edit', compact('user', 'profile', 'summary'));
    }

    /**
     * Simpan / update profil talenta mahasiswa.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'string', 'max:10'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = auth()->user();
        $profile = $user->profile ?? new StudentProfile(['user_id' => $user->id]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama supaya storage tidak menumpuk file yatim
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $profile->fill($validated);
        $profile->user_id = $user->id;
        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
