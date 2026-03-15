<?php
/**
 * Pay Per Use — one-time purchase page.
 * Not linked from the main site. Super admin can send this link to users
 * so they can buy a single-use access (£4.99).
 */
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/config/stripe_config.php';

$auth = Auth::getInstance();
$auth->requireAuth();

$user = $auth->getCurrentUser();
$db = Database::getInstance();

// Load Pay Per Use plan (not shown on main pricing page)
$plan = null;
$priceConfigured = false;
try {
    if ($db->isConnected()) {
        $stmt = $db->query(
            "SELECT * FROM subscription_plans WHERE is_active = 1 AND name = 'Pay Per Use' LIMIT 1"
        );
        $plan = $stmt->fetch();
    }
    $priceConfigured = defined('STRIPE_PRICE_PAY_PER_USE') && STRIPE_PRICE_PAY_PER_USE !== '';
} catch (Exception $e) {
    error_log('Pay per use page: ' . $e->getMessage());
}

$available = $plan && $priceConfigured;
$pageTitle = 'Pay Per Use — Simple Data Cleaner';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $available ? 'Pay Per Use' : 'Not Available'; ?> | Simple Data Cleaner</title>
    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-md mx-auto">
            <?php if ($available): ?>
                <div class="ds-card ds-hover-lift overflow-hidden border-2 border-yellow-500/40 p-8 text-center">
                    <h1 class="text-2xl font-bold text-white mb-2">Pay Per Use</h1>
                    <p class="text-neutral-400 text-sm mb-6">One-time access to clean and validate your UK data. No subscription.</p>
                    <div class="flex items-baseline justify-center gap-2 mb-6">
                        <span class="text-4xl font-bold text-white">£<?php echo number_format($plan['price'], 2); ?></span>
                        <span class="text-neutral-500 text-sm">one-time</span>
                    </div>
                    <ul class="space-y-2 text-left text-neutral-300 text-sm mb-8 max-w-xs mx-auto">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            One-time payment
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            100% in your browser
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            CSV, Excel, JSON export
                        </li>
                    </ul>
                    <a href="/checkout.php?plan=<?php echo (int) $plan['id']; ?>"
                       class="block w-full text-center py-3 px-6 rounded-lg font-semibold bg-yellow-500 hover:bg-yellow-400 text-black transition-colors">
                        Pay £<?php echo number_format($plan['price'], 2); ?> — Get access
                    </a>
                    <p class="text-neutral-500 text-xs mt-4">You will be taken to Stripe Checkout. After payment you can use the tool immediately.</p>
                </div>
                <p class="text-center mt-6">
                    <a href="/pricing.php" class="text-neutral-400 hover:text-white text-sm">View subscription plans</a>
                </p>
            <?php else: ?>
                <div class="ds-card p-8 text-center border border-neutral-700">
                    <h1 class="text-xl font-bold text-white mb-2">Pay Per Use is not available</h1>
                    <p class="text-neutral-400 text-sm mb-6">This option is not currently set up. Please use the main pricing page or contact support.</p>
                    <a href="/pricing.php" class="inline-block py-2 px-4 rounded-lg font-semibold bg-yellow-500 hover:bg-yellow-400 text-black transition-colors">
                        Go to pricing
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
