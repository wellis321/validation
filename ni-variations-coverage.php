<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/parse-variations.php';

$pageTitle = 'National Insurance Number Format Support';
$niCorpus = groupVariationsBySection(parseVariationsFile(__DIR__ . '/ni-variations.txt'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/ni-variations-coverage.php">
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
            <h1 class="text-4xl font-bold text-white mb-4">National Insurance Number Format Support</h1>
            <p class="text-xl text-neutral-400 max-w-3xl mx-auto">
                We clean National Insurance numbers from many different input formats. See what we support below.
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
            <script type="application/json" id="corpus-data"><?php echo json_encode($niCorpus); ?></script>
            <div data-live-coverage data-validator="ni_number">
                <p class="text-gray-500">Running live validation in your browser&hellip;</p>
            </div>

            <!-- Output Format -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Output Format
                </h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="mb-2">All National Insurance numbers are formatted consistently as:</p>
                    <code class="text-2xl font-mono bg-white px-4 py-2 rounded block text-center">AB 123456 C</code>
                    <p class="text-sm text-gray-600 mt-3">Two letters, six digits, one letter, with appropriate spacing.</p>
                </div>
            </div>
        </div>

        <!-- Validation Rules -->
        <div class="bg-amber-50 rounded-lg p-8 mb-8">
            <h3 class="text-2xl font-semibold text-amber-900 mb-4">✓ Validation Rules</h3>
            <ul class="space-y-2 text-amber-800">
                <li>• Must contain exactly 2 letters, 6 digits, and 1 letter</li>
                <li>• Banned prefixes (BG, GB, KN, NK, NT, TN, ZZ) are rejected</li>
                <li>• Administrative prefixes (OO, FY, NC, PZ) are rejected</li>
                <li>• Invalid characters (D, F, I, O, Q, U, V) in specific positions are rejected</li>
                <li>• TRN (Temporary Reference Number) format is detected and rejected</li>
                <li>• PP999999P is specifically rejected</li>
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
                If you have National Insurance number data in a format we don't currently handle, please
                <a href="mailto:noreply@simple-data-cleaner.com" class="text-yellow-500 hover:underline">contact us</a>
                with examples and we'll add support!
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
