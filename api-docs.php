<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Access - Simple Data Cleaner</title>
    <meta name="description" content="Simple Data Cleaner does not offer a server-side API. All processing happens in your browser for maximum privacy.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">Simple Data Cleaner</a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if ($user): ?>
                        <?php if ($subscription): ?>
                            <span class="text-sm text-green-600 font-medium">
                                ✓ Active Subscription
                            </span>
                            <a href="/dashboard.php" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        <?php else: ?>
                            <a href="/pricing.php" class="text-blue-600 hover:text-blue-800 font-medium">Choose a Plan</a>
                        <?php endif; ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-gray-700 hover:text-gray-900">
                                <span><?php echo htmlspecialchars($user['email']); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="/account.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Account Settings</a>
                                <hr class="my-2">
                                <a href="/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login.php" class="text-gray-700 hover:text-gray-900">Login</a>
                        <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">API Access</h1>
            <p class="text-xl text-gray-600 mb-8">Our commitment to privacy means no server-side API</p>

            <!-- No API Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">No Server-Side API</h3>
                        <p class="text-blue-800">
                            Simple Data Cleaner does not offer a server-side API. Instead, all data processing
                            happens entirely in your browser to guarantee that your data never leaves your device.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Why No API -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Why We Don't Offer a Server-Side API</h2>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Privacy First</h3>
                            <p class="text-gray-700">A server-side API would require your data to be sent to our servers. We refuse to process your data on our servers, even temporarily.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">GDPR Compliance</h3>
                            <p class="text-gray-700">By keeping all processing in your browser, you remain the sole data controller. We're not a data processor under GDPR.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Security</h3>
                            <p class="text-gray-700">No server means no server vulnerabilities. Your sensitive PII never leaves your secure environment.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Alternatives -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Automate Data Cleaning</h2>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Browser-Based Automation</h3>
                    <p class="text-gray-700 mb-4">
                        While we don't offer a server-side API, you can automate the web interface using browser automation tools:
                    </p>

                    <div class="space-y-3">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Puppeteer / Playwright</h4>
                            <p class="text-sm text-gray-600">
                                Automate Chrome or Firefox to upload and download files through the web interface.
                                Your data still processes locally in the browser.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Selenium</h4>
                            <p class="text-sm text-gray-600">
                                Similar automation capabilities for browser-based data processing.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Open Source Validators</h4>
                            <p class="text-sm text-gray-600">
                                Our validation algorithms are open source. You can integrate them into your own
                                codebase for offline, client-side processing that never touches external servers.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Need Help with Automation?</h2>
                <p class="text-gray-700">
                    If you have questions about automating data cleaning while maintaining privacy, please <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">contact us</a>.
                </p>
            </section>

            <!-- CTA -->
            <div class="border-t border-gray-200 pt-8">
                <div class="text-center">
                    <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Start Cleaning Your Data Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
