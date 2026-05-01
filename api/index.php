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

// Buat bootstrap/cache writable dengan copy ke /tmp
$bootstrapCacheSrc = __DIR__ . '/../bootstrap/cache';
$bootstrapCacheDst = '/tmp/bootstrap/cache';

if (!is_dir($bootstrapCacheDst)) {
    mkdir($bootstrapCacheDst, 0775, true);
}

// Copy packages.php ke /tmp supaya Laravel bisa update di sana
if (file_exists($bootstrapCacheSrc . '/packages.php')) {
    copy($bootstrapCacheSrc . '/packages.php', $bootstrapCacheDst . '/packages.php');
}

// Override bootstrap cache path
putenv("APP_BOOTSTRAP_CACHE=$bootstrapCacheDst");
$_ENV['APP_BOOTSTRAP_CACHE'] = $bootstrapCacheDst;

require __DIR__ . '/../public/index.php';