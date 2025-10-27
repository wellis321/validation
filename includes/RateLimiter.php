<?php
class RateLimiter {
    private $db;
    private static $instance = null;

    private function __construct() {
        $this->db = Database::getInstance();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function checkLimit($userId) {
        // Get user's subscription
        $user = new User();
        $subscription = $user->getCurrentSubscription();

        if (!$subscription) {
            throw new Exception('No active subscription');
        }

        // Get today's usage count
        $stmt = $this->db->query(
            "SELECT COUNT(*) as count
            FROM api_usage
            WHERE user_id = ?
            AND DATE(request_date) = CURDATE()",
            [$userId]
        );
        $usage = $stmt->fetch();

        if ($usage['count'] >= $subscription['max_requests_per_day']) {
            throw new Exception('Daily request limit exceeded');
        }

        return [
            'limit' => $subscription['max_requests_per_day'],
            'remaining' => $subscription['max_requests_per_day'] - $usage['count'],
            'reset' => strtotime('tomorrow 00:00:00')
        ];
    }

    public function checkFileSize($size, $userId) {
        // Get user's subscription
        $user = new User();
        $subscription = $user->getCurrentSubscription();

        if (!$subscription) {
            throw new Exception('No active subscription');
        }

        $maxSize = $subscription['max_file_size_mb'] * 1024 * 1024; // Convert MB to bytes
        if ($size > $maxSize) {
            throw new Exception("File size exceeds maximum allowed size of {$subscription['max_file_size_mb']}MB");
        }

        return true;
    }

    public function addHeaders($response) {
        if (is_array($response)) {
            $response['X-RateLimit-Limit'] = $response['limit'];
            $response['X-RateLimit-Remaining'] = $response['remaining'];
            $response['X-RateLimit-Reset'] = $response['reset'];
        }
        return $response;
    }

    public function logRequest($userId, $endpoint, $fileSize = null, $processingTime = null, $status = 'success', $errorMessage = null) {
        return $this->db->insert('api_usage', [
            'user_id' => $userId,
            'endpoint' => $endpoint,
            'file_size' => $fileSize,
            'processing_time' => $processingTime,
            'status' => $status,
            'error_message' => $errorMessage,
            'request_date' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUsageStats($userId, $days = 30) {
        $stmt = $this->db->query(
            "SELECT
                DATE(request_date) as date,
                COUNT(*) as total_requests,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as successful_requests,
                AVG(processing_time) as avg_processing_time,
                SUM(file_size) as total_data_processed
            FROM api_usage
            WHERE user_id = ?
            AND request_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(request_date)
            ORDER BY date DESC",
            [$userId, $days]
        );

        return $stmt->fetchAll();
    }

    public function getDailyAverage($userId, $days = 30) {
        $stmt = $this->db->query(
            "SELECT
                AVG(daily_count) as avg_daily_requests,
                MAX(daily_count) as peak_daily_requests
            FROM (
                SELECT
                    DATE(request_date) as date,
                    COUNT(*) as daily_count
                FROM api_usage
                WHERE user_id = ?
                AND request_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY DATE(request_date)
            ) as daily_stats",
            [$userId, $days]
        );

        return $stmt->fetch();
    }

    public function getErrorStats($userId, $days = 30) {
        $stmt = $this->db->query(
            "SELECT
                error_message,
                COUNT(*) as error_count
            FROM api_usage
            WHERE user_id = ?
            AND request_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            AND status = 'error'
            GROUP BY error_message
            ORDER BY error_count DESC
            LIMIT 10",
            [$userId, $days]
        );

        return $stmt->fetchAll();
    }
}
