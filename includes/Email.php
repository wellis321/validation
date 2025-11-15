<?php
class Email {
    private $config;

    public function __construct() {
        $this->config = require __DIR__ . '/../config/email.php';
    }

    public function sendVerificationEmail($email, $token) {
        try {
            $subject = 'Verify Your Simple Data Cleaner Account';
            // Use the current domain instead of config to avoid old URLs
            $baseUrl = 'https://simple-data-cleaner.com';
            $verificationLink = $baseUrl . "/verify-email.php?token={$token}";

            $message = "
            <html>
            <head>
                <title>Verify Your Account</title>
            </head>
            <body>
                <h2>Welcome to Simple Data Cleaner!</h2>
                <p>Please click the link below to verify your email address:</p>
                <p><a href='{$verificationLink}' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Email Address</a></p>
                <p>If the button doesn't work, copy and paste this link into your browser:</p>
                <p>{$verificationLink}</p>
                <p>This link will expire in 24 hours.</p>
                <p>Best regards,<br>Simple Data Cleaner Team</p>
            </body>
            </html>
            ";

            $result = $this->send($email, $subject, $message);

            if ($result) {
                error_log("Verification email sent successfully to: {$email}");
            } else {
                error_log("Failed to send verification email to: {$email}");
            }

            return $result;

        } catch (Exception $e) {
            error_log("Exception in sendVerificationEmail: " . $e->getMessage());
            return false;
        }
    }

    public function sendPasswordResetEmail($email, $token) {
        try {
            $subject = 'Reset Your Simple Data Cleaner Password';
            // Use the current domain instead of config to avoid old URLs
            $baseUrl = 'https://simple-data-cleaner.com';
            $resetLink = $baseUrl . "/reset-password.php?token={$token}";

            $message = "
            <html>
            <head>
                <title>Password Reset</title>
            </head>
            <body>
                <h2>Password Reset Request</h2>
                <p>You requested a password reset for your Simple Data Cleaner account.</p>
                <p>Click the link below to reset your password:</p>
                <p><a href='{$resetLink}' style='background-color: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
                <p>If the button doesn't work, copy and paste this link into your browser:</p>
                <p>{$resetLink}</p>
                <p>This link will expire in 1 hour.</p>
                <p>If you didn't request this reset, please ignore this email.</p>
                <p>Best regards,<br>Simple Data Cleaner Team</p>
            </body>
            </html>
            ";

            $result = $this->send($email, $subject, $message);

            if ($result) {
                error_log("Password reset email sent successfully to: {$email}");
            } else {
                error_log("Failed to send password reset email to: {$email}");
            }

            return $result;

        } catch (Exception $e) {
            error_log("Exception in sendPasswordResetEmail: " . $e->getMessage());
            return false;
        }
    }

    private function send($to, $subject, $message) {
        try {
            return $this->sendViaSMTP($to, $subject, $message);
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }


    private function sendViaSMTP($to, $subject, $message) {
        try {
            // Validate From address - must use the actual domain
            $fromAddress = $this->config['from']['address'];
            if (strpos($fromAddress, 'yourdomain.com') !== false || strpos($fromAddress, '@') === false) {
                error_log("ERROR: Invalid From address in config: {$fromAddress}. Using default.");
                $fromAddress = 'noreply@simple-data-cleaner.com';
            }

            // Log the email attempt with actual From address being used
            $logMessage = "=== SENDING VIA MAIL FUNCTION ===\n";
            $logMessage .= "To: {$to}\n";
            $logMessage .= "Subject: {$subject}\n";
            $logMessage .= "From Config: {$this->config['from']['address']}\n";
            $logMessage .= "From Address Used: {$fromAddress}\n";
            $logMessage .= "From Name: {$this->config['from']['name']}\n";
            $logMessage .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
            $logMessage .= "================================\n\n";
            error_log($logMessage, 3, __DIR__ . '/../logs/email.log');

            // Create email headers
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$this->config['from']['name']} <{$fromAddress}>\r\n";
            $headers .= "Reply-To: {$this->config['reply_to']['address']}\r\n";
            $headers .= "X-Mailer: Simple Data Cleaner\r\n";
            $headers .= "Return-Path: {$fromAddress}\r\n";

            // Use PHP's mail() function (works on Hostinger)
            // Capture any errors from mail()
            $errorReporting = error_reporting(0); // Temporarily suppress errors to capture them
            $result = mail($to, $subject, $message, $headers);
            $lastError = error_get_last();
            error_reporting($errorReporting); // Restore error reporting

            if ($result) {
                $successLog = "Email sent successfully to: {$to}\n";
                $successLog .= "From: {$fromAddress}\n";
                $successLog .= "Subject: {$subject}\n";
                $successLog .= "Timestamp: " . date('Y-m-d H:i:s') . "\n\n";
                error_log($successLog, 3, __DIR__ . '/../logs/email.log');
                error_log("Email sent successfully to: {$to}");
                return true;
            } else {
                $errorMsg = $lastError ? $lastError['message'] : 'Unknown error';
                error_log("Email failed to send to: {$to} - Error: {$errorMsg}");
                error_log("Email send failure for {$to}: {$errorMsg}", 3, __DIR__ . '/../logs/email.log');
                return false;
            }

        } catch (Exception $e) {
            error_log("Email error: " . $e->getMessage());
            return false;
        }
    }
}
