<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/security.php">
    <title>Security & Privacy - Simple Data Cleaner | 100% Private Processing</title>
    <meta name="description" content="Your data is processed entirely in your browser - it never leaves your device. No servers, no databases, no third parties. Learn about our commitment to security and privacy.">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>
    <main id="main-content">

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-neutral-800/60 border border-neutral-600 shadow-lg p-8">
            <h1 class="text-4xl font-bold text-white mb-2">Security & Privacy</h1>
            <p class="text-xl text-neutral-400 mb-8">Your data never leaves your device. Here's how we protect your privacy.</p>

            <!-- Key Features -->
            <div class="grid md:grid-cols-2 gap-6 mb-12">
                <div class="bg-amber-500/10 border border-amber-500/30 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-amber-200">100% Client-Side Processing</h2>
                    </div>
                    <p class="text-neutral-300">All data cleaning happens in your browser using JavaScript. Your sensitive data never leaves your computer.</p>
                </div>

                <div class="bg-green-500/10 border border-green-500/30 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-green-200">No Server-Side Processing</h3>
                    </div>
                    <p class="text-neutral-300">No file uploads. No server-side storage. No databases. Zero attack surface for your data.</p>
                </div>

                <div class="bg-yellow-500/10 border border-yellow-500/30 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-yellow-200">GDPR Compliant</h3>
                    </div>
                    <p class="text-neutral-300">Since we don't process or store your data, we're not a data processor under GDPR. You maintain full control.</p>
                </div>

                <div class="bg-yellow-500/10 border border-yellow-500/30 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-yellow-200">Open Source & Auditable</h3>
                    </div>
                    <p class="text-neutral-300">Our validation algorithms are open source. Review our code on GitHub to verify our privacy claims.</p>
                </div>
            </div>

            <!-- Technical Details -->
            <div class="border-t border-neutral-600 pt-8">
                <h2 class="text-2xl font-bold text-white mb-4">How It Works</h2>

                <div class="space-y-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-500/20 rounded-full flex items-center justify-center text-amber-300 font-semibold mr-4">1</div>
                        <div>
                            <h3 class="font-semibold text-white mb-1">You Upload a File</h3>
                            <p class="text-neutral-300">Files are read directly in your browser using the FileReader API. No data is transmitted over the network.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-500/20 rounded-full flex items-center justify-center text-amber-300 font-semibold mr-4">2</div>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Validation Runs Locally</h3>
                            <p class="text-neutral-300">Our JavaScript validators check phone numbers, NI numbers, postcodes, sort codes, and email addresses entirely in your browser's memory.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-500/20 rounded-full flex items-center justify-center text-amber-300 font-semibold mr-4">3</div>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Results Stay Private</h3>
                            <p class="text-neutral-300">Download your cleaned file directly from your browser. No server ever sees your data.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What We Do Store -->
            <div class="border-t border-neutral-600 pt-8 mb-8">
                <h2 class="text-2xl font-bold text-white mb-4">What We DO Store (For Account Management Only)</h2>

                <div class="bg-neutral-900/40 border border-neutral-600 rounded-lg p-6">
                    <p class="text-neutral-300 mb-4">To provide you with a subscription service, we store:</p>
                    <ul class="space-y-2 text-neutral-300 list-disc list-inside">
                        <li><strong>Account Information:</strong> Email address, password (hashed with bcrypt), name</li>
                        <li><strong>Subscription Details:</strong> Plan type, subscription status, expiration date</li>
                        <li><strong>Usage Metrics:</strong> Number of files processed (for billing/limiting purposes)</li>
                    </ul>
                    <p class="text-neutral-300 mt-4"><strong>What we DON'T store:</strong> Your files, your data, any content from your uploads, or any information about the files you clean.</p>
                </div>
            </div>

            <!-- Security Practices -->
            <div class="border-t border-neutral-600 pt-8 mb-8">
                <h2 class="text-2xl font-bold text-white mb-4">Security Best Practices</h2>

                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-neutral-300">HTTPS encryption for all page loads and API requests</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-neutral-300">Passwords hashed with bcrypt (industry standard)</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-neutral-300">Prepared statements for all database queries (prevents SQL injection)</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-neutral-300">Input validation and sanitization on all user inputs</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-neutral-300">Regular security updates and dependency monitoring</span>
                    </div>
                </div>
            </div>

            <!-- FAQs -->
            <div class="border-t border-neutral-600 pt-8 mb-8">
                <h2 class="text-2xl font-bold text-white mb-4">Frequently Asked Questions</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-white mb-2">Q: Can you see my data?</h3>
                        <p class="text-neutral-300">A: No. We never receive your files. All processing happens in your browser. Even we can't see what you're cleaning.</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-white mb-2">Q: Are my files stored on your server?</h3>
                        <p class="text-neutral-300">A: No. Files are never uploaded to our servers. They stay in your browser's memory for processing, then you download the result.</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-white mb-2">Q: Is this GDPR compliant?</h3>
                        <p class="text-neutral-300">A: Yes. Since we don't process or store your data, we're not acting as a data processor under GDPR. Your organization maintains full control and responsibility for the data.</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-white mb-2">Q: Can I verify this works as claimed?</h3>
                        <p class="text-neutral-300">A: Yes. You can monitor your browser's Network tab - you'll see no data being uploaded when you process files. Our code is also open source on GitHub.</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-white mb-2">Q: What about browser cache?</h3>
                        <p class="text-neutral-300">A: Your browser may cache JavaScript files (the validation code), but your actual data files are never cached. Close your browser tab and your data is gone.</p>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="border-t border-neutral-600 pt-8">
                <h2 class="text-2xl font-bold text-white mb-4">Have Security Concerns?</h2>
                <p class="text-neutral-300 mb-4">We take security seriously. If you discover a vulnerability or have concerns about our security practices, please <a href="mailto:noreply@simple-data-cleaner.com" class="text-yellow-400 underline underline-offset-2 hover:no-underline">contact us</a>.</p>
            </div>

            <!-- CTA -->
            <div class="mt-8 text-center">
                <a href="/" class="inline-block bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-400 font-semibold">
                    Start Cleaning Your Data
                </a>
            </div>
        </div>
    </div>

    </main>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
