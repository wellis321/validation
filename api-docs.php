<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'API Access';
$pageDescription = 'Simple Data Cleaner does not offer a server-side API. All processing happens in your browser for maximum privacy.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/api-docs.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/api-docs.php">
    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Hero -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">API Access</h1>
                <p class="text-xl text-neutral-400 max-w-2xl mx-auto">
                    Our commitment to privacy means no server-side API
                </p>
            </div>

            <!-- No API Banner -->
            <div class="ds-card p-6 mb-10 border-yellow-500/30 bg-yellow-500/5">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">No Server-Side API</h2>
                        <p class="text-neutral-300">
                            Simple Data Cleaner does not offer a server-side API. Instead, all data processing
                            happens entirely in your browser to guarantee that your data never leaves your device.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Why No API -->
            <section class="ds-card p-8 mb-10">
                <h2 class="text-2xl font-bold text-white mb-6">Why We Don't Offer a Server-Side API</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Privacy First</h3>
                            <p class="text-neutral-400">A server-side API would require your data to be sent to our servers. We refuse to process your data on our servers, even temporarily.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">GDPR Compliance</h3>
                            <p class="text-neutral-400">By keeping all processing in your browser, you remain the sole data controller. We're not a data processor under GDPR.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Security</h3>
                            <p class="text-neutral-400">No server means no server vulnerabilities. Your sensitive PII never leaves your secure environment.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Alternatives -->
            <section class="ds-card p-8 mb-10">
                <h2 class="text-2xl font-bold text-white mb-6">How to Automate Data Cleaning</h2>
                <div class="bg-neutral-900/60 border border-neutral-700 rounded-xl p-6">
                    <h3 class="font-semibold text-white mb-3">Browser-Based Automation</h3>
                    <p class="text-neutral-400 mb-4">
                        While we don't offer a server-side API, you can automate the web interface using browser automation tools:
                    </p>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-white mb-2">Puppeteer / Playwright</h4>
                            <p class="text-sm text-neutral-400">
                                Automate Chrome or Firefox to upload and download files through the web interface.
                                Your data still processes locally in the browser.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-2">Selenium</h4>
                            <p class="text-sm text-neutral-400">
                                Similar automation capabilities for browser-based data processing.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-2">Open Source Validators</h4>
                            <p class="text-sm text-neutral-400">
                                Our validation algorithms are open source. You can integrate them into your own
                                codebase for offline, client-side processing that never touches external servers.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            <section class="ds-card p-8 mb-10">
                <h2 class="text-2xl font-bold text-white mb-4">Need Help with Automation?</h2>
                <p class="text-neutral-400">
                    If you have questions about automating data cleaning while maintaining privacy, please <a href="mailto:noreply@simple-data-cleaner.com" class="text-yellow-400 hover:text-yellow-300 underline focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">contact us</a>.
                </p>
            </section>

            <!-- CTA -->
            <div class="text-center">
                <a href="/" class="ds-btn-primary">
                    Start Cleaning Your Data Now
                </a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
