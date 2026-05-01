<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Storage path
$storagePath = '/tmp/storage';
$_ENV['APP_STORAGE'] = $storagePath;
putenv("APP_STORAGE=$storagePath");

// Bootstrap path
$bootstrapPath = '/tmp/bootstrap';
$_ENV['APP_BOOTSTRAP_PATH'] = $bootstrapPath;
putenv("APP_BOOTSTRAP_PATH=$bootstrapPath");

// Buat semua folder yang dibutuhkan
$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $bootstrapPath . '/cache',  // ← bootstrap cache di /tmp
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

require __DIR__ . '/../public/index.php';