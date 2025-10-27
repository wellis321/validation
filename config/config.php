<?php
// Application configuration
return [
    'app' => [
        'name' => 'Simple Data Cleaner',
        'url' => getenv('APP_URL') ?: 'https://simple-data-cleaner.com',
        'env' => getenv('APP_ENV') ?: 'production',
        'debug' => getenv('APP_DEBUG') ?: false,
        'timezone' => 'Europe/London',
    ],

    'security' => [
        'session_lifetime' => 7200, // 2 hours
        'password_min_length' => 8,
        'token_lifetime' => 3600, // 1 hour for reset tokens
        'csrf_token_name' => 'csrf_token',
    ],

    'mail' => [
        'from_address' => getenv('MAIL_FROM_ADDRESS') ?: 'noreply@simple-data-cleaner.com',
        'from_name' => getenv('MAIL_FROM_NAME') ?: 'Simple Data Cleaner',
    ],

    'limits' => [
        'max_file_size' => 10 * 1024 * 1024, // 10MB default max file size
        'allowed_file_types' => ['text/csv', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
    ],

    'api' => [
        'rate_limit_window' => 3600, // 1 hour window for rate limiting
        'default_timeout' => 30, // API request timeout in seconds
    ]
];
