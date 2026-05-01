<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

$storagePath = '/tmp/storage';
$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

// Buat semua folder yang dibutuhkan di /tmp
$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/bootstrap/cache',  // ← tambah ini
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

// Symlink bootstrap/cache ke /tmp/bootstrap/cache
$bootstrapCache = __DIR__ . '/../bootstrap/cache';
if (!is_link($bootstrapCache) && !is_dir($bootstrapCache)) {
    symlink('/tmp/bootstrap/cache', $bootstrapCache);
} elseif (is_dir($bootstrapCache) && !is_link($bootstrapCache)) {
    // Kalau direktori asli ada tapi tidak writable, copy isinya ke /tmp
    $files = glob($bootstrapCache . '/*.php');
    foreach ($files as $file) {
        @unlink($file); // hapus cache lama
    }
}

// Pastikan bootstrap/cache point ke /tmp
putenv('APP_BOOTSTRAP_CACHE=/tmp/bootstrap/cache');
$_ENV['APP_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';

require __DIR__ . '/../public/index.php';