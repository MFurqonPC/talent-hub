<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\AIRecommendationService;

class RecommendationController extends Controller
{
    public function __construct(protected AIRecommendationService $aiService)
    {
    }

    public function index()
    {
        $student = auth()->user();

        $recommendations = $this->aiService->recommendOpportunities($student);
        $skillsToLearn = $this->aiService->recommendSkillsToLearn($student);

        return view('mahasiswa.recommendations.index', compact('recommendations', 'skillsToLearn'));
    }
}
