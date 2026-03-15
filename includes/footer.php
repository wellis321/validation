<script src="/scroll-reveal.js?v=<?php echo time(); ?>" defer></script>
<!-- Footer -->
<footer class="bg-neutral-950 border-t border-neutral-800 text-white mt-12 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 max-sm:grid-cols-1 gap-8 mb-8">
            <div>
                <a href="/" class="flex items-center gap-2 mb-4 hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">
                    <img src="/assets/images/transparent-white-logo.png" alt="Simple Data Cleaner Logo" class="h-10 w-auto" loading="lazy">
                    <span class="text-lg font-semibold text-white">Simple Data Cleaner</span>
                </a>
                <p class="text-neutral-400 text-sm mb-4">
                    UK data cleaning, validation, and compliance — built for privacy.
                </p>
                <div class="flex items-center gap-2 text-yellow-400">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-sm font-semibold">100% Private Processing</span>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-300 mb-4">Product</h3>
                <ul class="space-y-2 text-neutral-400">
                    <li><a href="/how-it-works.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">How It Works</a></li>
                    <li><a href="/why-choose-us.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Why Choose Us</a></li>
                    <li><a href="/documentation.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Documentation</a></li>
                    <li><a href="/validation-rules.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Validation Rules</a></li>
                    <li><a href="/blog/ai-data-cleaning-limitations.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Blog</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-300 mb-4">Resources</h3>
                <ul class="space-y-2 text-neutral-400">
                    <li><a href="/pricing.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Pricing</a></li>
                    <li><a href="/feedback.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Feedback</a></li>
                    <li><a href="/bespoke.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Bespoke Services</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-neutral-300 mb-4">Legal</h3>
                <ul class="space-y-2 text-neutral-400">
                    <li><a href="/terms.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Terms of Service</a></li>
                    <li><a href="/privacy.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Privacy Policy</a></li>
                    <li><a href="/gdpr.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">GDPR Compliance</a></li>
                    <li><a href="/security.php" class="hover:text-white transition-colors focus:outline-none focus:text-white focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">Security</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-neutral-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-neutral-400 text-sm">
                    © <?php echo date('Y'); ?> Simple Data Cleaner. All rights reserved.
                </p>
                <div class="flex items-center gap-4 flex-wrap justify-center">
                    <?php if (!$user): ?>
                        <a href="/register.php" class="text-white hover:text-yellow-400 transition-colors text-sm focus:outline-none focus:text-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">
                            Get Started
                        </a>
                    <?php elseif (!empty($user) && (empty($subscription))): ?>
                        <a href="/pricing.php" class="text-white hover:text-yellow-400 transition-colors text-sm focus:outline-none focus:text-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-950 rounded">
                            Choose a Plan
                        </a>
                    <?php endif; ?>
                    <div class="flex items-center gap-2 text-neutral-400 text-sm">
                        <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>GDPR Compliant — your data never leaves your device</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php include __DIR__ . '/analytics.php'; ?>
