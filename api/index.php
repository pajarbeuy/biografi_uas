<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Redirect storage ke /tmp (satu-satunya folder writable di Vercel)
$_ENV['APP_STORAGE'] = '/tmp';
putenv('APP_STORAGE=/tmp');

// Buat folder yang dibutuhkan Laravel di /tmp
$directories = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}

require __DIR__ . '/../public/index.php';