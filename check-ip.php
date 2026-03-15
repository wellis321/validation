<?php
// Temporary diagnostic script — DELETE THIS FILE after checking.
// Access it in your browser: https://simple-data-cleaner.com/check-ip.php

// Basic protection: only allow access from your own IP (edit this before uploading)
// Or just delete the file immediately after checking.

$vars = [
    'REMOTE_ADDR',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_X_REAL_IP',
    'HTTP_CLIENT_IP',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'HTTP_CF_CONNECTING_IP', // Cloudflare
];

header('Content-Type: text/plain');
echo "=== IP Diagnostic ===\n\n";
foreach ($vars as $var) {
    $value = $_SERVER[$var] ?? '(not set)';
    echo str_pad($var, 30) . $value . "\n";
}
echo "\n=== DELETE THIS FILE NOW ===\n";
