<?php

namespace App\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    private function tmpPath(string $file): string
    {
        // Pakai /tmp hanya di Vercel (Linux), lokal tetap normal
        if (PHP_OS_FAMILY === 'Linux' && is_dir('/tmp')) {
            return '/tmp/bootstrap/cache/' . $file;
        }
        return $this->bootstrapPath('cache/' . $file);
    }

    public function getCachedPackagesPath(): string
    {
        return $this->tmpPath('packages.php');
    }

    public function getCachedServicesPath(): string
    {
        return $this->tmpPath('services.php');
    }

    public function getCachedConfigPath(): string
    {
        return $this->tmpPath('config.php');
    }

    public function getCachedRoutesPath(): string
    {
        return $this->tmpPath('routes-v7.php');
    }
}