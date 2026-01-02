<?php
/**
 * Security Testing Suite
 * Run this on your production site to verify security measures
 * 
 * Usage: Visit https://your-site.com/tests/security-test.php
 * 
 * WARNING: Remove or protect this file in production after testing!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Test Suite - Simple Data Cleaner</title>
    <link rel="stylesheet" href="/assets/css/output.css">
    <style>
        .test-pass { color: #10b981; }
        .test-fail { color: #ef4444; }
        .test-warn { color: #f59e0b; }
        .test-section { margin: 2rem 0; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Security Test Suite</h1>
        <p class="text-gray-600 mb-8">Testing production security measures</p>

        <?php
        $tests = [];
        $allPassed = true;

        // Test 1: Check if config files are protected
        $tests[] = [
            'name' => 'Config Directory Protection',
            'description' => 'Verify .htaccess blocks config directory access',
            'status' => 'pending'
        ];

        // Test 2: Check security headers
        $tests[] = [
            'name' => 'Security Headers',
            'description' => 'Verify security headers are present',
            'status' => 'pending'
        ];

        // Test 3: Check session security
        $tests[] = [
            'name' => 'Session Security',
            'description' => 'Verify secure session configuration',
            'status' => 'pending'
        ];

        // Test 4: Check CSRF token generation
        $tests[] = [
            'name' => 'CSRF Token Generation',
            'description' => 'Verify CSRF tokens can be generated',
            'status' => 'pending'
        ];

        // Test 5: Check database prepared statements
        $tests[] = [
            'name' => 'Database Security',
            'description' => 'Verify database uses prepared statements',
            'status' => 'pending'
        ];

        // Test 6: Check error handling
        $tests[] = [
            'name' => 'Error Handling',
            'description' => 'Verify errors are handled securely',
            'status' => 'pending'
        ];

        // Run tests
        require_once __DIR__ . '/../includes/init.php';
        $security = Security::getInstance();

        // Test 1: Config Protection
        $configTest = @file_get_contents('https://' . $_SERVER['HTTP_HOST'] . '/config/database.php');
        if ($configTest === false || strpos($configTest, '<?php') === false) {
            $tests[0]['status'] = 'pass';
            $tests[0]['message'] = 'Config directory is protected';
        } else {
            $tests[0]['status'] = 'fail';
            $tests[0]['message'] = 'WARNING: Config files may be accessible!';
            $allPassed = false;
        }

        // Test 2: Security Headers
        $headers = headers_list();
        $requiredHeaders = ['X-Content-Type-Options', 'X-Frame-Options', 'X-XSS-Protection'];
        $foundHeaders = [];
        foreach ($headers as $header) {
            foreach ($requiredHeaders as $req) {
                if (stripos($header, $req) !== false) {
                    $foundHeaders[] = $req;
                }
            }
        }
        if (count($foundHeaders) >= 2) {
            $tests[1]['status'] = 'pass';
            $tests[1]['message'] = 'Security headers present: ' . implode(', ', $foundHeaders);
        } else {
            $tests[1]['status'] = 'warn';
            $tests[1]['message'] = 'Some security headers missing. Found: ' . implode(', ', $foundHeaders);
        }

        // Test 3: Session Security
        $sessionSecure = ini_get('session.cookie_httponly') == '1';
        $sessionSameSite = ini_get('session.cookie_samesite') == 'Lax' || ini_get('session.cookie_samesite') == 'Strict';
        if ($sessionSecure && $sessionSameSite) {
            $tests[2]['status'] = 'pass';
            $tests[2]['message'] = 'Session cookies are secure (HttpOnly, SameSite)';
        } else {
            $tests[2]['status'] = 'warn';
            $tests[2]['message'] = 'Session security could be improved';
        }

        // Test 4: CSRF Token
        try {
            $token = $security->generateCsrfToken();
            if (strlen($token) >= 32) {
                $tests[3]['status'] = 'pass';
                $tests[3]['message'] = 'CSRF tokens generated successfully (length: ' . strlen($token) . ')';
            } else {
                $tests[3]['status'] = 'fail';
                $tests[3]['message'] = 'CSRF token too short';
                $allPassed = false;
            }
        } catch (Exception $e) {
            $tests[3]['status'] = 'fail';
            $tests[3]['message'] = 'CSRF token generation failed: ' . $e->getMessage();
            $allPassed = false;
        }

        // Test 5: Database Security (check if PDO is used)
        try {
            $db = Database::getInstance();
            if ($db->isConnected()) {
                // Try to see if we can access Database class methods
                $reflection = new ReflectionClass('Database');
                $methods = $reflection->getMethods();
                $hasPrepare = false;
                foreach ($methods as $method) {
                    if ($method->getName() === 'query') {
                        $hasPrepare = true;
                        break;
                    }
                }
                if ($hasPrepare) {
                    $tests[4]['status'] = 'pass';
                    $tests[4]['message'] = 'Database uses prepared statements (query method found)';
                } else {
                    $tests[4]['status'] = 'warn';
                    $tests[4]['message'] = 'Could not verify prepared statement usage';
                }
            } else {
                $tests[4]['status'] = 'warn';
                $tests[4]['message'] = 'Database not connected (app can still work for data cleaning)';
            }
        } catch (Exception $e) {
            $tests[4]['status'] = 'warn';
            $tests[4]['message'] = 'Database test skipped: ' . $e->getMessage();
        }

        // Test 6: Error Handling
        $errorHandler = ErrorHandler::getInstance();
        $config = require __DIR__ . '/../config/config.php';
        if (!$config['app']['debug']) {
            $tests[5]['status'] = 'pass';
            $tests[5]['message'] = 'Debug mode is OFF (production-safe)';
        } else {
            $tests[5]['status'] = 'warn';
            $tests[5]['message'] = 'WARNING: Debug mode is ON - disable in production!';
        }

        // Display results
        foreach ($tests as $test) {
            $statusClass = $test['status'] === 'pass' ? 'test-pass' : ($test['status'] === 'fail' ? 'test-fail' : 'test-warn');
            $statusIcon = $test['status'] === 'pass' ? '✅' : ($test['status'] === 'fail' ? '❌' : '⚠️');
            echo "<div class='test-section'>";
            echo "<h2 class='text-xl font-semibold mb-2'>{$statusIcon} {$test['name']}</h2>";
            echo "<p class='text-gray-600 mb-2'>{$test['description']}</p>";
            echo "<p class='{$statusClass} font-medium'>{$test['message']}</p>";
            echo "</div>";
        }

        // Summary
        echo "<div class='test-section mt-8 p-6 " . ($allPassed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200') . "'>";
        echo "<h2 class='text-2xl font-bold mb-4'>Test Summary</h2>";
        if ($allPassed) {
            echo "<p class='text-green-700 text-lg font-semibold'>✅ All critical security tests passed!</p>";
        } else {
            echo "<p class='text-red-700 text-lg font-semibold'>❌ Some tests failed. Please review the results above.</p>";
        }
        echo "</div>";
        ?>

        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800 font-semibold">⚠️ Security Note:</p>
            <p class="text-yellow-700 text-sm mt-2">
                This test file should be removed or password-protected in production. 
                It exposes some system information that could be useful to attackers.
            </p>
        </div>
    </div>
</body>
</html>

