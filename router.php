<?php
// Router script for PHP built-in development server
// This file is only used when running: php -S localhost:8000 router.php

// Get the requested file path
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);
// Strip /public prefix so /public/hero-shader.js resolves to project root
$requestPath = preg_replace('#^/public#', '', $requestPath) ?: '/';
// Decode %20 etc. so paths like "Data Cleaning Icon 300.png" resolve correctly
$filePath = __DIR__ . rawurldecode($requestPath);

// MIME types for static files (needed when serving with correct Content-Type)
$mimeTypes = [
    'js' => 'application/javascript',
    'css' => 'text/css',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'ico' => 'image/x-icon',
    'svg' => 'image/svg+xml',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'json' => 'application/json',
    'webmanifest' => 'application/manifest+json',
];

// For static files (non-PHP) that exist, serve with correct MIME type (fixes /public/ path)
if (file_exists($filePath) && is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) !== 'php') {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        return true;
    }
}

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

// For other static files, let PHP serve them
if (file_exists($filePath) && is_file($filePath)) {
    return false;
}

// Default: serve index.php for all other requests
$_SERVER['SCRIPT_NAME'] = '/index.php';
include __DIR__ . '/index.php';
return true;

