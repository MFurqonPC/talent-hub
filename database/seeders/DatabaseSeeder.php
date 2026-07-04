<?php
/**
 * CATATAN: Ini SNIPPET. Buka database/seeders/DatabaseSeeder.php milikmu,
 * lalu pastikan method run() memanggil TalentHubSeeder seperti ini:
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TalentHubSeeder::class,
        ]);
    }
}
