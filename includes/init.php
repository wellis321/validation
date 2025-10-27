<?php
// Load environment variables first
require_once __DIR__ . '/env_loader.php';

// Initialize core functionality
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/ErrorHandler.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/Auth.php';

// Start session
session_start();

// Initialize error handler
$errorHandler = ErrorHandler::getInstance();

// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Initialize authentication
$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

// Initialize security
$security = Security::getInstance();

// Set timezone
date_default_timezone_set('Europe/London');
