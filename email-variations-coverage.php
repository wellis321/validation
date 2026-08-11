<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/parse-variations.php';

$pageTitle = 'Email Format Support';
$emailCorpus = groupVariationsBySection(parseVariationsFile(__DIR__ . '/email-variations.txt'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/email-variations-coverage.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Email Format Support</h1>
            <p class="text-xl text-neutral-400 max-w-3xl mx-auto">
                We clean emails for system-to-system moves: trim, fix common domain typos, and normalise case. See what we support below.
            </p>
        </header>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8 text-gray-900">
            <h2 class="text-2xl font-bold mb-2 flex items-center text-gray-900">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Supported Format Variations
            </h2>
            <p id="corpus-summary" class="text-sm text-gray-500 mb-6">Running live validation in your browser&hellip;</p>
            <script type="application/json" id="corpus-data"><?php echo json_encode($emailCorpus); ?></script>
            <div data-live-coverage data-validator="email">
                <p class="text-gray-500">Running live validation in your browser&hellip;</p>
            </div>

            <!-- Not supported / invalid -->
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-8 mb-8 mt-4">
                <h2 class="text-2xl font-bold mb-6 text-orange-900 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Reported as Invalid
                </h2>
                <ul class="space-y-2 text-orange-800">
                    <li>&bull; <code>user@example</code> - domain has no dot</li>
                    <li>&bull; <code>@example.com</code> - missing local part</li>
                    <li>&bull; <code>user@</code> - missing domain</li>
                    <li>&bull; <code>user@@example.com</code> - double @</li>
                    <li>&bull; <code>user@.com</code> - invalid domain</li>
                    <li>&bull; Empty value</li>
                </ul>
                <p class="text-sm text-orange-700 mt-4">Note: a stray space next to the @ (e.g. <code>user example@domain.com</code>) is currently stripped and merged rather than rejected - flagged for review.</p>
            </div>

            <!-- Get in Touch -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-4 flex items-center text-amber-900">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Have an Email Format We Don't Support?
                </h2>
                <p class="text-amber-800 mb-4">
                    If you have email data in a format we don't handle, or need more domain typo fixes,
                    <a href="/feedback.php" class="text-yellow-500 hover:underline">send us feedback</a>
                    with examples and we'll consider adding support.
                </p>
            </div>

        <div class="mt-8 text-center">
            <a href="/validation-rules.php#emailsTab" class="inline-flex items-center text-yellow-500 hover:text-amber-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Validation Rules (Email tab)
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
