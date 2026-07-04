<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::with('poster')->latest()->get();
        return view('admin.opportunities.index', compact('opportunities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'skill_tags' => ['required', 'string', 'max:255'],
            'deadline' => ['nullable', 'date'],
        ], [
            'skill_tags.required' => 'Isi skill tags (pisahkan dengan koma), contoh: php,laravel,ui/ux',
        ]);

        Opportunity::create([
            ...$validated,
            'posted_by' => auth()->id(),
        ]);

        return back()->with('success', 'Opportunity berhasil diposting.');
    }

    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();
        return back()->with('success', 'Opportunity dihapus.');
    }
}
