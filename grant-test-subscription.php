<?php
require_once __DIR__ . '/includes/init.php';

// Check if user is logged in
if (!$user) {
    header('Location: /login.php');
    exit;
}

$db = Database::getInstance();
$userModel = new User();

// Check if user already has a subscription
$subscription = $userModel->getCurrentSubscription();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get the "Monthly" plan (id=2) from the database
        $stmt = $db->query("SELECT * FROM subscription_plans WHERE name = 'Monthly' LIMIT 1");
        $plan = $stmt->fetch();

        if (!$plan) {
            $message = 'Error: Monthly plan not found in database.';
        } else {
            // Create a test subscription that lasts 1 year
            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime('+1 year'));

            // Check if user already has ANY subscription
            $stmt = $db->query("SELECT * FROM user_subscriptions WHERE user_id = ?", [$user['id']]);
            $existingSub = $stmt->fetch();

            if ($existingSub) {
                // Update existing subscription
                $db->update('user_subscriptions',
                    [
                        'plan_id' => $plan['id'],
                        'status' => 'active',
                        'payment_status' => 'completed',
                        'start_date' => $startDate,
                        'end_date' => $endDate
                    ],
                    'user_id = ?',
                    [$user['id']]
                );
                $message = '✅ Your existing subscription has been updated to Monthly plan for testing!';
            } else {
                // Create new subscription
                $db->insert('user_subscriptions', [
                    'user_id' => $user['id'],
                    'plan_id' => $plan['id'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'payment_status' => 'completed'
                ]);
                $message = '✅ Test subscription granted! You now have Monthly plan access for 1 year.';
            }
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }

    // Redirect to avoid resubmission
    header('Location: /grant-test-subscription.php?msg=' . urlencode($message));
    exit;
}

// Get any message from URL
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grant Test Subscription - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-16 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6">Grant Test Subscription</h1>

            <?php if ($subscription): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h2 class="font-semibold text-green-800 mb-2">✅ You have an active subscription!</h2>
                    <p class="text-green-700">
                        <strong>Plan:</strong> <?php echo htmlspecialchars($subscription['name']); ?><br>
                        <strong>Status:</strong> <?php echo htmlspecialchars($subscription['status']); ?><br>
                        <strong>End Date:</strong> <?php echo date('F j, Y', strtotime($subscription['end_date'])); ?>
                    </p>
                    <a href="/dashboard.php" class="inline-block mt-4 text-green-600 hover:text-green-800 font-semibold">
                        Go to Dashboard →
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-blue-800"><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>

            <div class="prose max-w-none mb-6">
                <p>This tool grants you a <strong>Monthly Plan</strong> subscription for testing purposes.</p>
                <p class="text-sm text-gray-600">
                    <strong>Warning:</strong> This is for development/testing only.
                    In production, users would purchase subscriptions through your payment system.
                </p>
            </div>

            <form method="POST">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold w-full">
                    <?php echo $subscription ? 'Renew/Update Subscription' : 'Grant Monthly Plan Access'; ?>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t">
                <p class="text-sm text-gray-500">
                    <strong>Current User:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
                    <strong>User ID:</strong> <?php echo $user['id']; ?>
                </p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/dashboard.php" class="text-blue-600 hover:text-blue-800">Go to Dashboard</a>
        </div>
    </div>
</body>
</html>
