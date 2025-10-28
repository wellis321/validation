<?php
require_once __DIR__ . '/includes/init.php';

// Require authentication
if (!$auth->isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

// Get user's subscription
$userModel = new User();
$userModel->id = $user['id'];
$subscription = $userModel->getCurrentSubscription();
$remainingRequests = $userModel->getRemainingRequests();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        validate_csrf();

        // Get form data
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Update profile
        if (!empty($firstName) || !empty($lastName)) {
            $auth->updateProfile($user['id'], [
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
            add_success('Profile updated successfully');
        }

        // Change password
        if (!empty($currentPassword) && !empty($newPassword)) {
            if ($newPassword !== $confirmPassword) {
                throw new Exception('New passwords do not match');
            }

            if (!$auth->verifyPassword($currentPassword, $user['password'])) {
                throw new Exception('Current password is incorrect');
            }

            $security->validatePassword($newPassword);

            $auth->updateProfile($user['id'], [
                'password' => $newPassword
            ]);

            add_success('Password changed successfully');
        }

        // Refresh user data
        $user = $auth->getCurrentUser();
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
    <title>Account Settings - UK Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-blue-600">UK Data Cleaner</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="/dashboard.php" class="text-gray-700 hover:text-gray-900 mr-4">Dashboard</a>
                    <a href="/logout.php" class="text-gray-700 hover:text-gray-900">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Account Settings</h1>
            </div>

            <?php display_messages(); ?>

            <div class="p-6">
                <!-- Profile Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
                    <form method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" id="first_name" name="first_name"
                                    value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" id="last_name" name="last_name"
                                    value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <p class="mt-1 text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Update Profile
                        </button>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                    <form method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" id="new_password" name="new_password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Change Password
                        </button>
                    </form>
                </div>

                <!-- Subscription Information -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Subscription Details</h2>
                    <?php if ($subscription): ?>
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Current Plan</p>
                                    <p class="font-semibold"><?php echo htmlspecialchars($subscription['name']); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Files Per Day</p>
                                    <p class="font-semibold"><?php echo ($subscription['max_requests_per_day'] ?? 0) == 0 ? 'Unlimited' : number_format($remainingRequests); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Max File Size</p>
                                    <p class="font-semibold"><?php echo ($subscription['max_file_size_mb'] ?? 0) == 0 ? 'Device-based (varies by browser)' : ($subscription['max_file_size_mb'] . 'MB'); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p class="font-semibold text-green-600">Active</p>
                                </div>
                            </div>
                            <?php if (isset($subscription['end_date']) && !empty($subscription['end_date'])): ?>
                                <?php
                                $endDate = new DateTime($subscription['end_date']);
                                $now = new DateTime();
                                $daysLeft = $now->diff($endDate)->days;
                                $isAnnual = $subscription['duration_months'] == 12;
                                $isMonthly = $subscription['duration_months'] == 1;
                                $isRecurring = $isAnnual || $isMonthly;
                                ?>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 mb-1">
                                        <?php if ($isRecurring && $subscription['duration_months'] != 0 && $subscription['duration_months'] != 0.033): ?>
                                            Subscription renews: <span class="font-semibold"><?php echo $endDate->format('F j, Y'); ?></span>
                                        <?php elseif ($subscription['duration_months'] == 0.033): ?>
                                            Expires: <span class="font-semibold"><?php echo $endDate->format('F j, Y \a\t g:i A'); ?></span>
                                        <?php else: ?>
                                            Valid until: <span class="font-semibold"><?php echo $endDate->format('F j, Y'); ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <?php if ($isRecurring): ?>
                                        <p class="text-xs text-gray-500 mb-3">
                                            You'll have access until <?php echo $endDate->format('F j, Y'); ?> (<?php echo $daysLeft; ?> days remaining)
                                        </p>
                                        <a href="/cancel-subscription.php" class="inline-block text-red-600 hover:text-red-800 text-sm font-medium">
                                            Cancel Subscription
                                        </a>
                                    <?php endif; ?>
                                    <span class="text-gray-400 mx-2">|</span>
                                    <a href="/pricing.php" class="text-blue-600 hover:text-blue-800 text-sm">View Plans</a>
                                </div>
                            <?php else: ?>
                                <div class="mt-4">
                                    <a href="/pricing.php" class="text-blue-600 hover:text-blue-800">View Plans</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800 mb-4">You don't have an active subscription.</p>
                            <a href="/pricing.php" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                                Choose a Plan
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
