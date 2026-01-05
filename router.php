<?php
// Router script for PHP built-in development server
// This file is only used when running: php -S localhost:8000 router.php

// Get the requested file path
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove query string for file checking
$filePath = __DIR__ . $requestPath;

// If the requested file exists and is a PHP file, serve it
if (file_exists($filePath) && is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    return false; // Let PHP serve the file directly
}

// If it's a directory, try index.php or index.html
if (is_dir($filePath)) {
    $indexFiles = ['index.php', 'index.html'];
    foreach ($indexFiles as $indexFile) {
        $indexPath = rtrim($filePath, '/') . '/' . $indexFile;
        if (file_exists($indexPath)) {
            return false; // Let PHP serve the index file
        }
    }
}

// For static files (CSS, JS, images, etc.), let PHP serve them
if (file_exists($filePath) && is_file($filePath)) {
    return false;
}

// Default: serve index.php for all other requests
$_SERVER['SCRIPT_NAME'] = '/index.php';
include __DIR__ . '/index.php';
return true;

