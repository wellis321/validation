<?php
// Read-only: is signup healthy? (CLI only)   php scripts/health_check.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
chdir(dirname(__DIR__));
require 'includes/env_loader.php';
$p = new PDO('mysql:host=' . (getenv('DB_HOST') ?: '127.0.0.1') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
$one = fn($q) => $p->query($q)->fetchColumn();
echo "Plans: " . implode(', ', $p->query('SELECT CONCAT(name, IF(is_active, "", " (inactive)")) FROM subscription_plans')->fetchAll(PDO::FETCH_COLUMN)) . "\n";
echo 'Free Trial plan active: ' . ($one("SELECT COUNT(*) FROM subscription_plans WHERE name='Free Trial' AND is_active=1") ? 'yes' : 'NO') . "\n";
echo 'Users: ' . $one('SELECT COUNT(*) FROM users') . ', verified: ' . $one('SELECT COUNT(*) FROM users WHERE email_verified=1') . "\n";
echo 'Users with no subscription at all: ' . $one('SELECT COUNT(*) FROM users u WHERE NOT EXISTS (SELECT 1 FROM user_subscriptions s WHERE s.user_id = u.id)') . "\n";
echo 'Newest user: ' . ($one('SELECT MAX(created_at) FROM users') ?: '-') . "\n";
echo 'Bundle configured: ' . ((getenv('FINDCARE_URL') && getenv('FINDCARE_SHARED_SECRET')) ? 'yes' : 'NO') . "\n";
