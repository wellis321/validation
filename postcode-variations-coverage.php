<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'UK Postcode Format Support';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-blue-600">Simple Data Cleaner</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if ($user): ?>
                        <?php
                        $userModel = new User();
                        $userModel->id = $user['id'];
                        $subscription = $userModel->getCurrentSubscription();
                        ?>
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
                        <a href="/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Sign Up Free
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">UK Postcode Format Support</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We clean UK postcodes from many different input formats. See what we support below.
            </p>
        </header>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Supported Format Variations
            </h2>

            <!-- Spacing Variations -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Spacing Variations
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW 1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A  1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">M1 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">M11AA</code></div>
                </div>
            </div>

            <!-- Separator Types -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Separator Types Handled
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A-1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A.1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A/1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A_1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A:1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A;1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A,1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A|1AA</code></div>
                </div>
            </div>

            <!-- Labels & Prefixes -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Labels & Prefixes Removed
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Postcode: SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">PC: SW1A1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Address: SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A 1AA (postcode)</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">UK SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">London SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A 1AA, UK</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1A 1AA, London</code></div>
                </div>
            </div>

            <!-- Wrapping Characters -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Wrapping Characters
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">"SW1A 1AA"</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'SW1A1AA'</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">*SW1A 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">#SW1A1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm"> SW1A 1AA </code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'SW1A 1AA</code></div>
                </div>
            </div>

            <!-- Lowercase Variations -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Lowercase & Case Variations
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">sw1a 1aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">sw1a1aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Sw1a 1aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SW1a 1AA</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">sw1A 1aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Sw1A 1Aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">sW1a 1Aa</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">m1 1aa</code></div>
                </div>
                <p class="text-sm text-gray-600 mt-3">All postcodes are normalized to uppercase during validation.</p>
            </div>

            <!-- Different Postcode Formats -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    All UK Postcode Formats
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">M1 1AA</code><br><small class="text-gray-600">A# #AA</small></div>
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">M60 1AA</code><br><small class="text-gray-600">A## #AA</small></div>
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">CR2 6XH</code><br><small class="text-gray-600">AA# #AA</small></div>
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">DN55 1PT</code><br><small class="text-gray-600">AA## #AA</small></div>
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">W1A 1AA</code><br><small class="text-gray-600">A#A #AA</small></div>
                    <div class="bg-blue-50 p-3 rounded"><code class="text-sm">EC1A 1BB</code><br><small class="text-gray-600">AA#A #AA</small></div>
                </div>
            </div>

            <!-- Special Cases -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Special Cases Handled
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>No Space Variation:</strong><br>
                        <code class="text-sm">SW1A1AA</code> → <code class="text-sm">SW1A 1AA</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>Missing Space:</strong><br>
                        <code class="text-sm">M11AA</code> → <code class="text-sm">M1 1AA</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>With Address:</strong><br>
                        <code class="text-sm">10 Downing Street, SW1A 1AA</code> → <code class="text-sm">SW1A 1AA</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>With City:</strong><br>
                        <code class="text-sm">London SW1A 1AA</code> → <code class="text-sm">SW1A 1AA</code>
                    </div>
                </div>
            </div>

            <!-- Output Format -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Output Format
                </h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="mb-2">All postcodes are formatted consistently with proper spacing:</p>
                    <div class="space-y-2">
                        <code class="text-xl font-mono bg-white px-4 py-2 rounded block text-center">SW1A 1AA</code>
                        <code class="text-xl font-mono bg-white px-4 py-2 rounded block text-center">M1 1AA</code>
                        <code class="text-xl font-mono bg-white px-4 py-2 rounded block text-center">EC1A 1BB</code>
                    </div>
                    <p class="text-sm text-gray-600 mt-3">Outward code (area), space, inward code (3 characters).</p>
                </div>
            </div>
        </div>

        <!-- Get in Touch -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Have a Format We Don't Support?
            </h2>
            <p class="text-blue-800 mb-4">
                If you have postcode data in a format we don't currently handle, please
                <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">contact us</a>
                with examples and we'll add support!
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="validation-rules.php" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Validation Rules
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
