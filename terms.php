<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Simple Data Cleaner</title>
    <meta name="description" content="Read our terms of service for Simple Data Cleaner - understand your rights and responsibilities when using our data cleaning service.">
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
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Terms of Service</h1>
            <p class="text-gray-600 mb-8">Last updated: <?php echo date('F j, Y'); ?></p>

            <!-- Agreement to Terms -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Agreement to Terms</h2>
                <p class="text-gray-700 mb-3">
                    By accessing or using Simple Data Cleaner ("we", "us", or "our"), you agree to be bound by these Terms of Service ("Terms"). If you disagree with any part of these terms, then you may not access the service.
                </p>
                <p class="text-gray-700">
                    These Terms apply to all visitors, users, and others who wish to access or use our service. This includes free users, subscribers, and API users.
                </p>
            </section>

            <!-- Use of Service -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Use of Service</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>Client-Side Processing:</strong> Simple Data Cleaner performs all data validation and cleaning entirely within your web browser. Your files are never uploaded to our servers.</p>
                    <p><strong>Acceptable Use:</strong> You may use our service to:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Validate and clean UK phone numbers, National Insurance numbers, postcodes, and bank sort codes</li>
                        <li>Process your own data or data for which you have legal authorization</li>
                        <li>Use the API for legitimate business purposes</li>
                    </ul>
                    <p><strong>Prohibited Use:</strong> You may not:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Use the service for any illegal or unauthorized purpose</li>
                        <li>Violate any laws in your jurisdiction (including but not limited to copyright laws)</li>
                        <li>Attempt to gain unauthorized access to any portion of the service</li>
                        <li>Reverse engineer or attempt to extract the source code of our service</li>
                        <li>Use the service to process data that violates the privacy rights of others</li>
                    </ul>
                </div>
            </section>

            <!-- Subscription Terms -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Subscription Terms</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>Subscription Plans:</strong> We offer various subscription plans with different features and pricing. All subscriptions are billed according to the terms outlined on our pricing page.</p>
                    <p><strong>Payment:</strong></p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Subscriptions are billed in advance on a recurring basis (monthly or yearly)</li>
                        <li>All fees are non-refundable except as required by law</li>
                        <li>We reserve the right to change our subscription plans and pricing with 30 days' notice</li>
                        <li>Your subscription will automatically renew unless cancelled before the end of the current billing period</li>
                    </ul>
                    <p><strong>Cancellation:</strong> You may cancel your subscription at any time. Cancellation takes effect at the end of your current billing period. You will continue to have access to the service until that time.</p>
                    <p><strong>Refunds:</strong> Due to the client-side nature of our service, we do not offer refunds. However, if you experience technical issues that prevent you from using the service, please contact us for assistance.</p>
                </div>
            </section>

            <!-- Data Processing and Privacy -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Data Processing and Privacy</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>No Server-Side Processing:</strong> Simple Data Cleaner performs all data cleaning in your web browser. Your data files are never transmitted to our servers. We cannot and do not access, store, or process your data.</p>
                    <p><strong>Account Information:</strong> We only collect and store the minimum information necessary to operate your account, including:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Email address</li>
                        <li>Hashed password</li>
                        <li>Subscription status</li>
                        <li>Usage metrics (for billing and service limits)</li>
                    </ul>
                    <p><strong>GDPR Compliance:</strong> Since we do not process your data, we are not acting as a data processor under GDPR. You retain full responsibility for any data you clean using our service.</p>
                    <p>For more information about our privacy practices, please see our <a href="/security.php" class="text-blue-600 hover:underline">Security & Privacy page</a>.</p>
                </div>
            </section>

            <!-- User Responsibilities -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">5. User Responsibilities</h2>
                <div class="space-y-3 text-gray-700">
                    <p>You are responsible for:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Maintaining the confidentiality of your account credentials</li>
                        <li>Ensuring you have proper authorization to process any data</li>
                        <li>Complying with all applicable laws and regulations in your jurisdiction</li>
                        <li>Ensuring your device and browser are capable of running our service</li>
                        <li>Verifying the accuracy of the cleaned data before using it</li>
                    </ul>
                    <p><strong>Disclaimer:</strong> While we make every effort to provide accurate validation rules for UK data formats, you should independently verify critical data. We are not responsible for any consequences resulting from the use of cleaned data.</p>
                </div>
            </section>

            <!-- Intellectual Property -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Intellectual Property</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>Our Rights:</strong> The service and its original content, features, and functionality are owned by Simple Data Cleaner and protected by international copyright, trademark, and other intellectual property laws.</p>
                    <p><strong>Your Rights:</strong> Your data files remain your property. We do not claim ownership of any data you process through our service.</p>
                    <p><strong>Open Source:</strong> Our validation algorithms are available as open source software. You may review, modify, and use the validation logic according to the applicable open source license.</p>
                </div>
            </section>

            <!-- Limitation of Liability -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Limitation of Liability</h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>Service Availability:</strong> We strive to provide a reliable service, but we do not guarantee that the service will always be available, uninterrupted, or error-free.</p>
                    <p><strong>Browser Limitations:</strong> The service is limited by your browser's capabilities and available memory. Very large files may not process correctly on all devices.</p>
                    <p><strong>No Warranty:</strong> The service is provided "as is" and "as available" without any warranties, either express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, or non-infringement.</p>
                    <p><strong>Limitation of Damages:</strong> In no event shall Simple Data Cleaner be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your use or inability to use the service.</p>
                </div>
            </section>

            <!-- Termination -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Termination</h2>
                <div class="space-y-3 text-gray-700">
                    <p>We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
                    <p>Upon termination, your right to use the service will immediately cease. If you wish to terminate your account, you may simply discontinue using the service.</p>
                </div>
            </section>

            <!-- Changes to Terms -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Changes to Terms</h2>
                <div class="space-y-3 text-gray-700">
                    <p>We reserve the right to modify or replace these Terms at any time. If a revision is material, we will provide at least 30 days' notice prior to any new terms taking effect.</p>
                    <p>What constitutes a material change will be determined at our sole discretion. By continuing to access or use our service after any revisions become effective, you agree to be bound by the revised terms.</p>
                </div>
            </section>

            <!-- Governing Law -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Governing Law</h2>
                <p class="text-gray-700">
                    These Terms shall be interpreted and governed by the laws of the United Kingdom, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights.
                </p>
            </section>

            <!-- Contact -->
            <section class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Contact Information</h2>
                <p class="text-gray-700 mb-3">
                    If you have any questions about these Terms, please <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">contact us</a> or visit our website at <a href="/" class="text-blue-600 hover:underline">simple-data-cleaner.com</a>.
                </p>
            </section>

            <!-- Acceptance -->
            <div class="border-t border-gray-200 pt-8">
                <p class="text-gray-700">
                    By using our service, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                </p>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
