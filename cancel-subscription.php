<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/Database.php';

// Require authentication
$auth = Auth::getInstance();
if (!$auth->isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

$user = $auth->getCurrentUser();
$userModel = new User();
$userModel->id = $user['id'];
$subscription = $userModel->getCurrentSubscription();

if (!$subscription) {
    $_SESSION['error'] = 'No active subscription found.';
    header('Location: /account.php');
    exit;
}

// Only allow cancellation of recurring subscriptions (not 24-hour access)
$isRecurring = ($subscription['duration_months'] == 1 || $subscription['duration_months'] == 12);

if (!$isRecurring) {
    $_SESSION['error'] = 'This plan does not require cancellation.';
    header('Location: /account.php');
    exit;
}

$error = null;
$success = null;

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validate_csrf();

        $db = Database::getInstance();

        // Get the subscription record
        $sub = $db->query(
            "SELECT * FROM user_subscriptions WHERE user_id = ? AND plan_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1",
            [$user['id'], $subscription['id']]
        )->fetch();

        if ($sub) {
            // Update subscription status to cancelled
            $db->query(
                "UPDATE user_subscriptions SET status = 'cancelled', updated_at = NOW() WHERE id = ?",
                [$sub['id']]
            );

            $success = 'Your subscription has been cancelled. You will continue to have access until ' .
                       date('F j, Y', strtotime($subscription['end_date'])) . '.';
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
    <title>Cancel Subscription - Simple Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-blue-600">Simple Data Cleaner</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="/account.php" class="text-gray-700 hover:text-gray-900">Account</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Cancel Subscription</h1>
            </div>

            <div class="p-6">
                <?php if ($success): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                    <div class="mt-4">
                        <a href="/account.php" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                            Back to Account
                        </a>
                    </div>
                <?php elseif ($error): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php else: ?>
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Are you sure you want to cancel?</h2>
                        <p class="text-gray-600 mb-4">
                            You're currently subscribed to the <strong><?php echo htmlspecialchars($subscription['name']); ?></strong> plan.
                        </p>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                <strong>Important:</strong> Your subscription will remain active until <strong><?php echo date('F j, Y', strtotime($subscription['end_date'])); ?></strong>.
                                You'll continue to have full access until then. You won't be charged again.
                            </p>
                        </div>

                        <form method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="flex gap-4">
                                <button type="submit"
                                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-medium">
                                    Yes, Cancel Subscription
                                </button>
                                <a href="/account.php"
                                    class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium">
                                    Keep My Subscription
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-md font-semibold text-gray-900 mb-3">Why are you cancelling?</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            We'd love to hear your feedback. Email us at <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600">noreply@simple-data-cleaner.com</a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
