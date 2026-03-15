<?php
class Auth {
    private $user = null;
    private $db;
    private static $instance = null;

    private function __construct() {
        try {
            $this->db = Database::getInstance();
            // Only initialize session if database is available
            if ($this->db->isConnected()) {
                $this->initSession();
            }
        } catch (Exception $e) {
            // Database connection failed - app can still work for data cleaning
            // Session will be initialized without database
            $this->initSessionWithoutDB();
        }
    }

    private function initSessionWithoutDB() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Clear any existing session data since DB is not available
        $_SESSION = [];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            try {
                $user = new User();
                $foundUser = $user->find($_SESSION['user_id']);
                // Only set user if we actually found a valid user record
                if ($foundUser && isset($foundUser['id'])) {
                    $this->user = $foundUser;
                } else {
                    // Invalid session data, clear it
                    session_destroy();
                    session_start();
                }
            } catch (Exception $e) {
                // Session data is corrupted, clear it
                session_destroy();
                session_start();
            }
        }
    }

    public function login($email, $password) {
        $user = new User();

        // Get user data directly from database (bypassing hidden fields)
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM users WHERE email = ?", [$email]);
        $userData = $stmt->fetch();

        if (!$userData) {
            throw new Exception('User not found');
        }

        if (!password_verify($password, $userData['password'])) {
            throw new Exception('Invalid password');
        }

        if (!$userData['is_active']) {
            throw new Exception('Account is inactive');
        }

        if (!$userData['email_verified']) {
            throw new Exception('Email not verified');
        }

        // Update last login timestamp
        $user->update($userData['id'], ['last_login' => date('Y-m-d H:i:s')]);

        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

        // Set session
        $_SESSION['user_id'] = $userData['id'];
        $this->user = $userData;

        return $userData;
    }

    public function register($data) {
        $user = new User();

        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }

        // Check if email exists
        if ($user->findBy('email', $data['email'])) {
            throw new Exception('Email already registered');
        }

        // Validate password
        $config = require __DIR__ . '/../config/config.php';
        if (strlen($data['password']) < $config['security']['password_min_length']) {
            throw new Exception("Password must be at least {$config['security']['password_min_length']} characters long");
        }

        // Generate verification token before creating user
        $verificationToken = bin2hex(random_bytes(32));

        // Create user with verification token
        $userId = $user->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'is_active' => true,
            'email_verified' => false,
            'verification_token' => $verificationToken
        ]);

        if (!$userId) {
            throw new Exception('Failed to create user account');
        }

        // Send verification email
        $emailSent = $this->sendVerificationEmail($data['email'], $verificationToken);

        if (!$emailSent) {
            error_log("Auth: Failed to send verification email for user ID: {$userId}");
            // Don't throw exception, just log the error
            // User is still created, they can request resend later
        }

        // Grant 7-day free trial if eligible
        $this->grantFreeTrial($userId);

        return $userId;
    }

    /**
     * Grant a 7-day free trial subscription to a new user
     * Only grants if user has never had any subscription before
     */
    private function grantFreeTrial($userId) {
        try {
            // Check if user has ever had a subscription (including expired/cancelled)
            $stmt = $this->db->query(
                "SELECT COUNT(*) as count FROM user_subscriptions WHERE user_id = ?",
                [$userId]
            );
            $result = $stmt->fetch();
            
            // Only grant trial if user has never had any subscription
            if ($result && $result['count'] > 0) {
                return false;
            }

            // Get the Free Trial plan
            $stmt = $this->db->query(
                "SELECT id FROM subscription_plans WHERE name = 'Free Trial' AND is_active = 1 LIMIT 1"
            );
            $trialPlan = $stmt->fetch();

            if (!$trialPlan) {
                error_log("Auth: Free Trial plan not found in database. Run database/add_free_trial_plan.sql");
                return false;
            }

            // Calculate trial dates (7 days from now)
            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime('+7 days'));

            // Create trial subscription
            $this->db->insert('user_subscriptions', [
                'user_id' => $userId,
                'plan_id' => $trialPlan['id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'payment_status' => 'completed' // Trial is free, so payment is "completed"
            ]);

            error_log("Auth: Granted 7-day free trial to user ID: {$userId}");
            return true;
        } catch (Exception $e) {
            // Don't fail registration if trial grant fails
            error_log("Auth: Failed to grant free trial to user ID {$userId}: " . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        session_destroy();
        $this->user = null;
    }

    public function isLoggedIn() {
        return $this->user !== null;
    }

    public function getCurrentUser() {
        return $this->user;
    }

    /**
     * Require authenticated user. If not logged in, redirect to login or sign-up.
     * @param string|null $returnTo Optional URL path to return to after login (e.g. /checkout.php?plan=1)
     * @param bool $preferSignUp If true, send to register page (e.g. for subscription flow) instead of login
     */
    public function requireAuth($returnTo = null, $preferSignUp = false) {
        if (!$this->isLoggedIn()) {
            $url = $preferSignUp ? '/register.php' : '/login.php';
            if ($returnTo !== null && $returnTo !== '') {
                $url .= '?redirect=' . rawurlencode($returnTo);
            }
            header('Location: ' . $url);
            exit;
        }
    }

    public function sendVerificationEmail($email, $token) {
        $emailSender = new Email();
        return $emailSender->sendVerificationEmail($email, $token);
    }

    public function verifyEmail($token) {
        $user = new User();
        return $user->verifyEmail($token);
    }

    public function requestPasswordReset($email) {
        try {
            $user = new User();
            $userData = $user->findBy('email', $email);

            if (!$userData) {
                // Log without exposing email (use hash for correlation if needed)
                error_log("Auth: Password reset requested for non-existent account");
                throw new Exception('User not found');
            }

            // Set the user ID so generatePasswordResetToken() can use it
            if (!isset($userData['id']) || empty($userData['id'])) {
                error_log("Auth: Invalid user data during password reset");
                throw new Exception('Invalid user data');
            }

            $user->id = $userData['id'];

            // Generate password reset token
            try {
                $token = $user->generatePasswordResetToken();
            } catch (Exception $e) {
                error_log("Auth: Failed to generate password reset token for user ID: {$user->id}");
                throw new Exception('Failed to generate reset token');
            }

            // Send password reset email
            try {
                $emailSent = $this->sendPasswordResetEmail($email, $token);

                if (!$emailSent) {
                    error_log("Auth: Failed to send password reset email for user ID: {$user->id}");
                    // Don't throw exception - still return true to prevent email enumeration
                }
            } catch (Exception $e) {
                error_log("Auth: Email send error for user ID: {$user->id}");
                // Don't throw - still return true to prevent email enumeration
            }

            return true;
        } catch (Exception $e) {
            // Log without sensitive data - just the error type
            error_log("Auth: Password reset error - " . get_class($e));
            throw $e; // Re-throw to be caught by caller
        }
    }

    public function resetPassword($token, $newPassword) {
        $user = new User();
        return $user->resetPassword($token, $newPassword);
    }

    private function sendPasswordResetEmail($email, $token) {
        $emailSender = new Email();
        return $emailSender->sendPasswordResetEmail($email, $token);
    }

    public function updateProfile($userId, $data) {
        if (!$this->isLoggedIn() || $this->user['id'] !== $userId) {
            throw new Exception('Unauthorized');
        }

        $user = new User();
        $updates = array_intersect_key($data, array_flip(['first_name', 'last_name', 'email']));

        if (isset($data['password'])) {
            if (strlen($data['password']) < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }
            $updates['password'] = $data['password'];
        }

        return $user->update($userId, $updates);
    }
}
