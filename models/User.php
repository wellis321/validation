<?php
class User extends Model {
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'is_active',
        'email_verified',
        'verification_token',
        'last_login'
    ];

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return parent::create($data);
    }

    public function update($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return parent::update($id, $data);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function getCurrentSubscription() {
        $stmt = $this->db->query(
            "SELECT us.*, sp.*
            FROM user_subscriptions us
            JOIN subscription_plans sp ON us.plan_id = sp.id
            WHERE us.user_id = ?
            AND us.status = 'active'
            AND us.start_date <= NOW()
            AND us.end_date >= NOW()",
            [$this->id]
        );
        return $stmt->fetch();
    }

    public function hasActiveSubscription() {
        return (bool) $this->getCurrentSubscription();
    }

    public function getRemainingRequests() {
        $subscription = $this->getCurrentSubscription();
        if (!$subscription) {
            return 0;
        }

        // Get today's API usage count
        $stmt = $this->db->query(
            "SELECT COUNT(*) as count
            FROM api_usage
            WHERE user_id = ?
            AND DATE(request_date) = CURDATE()",
            [$this->id]
        );
        $usage = $stmt->fetch();

        return max(0, $subscription['max_requests_per_day'] - $usage['count']);
    }

    public function logApiUsage($endpoint, $fileSize = null, $processingTime = null, $status = 'success', $errorMessage = null) {
        return $this->db->insert('api_usage', [
            'user_id' => $this->id,
            'endpoint' => $endpoint,
            'file_size' => $fileSize,
            'processing_time' => $processingTime,
            'status' => $status,
            'error_message' => $errorMessage
        ]);
    }

    public function generateVerificationToken() {
        $token = bin2hex(random_bytes(32));
        $this->update($this->id, ['verification_token' => $token]);
        return $token;
    }

    public function verifyEmail($token) {
        $user = $this->findBy('verification_token', $token);
        if ($user) {
            return $this->update($user['id'], [
                'email_verified' => true,
                'verification_token' => null
            ]);
        }
        return false;
    }

    public function generatePasswordResetToken() {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->db->insert('password_reset_tokens', [
            'user_id' => $this->id,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }

    public function verifyPasswordResetToken($token) {
        $stmt = $this->db->query(
            "SELECT * FROM password_reset_tokens
            WHERE token = ?
            AND expires_at > NOW()
            AND user_id = ?",
            [$token, $this->id]
        );
        return (bool) $stmt->fetch();
    }

    public function resetPassword($token, $newPassword) {
        if ($this->verifyPasswordResetToken($token)) {
            // Update password
            $success = $this->update($this->id, ['password' => $newPassword]);

            // Delete used token
            if ($success) {
                $this->db->delete('password_reset_tokens', 'token = ?', [$token]);
            }

            return $success;
        }
        return false;
    }
}
