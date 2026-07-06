<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * AI Recommendation Engine sederhana berbasis content-matching (skill similarity).
 *
 * Pendekatan: setiap opportunity punya skill_tags (comma-separated).
 * Setiap mahasiswa punya daftar skill yang sudah approved.
 * Match score = irisan (intersection) antara skill mahasiswa & tag opportunity,
 * dibagi jumlah tag opportunity -> menghasilkan persentase kecocokan.
 *
 * Tidak butuh API key eksternal, sehingga stabil untuk demo hackathon.
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

    /**
     * OPSI B — Rekomendasi karier naratif memakai LLM lewat Groq
     * (gratis, tanpa kartu kredit, https://console.groq.com).
     * Endpoint-nya OpenAI-compatible, jadi formatnya mirip banget sama OpenAI API.
     *
     * Dipanggil terpisah dari recommendOpportunities() supaya kalau API
     * gagal/lambat/kuota habis, halaman tetap tampil normal dengan
     * rekomendasi rule-based di atas (fallback aman untuk demo).
     */
    public function getAICareerAdvice(User $student): ?string
    {
        if (empty(config('services.groq.key'))) {
            return null; // API key belum diset, skip diam-diam
        }

        $skills = $student->skills()->where('status', 'approved')->pluck('skill_name')->implode(', ');
        $certificates = $student->certificates()->where('status', 'approved')->pluck('title')->implode(', ');
        $points = $student->points;

        $prompt = "Mahasiswa ini punya skill terverifikasi: " . ($skills ?: 'belum ada') . ". "
            . "Sertifikat: " . ($certificates ?: 'belum ada') . ". "
            . "Total poin kontribusi: {$points}. "
            . "Berikan 2-3 kalimat saran pengembangan karier yang singkat, memotivasi, "
            . "dan actionable dalam Bahasa Indonesia. Jangan gunakan format list, cukup paragraf singkat.";

        try {
            $response = Http::timeout(10)
                ->withToken(config('services.groq.key'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'max_tokens' => 300,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        } catch (\Throwable $e) {
            // Diam-diam gagal, biar halaman tetap jalan pakai rule-based saja
            report($e);
        }

        return null;
    }
}
