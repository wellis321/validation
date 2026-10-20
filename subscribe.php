<?php
require_once __DIR__ . '/includes/init.php';

$auth->requireAuth(); // Redirect to login if not authenticated
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
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>
    <main id="main-content">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white">Subscribe to <?php echo htmlspecialchars($plan['name']); ?></h1>
                <p class="text-neutral-400 mt-2">Complete your subscription to start cleaning data</p>
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
                        <a href="/dashboard.php"
                            class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-400 font-semibold">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-neutral-900 rounded-xl border border-neutral-700 p-8">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-white mb-4">Plan Details</h2>
                        <div class="bg-neutral-800/50 rounded-lg p-4 border border-neutral-700">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-neutral-300"><?php echo htmlspecialchars($plan['name']); ?></span>
                                <span class="text-xl font-bold text-white">£<?php echo number_format($plan['price'], 2); ?>/month</span>
                            </div>
                            <ul class="space-y-2 text-neutral-400">
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
                                <label for="card_number" class="block text-neutral-300 text-sm font-medium mb-2">Card Number</label>
                                <input type="text" id="card_number" name="card_number" required
                                    class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                    placeholder="1234 5678 9012 3456">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry" class="block text-neutral-300 text-sm font-medium mb-2">Expiry Date</label>
                                    <input type="text" id="expiry" name="expiry" required
                                        class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        placeholder="MM/YY">
                                </div>

                                <div>
                                    <label for="cvc" class="block text-neutral-300 text-sm font-medium mb-2">CVC</label>
                                    <input type="text" id="cvc" name="cvc" required
                                        class="w-full px-4 py-2 bg-neutral-800 border border-neutral-600 rounded-lg text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                        placeholder="123">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-yellow-500 text-black py-3 px-6 rounded-lg font-semibold hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                                Subscribe Now
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="w-full bg-yellow-500 text-black py-3 px-6 rounded-lg font-semibold hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950">
                                Activate Free Plan
                            </button>
                        </form>
                    <?php endif; ?>

                    <p class="text-sm text-neutral-500 mt-6">
                        By subscribing, you agree to our
                        <a href="/terms.php" class="text-yellow-400 hover:text-yellow-300">Terms of Service</a>
                        and
                        <a href="/privacy.php" class="text-yellow-400 hover:text-yellow-300">Privacy Policy</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$success): ?>
        <script <?php echo script_nonce(); ?>>
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

    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
