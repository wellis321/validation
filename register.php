<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Security.php';
require_once __DIR__ . '/includes/ErrorHandler.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Email.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$errorHandler = ErrorHandler::getInstance();

// If already logged in, redirect to dashboard
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
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
            throw new Exception('Please fill in all required fields');
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

        add_success('Registration successful! Please check your email to verify your account.');
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
    <title>Register - Simple Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Create Account</h1>
                <p class="text-gray-600 mt-2">Join Simple Data Cleaner today</p>
            </div>

            <?php display_messages(); ?>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <form method="POST" action="register.php">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="John"
                                value="<?php echo old('first_name'); ?>">
                        </div>

                        <div>
                            <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Doe"
                                value="<?php echo old('last_name'); ?>">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="your@email.com"
                            value="<?php echo old('email'); ?>">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                        <p class="mt-1 text-sm text-gray-500">Must be at least 8 characters long</p>
                    </div>

                    <div class="mb-6">
                        <label for="confirm_password" class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" required
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">
                                I agree to the
                                <a href="/terms.php" class="text-blue-600 hover:text-blue-800">Terms of Service</a>
                                and
                                <a href="/privacy.php" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="login.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            Log in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
