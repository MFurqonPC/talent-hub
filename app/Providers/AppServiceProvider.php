<?php
/**
 * CATATAN: Ini SNIPPET. Buka app/Providers/AppServiceProvider.php,
 * tambahkan use statement di atas dan isi method boot() seperti ini.
 * (Kalau boot() sudah ada isinya, tambahkan baris URL::forceScheme
 * di dalamnya, jangan hapus yang sudah ada.)
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Railway (dan kebanyakan platform hosting modern) menerima request
        // via HTTPS tapi meneruskannya ke container sebagai HTTP biasa.
        // Tanpa baris ini, Laravel generate semua URL asset/link pakai http://
        // yang diblokir browser karena "mixed content" di halaman https://.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
