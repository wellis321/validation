<?php
// Load environment variables first
require_once __DIR__ . '/env_loader.php';

// Composer autoload (required for Stripe SDK etc.)
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

// Initialize core functionality
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/ErrorHandler.php';
require_once __DIR__ . '/Email.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/Auth.php';

// Security will handle session initialization with proper settings
// Don't call session_start() here as Security class handles it

// Initialize error handler
$errorHandler = ErrorHandler::getInstance();

// Initialize security first (this starts the session with secure settings)
$security = Security::getInstance();

// Set all security headers including CSP with nonce
$security->secureHeaders();

// Sessions are lazy (see Security::__construct) so anonymous page views, e.g. from
// crawlers, don't create session files. Pages that render or process forms
// (CSRF tokens, flash messages) need the session started before any output.
$sessionPages = ['account', 'bespoke', 'checkout-success', 'cancel-subscription', 'checkout',
    'contact', 'feedback', 'login', 'forgot-password', 'reset-password', 'subscribe', 'register'];
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    || in_array(basename($_SERVER['SCRIPT_NAME'] ?? '', '.php'), $sessionPages, true)) {
    $security->ensureSession();
}

// Initialize authentication
$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

// Set timezone
date_default_timezone_set('Europe/London');
