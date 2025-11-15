<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$error = null;
$success = null;

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: /login.php');
    exit;
}

try {
    if ($auth->verifyEmail($token)) {
        $success = 'Your email has been verified successfully. You can now log in to your account.';
    } else {
        $error = 'Invalid or expired verification token';
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Simple Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Email Verification</h1>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <p><?php echo htmlspecialchars($error); ?></p>
                    <div class="mt-4">
                        <a href="/login.php"
                            class="inline-block bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                            Return to Login
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p><?php echo htmlspecialchars($success); ?></p>
                    </div>
                    <div class="mt-4">
                        <a href="/login.php"
                            class="inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                            Go to Login
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
