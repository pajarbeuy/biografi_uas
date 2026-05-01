<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

$storagePath = '/tmp/storage';
$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

// Hapus route/config cache yang salah path
$cacheFiles = [
    '/var/task/user/bootstrap/cache/routes-v7.php',
    '/var/task/user/bootstrap/cache/config.php',
    '/var/task/user/bootstrap/cache/packages.php',
    '/var/task/user/bootstrap/cache/services.php',
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        @unlink($file);
    }
}

require __DIR__ . '/../public/index.php';