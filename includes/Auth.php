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
            $user = new User();
            $this->user = $user->find($_SESSION['user_id']);
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
        $user = new User();
        $userData = $user->findBy('email', $email);

        if (!$userData) {
            throw new Exception('User not found');
        }

        $token = $user->generatePasswordResetToken();

        // TODO: Send password reset email
        $this->sendPasswordResetEmail($email, $token);

        return true;
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
