<?php $currentPath = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
<!-- Skip to main content link for keyboard navigation -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    Skip to main content
</a>
<div class="bg-amber-50 border-b border-amber-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-col md:flex-row md:items-center md:justify-between gap-2 text-amber-900 text-sm">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-200 text-amber-900 font-semibold uppercase tracking-wide text-xs">Beta</span>
            <span>We're in open beta - lock in lifetime access to today's feature set for just £99.99.</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="/beta-offer.php" class="inline-flex items-center text-amber-900 font-semibold hover:text-amber-700 transition-colors">
                Join the lifetime beta offer
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
            <span class="hidden md:inline text-amber-300">|</span>
            <a href="/feedback.php" class="inline-flex items-center text-amber-900 hover:text-amber-700 transition-colors">
                Share feedback
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4h9" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h.01" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20h.01" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18" /></svg>
            </a>
        </div>
    </div>
</div>
<!-- Navigation -->
<nav class="bg-white shadow relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center group">
                        <img src="/assets/images/Data Cleaning Icon 300.png" alt="Simple Data Cleaner" class="h-10 w-auto mr-2 transition-transform group-hover:scale-105">
                        <span class="text-xl font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Simple Data Cleaner</span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4 ml-6 xl:space-x-6 xl:ml-10">
                    <!-- Product Dropdown -->
                    <div class="relative group">
                        <button
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="product-menu"
                            class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo in_array($currentPath, ['how-it-works.php', 'documentation.php']) ? 'text-blue-600 border-blue-500' : ''; ?>">
                            Product
                            <svg aria-hidden="true" class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="product-menu" role="menu" class="absolute left-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="/how-it-works.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'how-it-works.php' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">
                                How It Works
                            </a>
                            <a href="/documentation.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'documentation.php' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">
                                Documentation
                            </a>
                        </div>
                    </div>
                    
                    <!-- Pricing (standalone - important) -->
                    <a href="/pricing.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'pricing.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        Pricing
                    </a>
                    
                    <!-- Business Dropdown -->
                    <div class="relative group">
                        <button
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="business-menu"
                            class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo in_array($currentPath, ['beta-offer.php', 'bespoke.php']) ? 'text-blue-600 border-blue-500' : ''; ?>">
                            Business
                            <svg aria-hidden="true" class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="business-menu" role="menu" class="absolute left-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="/beta-offer.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'beta-offer.php' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">
                                Lifetime Beta
                            </a>
                            <a href="/bespoke.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'bespoke.php' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">
                                Bespoke Services
                            </a>
                        </div>
                    </div>
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
                            class="flex items-center space-x-1 text-gray-700 hover:text-gray-900 transition-colors text-sm md:text-base">
                            <span class="hidden sm:inline"><?php echo htmlspecialchars($user['email']); ?></span>
                            <span class="sm:hidden">Account</span>
                            <svg aria-hidden="true" class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="user-menu" role="menu" class="absolute right-0 w-56 mt-2 py-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <?php if ($subscription): ?>
                                <div class="px-4 pb-3 border-b border-gray-100 text-xs text-gray-600">
                                    <p class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Active Subscription
                                    </p>
                                    <p class="text-gray-500 mb-2"><?php echo htmlspecialchars($subscription['name'] ?? ''); ?></p>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <?php if (!empty($subscriptionFeatureSetVersion)): ?>
                                            <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                v<?php echo htmlspecialchars($subscriptionFeatureSetVersion); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($subscriptionLifetime)): ?>
                                            <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                Lifetime
                                            </span>
                                        <?php elseif (!empty($subscriptionLicenseScope) && $subscriptionLicenseScope === 'subscription'): ?>
                                            <span class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-2 py-0.5 font-semibold uppercase tracking-wide text-[10px]">
                                                Subscription
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($subscription): ?>
                                <a href="/dashboard.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'dashboard.php' ? 'bg-gray-100 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">Dashboard</a>
                            <?php else: ?>
                                <a href="/pricing.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'pricing.php' ? 'bg-gray-100 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">Choose a Plan</a>
                            <?php endif; ?>
                            <a href="/account.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'account.php' ? 'bg-gray-100 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">Account Settings</a>
                            <a href="/feedback.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'feedback.php' ? 'bg-gray-100 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">Feedback</a>
                            <hr class="my-2">
                            <a href="/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100 transition-colors">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Not logged in - show Feedback link -->
                    <a href="/feedback.php" class="hidden md:inline-block font-medium transition-colors <?php echo $currentPath === 'feedback.php' ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900'; ?>">Feedback</a>
                    <!-- Not logged in -->
                    <a href="/login.php" class="hidden sm:inline-block transition-colors <?php echo $currentPath === 'login.php' ? 'text-blue-600 font-medium' : 'text-gray-700 hover:text-gray-900'; ?>">Login</a>
                    <a href="/register.php" class="bg-blue-600 text-white px-3 py-2 md:px-4 md:py-2 rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg font-medium text-sm md:text-base">
                        <span class="hidden sm:inline">Sign Up Free</span>
                        <span class="sm:hidden">Sign Up</span>
                    </a>
                <?php endif; ?>
                
                <!-- Mobile menu button -->
                <button id="mobileMenuButton" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false" aria-label="Toggle menu">
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
    <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 bg-white">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Product Section -->
            <div class="px-3 py-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Product</p>
                <a href="/how-it-works.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'how-it-works.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    How It Works
                </a>
                <a href="/documentation.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'documentation.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    Documentation
                </a>
            </div>
            
            <!-- Pricing (standalone) -->
            <a href="/pricing.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                Pricing
            </a>
            
            <!-- Business Section -->
            <div class="px-3 py-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Business</p>
                <a href="/beta-offer.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'beta-offer.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    Lifetime Beta
                </a>
                <a href="/bespoke.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'bespoke.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    Bespoke Services
                </a>
            </div>
            
            <!-- Feedback (standalone) -->
            <a href="/feedback.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'feedback.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                Feedback
            </a>
            <?php if ($user): ?>
                <hr class="my-2 border-gray-200">
                <?php if ($subscription): ?>
                    <a href="/dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'dashboard.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="/pricing.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                        Choose a Plan
                    </a>
                <?php endif; ?>
                <a href="/account.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'account.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    Account Settings
                </a>
                <a href="/logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-50 transition-colors">
                    Logout
                </a>
            <?php else: ?>
                <hr class="my-2 border-gray-200">
                <a href="/login.php" class="block px-3 py-2 rounded-md text-base font-medium transition-colors <?php echo $currentPath === 'login.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    Login
                </a>
                <a href="/register.php" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                    Sign Up Free
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
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
