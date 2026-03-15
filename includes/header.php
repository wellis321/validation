<?php $currentPath = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
<!-- Skip to main content link for keyboard navigation -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 bg-yellow-400 text-black px-4 py-2 rounded-lg font-medium shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
    Skip to main content
</a>
<!-- Navigation -->
<nav class="bg-neutral-900 border-b border-neutral-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2.5 group focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded px-1 -mx-1 py-0.5">
                        <img src="/assets/images/smooth-white-transparent.png" alt="" width="40" height="40" class="h-8 sm:h-9 w-auto max-h-10 object-contain opacity-95 group-hover:opacity-100 transition-opacity group-hover:scale-105" aria-hidden="true">
                        <span class="text-xl font-extrabold tracking-tight text-white">
                            <span class="group-hover:text-yellow-400 transition-colors">Simple Data</span>
                            <span class="text-yellow-400 group-hover:text-yellow-300 transition-colors"> Cleaner</span>
                        </span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-3 ml-5 xl:space-x-5 xl:ml-8">
                    <!-- Product Dropdown -->
                    <div class="relative group">
                        <button
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="product-menu"
                            class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-neutral-300 hover:text-white hover:border-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 px-1 -mx-1 <?php echo in_array($currentPath, ['why-choose-us.php', 'how-it-works.php', 'documentation.php', 'sample-reports.php', 'issues-report-demo.php', 'cleaned-data-report-demo.php', 'full-preview-report-demo.php']) ? 'text-white border-yellow-500' : ''; ?>">
                            Product
                            <svg aria-hidden="true" class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="product-menu" role="menu" class="absolute left-0 w-48 mt-2 py-2 bg-neutral-800 shadow-xl border border-neutral-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 z-50">
                            <a href="/why-choose-us.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'why-choose-us.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                                Why Choose Us
                            </a>
                            <a href="/sample-reports.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'sample-reports.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                                Sample Reports
                            </a>
                            <a href="/how-it-works.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'how-it-works.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                                How It Works
                            </a>
                            <a href="/documentation.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'documentation.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                                Documentation
                            </a>
                        </div>
                    </div>

                    <!-- Business Dropdown -->
                    <div class="relative group">
                        <button
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="business-menu"
                            class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-neutral-300 hover:text-white hover:border-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 px-1 -mx-1 <?php echo $currentPath === 'bespoke.php' ? 'text-white border-yellow-500' : ''; ?>">
                            Business
                            <svg aria-hidden="true" class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="business-menu" role="menu" class="absolute left-0 w-48 mt-2 py-2 bg-neutral-800 shadow-xl border border-neutral-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 z-50">
                            <a href="/bespoke.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'bespoke.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                                Bespoke Services
                            </a>
                        </div>
                    </div>

                    <!-- Blog (standalone) -->
                    <a href="/blog/ai-data-cleaning-limitations.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-neutral-300 hover:text-white hover:border-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 px-1 -mx-1 <?php echo strpos($currentPath, 'blog') !== false ? 'text-white border-yellow-500' : ''; ?>">
                        Blog
                    </a>

                    <!-- Pricing (standalone - important) -->
                    <a href="/pricing.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-neutral-300 hover:text-white hover:border-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 px-1 -mx-1 <?php echo $currentPath === 'pricing.php' ? 'text-white border-yellow-500' : ''; ?>">
                        Pricing
                    </a>
                </div>
            </div>

            <!-- Right side: User menu / Auth buttons -->
            <div class="flex items-center gap-3 md:gap-4">
                <?php if ($user): ?>
                    <?php
                    // Get subscription if not already available
                    if (!isset($subscription)) {
                        $userModel = new User();
                        $userModel->id = $user['id'];
                        $subscription = $userModel->getCurrentSubscription();
                    }
                    ?>
                    <?php
                    if ($subscription) {
                        $subscriptionFeatures = json_decode($subscription['features'] ?? '{}', true) ?: [];
                        $subscriptionFeatureSetVersion = $subscription['feature_set_version'] ?? null;
                        $subscriptionLicenseScope = $subscription['license_scope'] ?? null;
                        $subscriptionLifetime = !empty($subscriptionFeatures['lifetime_access']);
                    }
                    ?>

                    <!-- User dropdown menu -->
                    <div class="relative group">
                        <button
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="user-menu"
                            aria-label="User account menu"
                            class="flex items-center space-x-1 text-neutral-200 hover:text-white transition-colors text-sm md:text-base focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 px-2 py-1 -mx-2 -my-1">
                            <span class="hidden sm:inline"><?php echo htmlspecialchars($user['email']); ?></span>
                            <span class="sm:hidden">Account</span>
                            <svg aria-hidden="true" class="w-4 h-4 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="user-menu" role="menu" class="absolute right-0 w-56 mt-2 py-2 bg-neutral-800 shadow-xl border border-neutral-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 z-50">
                            <?php if ($subscription): ?>
                                <div class="px-4 pb-3 border-b border-neutral-600 text-xs text-neutral-400">
                                    <p class="font-semibold text-white mb-1 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Active Subscription
                                    </p>
                                    <p class="text-neutral-400 mb-2"><?php echo htmlspecialchars($subscription['name'] ?? ''); ?></p>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <?php if (!empty($subscriptionFeatureSetVersion)): ?>
                                            <span class="inline-flex items-center rounded-full bg-yellow-400/20 text-yellow-400 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                v<?php echo htmlspecialchars($subscriptionFeatureSetVersion); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($subscriptionLifetime)): ?>
                                            <span class="inline-flex items-center rounded-full bg-amber-400/20 text-amber-400 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                Lifetime
                                            </span>
                                        <?php elseif (!empty($subscriptionLicenseScope) && $subscriptionLicenseScope === 'subscription'): ?>
                                            <span class="inline-flex items-center rounded-full bg-neutral-600 text-neutral-300 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                Subscription
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($subscription): ?>
                                <a href="/dashboard.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'dashboard.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">Dashboard</a>
                            <?php else: ?>
                                <a href="/pricing.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'pricing.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">Choose a Plan</a>
                            <?php endif; ?>
                            <a href="/account.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'account.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">Account Settings</a>
                            <a href="/feedback.php" role="menuitem" class="block px-4 py-2 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2 <?php echo $currentPath === 'feedback.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">Feedback</a>
                            <hr class="my-2 border-neutral-600">
                            <a href="/logout.php" role="menuitem" class="block px-4 py-2 text-red-400 hover:bg-neutral-700 transition-colors focus:outline-none focus:bg-neutral-700 focus:ring-2 focus:ring-yellow-500 focus:ring-inset mx-2">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Not logged in - show Feedback link -->
                    <a href="/feedback.php" class="hidden md:inline-block font-medium transition-colors <?php echo $currentPath === 'feedback.php' ? 'text-white font-semibold' : 'text-neutral-300 hover:text-white'; ?>">Feedback</a>
                    <!-- Not logged in -->
                    <a href="/login.php" class="hidden sm:inline-block transition-colors <?php echo $currentPath === 'login.php' ? 'text-white font-semibold font-medium' : 'text-neutral-300 hover:text-white'; ?>">Login</a>
                    <a href="/register.php" class="bg-yellow-400 text-black px-3 py-1.5 md:px-4 md:py-2 hover:bg-yellow-500 transition-all font-semibold text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                        <span class="hidden sm:inline">Start for Free</span>
                        <span class="sm:hidden">Sign Up</span>
                    </a>
                <?php endif; ?>

                <!-- Mobile menu button -->
                <button id="mobileMenuButton" class="md:hidden inline-flex items-center justify-center min-w-[44px] min-h-[44px] p-3 text-neutral-200 hover:text-white hover:bg-neutral-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-yellow-500" aria-expanded="false" aria-label="Toggle menu">
                    <svg class="block h-6 w-6" id="mobileMenuIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" id="mobileMenuCloseIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-neutral-700 bg-neutral-800">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Product Section -->
            <div class="px-3 py-2">
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">Product</p>
                <a href="/why-choose-us.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'why-choose-us.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Why Choose Us
                </a>
                <a href="/sample-reports.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'sample-reports.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Sample Reports
                </a>
                <a href="/how-it-works.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'how-it-works.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    How It Works
                </a>
                <a href="/documentation.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'documentation.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Documentation
                </a>
            </div>

            <!-- Business Section -->
            <div class="px-3 py-2">
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">Business</p>
                <a href="/bespoke.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'bespoke.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Bespoke Services
                </a>
            </div>

            <!-- Blog (standalone) -->
            <a href="/blog/ai-data-cleaning-limitations.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo strpos($currentPath, 'blog') !== false ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                Blog
            </a>

            <!-- Pricing (standalone) -->
            <a href="/pricing.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                Pricing
            </a>

            <!-- Feedback (standalone) -->
            <a href="/feedback.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'feedback.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                Feedback
            </a>
            <?php if ($user): ?>
                <hr class="my-2 border-neutral-700">
                <?php if ($subscription): ?>
                    <a href="/dashboard.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'dashboard.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="/pricing.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                        Choose a Plan
                    </a>
                <?php endif; ?>
                <a href="/account.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'account.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Account Settings
                </a>
                <a href="/logout.php" class="block px-3 py-2 text-base font-medium text-red-400 hover:bg-neutral-700 transition-colors">
                    Logout
                </a>
            <?php else: ?>
                <hr class="my-2 border-neutral-700">
                <a href="/login.php" class="block px-3 py-2 text-base font-medium transition-colors <?php echo $currentPath === 'login.php' ? 'bg-yellow-400/20 text-yellow-400 font-semibold' : 'text-neutral-200 hover:bg-neutral-700'; ?>">
                    Login
                </a>
                <a href="/register.php" class="block px-3 py-2 text-base font-medium bg-yellow-400 text-black hover:bg-yellow-500 transition-colors">
                    Sign Up Free
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script <?php echo script_nonce(); ?>>
// Keyboard: Escape closes dropdowns and returns focus to trigger
document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    var active = document.activeElement;
    if (!active || !active.closest) return;
    var group = active.closest('.group');
    if (!group) return;
    var btn = group.querySelector('button[aria-haspopup="true"]');
    if (btn) {
        btn.focus();
    }
});

// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuIcon = document.getElementById('mobileMenuIcon');
    const mobileMenuCloseIcon = document.getElementById('mobileMenuCloseIcon');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                // Show menu
                mobileMenu.classList.remove('hidden');
                mobileMenuIcon.classList.add('hidden');
                mobileMenuCloseIcon.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
            } else {
                // Hide menu
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.classList.remove('hidden');
                mobileMenuCloseIcon.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu when clicking on a link (mobile)
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.classList.remove('hidden');
                mobileMenuCloseIcon.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            });
        });

        // Close menu when clicking outside (optional)
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenu.contains(event.target) || mobileMenuButton.contains(event.target);
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.classList.remove('hidden');
                mobileMenuCloseIcon.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>
