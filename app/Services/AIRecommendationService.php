<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Support\Collection;

class AIRecommendationService
{
    /**
     * Mapping skill generik -> skill spesifik yang dianggap setara.
     * Sesuaikan dengan skill_tags yang dipakai di tabel opportunities.
     */
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
    private array $skillAliases = [
        'backend' => ['laravel', 'php', 'mysql', 'nodejs', 'express', 'django', 'python', 'postgresql'],
        'frontend' => ['react', 'vue', 'javascript', 'html', 'css', 'tailwind', 'bootstrap'],
        'design' => ['ui/ux', 'figma', 'photoshop', 'canva', 'adobe xd'],
        'data analyst' => ['data analyst', 'excel', 'python', 'sql', 'tableau', 'power bi'],
        'mobile developer' => ['flutter', 'kotlin', 'swift', 'react native'],
        // tambah sesuai kebutuhan
    ];

    /**
     * Perluas skill mahasiswa: kalau dia punya skill generik ("backend"),
     * anggap dia juga "punya" skill spesifik turunannya untuk keperluan matching.
     */
    private function expandSkills(array $skills): array
    {
        $expanded = $skills;
        foreach ($skills as $skill) {
            if (isset($this->skillAliases[$skill])) {
                $expanded = array_merge($expanded, $this->skillAliases[$skill]);
            }
        }
        return array_unique($expanded);
    }

    private function getApprovedSkills(User $student): array
    {
        $skills = $student->skills()
            ->where('status', 'approved')
            ->pluck('skill_name')
            ->map(fn ($s) => strtolower(trim($s)))
            ->toArray();

        return $this->expandSkills($skills);
    }

    public function recommendOpportunities(User $student, int $limit = 10): Collection
    {
        $studentSkills = $this->getApprovedSkills($student);
        $opportunities = Opportunity::latest()->get();

        if (empty($studentSkills)) {
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

    public function recommendSkillsToLearn(User $student, int $limit = 5): array
    {
        $studentSkills = $this->getApprovedSkills($student);

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