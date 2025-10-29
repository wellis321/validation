<!-- Navigation -->
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="/assets/images/Data Cleaning Icon 300.png" alt="Simple Data Cleaner" class="h-10 w-auto mr-2">
                        <span class="text-xl font-bold text-slate-800">Simple Data Cleaner</span>
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <?php if ($user): ?>
                    <?php
                    // Get subscription if not already available
                    if (!isset($subscription)) {
                        $userModel = new User();
                        $userModel->id = $user['id'];
                        $subscription = $userModel->getCurrentSubscription();
                    }
                    ?>
                    <?php if ($subscription): ?>
                        <span class="text-sm text-slate-700 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Active Subscription
                        </span>
                        <a href="/dashboard.php" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    <?php else: ?>
                        <a href="/pricing.php" class="text-slate-700 hover:text-slate-900 font-medium">Choose a Plan</a>
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
                    <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg font-medium">
                        Sign Up Free
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
