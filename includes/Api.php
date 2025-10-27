<?php
class Api {
    protected $auth;
    protected $user;
    protected $db;

    public function __construct() {
        $this->auth = Auth::getInstance();
        $this->db = Database::getInstance();
        $this->user = $this->auth->getCurrentUser();

        // Set JSON response headers
        header('Content-Type: application/json');

        // Allow CORS for development
        if (getenv('APP_ENV') === 'development') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        }
    }

    protected function requireAuth() {
        if (!$this->user) {
            $this->sendError('Unauthorized', 401);
        }
    }

    protected function checkSubscription() {
        if (!$this->user) {
            $this->sendError('Unauthorized', 401);
        }

        try {
            $rateLimiter = RateLimiter::getInstance();
            $limits = $rateLimiter->checkLimit($this->user['id']);

            // Add rate limit headers
            header('X-RateLimit-Limit: ' . $limits['limit']);
            header('X-RateLimit-Remaining: ' . $limits['remaining']);
            header('X-RateLimit-Reset: ' . $limits['reset']);

            return (new User())->getCurrentSubscription();
        } catch (Exception $e) {
            if ($e->getMessage() === 'Daily request limit exceeded') {
                header('X-RateLimit-Limit: ' . $limits['limit']);
                header('X-RateLimit-Remaining: 0');
                header('X-RateLimit-Reset: ' . strtotime('tomorrow 00:00:00'));
                $this->sendError($e->getMessage(), 429);
            }
            $this->sendError($e->getMessage(), 403);
        }
    }

    protected function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->sendError('Method not allowed', 405);
        }
    }

    protected function getRequestData() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->sendError('Invalid JSON payload');
        }
        return $data;
    }

    protected function validateRequiredFields($data, $required) {
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->sendError("Missing required field: {$field}");
            }
        }
    }

    protected function sendResponse($data, $status = 200) {
        http_response_code($status);
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
        exit;
    }

    protected function sendError($message, $status = 400) {
        http_response_code($status);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }

    protected function validateApiKey() {
        $headers = getallheaders();
        $apiKey = $headers['Authorization'] ?? null;

        if (!$apiKey) {
            $this->sendError('API key is required', 401);
        }

        // Remove 'Bearer ' prefix if present
        $apiKey = str_replace('Bearer ', '', $apiKey);

        // TODO: Implement proper API key validation
        // For now, we'll just check if it matches the user's ID
        if (!$this->user || $apiKey !== "uk_dc_{$this->user['id']}") {
            $this->sendError('Invalid API key', 401);
        }
    }

    protected function logApiUsage($endpoint, $fileSize = null, $processingTime = null, $status = 'success', $errorMessage = null) {
        if ($this->user) {
            (new User())->logApiUsage($endpoint, $fileSize, $processingTime, $status, $errorMessage);
        }
    }

    protected function validateFileSize($fileSize, $maxSize) {
        if ($fileSize > $maxSize * 1024 * 1024) { // Convert MB to bytes
            $this->sendError("File size exceeds maximum allowed size of {$maxSize}MB");
        }
    }
}
