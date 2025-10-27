<?php
function csrf_field() {
    $security = Security::getInstance();
    $token = $security->generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

function old($field, $default = '') {
    return htmlspecialchars($_POST[$field] ?? $default);
}

function sanitize($data) {
    $security = Security::getInstance();
    return $security->sanitizeInput($data);
}

function validate_csrf() {
    $security = Security::getInstance();
    $token = $_POST['csrf_token'] ?? '';
    return $security->validateCsrfToken($token);
}

function is_production() {
    $config = require __DIR__ . '/../config/config.php';
    return $config['app']['env'] === 'production';
}

function format_bytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}

function format_duration($seconds) {
    if ($seconds < 0.001) {
        return round($seconds * 1000000) . 'µs';
    } elseif ($seconds < 1) {
        return round($seconds * 1000, 2) . 'ms';
    } else {
        return round($seconds, 2) . 's';
    }
}

function format_date($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

function get_subscription_features($features) {
    if (!is_string($features)) {
        return [];
    }
    return json_decode($features, true) ?: [];
}

function format_money($amount, $currency = 'GBP') {
    return '£' . number_format($amount, 2);
}

function get_error_message($exception) {
    return is_production()
        ? 'An error occurred. Please try again later.'
        : $exception->getMessage();
}

function redirect($url) {
    header("Location: {$url}");
    exit;
}

function is_ajax_request() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function json_response($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function require_auth() {
    $auth = Auth::getInstance();
    if (!$auth->isLoggedIn()) {
        redirect('/login.php');
    }
}

function require_subscription() {
    $auth = Auth::getInstance();
    $user = $auth->getCurrentUser();

    if (!$user) {
        redirect('/login.php');
    }

    $subscription = (new User())->getCurrentSubscription();
    if (!$subscription) {
        redirect('/pricing.php');
    }

    return $subscription;
}

function get_gravatar($email, $size = 80) {
    $hash = md5(strtolower(trim($email)));
    return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
}

function format_file_size($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}

function get_max_upload_size() {
    return min(
        ini_get('upload_max_filesize'),
        ini_get('post_max_size'),
        ini_get('memory_limit')
    );
}

function is_valid_date($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function generate_random_string($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

function mask_card_number($number) {
    $masked = str_repeat('*', strlen($number) - 4) . substr($number, -4);
    return chunk_split($masked, 4, ' ');
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function display_messages() {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->displayErrors();
}

function add_error($message) {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->addError($message);
}

function add_warning($message) {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->addWarning($message);
}

function add_info($message) {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->addInfo($message);
}

function add_success($message) {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->addSuccess($message);
}

function has_errors() {
    $errorHandler = ErrorHandler::getInstance();
    return $errorHandler->hasErrors();
}

function has_warnings() {
    $errorHandler = ErrorHandler::getInstance();
    return $errorHandler->hasWarnings();
}

function has_info() {
    $errorHandler = ErrorHandler::getInstance();
    return $errorHandler->hasInfo();
}

function has_success() {
    $errorHandler = ErrorHandler::getInstance();
    return $errorHandler->hasSuccess();
}

function clear_messages() {
    $errorHandler = ErrorHandler::getInstance();
    $errorHandler->clearAll();
}
