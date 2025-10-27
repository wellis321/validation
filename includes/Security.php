<?php
class Security {
    private static $instance = null;
    private $config;

    private function __construct() {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->initSession();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            // Set secure session parameters
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', $this->config['app']['env'] === 'production' ? 1 : 0);
            ini_set('session.cookie_samesite', 'Lax');
            ini_set('session.use_strict_mode', 1);
            ini_set('session.gc_maxlifetime', $this->config['security']['session_lifetime']);

            session_start();
        }
    }

    public function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken($token) {
        if (empty($_SESSION['csrf_token']) || empty($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('Invalid CSRF token');
        }
        return true;
    }

    public function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
        return true;
    }

    public function validatePassword($password) {
        $minLength = $this->config['security']['password_min_length'];

        if (strlen($password) < $minLength) {
            throw new Exception("Password must be at least {$minLength} characters long");
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new Exception('Password must contain at least one number');
        }

        return true;
    }

    public function validateFileUpload($file, $allowedTypes, $maxSize) {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new Exception('Invalid file upload');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('File size exceeds limit');
            case UPLOAD_ERR_PARTIAL:
                throw new Exception('File was only partially uploaded');
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file was uploaded');
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new Exception('Missing temporary folder');
            case UPLOAD_ERR_CANT_WRITE:
                throw new Exception('Failed to write file to disk');
            case UPLOAD_ERR_EXTENSION:
                throw new Exception('File upload stopped by extension');
            default:
                throw new Exception('Unknown upload error');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('File size exceeds limit');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception('Invalid file type');
        }

        return true;
    }

    public function secureHeaders() {
        // Security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');

        if ($this->config['app']['env'] === 'production') {
            header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' cdn.tailwindcss.com; img-src 'self' data:; font-src 'self'; connect-src 'self'");
        }
    }

    public function validateJson($json) {
        if (!is_string($json)) {
            return false;
        }

        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function generateApiKey($userId) {
        return "uk_dc_{$userId}_" . bin2hex(random_bytes(16));
    }

    public function validateApiKey($apiKey) {
        if (!preg_match('/^uk_dc_\d+_[a-f0-9]{32}$/', $apiKey)) {
            return false;
        }
        return true;
    }

    public function rateLimit($ip, $route, $limit = 60, $period = 60) {
        // Use database-based rate limiting instead of APCu (not available on all hosts)
        $db = Database::getInstance();

        // Clean old entries first
        $db->query(
            "DELETE FROM rate_limits WHERE created_at < DATE_SUB(NOW(), INTERVAL ? SECOND)",
            [$period]
        );

        // Count current requests for this IP/route
        $stmt = $db->query(
            "SELECT COUNT(*) as count FROM rate_limits
             WHERE ip_address = ? AND route = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? SECOND)",
            [$ip, $route, $period]
        );
        $result = $stmt->fetch();
        $current = $result['count'];

        if ($current >= $limit) {
            throw new Exception('Too many requests. Please try again later.');
        }

        // Log this request
        $db->insert('rate_limits', [
            'ip_address' => $ip,
            'route' => $route,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    public function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function validatePhone($phone) {
        // Basic UK phone number validation
        return preg_match('/^(\+44|0)[1-9]\d{8,9}$/', $phone);
    }

    public function validatePostcode($postcode) {
        // UK postcode validation
        return preg_match('/^[A-Z]{1,2}[0-9][A-Z0-9]? ?[0-9][A-Z]{2}$/i', $postcode);
    }

    public function validateNiNumber($ni) {
        // UK National Insurance number validation
        return preg_match('/^[A-Z]{2}[0-9]{6}[A-Z]$/i', str_replace(' ', '', $ni));
    }

    public function validateSortCode($sortCode) {
        // UK bank sort code validation
        return preg_match('/^[0-9]{6}$/', str_replace('-', '', $sortCode));
    }
}
