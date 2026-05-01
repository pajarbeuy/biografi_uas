<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Set storage ke /tmp/storage (bukan /tmp langsung!)
$storagePath = '/tmp/storage';
$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

// Buat semua folder yang dibutuhkan Laravel
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

require __DIR__ . '/../public/index.php';