<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Deteksi HTTPS otomatis dari header Vercel
        // Tidak perlu hardcode APP_URL
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
            $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }

        // Atau lebih simpel: force https kalau bukan local
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}