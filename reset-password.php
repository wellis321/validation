<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$error = null;
$success = null;

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: /forgot-password.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        validate_csrf();
        
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($password) || empty($confirmPassword)) {
            throw new Exception('Please fill in all fields');
        }

        if ($password !== $confirmPassword) {
            throw new Exception('Passwords do not match');
        }

        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }

        if ($auth->resetPassword($token, $password)) {
            $success = 'Your password has been reset successfully. You can now log in with your new password.';
        } else {
            throw new Exception('Invalid or expired reset token');
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
    <title>Reset Password - Simple Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>
    <main id="main-content">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white">Reset Password</h1>
                <p class="text-neutral-400 mt-2">Enter your new password</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 px-4 py-3 rounded-lg mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500/20 border border-green-500/40 text-green-200 px-4 py-3 rounded-lg mb-4">
                    <?php echo htmlspecialchars($success); ?>
                    <div class="mt-4">
                        <a href="/login.php"
                            class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold">
                            Go to Login
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-neutral-900 rounded-xl border border-neutral-700 p-8">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                        <div class="mb-6">
                            <label for="password" class="block text-neutral-300 text-sm font-medium mb-2">New Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="••••••••">
                            <p class="mt-1 text-sm text-neutral-500">Must be at least 8 characters long</p>
                        </div>

                        <div class="mb-6">
                            <label for="confirm_password" class="block text-neutral-300 text-sm font-medium mb-2">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="••••••••">
                        </div>

                        <button type="submit"
                            class="w-full bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                            Reset Password
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
