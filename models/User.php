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
        if (!$this->id || empty($this->id)) {
            throw new Exception('User ID is not set. Cannot generate password reset token.');
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        try {
            // Check if table exists by trying to query it first
            try {
                $testQuery = $this->db->query("SELECT 1 FROM password_reset_tokens LIMIT 1");
            } catch (Exception $e) {
                error_log("ERROR: password_reset_tokens table might not exist: " . $e->getMessage());
                // Continue anyway - the insert will fail if table doesn't exist
            }

            $result = $this->db->insert('password_reset_tokens', [
                'user_id' => $this->id,
                'token' => $token,
                'expires_at' => $expiresAt
            ]);

            if (!$result || $result === 0) {
                error_log("ERROR: Failed to insert password reset token for user ID: {$this->id}");
                error_log("ERROR: Insert returned: " . var_export($result, true));
                throw new Exception('Failed to save password reset token to database');
            }

            error_log("Password reset token inserted successfully. ID: {$result}");
            return $token;
        } catch (\PDOException $e) {
            error_log("ERROR: PDO exception while inserting password reset token: " . $e->getMessage());
            error_log("ERROR: SQL State: " . $e->getCode());
            error_log("ERROR: SQL Error Info: " . print_r($e->errorInfo ?? [], true));
            throw new Exception('Database error while generating reset token: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log("ERROR: Exception while generating password reset token: " . $e->getMessage());
            error_log("ERROR: Exception class: " . get_class($e));
            throw $e;
        }
    }

    public function verifyPasswordResetToken($token) {
        // First, find the token and get the user_id
        $stmt = $this->db->query(
            "SELECT * FROM password_reset_tokens
            WHERE token = ?
            AND expires_at > NOW()",
            [$token]
        );
        $tokenData = $stmt->fetch();

        if (!$tokenData) {
            error_log("Password reset token not found or expired: {$token}");
            return false;
        }

        // Set the user ID from the token
        $this->id = $tokenData['user_id'];
        error_log("Password reset token verified for user ID: {$this->id}");

        return true;
    }

    public function resetPassword($token, $newPassword) {
        // Verify token and set user ID
        if (!$this->verifyPasswordResetToken($token)) {
            error_log("Failed to verify password reset token: {$token}");
            return false;
        }

        if (!$this->id || empty($this->id)) {
            error_log("ERROR: User ID not set after token verification");
            return false;
        }

        try {
            // Update password
            $success = $this->update($this->id, ['password' => $newPassword]);

            if (!$success) {
                error_log("ERROR: Failed to update password for user ID: {$this->id}");
                return false;
            }

            error_log("Password updated successfully for user ID: {$this->id}");

            // Delete used token
            try {
                $this->db->delete('password_reset_tokens', 'token = ?', [$token]);
                error_log("Password reset token deleted: {$token}");
            } catch (Exception $e) {
                error_log("ERROR: Failed to delete password reset token: " . $e->getMessage());
                // Don't fail if token deletion fails - password is already updated
            }

            return true;
        } catch (Exception $e) {
            error_log("ERROR: Exception while resetting password: " . $e->getMessage());
            error_log("ERROR: Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
