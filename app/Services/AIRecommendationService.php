<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * AI Recommendation Engine sederhana berbasis content-matching (skill similarity).
 *
 * Pendekatan: setiap opportunity punya skill_tags (comma-separated).
 * Setiap mahasiswa punya daftar skill yang sudah approved.
 * Match score = irisan (intersection) antara skill mahasiswa & tag opportunity,
 * dibagi jumlah tag opportunity -> menghasilkan persentase kecocokan.
 *
 * Tidak butuh API key eksternal, sehingga stabil untuk demo hackathon.
 * Bisa di-upgrade ke pemanggilan LLM (OpenAI/Anthropic) kalau waktu memungkinkan.
 */
class AIRecommendationService
{
    public function recommendOpportunities(User $student, int $limit = 10): Collection
    {
        $studentSkills = $student->skills()
            ->where('status', 'approved')
            ->pluck('skill_name')
            ->map(fn ($s) => strtolower(trim($s)))
            ->toArray();

        $opportunities = Opportunity::latest()->get();

        if (empty($studentSkills)) {
            // Mahasiswa belum punya skill approved -> tampilkan opportunity terbaru saja
            return $opportunities->take($limit)->map(function ($opp) {
                $opp->match_score = 0;
                $opp->matched_skills = [];
                return $opp;
            });
        }

        return $opportunities->map(function ($opp) use ($studentSkills) {
            $tags = $opp->tagsArray();
            $matched = array_values(array_intersect($studentSkills, $tags));
            $score = count($tags) > 0 ? count($matched) / count($tags) : 0;

            $opp->match_score = (int) round($score * 100);
            $opp->matched_skills = $matched;

            return $opp;
        })
        ->sortByDesc('match_score')
        ->take($limit)
        ->values();
    }

    /**
     * Rekomendasi skill yang sebaiknya ditambahkan mahasiswa,
     * berdasarkan skill yang paling sering diminta opportunity
     * tapi belum dimiliki mahasiswa. Berguna untuk "gap analysis" sederhana.
     */
    public function recommendSkillsToLearn(User $student, int $limit = 5): array
    {
        $studentSkills = $student->skills()
            ->where('status', 'approved')
            ->pluck('skill_name')
            ->map(fn ($s) => strtolower(trim($s)))
            ->toArray();

        $allTags = Opportunity::pluck('skill_tags')
            ->flatMap(fn ($tags) => explode(',', $tags))
            ->map(fn ($t) => strtolower(trim($t)))
            ->filter();

        $tagFrequency = $allTags->countBy();

        return $tagFrequency
            ->reject(fn ($count, $tag) => in_array($tag, $studentSkills))
            ->sortDesc()
            ->take($limit)
            ->keys()
            ->toArray();
    }
}
