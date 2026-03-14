<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'Email Format Support';
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
<body class="min-h-screen bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Email Format Support</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We clean emails for system-to-system moves: trim, fix common domain typos, and normalise case. See what we support below.
            </p>
        </header>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Supported Format Variations
            </h2>

            <!-- Trimming -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Trimming
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">  user@example.com</code> → <code class="text-sm">user@example.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@example.com  </code> → <code class="text-sm">user@example.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">  user@example.com  </code> → <code class="text-sm">user@example.com</code></div>
                </div>
            </div>

            <!-- Case normalisation -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Case Normalisation
                </h3>
                <p class="text-gray-600 mb-4">Emails are lowercased by default for consistent system-to-system output.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">User@Example.COM</code> → <code class="text-sm">user@example.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">FIRST.LAST@COMPANY.CO.UK</code> → <code class="text-sm">first.last@company.co.uk</code></div>
                </div>
            </div>

            <!-- Domain typo fixes -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Common Domain Typo Fixes
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@gmial.com</code> → <code class="text-sm">user@gmail.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@gmai.com</code> → <code class="text-sm">user@gmail.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@gmail.con</code> → <code class="text-sm">user@gmail.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@yaho.com</code> → <code class="text-sm">user@yahoo.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@hotmial.com</code> → <code class="text-sm">user@hotmail.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@outlok.com</code> → <code class="text-sm">user@outlook.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@icloud.con</code> → <code class="text-sm">user@icloud.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@live.con</code> → <code class="text-sm">user@live.com</code></div>
                </div>
            </div>

            <!-- Valid formats -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Valid Formats Accepted
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user@example.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">first.last@company.co.uk</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">user+tag@gmail.com</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">name_123@domain.org</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">a@b.co</code></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Local part: letters, digits, . _ % + - . Domain: at least one dot, valid TLD.</p>
            </div>

            <!-- Not supported / invalid -->
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-8 mb-8">
                <h2 class="text-2xl font-bold mb-6 text-orange-900 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Reported as Invalid
                </h2>
                <ul class="space-y-2 text-orange-800">
                    <li>• <code>user@example</code> — domain has no dot</li>
                    <li>• <code>@example.com</code> — missing local part</li>
                    <li>• <code>user@</code> — missing domain</li>
                    <li>• <code>user example@domain.com</code> — space in local part</li>
                    <li>• <code>user@.com</code> — invalid domain</li>
                    <li>• Empty value</li>
                </ul>
            </div>

            <!-- Get in Touch -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-4 flex items-center">
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
