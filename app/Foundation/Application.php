<?php

namespace App\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function getCachedPackagesPath(): string
    {
        return '/tmp/bootstrap/cache/packages.php';
    }

    public function getCachedServicesPath(): string
    {
        return '/tmp/bootstrap/cache/services.php';
    }

    public function getCachedConfigPath(): string
    {
        return '/tmp/bootstrap/cache/config.php';
    }

    public function getCachedRoutesPath(): string
    {
        return '/tmp/bootstrap/cache/routes-v7.php';
    }
}