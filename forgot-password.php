<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$errorHandler = ErrorHandler::getInstance();

// If already logged in with valid session, redirect to homepage
if ($auth->isLoggedIn() && $auth->getCurrentUser() && isset($auth->getCurrentUser()['id'])) {
    header('Location: index.php');
    exit;
}

$success = false;
$error = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        try {
            validate_csrf();
        } catch (Exception $e) {
            error_log("CSRF validation failed: " . $e->getMessage());
            $error = 'Invalid request. Please try again.';
            throw $e;
        }

        // Sanitize and validate input
        $security = Security::getInstance();
        $email = $security->sanitizeInput($_POST['email'] ?? '');

        if (empty($email)) {
            $error = 'Please enter your email address';
            throw new Exception($error);
        }

        // Validate email format
        try {
            $security->validateEmail($email);
        } catch (Exception $e) {
            error_log("Email validation failed for: {$email} - " . $e->getMessage());
            $error = 'Please enter a valid email address';
            throw new Exception($error);
        }

        // Add rate limiting for password reset requests (by IP and by email)
        try {
            $security->rateLimit(get_client_ip(), 'password_reset', 5, 300);
        } catch (Exception $e) {
            error_log("Rate limit exceeded (IP) for password_reset");
            $error = 'Too many requests. Please try again later.';
            throw new Exception($error);
        }
        try {
            // Per-email limit prevents inbox flooding even from multiple IPs
            $security->rateLimit(hash('sha256', strtolower($email)), 'password_reset_email', 3, 3600);
        } catch (Exception $e) {
            error_log("Rate limit exceeded (email) for password_reset");
            $error = 'Too many requests. Please try again later.';
            throw new Exception($error);
        }

        // Request password reset
        // Note: We don't reveal if the email exists for security reasons
        try {
            error_log("Password reset form submitted for email: {$email}");
            $auth->requestPasswordReset($email);
            // Always show success message for security (don't reveal if email exists)
            $success = true;
            error_log("Password reset request processed successfully for: {$email}");
        } catch (Exception $e) {
            // Log the error for debugging, but don't reveal to user
            error_log("Password reset request failed for: {$email} - Error: " . $e->getMessage());
            error_log("Exception type: " . get_class($e));
            error_log("Stack trace: " . $e->getTraceAsString());
            // Still show success message to prevent email enumeration
            // Even if there's an error (like user not found), show success
            $success = true;
        }
    } catch (Exception $e) {
        // Only show error if it's a validation error (CSRF, email format, rate limit)
        // Don't show errors for user not found or database errors (security)
        if (!empty($error)) {
            // $error is already set above for user-facing errors
        } else {
            // For other errors, log but don't show to user
            error_log("Unexpected error in forgot-password.php: " . $e->getMessage());
            error_log("Exception type: " . get_class($e));
            error_log("Stack trace: " . $e->getTraceAsString());
            // Show success to prevent information leakage
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/forgot-password.php">
    <title>Forgot Password - Simple Data Cleaner</title>
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
                <h1 class="text-4xl font-bold text-white">Forgot Password</h1>
                <p class="text-neutral-400 mt-2">Enter your email address and we'll send you a link to reset your password</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500/20 border border-green-500/40 text-green-200 px-4 py-3 rounded-lg mb-6">
                    <p class="font-semibold mb-2">Password reset email sent!</p>
                    <p class="text-sm">If an account exists with that email address, we've sent you a password reset link. Please check your inbox and follow the instructions to reset your password.</p>
                    <p class="text-sm mt-2">The link will expire in 1 hour.</p>
                    <div class="mt-4">
                        <a href="/login.php" class="text-yellow-400 hover:text-yellow-300 font-medium text-sm">
                            ← Back to Login
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-neutral-900 rounded-xl border border-neutral-700 p-8">
                    <form method="POST" action="forgot-password.php">
                        <?php echo csrf_field(); ?>
                        <div class="mb-6">
                            <label for="email" class="block text-neutral-300 text-sm font-medium mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="your@email.com"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <p class="mt-1 text-sm text-neutral-500">Enter the email address associated with your account</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                            Send Reset Link
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-neutral-400 text-sm">
                            Remember your password?
                            <a href="/login.php" class="text-yellow-400 hover:text-yellow-300 font-medium">
                                Log in
                            </a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
