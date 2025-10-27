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

        return $this->send($email, $subject, $message);
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
            // Log the email attempt
            $logMessage = "=== SENDING VIA MAIL FUNCTION ===\n";
            $logMessage .= "To: {$to}\n";
            $logMessage .= "Subject: {$subject}\n";
            $logMessage .= "From: {$this->config['from']['address']}\n";
            $logMessage .= "================================\n\n";
            error_log($logMessage, 3, __DIR__ . '/../logs/email.log');

            // Create email headers
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$this->config['from']['name']} <{$this->config['from']['address']}>\r\n";
            $headers .= "Reply-To: {$this->config['reply_to']['address']}\r\n";
            $headers .= "X-Mailer: Simple Data Cleaner\r\n";

            // Use PHP's mail() function (works on Hostinger)
            $result = mail($to, $subject, $message, $headers);

            if ($result) {
                error_log("Email sent successfully to: {$to}");
                return true;
            } else {
                error_log("Email failed to send to: {$to}");
                return false;
            }

        } catch (Exception $e) {
            error_log("Email error: " . $e->getMessage());
            return false;
        }
    }
}
