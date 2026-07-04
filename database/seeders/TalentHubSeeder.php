<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\PointHistory;
use App\Models\Reward;
use App\Models\Opportunity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TalentHubSeeder extends Seeder
{
    /**
     * Jalankan: php artisan db:seed --class=TalentHubSeeder
     * atau panggil dari DatabaseSeeder::run() -> $this->call(TalentHubSeeder::class);
     */
    public function run(): void
    {
        // ===================== 1. ADMIN =====================
        $admin = User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@talenthub.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'points' => 0,
            'email_verified_at' => now(),
        ]);

        // ===================== 2. MAHASISWA =====================
        $mahasiswaData = [
            ['name' => 'Budi Santoso', 'email' => 'budi@talenthub.test', 'jurusan' => 'Teknik Informatika', 'angkatan' => '2022'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@talenthub.test', 'jurusan' => 'Sistem Informasi', 'angkatan' => '2021'],
            ['name' => 'Andi Wijaya', 'email' => 'andi@talenthub.test', 'jurusan' => 'Desain Komunikasi Visual', 'angkatan' => '2023'],
            ['name' => 'Rina Amelia', 'email' => 'rina@talenthub.test', 'jurusan' => 'Teknik Informatika', 'angkatan' => '2022'],
            ['name' => 'Fajar Ramadhan', 'email' => 'fajar@talenthub.test', 'jurusan' => 'Ilmu Komunikasi', 'angkatan' => '2021'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@talenthub.test', 'jurusan' => 'Sistem Informasi', 'angkatan' => '2023'],
        ];

        $mahasiswaUsers = [];
        foreach ($mahasiswaData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'points' => 0,
                'email_verified_at' => now(),
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => '2200' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'jurusan' => $data['jurusan'],
                'angkatan' => $data['angkatan'],
                'bio' => 'Mahasiswa aktif yang senang mengembangkan diri lewat berbagai kegiatan non-akademik.',
                'phone' => '08123456' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            ]);

            $mahasiswaUsers[] = $user;
        }

        [$budi, $siti, $andi, $rina, $fajar, $dewi] = $mahasiswaUsers;

        // ===================== 3. SKILL (approved & pending, biar dashboard ada variasi) =====================
        $skillSeed = [
            [$budi, 'Laravel', 'Advanced', 'approved', 5],
            [$budi, 'UI/UX Design', 'Intermediate', 'pending', 0],
            [$siti, 'Data Analysis', 'Advanced', 'approved', 5],
            [$siti, 'Python', 'Intermediate', 'approved', 3],
            [$andi, 'UI/UX Design', 'Advanced', 'approved', 5],
            [$andi, 'Figma', 'Advanced', 'pending', 0],
            [$rina, 'Laravel', 'Intermediate', 'approved', 3],
            [$rina, 'Videografi', 'Beginner', 'pending', 0],
            [$fajar, 'Public Speaking', 'Advanced', 'approved', 5],
            [$fajar, 'Content Writing', 'Intermediate', 'approved', 3],
            [$dewi, 'UI/UX Design', 'Beginner', 'pending', 0],
        ];

        foreach ($skillSeed as [$student, $name, $level, $status, $points]) {
            $skill = Skill::create([
                'student_id' => $student->id,
                'skill_name' => $name,
                'level' => $level,
                'status' => $status,
                'point_value' => $points,
                'reviewed_by' => $status === 'approved' ? $admin->id : null,
                'reviewed_at' => $status === 'approved' ? now() : null,
            ]);

            if ($status === 'approved') {
                $this->giveSkillPoints($student, $skill, $points);
            }
        }

        // ===================== 4. SERTIFIKAT =====================
        $certSeed = [
            [$budi, 'Sertifikat Lomba Hackathon Nasional', 'nasional', 'approved'],
            [$siti, 'Sertifikat Seminar Data Science Regional', 'regional', 'approved'],
            [$andi, 'Sertifikat Kompetisi Design Internasional', 'internasional', 'pending'],
            [$rina, 'Sertifikat Workshop Web Development', 'lokal', 'approved'],
        ];

        foreach ($certSeed as [$student, $title, $category, $status]) {
            $points = $status === 'approved' ? Certificate::DEFAULT_POINTS[$category] : 0;

            $cert = Certificate::create([
                'student_id' => $student->id,
                'title' => $title,
                'category' => $category,
                'file_path' => null, // dummy, tidak upload file asli
                'status' => $status,
                'point_value' => $points,
                'reviewed_by' => $status === 'approved' ? $admin->id : null,
                'reviewed_at' => $status === 'approved' ? now() : null,
            ]);

            if ($status === 'approved') {
                $this->giveGenericPoints($student, 'certificate', $cert->id, $points, "Sertifikat '{$title}' disetujui.");
            }
        }

        // ===================== 5. PORTFOLIO =====================
        $portfolioSeed = [
            [$budi, 'Sistem Informasi Akademik Kampus', 'industri', 'approved', 'https://github.com/budi/sia'],
            [$andi, 'Redesign Landing Page UMKM', 'freelance', 'approved', 'https://behance.net/andi/umkm'],
            [$siti, 'Dashboard Analisis Penjualan', 'personal', 'approved', 'https://github.com/siti/dashboard'],
            [$dewi, 'Poster Event Kampus', 'personal', 'pending', null],
        ];

        foreach ($portfolioSeed as [$student, $title, $category, $status, $link]) {
            $points = $status === 'approved' ? Portfolio::DEFAULT_POINTS[$category] : 0;

            $pf = Portfolio::create([
                'student_id' => $student->id,
                'title' => $title,
                'category' => $category,
                'description' => "Project {$category} yang dikerjakan sebagai bagian dari portofolio.",
                'link' => $link,
                'status' => $status,
                'point_value' => $points,
                'reviewed_by' => $status === 'approved' ? $admin->id : null,
                'reviewed_at' => $status === 'approved' ? now() : null,
            ]);

            if ($status === 'approved') {
                $this->giveGenericPoints($student, 'portfolio', $pf->id, $points, "Portfolio '{$title}' disetujui.");
            }
        }

        // ===================== 6. JUARA KOMPETISI (contoh poin manual dari histori) =====================
        $this->giveGenericPoints($andi, 'competition', null, 10, 'Juara 1 Lomba UI/UX Tingkat Nasional.');

        // ===================== 7. REWARD =====================
        Reward::create(['title' => 'Voucher Kantin 20rb', 'description' => 'Voucher makan siang di kantin kampus.', 'points_required' => 5, 'stock' => 20, 'is_active' => true]);
        Reward::create(['title' => 'Voucher Print & Fotokopi', 'description' => 'Voucher cetak dokumen di reprografi kampus.', 'points_required' => 3, 'stock' => 30, 'is_active' => true]);
        Reward::create(['title' => 'E-Sertifikat Talent Award', 'description' => 'Sertifikat penghargaan digital untuk mahasiswa berprestasi.', 'points_required' => 15, 'stock' => 10, 'is_active' => true]);
        Reward::create(['title' => 'Merchandise Kampus (Kaos)', 'description' => 'Kaos eksklusif bertema kampus.', 'points_required' => 25, 'stock' => 5, 'is_active' => true]);

        // ===================== 8. OPPORTUNITY (dipakai AI Recommendation) =====================
        Opportunity::create(['posted_by' => $admin->id, 'title' => 'Dibutuhkan Backend Developer Laravel', 'description' => 'Proyek sistem informasi UKM kampus.', 'skill_tags' => 'laravel,php,mysql', 'deadline' => now()->addDays(14)]);
        Opportunity::create(['posted_by' => $admin->id, 'title' => 'Dicari UI/UX Designer untuk Event Wisuda', 'description' => 'Desain kebutuhan visual acara wisuda.', 'skill_tags' => 'ui/ux,figma,design', 'deadline' => now()->addDays(10)]);
        Opportunity::create(['posted_by' => $admin->id, 'title' => 'Videografer untuk Dokumentasi Kampus', 'description' => 'Meliput kegiatan kampus sepanjang semester.', 'skill_tags' => 'videografi,editing,adobe premiere', 'deadline' => now()->addDays(20)]);
        Opportunity::create(['posted_by' => $admin->id, 'title' => 'Data Analyst untuk Riset Internal', 'description' => 'Analisis data survei kepuasan mahasiswa.', 'skill_tags' => 'data analysis,python,excel', 'deadline' => now()->addDays(30)]);

        $this->command->info('✅ Talent Hub dummy data berhasil di-seed!');
        $this->command->info('Login Admin   : admin@talenthub.test / password');
        $this->command->info('Login Mahasiswa: budi@talenthub.test / password (dan email lain di atas, password sama)');
    }

    private function giveSkillPoints(User $student, Skill $skill, int $points): void
    {
        $student->increment('points', $points);
        PointHistory::create([
            'student_id' => $student->id,
            'source_type' => 'skill',
            'source_id' => $skill->id,
            'points' => $points,
            'note' => "Skill '{$skill->skill_name}' disetujui (seeded).",
        ]);
    }

    private function giveGenericPoints(User $student, string $type, ?int $sourceId, int $points, string $note): void
    {
        $student->increment('points', $points);
        PointHistory::create([
            'student_id' => $student->id,
            'source_type' => $type,
            'source_id' => $sourceId,
            'points' => $points,
            'note' => $note,
        ]);
    }
}
