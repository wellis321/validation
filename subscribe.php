<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$auth->requireAuth(); // Redirect to login if not authenticated

$user = $auth->getCurrentUser();
$error = null;
$success = null;

// Get plan ID from URL
$planId = $_GET['plan'] ?? null;

if (!$planId) {
    header('Location: /pricing.php');
    exit;
}

// Get plan details
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM subscription_plans WHERE id = ? AND is_active = 1", [$planId]);
$plan = $stmt->fetch();

if (!$plan) {
    header('Location: /pricing.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        validate_csrf();
        
        // TODO: Integrate with payment gateway
        // For now, we'll just create a subscription record

        // Calculate subscription dates
        $startDate = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime("+{$plan['duration_months']} months"));

        // Create subscription
        $db->insert('user_subscriptions', [
            'user_id' => $user['id'],
            'plan_id' => $plan['id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'payment_status' => $plan['price'] > 0 ? 'pending' : 'completed'
        ]);

        $success = 'Subscription activated successfully!';
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
    <title>Subscribe - UK Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Subscribe to <?php echo htmlspecialchars($plan['name']); ?></h1>
                <p class="text-gray-600 mt-2">Complete your subscription to start cleaning data</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($success); ?>
                    <div class="mt-4">
                        <a href="/dashboard.php"
                            class="inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Plan Details</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-700"><?php echo htmlspecialchars($plan['name']); ?></span>
                                <span class="text-xl font-bold">£<?php echo number_format($plan['price'], 2); ?>/month</span>
                            </div>
                            <ul class="space-y-2 text-gray-600">
                                <li>• <?php echo number_format($plan['max_requests_per_day']); ?> requests per day</li>
                                <li>• Up to <?php echo $plan['max_file_size_mb']; ?>MB file size</li>
                                <?php
                                $features = json_decode($plan['features'], true);
                                if ($features['batch_processing']) echo '<li>• Batch processing</li>';
                                if ($features['api_access']) echo '<li>• API access</li>';
                                if ($features['priority_support']) echo '<li>• Priority support</li>';
                                ?>
                            </ul>
                        </div>
                    </div>

                    <?php if ($plan['price'] > 0): ?>
                        <form method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="card_number" class="block text-gray-700 text-sm font-medium mb-2">Card Number</label>
                                <input type="text" id="card_number" name="card_number" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="1234 5678 9012 3456">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry" class="block text-gray-700 text-sm font-medium mb-2">Expiry Date</label>
                                    <input type="text" id="expiry" name="expiry" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="MM/YY">
                                </div>

                                <div>
                                    <label for="cvc" class="block text-gray-700 text-sm font-medium mb-2">CVC</label>
                                    <input type="text" id="cvc" name="cvc" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="123">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Subscribe Now
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Activate Free Plan
                            </button>
                        </form>
                    <?php endif; ?>

                    <p class="text-sm text-gray-500 mt-6">
                        By subscribing, you agree to our
                        <a href="/terms.php" class="text-blue-600 hover:text-blue-800">Terms of Service</a>
                        and
                        <a href="/privacy.php" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$success): ?>
        <script>
            // Basic form validation
            document.querySelector('form')?.addEventListener('submit', function(e) {
                const cardNumber = document.getElementById('card_number')?.value;
                const expiry = document.getElementById('expiry')?.value;
                const cvc = document.getElementById('cvc')?.value;

                if (cardNumber) {
                    if (!/^\d{16}$/.test(cardNumber.replace(/\s/g, ''))) {
                        e.preventDefault();
                        alert('Please enter a valid 16-digit card number');
                        return;
                    }
                }

                if (expiry) {
                    if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                        e.preventDefault();
                        alert('Please enter a valid expiry date (MM/YY)');
                        return;
                    }
                }

                if (cvc) {
                    if (!/^\d{3,4}$/.test(cvc)) {
                        e.preventDefault();
                        alert('Please enter a valid CVC (3-4 digits)');
                        return;
                    }
                }
            });

            // Format card number with spaces
            document.getElementById('card_number')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                if (value.length > 16) value = value.slice(0, 16);
                e.target.value = value.replace(/(\d{4})/g, '$1 ').trim();
            });

            // Format expiry date
            document.getElementById('expiry')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0, 4);
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                e.target.value = value;
            });

            // Format CVC
            document.getElementById('cvc')?.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0, 4);
                e.target.value = value;
            });
        </script>
    <?php endif; ?>
</body>
</html>
