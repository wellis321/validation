<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$errorHandler = ErrorHandler::getInstance();

// If already logged in with valid session, redirect to homepage
// Check for valid user session (not just session ID from Brave's cookie blocking)
if ($auth->isLoggedIn() && $auth->getCurrentUser() && isset($auth->getCurrentUser()['id'])) {
    header('Location: index.php');
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        validate_csrf();

        // Sanitize and validate input
        $security = Security::getInstance();
        $email = $security->sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            throw new Exception('Enter your email and password to sign in.');
        }

        // Validate email format
        $security->validateEmail($email);

        // Add rate limiting for failed login attempts
        $security->rateLimit(get_client_ip(), 'login', 5, 300);

        $auth->login($email, $password);
        add_success('Login successful! Redirecting...');
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        add_error($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/login.php">
    <title>Login - Simple Data Cleaner</title>
    <meta name="description" content="Log in to Simple Data Cleaner to access your UK data validation tools. Clean phone numbers, NI numbers, postcodes, sort codes, and email addresses securely in your browser.">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Login - Simple Data Cleaner">
    <meta property="og:description" content="Log in to access your UK data validation tools. Clean phone numbers, NI numbers, postcodes, sort codes, and email addresses securely in your browser.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/login.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Login - Simple Data Cleaner">
    <meta name="twitter:description" content="Log in to access your UK data validation tools.">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>
    <div id="main-content" class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white">Welcome Back</h1>
                <p class="text-neutral-400 mt-2">Log in to your Simple Data Cleaner account</p>
            </div>

            <?php display_messages(); ?>

            <div class="bg-neutral-900 rounded-xl border border-neutral-700 p-8">
                <form method="POST" action="login.php">
                    <?php echo csrf_field(); ?>
                    <div class="mb-6">
                        <label for="email" class="block text-neutral-300 text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="your@email.com"
                            value="<?php echo old('email'); ?>">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-neutral-300 text-sm font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-neutral-600 rounded bg-neutral-800">
                            <label for="remember" class="ml-2 block text-sm text-neutral-300">Remember me</label>
                        </div>

                        <a href="forgot-password.php" class="text-sm text-yellow-400 hover:text-yellow-300">
                            Forgot your password?
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                        Log In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-neutral-400">
                        Don't have an account?
                        <a href="register.php" class="text-yellow-400 hover:text-yellow-300 font-medium">
                            Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
