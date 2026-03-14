<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$security = Security::getInstance();
$error = null;
$success = null;

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: /login.php');
    exit;
}

// Rate limit email verification attempts (10 per hour per IP)
try {
    $security->rateLimit($_SERVER['REMOTE_ADDR'], 'verify-email', 10, 3600);
} catch (Exception $e) {
    $error = 'Too many verification attempts. Please try again later.';
}

if (!$error) {
    try {
        if ($auth->verifyEmail($token)) {
            $success = 'Your email has been verified successfully. You can now log in to your account.';
        } else {
            $error = 'Invalid or expired verification token';
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
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
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white">Email Verification</h1>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 px-4 py-3 rounded-lg mb-4">
                    <p><?php echo htmlspecialchars($error); ?></p>
                    <div class="mt-4">
                        <a href="/login.php"
                            class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold">
                            Return to Login
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500/20 border border-green-500/40 text-green-200 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p><?php echo htmlspecialchars($success); ?></p>
                    </div>
                    <div class="mt-4">
                        <a href="/login.php"
                            class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold">
                            Go to Login
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
