<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/parse-variations.php';

$pageTitle = 'Phone Number Format Support';
$phoneCorpus = groupVariationsBySection(parseVariationsFile(__DIR__ . '/phone-variations.txt'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/phone-variations-coverage.php">
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
            <h1 class="text-4xl font-bold text-white mb-4">Phone Number Format Support</h1>
            <p class="text-xl text-neutral-400 max-w-3xl mx-auto">
                We clean phone numbers from 100+ different input formats. See what we support below.
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
            <script type="application/json" id="corpus-data"><?php echo json_encode($phoneCorpus); ?></script>
            <div data-live-coverage data-validator="phone_number">
                <p class="text-gray-500">Running live validation in your browser&hellip;</p>
            </div>

            <!-- Special Cases -->
            <div class="mb-8 mt-4 border-t pt-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center text-gray-900">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Special Cases Handled
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-amber-50 p-3 rounded">
                        <strong>Excel Scientific Notation:</strong><br>
                        <code class="text-sm">4.47701E+11</code> &rarr; <code class="text-sm js-live-value" data-type="phone_number" data-input="4.47701E+11">&hellip;</code>
                    </div>
                    <div class="bg-amber-50 p-3 rounded">
                        <strong>Missing Leading Zero:</strong><br>
                        <code class="text-sm">7123456789</code> &rarr; <code class="text-sm js-live-value" data-type="phone_number" data-input="7123456789">&hellip;</code>
                    </div>
                </div>
            </div>

            <!-- Output Formats -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Output Formats
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">International Format (+44)</h4>
                        <code class="text-lg">+44 7700 900123</code>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">UK Format (0)</h4>
                        <code class="text-lg">07700 900123</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Not Supported Yet -->
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-orange-900 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Currently Not Supported
            </h2>
            <ul class="space-y-2 text-orange-800">
                <li>• Extra digits (typos)</li>
                <li>• Non-ASCII characters</li>
                <li>• HTML encoded entities</li>
                <li>• Protocol links (tel:, callto:)</li>
            </ul>
        </div>

        <!-- Get in Touch -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-4 flex items-center text-amber-900">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Have a Format We Don't Support?
            </h2>
            <p class="text-amber-800 mb-4">
                If you have phone number data in a format we don't currently handle, please
                <a href="mailto:noreply@simple-data-cleaner.com" class="text-yellow-400 underline underline-offset-2 hover:no-underline">contact us</a>
                with examples and we'll add support!
            </p>
            <p class="text-sm text-amber-800">
                We're constantly improving our format detection and cleaning capabilities based on real-world data.
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="validation-rules.php" class="inline-flex items-center text-yellow-500 hover:text-amber-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Validation Rules
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
    <script src="/validators.js?v=<?php echo time(); ?>" defer></script>
    <script src="/coverage-live.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
