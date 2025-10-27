<?php
// Email configuration for production
// This function ensures environment variables are loaded before returning config
if (!function_exists('getEmailConfig')) {
    function getEmailConfig() {
    // Ensure environment variables are loaded
    static $envLoaded = false;
    if (!$envLoaded) {
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                        (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                        $value = substr($value, 1, -1);
                    }
                    if (!getenv($key)) {
                        putenv("$key=$value");
                        $_ENV[$key] = $value;
                    }
                }
            }
        }
        $envLoaded = true;
    }

    return [
        'driver' => 'smtp',
        'smtp' => [
            'host' => getenv('MAIL_SMTP_HOST') ?: 'smtp.hostinger.com',
            'port' => getenv('MAIL_SMTP_PORT') ?: 587,
            'username' => getenv('MAIL_SMTP_USERNAME') ?: 'noreply@simple-data-cleaner.com',
            'password' => getenv('MAIL_SMTP_PASSWORD') ?: 'YOUR_EMAIL_PASSWORD',
            'encryption' => getenv('MAIL_SMTP_ENCRYPTION') ?: 'tls'
        ],
        'from' => [
            'address' => getenv('MAIL_FROM_ADDRESS') ?: 'noreply@simple-data-cleaner.com',
            'name' => getenv('MAIL_FROM_NAME') ?: 'Simple Data Cleaner'
        ],
        'reply_to' => [
            'address' => getenv('MAIL_FROM_ADDRESS') ?: 'noreply@simple-data-cleaner.com',
            'name' => getenv('MAIL_FROM_NAME') ?: 'Simple Data Cleaner Support'
        ]
    ];
    }
}

// Return the config (for backward compatibility)
return getEmailConfig();
