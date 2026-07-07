<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('mahasiswa.portfolios.index', compact('portfolios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:personal,freelance,industri'],
            'description' => ['nullable', 'string', 'max:1000'],
            'link' => ['nullable', 'url', 'max:255'],
            'file_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'title.required' => 'Judul portfolio wajib diisi.',
            'category.required' => 'Kategori portfolio wajib dipilih.',
            'link.url' => 'Link harus berupa URL yang valid (contoh: https://...).',
        ]);

        if (empty($validated['link']) && !$request->hasFile('file_path')) {
            return back()->withErrors('Wajib mengisi link ATAU mengunggah file sebagai bukti portfolio.')->withInput();
        }

        $path = null;
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('portfolios', 'public');
        }

        Portfolio::create([
            'student_id' => auth()->id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'link' => $validated['link'] ?? null,
            'file_path' => $path,
            'status' => 'pending',
            'point_value' => 0,
        ]);

        return redirect()
            ->route('mahasiswa.portfolios.index')
            ->with('success', 'Portfolio berhasil diajukan, menunggu verifikasi admin.');
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        abort_unless($portfolio->student_id === auth()->id(), 403);
        abort_unless($portfolio->status === 'pending', 403, 'Portfolio yang sudah diverifikasi tidak dapat diubah.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:personal,freelance,industri'],
            'description' => ['nullable', 'string', 'max:1000'],
            'link' => ['nullable', 'url', 'max:255'],
            'file_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'title.required' => 'Judul portfolio wajib diisi.',
            'category.required' => 'Kategori portfolio wajib dipilih.',
            'link.url' => 'Link harus berupa URL yang valid (contoh: https://...).',
        ]);

        if (empty($validated['link']) && !$request->hasFile('file_path') && !$portfolio->file_path) {
            return back()->withErrors('Wajib mengisi link ATAU mengunggah file sebagai bukti portfolio.')->withInput();
        }

        if ($request->hasFile('file_path')) {
            if ($portfolio->file_path) {
                Storage::disk('public')->delete($portfolio->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('portfolios', 'public');
        }

        $portfolio->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'link' => $validated['link'] ?? null,
            'file_path' => $validated['file_path'] ?? $portfolio->file_path,
        ]);

        return redirect()
            ->route('mahasiswa.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        abort_unless($portfolio->student_id === auth()->id(), 403);
        abort_unless($portfolio->status === 'pending', 403, 'Portfolio yang sudah diverifikasi tidak dapat dihapus.');

        $portfolio->delete();

        return back()->with('success', 'Pengajuan portfolio dibatalkan.');
    }
}
