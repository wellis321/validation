<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GDPR Compliance - Simple Data Cleaner | Data Protection & Privacy</title>
    <meta name="description" content="Simple Data Cleaner is GDPR compliant. Learn how our browser-based processing means your data never leaves your device and we're not a data processor.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">GDPR Compliance</h1>
            <p class="text-xl text-gray-600 mb-2">Your Data, Your Control, Your Responsibility</p>
            <p class="text-gray-600 mb-8">Last updated: <?php echo date('F j, Y'); ?></p>

            <!-- Key Point -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900 mb-2">We Are NOT a Data Processor</h3>
                        <p class="text-green-800">
                            Because Simple Data Cleaner processes all data entirely in your browser (client-side),
                            we never receive, store, or process your data. This means under GDPR,
                            <strong>we are not acting as a data processor</strong>. You remain the sole
                            data controller with full responsibility and control.
                        </p>
                    </div>
                </div>
            </div>

            <!-- How It Works -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How Client-Side Processing Protects You</h2>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-4">1</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Upload Happens Only in Your Browser</h3>
                            <p class="text-gray-700">When you select a file, it's read using JavaScript in your browser. The file content never leaves your computer's memory.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-4">2</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Processing is Local</h3>
                            <p class="text-gray-700">Validation algorithms run entirely in your browser's JavaScript engine. No network requests are made to send your data anywhere.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-4">3</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Download Stays Local</h3>
                            <p class="text-gray-700">When you download the cleaned file, it's generated in your browser and saved directly to your device. We never see it.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-4">4</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Memory is Cleared</h3>
                            <p class="text-gray-700">When you close the browser tab, all data is removed from memory. Nothing persists on our servers.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Legal Basis -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">GDPR Legal Basis</h2>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-3">For Personal Data We Store (Account Information)</h3>
                    <p class="text-blue-800 mb-3">
                        We only collect and process the following account information:
                    </p>
                    <ul class="list-disc list-inside text-blue-800 space-y-1 mb-4">
                        <li>Email address</li>
                        <li>Hashed password (using bcrypt)</li>
                        <li>Name (if provided)</li>
                        <li>Subscription status and billing information</li>
                        <li>Usage metrics (for service limits)</li>
                    </ul>
                    <p class="text-blue-800">
                        <strong>Legal Basis:</strong> Legitimate interest - we need this information to provide you with the subscription service you requested and to manage your account.
                    </p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-4">
                    <h3 class="font-semibold text-green-900 mb-3">For Data You Clean (Your Files)</h3>
                    <p class="text-green-800 mb-3">
                        We do NOT process, store, or have any access to the data files you clean.
                    </p>
                    <p class="text-green-800">
                        <strong>Legal Basis:</strong> Not applicable - since we never receive this data, GDPR data processing rules don't apply. You remain the sole data controller.
                    </p>
                </div>
            </section>

            <!-- Your Rights -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your GDPR Rights</h2>

                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Right to Access</h3>
                        <p class="text-gray-700">You can request a copy of all personal data we hold about you (account information only). <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">Contact us</a> to make a request.</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Right to Rectification</h3>
                        <p class="text-gray-700">You can update your account information at any time through your <a href="/account.php" class="text-blue-600 hover:underline">Account Settings</a> page.</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Right to Erasure (Right to be Forgotten)</h3>
                        <p class="text-gray-700">You can delete your account at any time. This permanently removes all personal data we hold about you. <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">Contact us</a> to request account deletion.</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Right to Data Portability</h3>
                        <p class="text-gray-700">You can export your account data in a machine-readable format. <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">Contact us</a> to request an export.</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Right to Object</h3>
                        <p class="text-gray-700">You can object to our processing of your personal data for marketing purposes. We don't send marketing emails, but you can update preferences in your account.</p>
                    </div>
                </div>
            </section>

            <!-- Data Retention -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Retention</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>Account Data:</strong> We retain your account information for as long as your account is active. After you cancel your subscription, we retain data for 30 days to ensure smooth account restoration if needed.</p>
                    <p><strong>Deleted Accounts:</strong> When you delete your account, all personal data is permanently removed within 7 days.</p>
                    <p><strong>Billing Records:</strong> Financial transaction records are retained for 7 years as required by UK tax law.</p>
                    <p><strong>Your Files:</strong> Never stored, so no retention period applies.</p>
                </div>
            </section>

            <!-- Security Measures -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Security Measures</h2>
                <div class="space-y-3 text-gray-700">
                    <p>We implement appropriate technical and organizational measures to protect your account data:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>HTTPS encryption for all data transmission</li>
                        <li>Passwords hashed with bcrypt (industry standard)</li>
                        <li>Prepared statements to prevent SQL injection</li>
                        <li>Input validation and sanitization</li>
                        <li>Regular security updates</li>
                        <li>Access controls and authentication</li>
                    </ul>
                    <p>For more details, see our <a href="/security.php" class="text-blue-600 hover:underline">Security & Privacy page</a>.</p>
                </div>
            </section>

            <!-- Data Sharing -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Sharing and Third Parties</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>We do not sell your data.</strong> We do not share your account information with third parties except:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>Payment Processors:</strong> We use Stripe for payment processing. Your payment information is handled directly by Stripe and never stored on our servers.</li>
                        <li><strong>Legal Requirements:</strong> If required by law or to protect our legal rights.</li>
                    </ul>
                </div>
            </section>

            <!-- Verification -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Verify Our Claims</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="font-semibold text-yellow-900 mb-3">You Can Verify Our Privacy Claims</h3>
                    <ol class="list-decimal list-inside text-yellow-800 space-y-2">
                        <li>Open your browser's Developer Tools (F12)</li>
                        <li>Go to the "Network" tab</li>
                        <li>Select and process a file using Simple Data Cleaner</li>
                        <li>You'll see NO file uploads or data transmission to our servers</li>
                        <li>The only network requests will be for JavaScript files (our code)</li>
                    </ol>
                </div>
            </section>

            <!-- Contact -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact & Complaints</h2>
                <div class="space-y-3 text-gray-700">
                    <p>If you have any questions about our GDPR compliance or wish to exercise your rights, please <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">contact us</a>.</p>
                    <p class="mt-4">
                        You also have the right to lodge a complaint with the UK Information Commissioner's Office (ICO) at
                        <a href="https://ico.org.uk" target="_blank" class="text-blue-600 hover:underline">ico.org.uk</a>
                    </p>
                </div>
            </section>

            <!-- Bottom CTA -->
            <div class="border-t border-gray-200 pt-8">
                <div class="text-center">
                    <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Start Using Simple Data Cleaner
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
