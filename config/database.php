<?php
// Database configuration
// This function ensures environment variables are loaded before returning config
function getDatabaseConfig() {
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
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: 3306,
        'database' => getenv('DB_NAME') ?: 'u248320297_ukdata',
        'username' => getenv('DB_USER') ?: 'u248320297_ukdata_user',
        'password' => getenv('DB_PASS') ?: 'YOUR_DATABASE_PASSWORD',
        'charset' => 'utf8',
        'collation' => 'utf8_general_ci',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ];
}

// Return the config (for backward compatibility)
return getDatabaseConfig();