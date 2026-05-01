<?php

// Force tampilkan error meskipun di production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_ENV['APP_STORAGE'] = '/tmp';
putenv('APP_STORAGE=/tmp');

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

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<pre style='background:#1e1e1e;color:#ff6b6b;padding:20px;'>";
    echo "<b>ERROR:</b> " . $e->getMessage() . "\n\n";
    echo "<b>FILE:</b> " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    echo "</pre>";
}