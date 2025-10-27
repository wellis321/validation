<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $config = require __DIR__ . '/config/database.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);

    echo "<h1>Subscription Plans</h1>";

    $stmt = $pdo->query("SELECT * FROM subscription_plans ORDER BY price ASC");
    $plans = $stmt->fetchAll();

    if (empty($plans)) {
        echo "<p style='color: red;'>No subscription plans found. Importing default plans...</p>";

        // Import default plans
        $sql = "INSERT INTO subscription_plans (name, description, price, duration_months, max_requests_per_day, max_file_size_mb, features) VALUES
            ('Free', 'Basic data cleaning features with limited usage', 0.00, 1, 50, 5, '{\"batch_processing\": false, \"priority_support\": false, \"api_access\": false}'),
            ('Professional', 'Advanced features for professional users', 29.99, 1, 1000, 25, '{\"batch_processing\": true, \"priority_support\": false, \"api_access\": true}'),
            ('Enterprise', 'Unlimited access with priority support', 99.99, 1, 5000, 100, '{\"batch_processing\": true, \"priority_support\": true, \"api_access\": true}')";

        $pdo->exec($sql);
        echo "<p style='color: green;'>Default plans imported successfully!</p>";

        $stmt = $pdo->query("SELECT * FROM subscription_plans ORDER BY price ASC");
        $plans = $stmt->fetchAll();
    }

    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Name</th><th>Price</th><th>Requests/Day</th><th>Max File Size</th><th>Features</th></tr>";

    foreach ($plans as $plan) {
        $features = json_decode($plan['features'], true);
        $featuresList = [];
        foreach ($features as $key => $value) {
            if ($value) {
                $featuresList[] = str_replace('_', ' ', ucfirst($key));
            }
        }

        echo "<tr>";
        echo "<td>{$plan['name']}</td>";
        echo "<td>£" . number_format($plan['price'], 2) . "</td>";
        echo "<td>{$plan['max_requests_per_day']}</td>";
        echo "<td>{$plan['max_file_size_mb']}MB</td>";
        echo "<td>" . ($featuresList ? implode(', ', $featuresList) : 'Basic Features') . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>";
}
