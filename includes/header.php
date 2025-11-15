<?php $currentPath = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
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
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center group">
                        <img src="/assets/images/Data Cleaning Icon 300.png" alt="Simple Data Cleaner" class="h-10 w-auto mr-2 transition-transform group-hover:scale-105">
                        <span class="text-xl font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Simple Data Cleaner</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6 ml-10">
                    <a href="/how-it-works.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'how-it-works.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        How It Works
                    </a>
                    <a href="/pricing.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'pricing.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        Pricing
                    </a>
                    <a href="/beta-offer.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'beta-offer.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        Lifetime Beta
                    </a>
                    <a href="/feedback.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'feedback.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        Feedback
                    </a>
                    <a href="/bespoke.php"
                       class="inline-flex items-center border-b-2 border-transparent pb-1 font-medium transition-all text-gray-700 hover:text-gray-900 hover:border-blue-400 <?php echo $currentPath === 'bespoke.php' ? 'text-blue-600 border-blue-500' : ''; ?>">
                        Bespoke
                    </a>
                </div>
            </div>
                <div class="flex items-center gap-4 flex-wrap justify-end text-sm">
                <div class="md:hidden flex items-center space-x-4 mr-2">
                    <a href="/how-it-works.php" class="text-sm font-medium transition-colors <?php echo $currentPath === 'how-it-works.php' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'; ?>">How It Works</a>
                    <a href="/pricing.php" class="text-sm font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'; ?>">Pricing</a>
                    <a href="/beta-offer.php" class="text-sm font-medium transition-colors <?php echo $currentPath === 'beta-offer.php' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'; ?>">Lifetime Beta</a>
                    <a href="/feedback.php" class="text-sm font-medium transition-colors <?php echo $currentPath === 'feedback.php' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'; ?>">Feedback</a>
                    <a href="/bespoke.php" class="text-sm font-medium transition-colors <?php echo $currentPath === 'bespoke.php' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900'; ?>">Bespoke</a>
                </div>
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
                    <?php if ($subscription): ?>
                        <a href="/dashboard.php" class="font-medium transition-colors <?php echo $currentPath === 'dashboard.php' ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900'; ?>">Dashboard</a>
                    <?php else: ?>
                        <a href="/pricing.php" class="font-medium transition-colors <?php echo $currentPath === 'pricing.php' ? 'text-blue-600' : 'text-slate-700 hover:text-slate-900'; ?>">Choose a Plan</a>
                    <?php endif; ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-gray-700 hover:text-gray-900 transition-colors">
                            <span><?php echo htmlspecialchars($user['email']); ?></span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute right-0 w-56 mt-2 py-2 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
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
                            <a href="/account.php" class="block px-4 py-2 transition-colors <?php echo $currentPath === 'account.php' ? 'bg-gray-100 text-blue-600 font-semibold' : 'text-gray-800 hover:bg-gray-100'; ?>">Account Settings</a>
                            <hr class="my-2">
                            <a href="/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100 transition-colors">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login.php" class="transition-colors <?php echo $currentPath === 'login.php' ? 'text-blue-600 font-medium' : 'text-gray-700 hover:text-gray-900'; ?>">Login</a>
                    <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg font-medium transform hover:-translate-y-0.5 <?php echo $currentPath === 'register.php' ? 'ring-2 ring-blue-300' : ''; ?>">
                        Sign Up Free
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
