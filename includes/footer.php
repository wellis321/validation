<!-- Footer -->
<footer class="bg-gray-900 text-white mt-12 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="/" class="flex items-center gap-3 mb-4 hover:opacity-80 transition-opacity">
                        <img src="/assets/images/transparent-white-logo.png" alt="Simple Data Cleaner Logo" class="h-12 w-auto">
                        <h3 class="text-lg font-semibold text-white">Simple Data Cleaner</h3>
                    </a>
                    <p class="text-gray-400 mb-4">
                        Professional browser-based data validation for UK businesses.
                        Your data never leaves your device - guaranteed privacy and GDPR compliance.
                    </p>
                    <div class="flex items-center space-x-2 text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-sm font-semibold">100% Private Processing</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Features</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/validation-rules.php#phone_numbersTab" class="hover:text-white transition-colors">Phone Numbers</a></li>
                        <li><a href="/validation-rules.php#national_insuranceTab" class="hover:text-white transition-colors">NI Numbers</a></li>
                        <li><a href="/validation-rules.php#postcodesTab" class="hover:text-white transition-colors">Postcodes</a></li>
                        <li><a href="/validation-rules.php#sort_codesTab" class="hover:text-white transition-colors">Sort Codes</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/how-it-works.php" class="hover:text-white transition-colors">How It Works</a></li>
                        <li><a href="/documentation.php" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="/validation-rules.php" class="hover:text-white transition-colors">Validation Rules</a></li>
                        <li><a href="/pricing.php" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="/feedback.php" class="hover:text-white transition-colors">Beta Feedback</a></li>
                        <li><a href="/bespoke.php" class="hover:text-white transition-colors">Bespoke Services</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/terms.php" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="/privacy.php" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="/gdpr.php" class="hover:text-white transition-colors">GDPR Compliance</a></li>
                        <li><a href="/security.php" class="hover:text-white transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 mb-4 md:mb-0">
                        © <?php echo date('Y'); ?> Simple Data Cleaner. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-6 flex-wrap justify-center gap-4">
                        <?php if (!$user): ?>
                            <a href="/register.php" class="text-white hover:text-blue-400 transition-colors">
                                Get Started
                            </a>
                        <?php elseif (!$subscription): ?>
                            <a href="/pricing.php" class="text-white hover:text-blue-400 transition-colors">
                                Choose a Plan
                            </a>
                        <?php endif; ?>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-gray-300 text-sm">
                                <strong>GDPR Compliant:</strong> Browser-based processing - Your data never leaves your device
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
