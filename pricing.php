<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

// Get all active subscription plans, excluding Pay Per Use and Free Trial
$db = Database::getInstance();
$allPlans = [];
try {
    if ($db->isConnected()) {
        // Use the original query format but exclude Free Trial and Lifetime Beta
        $stmt = $db->query("SELECT * FROM subscription_plans WHERE is_active = 1 AND name != 'Pay Per Use' AND name != 'Free Trial' AND name != 'Lifetime Beta' ORDER BY FIELD(name, 'Monthly', 'Annual'), price ASC");
        $result = $stmt->fetchAll();
        $allPlans = is_array($result) ? $result : [];
    }
} catch (Exception $e) {
        // Fallback: try without excluding Free Trial (in case it doesn't exist yet)
        error_log("Pricing page query error: " . $e->getMessage());
        try {
            if ($db->isConnected()) {
                $stmt = $db->query("SELECT * FROM subscription_plans WHERE is_active = 1 AND name != 'Pay Per Use' AND name != 'Lifetime Beta' ORDER BY FIELD(name, 'Monthly', 'Annual'), price ASC");
            $result = $stmt->fetchAll();
            $allPlans = is_array($result) ? $result : [];
        }
    } catch (Exception $e2) {
        error_log("Pricing page fallback query error: " . $e2->getMessage());
        $allPlans = [];
    }
}

// Remove duplicates by plan name (keep the one with highest ID - most recent)
// Use ordered array to maintain the desired display order
$orderMap = ['Monthly' => 1, 'Annual' => 2];
$plansByName = [];
if (is_array($allPlans)) {
    foreach ($allPlans as $plan) {
        if (isset($plan['name']) && isset($plan['id'])) {
            $name = $plan['name'];
            if (!isset($plansByName[$name]) || $plan['id'] > $plansByName[$name]['id']) {
                $plansByName[$name] = $plan;
            }
        }
    }
}

// Sort by desired order and convert to indexed array
uksort($plansByName, function($a, $b) use ($orderMap) {
    $orderA = $orderMap[$a] ?? 999;
    $orderB = $orderMap[$b] ?? 999;
    return $orderA <=> $orderB;
});

$plans = array_values($plansByName);

// Ensure plans array exists
if (!is_array($plans)) {
    $plans = [];
}

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
    <link rel="canonical" href="https://simple-data-cleaner.com/pricing.php">
    <title>Pricing - Simple Data Cleaner | UK Data Validation</title>
    <meta name="description" content="Simple, transparent pricing for UK data validation. All processing happens in your browser - your data never leaves your device. Start with a 7-day free trial. Choose from Monthly or Annual plans, or contact us for bespoke solutions.">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Pricing - Simple Data Cleaner | UK Data Validation">
    <meta property="og:description" content="Simple, transparent pricing for UK data validation. All processing happens in your browser.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/pricing.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:site_name" content="Simple Data Cleaner">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Pricing - Simple Data Cleaner">
    <meta name="twitter:description" content="Simple, transparent pricing for UK data validation. All processing happens in your browser.">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">

    <!-- Product/Offer Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": "Simple Data Cleaner",
      "description": "UK data validation and cleaning service - phone numbers, NI numbers, postcodes, bank sort codes, and email addresses",
      "brand": {
        "@type": "Organization",
        "name": "Simple Data Cleaner"
      },
      "offers": [
        <?php
        $offerSchemas = [];
        foreach ($plans as $index => $plan) {
            $features = json_decode($plan['features'], true) ?: [];
            $isLifetime = $plan['name'] === 'Lifetime Beta' || (!empty($features['lifetime_access']));
            $duration = $isLifetime ? 'P99Y' : ($plan['duration_months'] === 12 ? 'P1Y' : 'P1M');

            $offerSchemas[] = json_encode([
                "@type" => "Offer",
                "name" => $plan['name'],
                "description" => $plan['description'],
                "price" => number_format($plan['price'], 2),
                "priceCurrency" => "GBP",
                "availability" => "https://schema.org/InStock",
                "url" => "https://simple-data-cleaner.com/pricing.php",
                "priceSpecification" => [
                    "@type" => "UnitPriceSpecification",
                    "price" => number_format($plan['price'], 2),
                    "priceCurrency" => "GBP",
                    "billingDuration" => $duration
                ]
            ], JSON_UNESCAPED_SLASHES);
        }
        echo implode(",\n        ", $offerSchemas);
        ?>
      ]
    }
    </script>

    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12 ds-animate-fade-slide ds-animate-delay-1">
            <h1 class="text-4xl font-bold text-white mb-4">Simple, Transparent Pricing</h1>
            <p class="text-xl text-neutral-400 max-w-2xl mx-auto">Start with a <span class="text-yellow-400 font-semibold">7-day free trial</span> — no card required. Choose the plan that fits your needs. All processing happens in your browser — your data never leaves your device.</p>
            <p class="text-sm text-green-400 mt-3">✓ Large files supported ✓ Unlimited files ✓ Complete privacy</p>
            <div class="max-w-3xl mx-auto mt-8 bg-green-500/10 border border-green-500/30 text-neutral-200 rounded-xl px-6 py-4 mb-4">
                <p class="font-semibold text-sm uppercase tracking-wide text-green-400 mb-1">New users: 7-day free trial</p>
                <p class="text-sm md:text-base">Sign up and get full access for 7 days. Upload your own files, clean unlimited data, export results. No credit card required. Cancel anytime.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Monthly Plan -->
            <!-- Annual Plan -->
            <!-- Plans will be rendered here -->
            <!-- Bespoke Services Card (not a subscription) -->
            <?php if (empty($plans)): ?>
                <div class="col-span-3 text-center py-12">
                    <p class="text-neutral-400 mb-4">No subscription plans available at this time.</p>
                    <p class="text-sm text-neutral-500">Please contact support if you believe this is an error.</p>
                </div>
            <?php else: ?>
            <?php $planIndex = 0; foreach ($plans as $plan): $planIndex++; ?>
                <?php
                $features = json_decode($plan['features'], true) ?: [];
                $isLifetime = !empty($features['lifetime_access']);
                $isCurrentPlan = $currentPlan && $currentPlan['id'] === $plan['id'];
                $isMonthly = $plan['name'] === 'Monthly';
                $isAnnual = $plan['name'] === 'Annual';

                $ctaLabel = 'Subscribe Now';
                $cardClasses = 'ds-card ds-animate-fade-slide ds-hover-lift overflow-hidden';
                $cardClasses .= ' ds-animate-delay-' . min($planIndex, 6);
                if ($isMonthly) {
                    $cardClasses .= ' border-2 border-yellow-500/60 ring-2 ring-yellow-500/30 relative z-10 md:scale-[1.02]';
                }
                ?>
                <div class="<?php echo $cardClasses; ?>" <?php echo $isLifetime ? 'id="lifetime-beta-plan"' : ''; ?>>
                    <div class="p-8">
                        <?php if ($isMonthly): ?>
                            <p class="ds-badge-popular mb-3">Most popular</p>
                        <?php endif; ?>
                        <?php if ($isAnnual): ?>
                            <p class="ds-badge-value mb-3">Best value — save £109.89</p>
                        <?php endif; ?>
                        <h2 class="text-xl font-bold text-white mb-2"><?php echo htmlspecialchars($plan['name']); ?></h2>
                        <p class="text-neutral-400 text-sm mb-4"><?php echo htmlspecialchars($plan['description']); ?></p>
                        <div class="flex items-baseline mb-1">
                            <span class="text-3xl font-bold text-white">£<?php echo number_format($plan['price'], 2); ?></span>
                            <span class="text-neutral-500 ml-2 text-sm">
                                <?php if ($isLifetime): ?>
                                    one-time
                                <?php elseif ($plan['duration_months'] === 12): ?>
                                    /year
                                <?php else: ?>
                                    /month
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php if ($isAnnual): ?>
                            <p class="text-sm text-green-400 mb-6">That's just £20.83/month</p>
                        <?php else: ?>
                            <div class="mb-6"></div>
                        <?php endif; ?>

                        <ul class="space-y-3 mb-8">
                            <?php if (!empty($features['unlimited_files'])): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-neutral-300">Unlimited files</span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($features['client_side_processing'])): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-neutral-300">Client-side processing (100% private)</span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($features['all_data_types'])): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-neutral-300">Phone numbers, NI numbers, postcodes, sort codes & email</span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($features['priority_support'])): ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-neutral-300">Priority email support</span>
                                </li>
                            <?php endif; ?>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-neutral-300">Export to CSV, Excel, JSON</span>
                            </li>
                        </ul>

                        <?php if ($isCurrentPlan): ?>
                            <button disabled
                                class="w-full bg-neutral-600 text-neutral-400 py-3 px-6 rounded-lg font-medium cursor-not-allowed">
                                Current Plan
                            </button>
                        <?php else: ?>
                            <a href="/checkout.php?plan=<?php echo $plan['id']; ?>"
                                class="block w-full text-center py-3 px-6 rounded-lg font-semibold transition-colors <?php echo $isMonthly ? 'bg-yellow-400 hover:bg-yellow-500 text-black' : 'bg-white hover:bg-neutral-200 text-black'; ?>">
                                <?php echo $ctaLabel; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <!-- Bespoke Services Card -->
            <div class="ds-card ds-animate-fade-slide ds-animate-delay-4 ds-hover-lift overflow-hidden border-2 border-yellow-500/40">
                <div class="p-8">
                    <p class="ds-badge-popular mb-3">Enterprise</p>
                    <h2 class="text-xl font-bold text-white mb-2">Bespoke Services</h2>
                    <p class="text-neutral-400 text-sm mb-4">Custom data validation rules built for your specific needs. Perfect for unique fields, compliance requirements, and enterprise solutions.</p>
                    <div class="flex items-baseline mb-1">
                        <span class="text-3xl font-bold text-white">Custom</span>
                        <span class="text-neutral-500 ml-2 text-sm">pricing</span>
                    </div>
                    <p class="text-sm text-yellow-400 mb-6">Tailored to your requirements</p>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-neutral-300">Custom validation rules</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-neutral-300">100% browser-based processing</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-neutral-300">Dedicated support & consultation</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-neutral-300">GDPR compliant & on-premise</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-neutral-300">Integration support</span>
                        </li>
                    </ul>

                    <a href="/bespoke.php"
                        class="block w-full text-center py-3 px-6 rounded-lg font-semibold transition-colors bg-yellow-500 hover:bg-yellow-400 text-black">
                        Get Started
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center">
            <h2 class="text-2xl font-bold text-white mb-8">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-6 text-left">
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">How does client-side processing work?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Your files are processed entirely in your browser using JavaScript. No data is ever uploaded to our servers - we only handle authentication. This means your sensitive data stays 100% private and secure on your device.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Are there any file size limits?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Since processing happens on your device, file size limits depend on your device's memory. We automatically detect your device capabilities and recommend appropriate file sizes. Most modern computers can handle files of several hundred MB, while devices with less memory may be better suited for smaller files.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">What payment methods do you accept?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">We accept all major credit cards and PayPal.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Can I cancel my subscription?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Yes! Monthly and Annual plans can be cancelled at any time. You'll continue to have access until the end of your billing period.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">How do the plans compare?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Monthly (£29.99) gives you unlimited access with predictable monthly billing, while Annual (£249.99) delivers the lowest effective price for teams who need year-round cleaning. All plans include unlimited files, client-side processing, and export to CSV, Excel, and JSON. Need custom validation rules? Check out our <a href="/bespoke.php" class="text-yellow-400 hover:text-yellow-300 underline">Bespoke Services</a>.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Do you offer custom validation rules?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Yes! Our <a href="/bespoke.php" class="text-yellow-400 hover:text-yellow-300 underline">Bespoke Services</a> team can build custom validation rules for your specific data fields and compliance requirements. Everything runs in the browser, keeping your data private and GDPR compliant. Contact us to discuss your needs. and any stability or UX improvements to this validator set. When we launch entirely new validator families or major feature versions, we’ll offer optional upgrade paths so you can choose whether to extend your licence. That keeps your original lifetime access safe while letting us keep innovating.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">Is my data really secure?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Absolutely! Your files never leave your computer. All cleaning and validation happens in your browser. We only verify your subscription status - we never see or store your data.</p>
                </div>
                <div>
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9a2 2 0 012-2h2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v6m0 0l-2.5-2.5M12 18l2.5-2.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L9.5 4.5 12 7l2.5-2.5L12 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white">How do I share feedback?</h3>
                    </div>
                    <p class="text-neutral-400 mt-2">Head to our <a href="/feedback.php" class="text-yellow-500 hover:underline">feedback form</a> any time to submit your experience, ideas, or custom validator requests. We review all feedback and use it to prioritize improvements.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
