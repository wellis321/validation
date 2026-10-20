<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$errorHandler = ErrorHandler::getInstance();

// If already logged in, redirect to return URL or homepage
if ($auth->isLoggedIn()) {
    $redirect = $_GET['redirect'] ?? '';
    if (is_safe_redirect($redirect)) {
        header('Location: ' . $redirect);
    } else {
        header('Location: index.php');
    }
    exit;
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        validate_csrf();

        // Sanitize and validate input
        $security = Security::getInstance();
        $email = $security->sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $firstName = $security->sanitizeInput($_POST['first_name'] ?? '');
        $lastName = $security->sanitizeInput($_POST['last_name'] ?? '');

        // Validate required fields
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            throw new Exception('Email and password are required. Please fill in all fields.');
        }

        // Validate email format
        $security->validateEmail($email);

        // Validate password
        $security->validatePassword($password);

        if ($password !== $confirmPassword) {
            throw new Exception('Passwords do not match');
        }

        // Add rate limiting for registrations
        $security->rateLimit(get_client_ip(), 'register', 3, 3600);

        // Register user
        $userId = $auth->register([
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);

        $redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? '';
        $isCheckoutRedirect = (strpos($redirect, '/checkout.php') === 0);
        if ($isCheckoutRedirect && is_safe_redirect($redirect)) {
            add_success('Account created! Please check your email to verify your address, then log in to complete your purchase.');
        } else {
            add_success('Registration successful! Your 7-day free trial has started. Please check your email to verify your account, then you can start cleaning your data.');
        }
        // Preserve redirect so after verification they can use "Log in" with return URL
        if (is_safe_redirect($redirect)) {
            header('Location: register.php?redirect=' . rawurlencode($redirect));
            exit;
        }
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
    <link rel="canonical" href="https://simple-data-cleaner.com/register.php">
    <title>Register - Simple Data Cleaner</title>
    <meta name="description" content="Create your free Simple Data Cleaner account to clean UK phone numbers, NI numbers, postcodes, sort codes, and email addresses. 100% browser-based, GDPR compliant data validation.">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Register - Simple Data Cleaner">
    <meta property="og:description" content="Create your free account to access UK data validation tools. 100% browser-based, GDPR compliant data cleaning.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/register.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Register - Simple Data Cleaner">
    <meta name="twitter:description" content="Create your free account to access UK data validation tools.">
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
    <main id="main-content">
    <div id="main-content" class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white">Start Your 7-Day Free Trial</h1>
                <p class="text-neutral-400 mt-2">Create your account and get full access for 7 days. No card required.</p>
                <div class="mt-4 bg-green-500/10 border border-green-500/30 rounded-lg p-4 max-w-md mx-auto">
                    <p class="text-sm text-green-300 font-medium mb-1">✓ Full access to all features</p>
                    <p class="text-sm text-green-400/90">✓ Upload your own files • Unlimited cleaning • Export results</p>
                </div>
            </div>

            <?php display_messages(); ?>

            <div class="bg-neutral-900 rounded-xl border border-neutral-700 p-8">
                <form method="POST" action="register.php<?php echo (isset($_GET['redirect']) && is_safe_redirect($_GET['redirect'])) ? '?redirect=' . rawurlencode($_GET['redirect']) : ''; ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? ''); ?>">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="first_name" class="block text-neutral-300 text-sm font-medium mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="John"
                                value="<?php echo old('first_name'); ?>">
                        </div>

                        <div>
                            <label for="last_name" class="block text-neutral-300 text-sm font-medium mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Doe"
                                value="<?php echo old('last_name'); ?>">
                        </div>
                    </div>

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
                        <p class="mt-1 text-sm text-neutral-400">Must be at least 8 characters long</p>
                    </div>

                    <div class="mb-6">
                        <label for="confirm_password" class="block text-neutral-300 text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="••••••••">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" required
                                class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-neutral-600 rounded bg-neutral-800">
                            <span class="ml-2 text-sm text-neutral-400">
                                I agree to the
                                <a href="/terms.php" class="text-yellow-400 hover:text-yellow-300">Terms of Service</a>
                                and
                                <a href="/privacy.php" class="text-yellow-400 hover:text-yellow-300">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-neutral-400">
                        Already have an account?
                        <?php
                        $loginUrl = '/login.php';
                        if (!empty($_GET['redirect']) && is_safe_redirect($_GET['redirect'])) {
                            $loginUrl .= '?redirect=' . rawurlencode($_GET['redirect']);
                        }
                        ?>
                        <a href="<?php echo htmlspecialchars($loginUrl); ?>" class="text-yellow-400 hover:text-yellow-300 font-medium">
                            Log in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
