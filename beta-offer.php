<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'Lifetime Beta Offer';
$pageDescription = 'Lock in lifetime access to the Simple Data Cleaner beta validators for a one-time payment and see what is included.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/beta-offer.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/beta-offer.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:site_name" content="Simple Data Cleaner">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    
    <!-- Offer Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Offer",
      "name": "Lifetime Beta Access to Simple Data Cleaner",
      "description": "Lock in lifetime access to the Simple Data Cleaner beta validators for a one-time payment of £99.99",
      "price": "99.99",
      "priceCurrency": "GBP",
      "availability": "https://schema.org/InStock",
      "url": "https://simple-data-cleaner.com/beta-offer.php",
      "seller": {
        "@type": "Organization",
        "name": "Simple Data Cleaner"
      },
      "priceSpecification": {
        "@type": "UnitPriceSpecification",
        "price": "99.99",
        "priceCurrency": "GBP",
        "billingDuration": "P99Y"
      },
      "itemOffered": {
        "@type": "Service",
        "name": "Lifetime Beta Access",
        "description": "Lifetime access to UK data validation validators including phone numbers, NI numbers, postcodes, and bank sort codes"
      }
    }
    </script>
    
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-slate-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="max-w-5xl mx-auto py-12 px-4">
        <section class="bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="bg-slate-900 text-white px-6 py-12 md:px-12" id="lifetime-beta">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-400/20 text-amber-200 text-xs font-semibold uppercase tracking-wide">Limited Beta Offer</span>
                <h1 class="text-3xl sm:text-4xl font-bold mt-5">Lifetime access to today’s validator set</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-200 leading-relaxed max-w-3xl">
                    Pay once (£99.99) and keep the current Simple Data Cleaner feature set forever. This beta licence
                    gives you lifetime usage rights to our UK validator suite exactly as it exists today, plus
                    maintenance fixes and UX refinements to those validators.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="/pricing.php#lifetime-beta-plan" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Purchase Lifetime Beta (£99.99)
                    </a>
                    <a href="/feedback.php" class="inline-flex items-center gap-2 text-amber-200 hover:text-white transition-colors font-semibold">
                        Why we’re inviting feedback
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="px-6 py-10 md:px-12 space-y-12">
                <section>
                    <h2 class="text-2xl font-semibold text-slate-900">What’s included forever</h2>
                    <p class="text-slate-600 mt-3">Lifetime Beta customers retain access to everything in the current validator suite, even after the beta closes.</p>
                    <div class="grid gap-4 md:grid-cols-2 mt-6">
                        <?php
                        $included = [
                            'UK phone number validation and formatting (mobile + landline)',
                            'UK National Insurance number validation',
                            'UK postcode validation with automatic formatting',
                            'UK bank sort code validation',
                            'Unlimited file uploads with in-browser processing',
                            'CSV, Excel, and JSON export options',
                            'Ongoing maintenance fixes and UX improvements for this validator set'
                        ];
                        foreach ($included as $item): ?>
                            <div class="flex items-start gap-3 bg-green-50 border border-green-200 rounded-xl p-4">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-green-900 text-sm font-medium leading-relaxed"><?php echo htmlspecialchars($item); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-slate-900">What isn’t covered</h2>
                    <p class="text-slate-600 mt-3">The Lifetime Beta licence intentionally focuses on the current feature set so we can offer future upgrades separately.</p>
                    <div class="space-y-4 mt-6">
                        <?php
                        $notIncluded = [
                            'Brand-new validator families (e.g. email, driving licence, passport) launching after beta',
                            'Enterprise automation features or integrations released in future versions',
                            'Team management, audit trails, or analytics modules built after the beta cycle'
                        ];
                        foreach ($notIncluded as $item): ?>
                            <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-amber-900 text-sm font-medium leading-relaxed"><?php echo htmlspecialchars($item); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 bg-amber-100 border border-amber-200 rounded-2xl p-5">
                        <p class="text-amber-900 text-sm leading-relaxed">
                            When new validator families or major feature versions launch, you’ll be offered an optional upgrade price.
                            Your Lifetime Beta access remains active for the original validators even if you choose not to upgrade.
                        </p>
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-slate-900">Why we’re offering this</h2>
                    <div class="grid gap-6 md:grid-cols-2 mt-6">
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-800 mb-3">Support our roadmap</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">The one-time beta payment funds new validator research and the infrastructure we need for larger teams. In return, we keep shipping stability releases to the version you own.</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-800 mb-3">Shape future versions</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">Lifetime Beta members get first access to prototypes and feedback sessions. The pre-release feedback link in your confirmation email keeps us in sync.</p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-slate-900">Need a written summary?</h2>
                    <div class="bg-slate-100 border border-slate-200 rounded-2xl p-6 mt-4">
                        <p class="text-slate-700 text-sm leading-relaxed">
                            The Lifetime Beta licence equals “lifetime access to Simple Data Cleaner v1 (2025 UK validator set)”.
                            We’ll keep polishing this version, but new validator families and major features will live in future version licences.
                            You’ll always have the option to upgrade when those arrive—never a forced migration.
                        </p>
                    </div>
                    <div class="mt-6 flex flex-wrap items-center gap-4">
                        <a href="/pricing.php#lifetime-beta-plan" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-colors">
                            View plan details on pricing
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="/terms.php" class="text-sm text-slate-600 hover:text-slate-900 transition-colors">Review our Terms of Service</a>
                    </div>
                </section>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
