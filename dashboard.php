<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$auth->requireAuth();

$user = $auth->getCurrentUser();
$subscription = (new User())->getCurrentSubscription();
$remainingRequests = (new User())->getRemainingRequests();

// Get usage statistics
$db = Database::getInstance();
$stmt = $db->query(
    "SELECT COUNT(*) as total_requests,
    SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as successful_requests,
    AVG(processing_time) as avg_processing_time
    FROM api_usage
    WHERE user_id = ? AND DATE(request_date) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)",
    [$user['id']]
);
$stats = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simple Data Cleaner</title>
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
                <div class="flex items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">
                                <?php echo htmlspecialchars($user['email']); ?>
                            </span>
                            <a href="/logout.php" class="text-gray-700 hover:text-gray-900">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Subscription Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Subscription Status</h2>
                    <?php if ($subscription): ?>
                        <p class="text-green-600 mt-1">
                            Active - <?php echo htmlspecialchars($subscription['name']); ?> Plan
                        </p>
                    <?php else: ?>
                        <p class="text-yellow-600 mt-1">No active subscription</p>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Remaining Requests Today</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo $remainingRequests; ?></p>
                </div>
            </div>
            <?php if (!$subscription): ?>
                <div class="mt-4">
                    <a href="/pricing.php"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View Plans
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Usage Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900">Total Requests</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">
                    <?php echo number_format($stats['total_requests'] ?? 0); ?>
                </p>
                <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900">Success Rate</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">
                    <?php
                    $successRate = $stats['total_requests'] > 0
                        ? ($stats['successful_requests'] / $stats['total_requests']) * 100
                        : 0;
                    echo number_format($successRate, 1) . '%';
                    ?>
                </p>
                <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900">Avg. Processing Time</h3>
                <p class="text-3xl font-bold text-purple-600 mt-2">
                    <?php echo number_format($stats['avg_processing_time'] ?? 0, 2); ?>s
                </p>
                <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="/"
                    class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <span class="text-blue-900">Clean Data</span>
                </a>

                <a href="/api-docs.php"
                    class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <span class="text-purple-900">API Documentation</span>
                </a>

                <a href="/settings.php"
                    class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-gray-900">Settings</span>
                </a>

                <a href="/support.php"
                    class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-green-900">Support</span>
                </a>
            </div>
        </div>
    </main>
</body>
</html>
