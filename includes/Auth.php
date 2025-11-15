<?php
class Auth {
    private $user = null;
    private $db;
    private static $instance = null;

    private function __construct() {
        $this->db = Database::getInstance();
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
            error_log("Failed to send verification email to: {$data['email']}");
            // Don't throw exception, just log the error
            // User is still created, they can request resend later
        } else {
            error_log("Verification email sent successfully to: {$data['email']}");
        }

        return $userId;
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

    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header('Location: /login.php');
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
                // Log that user was not found (for debugging) but don't reveal to user
                error_log("Password reset requested for non-existent email: {$email}");
                throw new Exception('User not found');
            }

            // Log that we found the user and are generating token
            error_log("Password reset requested for existing user: {$email} (ID: {$userData['id']})");

            // Set the user ID so generatePasswordResetToken() can use it
            if (!isset($userData['id']) || empty($userData['id'])) {
                error_log("ERROR: User data missing ID for email: {$email}");
                throw new Exception('Invalid user data');
            }

            $user->id = $userData['id'];
            error_log("Set user ID to: {$user->id} for email: {$email}");

            // Generate password reset token
            try {
                $token = $user->generatePasswordResetToken();
                error_log("Password reset token generated for: {$email} (User ID: {$user->id})");
            } catch (Exception $e) {
                error_log("ERROR: Failed to generate password reset token for: {$email} - " . $e->getMessage());
                error_log("ERROR: Stack trace: " . $e->getTraceAsString());
                throw new Exception('Failed to generate reset token: ' . $e->getMessage());
            }

            // Send password reset email and check if it was successful
            try {
                $emailSent = $this->sendPasswordResetEmail($email, $token);

                if (!$emailSent) {
                    error_log("Failed to send password reset email to: {$email}. Token generated: {$token}");
                    // Don't throw exception - still return true to prevent email enumeration
                    // But log the error for debugging
                } else {
                    error_log("Password reset email sent successfully to: {$email}");
                }
            } catch (Exception $e) {
                error_log("ERROR: Failed to send password reset email to: {$email} - " . $e->getMessage());
                // Don't throw - still return true to prevent email enumeration
            }

            return true;
        } catch (Exception $e) {
            error_log("ERROR in requestPasswordReset for {$email}: " . $e->getMessage());
            error_log("ERROR: Stack trace: " . $e->getTraceAsString());
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
