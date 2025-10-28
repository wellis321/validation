<!-- Footer -->
<footer class="bg-gray-900 text-white mt-12 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">Simple Data Cleaner</h3>
                <p class="text-gray-400 mb-4">
                    100% Private Processing<br>
                    Your Data Never Leaves Your Device
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-3">Product</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="/pricing.php" class="hover:text-white transition-colors">Pricing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-3">Company</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="/security.php" class="hover:text-white transition-colors">Security & Privacy</a></li>
                    <li><a href="/terms.php" class="hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="/gdpr.php" class="hover:text-white transition-colors">GDPR Compliance</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-3">Account</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <?php if ($user): ?>
                        <li><a href="/dashboard.php" class="hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="/account.php" class="hover:text-white transition-colors">Account Settings</a></li>
                    <?php else: ?>
                        <li><a href="/login.php" class="hover:text-white transition-colors">Login</a></li>
                        <li><a href="/register.php" class="hover:text-white transition-colors">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0 text-sm">
                    © <?php echo date('Y'); ?> Simple Data Cleaner. All rights reserved.
                </p>
                <div class="flex items-center space-x-6 flex-wrap justify-center gap-4">
                    <?php if (!$user): ?>
                        <a href="/register.php" class="text-white hover:text-blue-400 transition-colors text-sm">
                            Get Started
                        </a>
                    <?php elseif (!$subscription): ?>
                        <a href="/pricing.php" class="text-white hover:text-blue-400 transition-colors text-sm">
                            Choose a Plan
                        </a>
                    <?php endif; ?>
                    <div class="flex items-center space-x-2">
                        <span>🔒</span>
                        <p class="text-gray-300 text-xs">
                            <strong>GDPR Compliant:</strong> Browser-based processing - Your data never leaves your device
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
