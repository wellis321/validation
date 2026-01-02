<?php
// Set 404 status code
http_response_code(404);

require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = '404 - Page Not Found';
$pageDescription = 'The page you are looking for could not be found. Return to Simple Data Cleaner homepage to clean and validate your UK data.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="text-center">
            <!-- 404 Icon -->
            <div class="mb-8">
                <svg class="w-32 h-32 mx-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Error Message -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Page Not Found</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Oops! The page you're looking for doesn't exist. It might have been moved or deleted.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="/" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl font-semibold">
                    Go to Homepage
                </a>
                <a href="/how-it-works.php" class="inline-block bg-white text-blue-600 border-2 border-blue-600 px-8 py-3 rounded-lg hover:bg-blue-50 transition-colors font-semibold">
                    Learn How It Works
                </a>
            </div>

            <!-- Helpful Links -->
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
                <h3 class="text-xl font-bold text-gray-900 mb-6">You might be looking for:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <a href="/dashboard.php" class="flex items-start gap-3 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">Dashboard</h4>
                            <p class="text-sm text-gray-600">Clean your data files</p>
                        </div>
                    </a>

                    <a href="/documentation.php" class="flex items-start gap-3 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">Documentation</h4>
                            <p class="text-sm text-gray-600">Complete guides and FAQs</p>
                        </div>
                    </a>

                    <a href="/pricing.php" class="flex items-start gap-3 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">Pricing</h4>
                            <p class="text-sm text-gray-600">View plans and pricing</p>
                        </div>
                    </a>

                    <a href="/account.php" class="flex items-start gap-3 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">Account</h4>
                            <p class="text-sm text-gray-600">Manage your account</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-8">
                <p class="text-gray-600">
                    Need help? <a href="/contact.php" class="text-blue-600 hover:text-blue-700 font-semibold underline">Contact our support team</a>
                </p>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
