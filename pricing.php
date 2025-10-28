<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

// Get all active subscription plans
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM subscription_plans WHERE is_active = 1 ORDER BY price ASC");
$plans = $stmt->fetchAll();

// Get user's current subscription if logged in
$currentPlan = null;
if ($user) {
    $userModel = new User();
    $userModel->id = $user['id'];
    $currentPlan = $userModel->getCurrentSubscription();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - UK Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
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
                    <?php if ($user): ?>
                        <a href="/dashboard.php" class="text-gray-700 hover:text-gray-900 mr-4">Dashboard</a>
                        <a href="/logout.php" class="text-gray-700 hover:text-gray-900">Logout</a>
                    <?php else: ?>
                        <a href="/login.php" class="text-gray-700 hover:text-gray-900">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h1>
            <p class="text-xl text-gray-600">All processing happens in your browser - your data never leaves your device!</p>
            <p class="text-lg text-green-600 mt-2">✓ Large files supported ✓ Unlimited files ✓ Complete privacy</p>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($plans as $plan): ?>
                <?php
                $features = json_decode($plan['features'], true);
                $isCurrentPlan = $currentPlan && $currentPlan['id'] === $plan['id'];
                $isPopular = $plan['name'] === 'Monthly';
                $isAnnual = $plan['name'] === 'Annual';
                ?>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden <?php echo $isPopular ? 'ring-2 ring-blue-500 transform scale-105' : ''; ?>">
                    <?php if ($isPopular): ?>
                        <div class="bg-blue-500 text-white text-center py-2 text-sm font-semibold">
                            MOST POPULAR
                        </div>
                    <?php endif; ?>
                    <?php if ($isAnnual): ?>
                        <div class="bg-green-500 text-white text-center py-2 text-sm font-semibold">
                            BEST VALUE - SAVE £109.89!
                        </div>
                    <?php endif; ?>
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($plan['name']); ?></h2>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($plan['description']); ?></p>
                        <div class="flex items-baseline mb-2">
                            <span class="text-4xl font-bold text-gray-900">£<?php echo number_format($plan['price'], 2); ?></span>
                            <span class="text-gray-500 ml-2">
                                <?php if ($plan['name'] === 'Pay Per Use'): ?>
                                    /24 hours
                                <?php elseif ($plan['duration_months'] === 12): ?>
                                    /year
                                <?php else: ?>
                                    /month
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ($isAnnual): ?>
                            <p class="text-sm text-green-600 mb-6">That's just £20.83/month!</p>
                        <?php else: ?>
                            <div class="mb-6"></div>
                        <?php endif; ?>

                        <ul class="space-y-3 mb-8">
                            <?php if ($features['unlimited_files']): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">
                                        <?php echo $plan['name'] === 'Pay Per Use' ? 'Use once' : 'Unlimited files'; ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                            <?php if ($features['client_side_processing']): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Client-side processing (100% private)</span>
                                </li>
                            <?php endif; ?>
                            <?php if ($features['all_data_types']): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Phone numbers, NI numbers, postcodes & sort codes</span>
                                </li>
                            <?php endif; ?>
                            <?php if ($features['api_access']): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">API access</span>
                                </li>
                            <?php endif; ?>
                            <?php if ($features['priority_support']): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">Priority email support</span>
                                </li>
                            <?php endif; ?>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Export to CSV, Excel, JSON</span>
                            </li>
                        </ul>

                        <?php if ($isCurrentPlan): ?>
                            <button disabled
                                class="w-full bg-gray-300 text-gray-700 py-3 px-6 rounded-lg font-medium">
                                Current Plan
                            </button>
                        <?php else: ?>
                            <a href="/checkout.php?plan=<?php echo $plan['id']; ?>"
                                class="block w-full <?php echo $isPopular ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-800 hover:bg-gray-900'; ?> text-white text-center py-3 px-6 rounded-lg font-medium transition-colors">
                                <?php echo $plan['name'] === 'Pay Per Use' ? 'Pay £' . number_format($plan['price'], 2) : 'Subscribe Now'; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-16 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-6 text-left">
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">How does client-side processing work?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">Your files are processed entirely in your browser using JavaScript. No data is ever uploaded to our servers - we only handle authentication. This means your sensitive data stays 100% private and secure on your device.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Are there any file size limits?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">Since processing happens on your device, file size limits depend on your device's memory. We automatically detect your device capabilities and recommend appropriate file sizes. Most modern computers can handle files of several hundred MB, while devices with less memory may be better suited for smaller files.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">What payment methods do you accept?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">We accept all major credit cards and PayPal.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Can I cancel my subscription?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">Yes! Monthly and Annual plans can be cancelled at any time. You'll continue to have access until the end of your billing period.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">What's the difference between Pay Per Use and subscriptions?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">Pay Per Use (£4.99) gives you 24-hour access - perfect for quick jobs or trying the service. Monthly (£29.99) and Annual (£249.99) plans give you unlimited access, priority support, and API access.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Is my data really secure?</h3>
                    </div>
                    <p class="text-gray-600 mt-2">Absolutely! Your files never leave your computer. All cleaning and validation happens in your browser. We only verify your subscription status - we never see or store your data.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
