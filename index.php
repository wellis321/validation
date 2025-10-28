<?php
require_once __DIR__ . '/includes/init.php';

// Get user's subscription if logged in
$subscription = null;
$remainingRequests = 0;
if ($user) {
    $userModel = new User();
    $userModel->id = $user['id']; // Set the user ID
    $subscription = $userModel->getCurrentSubscription();
    $remainingRequests = $userModel->getRemainingRequests();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Data Cleaner - 100% Private UK Data Validation | GDPR Compliant</title>
    <meta name="description" content="Clean and validate UK phone numbers, NI numbers, postcodes, and bank sort codes in your browser. 100% private - your data never leaves your device. Perfect for businesses handling sensitive PII. GDPR compliant data cleaning.">
    <meta name="keywords" content="UK data validation, phone number cleaning, NI number validation, GDPR compliant data cleaning, browser-based data processing, UK postcode validation">
    <meta property="og:title" content="Simple Data Cleaner - 100% Private UK Data Validation">
    <meta property="og:description" content="Clean UK data in your browser. Your data never leaves your device. Perfect for sensitive PII.">
    <meta property="og:type" content="website">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔧</text></svg>">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (!$user): ?>
            <!-- Hero Section for Non-Authenticated Users -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Clean Your UK Data <span class="text-blue-600">Instantly</span>
                </h1>
                <p class="text-xl text-gray-600 mb-6 max-w-3xl mx-auto">
                    The only UK data validation tool that processes everything in your browser.
                   Personally Identifiable Information (PII) <strong>never leaves your device</strong> - perfect for GDPR compliance.
                </p>

                <!-- Key Benefit Highlights -->
                <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-green-800 mb-2">100% Private Processing</h3>
                        <p class="text-sm text-green-700">All validation happens in your browser. We never see, store, or process your data.</p>
                    </div>
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-blue-800 mb-2">GDPR Compliant</h3>
                        <p class="text-sm text-blue-700">We're not a data processor - you maintain full control and compliance responsibility.</p>
                    </div>
                    <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-6 text-center">
                        <div class="flex justify-center mb-3">
                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-purple-800 mb-2">Perfect for Businesses</h3>
                        <p class="text-sm text-purple-700">Clean NI numbers, bank details, and sensitive customer data without security risks.</p>
                    </div>
                </div>

                <div class="space-x-4">
                    <a href="/register.php" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Get Started - From £0.99
                    </a>
                    <a href="/pricing.php" class="inline-block text-blue-600 hover:text-blue-800 font-semibold">
                        View Pricing
                    </a>
                </div>
            </div>

            <!-- Why Choose Browser-Based Processing -->
            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-16">
                <h2 class="text-3xl font-bold text-center mb-8">Why Businesses Choose Browser-Based Processing</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-7 h-7 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Zero Data Transmission
                        </h3>
                        <p class="text-gray-700 mb-4">
                            Unlike cloud-based solutions, your sensitive Personally Identifiable Information (NI numbers, bank sort codes, phone numbers)
                            stays entirely on your device. No upload risks, no data breaches, no third-party exposure.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No server-side processing costs
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No database scaling concerns
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No compliance documentation needed
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-7 h-7 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Instant Processing
                        </h3>
                        <p class="text-gray-700 mb-4">
                            Process data instantly in your browser. No upload wait times,
                            no network bottlenecks. Your browser's processing power handles everything.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Works with files up to several hundred MB
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No API rate limits
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Export results instantly
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- File Upload Section -->
        <?php if ($user): ?>
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-center mb-2">Upload & Clean Your Data</h2>
                <p class="text-center text-green-600 mb-6">
                    🔒 Your files are processed in your browser - 100% private & secure
                </p>

                <?php if (!$subscription): ?>
                    <!-- Subscription Info Message -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Choose a Plan to Get Started</h3>
                        <p class="text-blue-700 mb-4">
                            Starting from just £0.99 for one-time use, or £4.99/month for unlimited access.
                        </p>
                        <a href="/pricing.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            View Plans
                        </a>
                    </div>
                <?php endif; ?>

                <!-- File Upload Form (always visible to authenticated users) -->
                <form id="uploadForm" class="space-y-6 <?php echo !$subscription ? 'opacity-50 pointer-events-none' : ''; ?>">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                        <input type="file" id="fileInput" class="hidden" accept=".csv,.xlsx,.txt" <?php echo !$subscription ? 'disabled' : ''; ?>>
                        <label for="fileInput" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-lg text-gray-600">Drop your file here or click to browse</p>
                            <p class="text-sm text-gray-500 mt-2">Supports CSV, Excel, and text files</p>
                            <p id="fileSizeLimit" class="text-xs text-gray-400 mt-1"></p>
                        </label>
                    </div>

                    <?php if ($subscription): ?>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-green-800 mb-2">✓ Your Plan Benefits:</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li>✓ Large files supported (processed in your browser)</li>
                                <li>✓ Unlimited files</li>
                                <li>✓ All data types: Phone, NI, Postcodes, Sort Codes</li>
                                <?php
                                $features = json_decode($subscription['features'], true);
                                if ($features['api_access']) echo '<li>✓ API access enabled</li>';
                                if ($features['priority_support']) echo '<li>✓ Priority email support</li>';
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- File Selected State (hidden by default) -->
                    <div id="fileSelected" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-800"><strong>Selected:</strong> <span id="fileName"></span> <span id="fileSize"></span></p>
                    </div>

                    <!-- Field Selection (hidden by default) -->
                    <div id="fieldSelection" class="hidden">
                        <h3 class="text-lg font-bold mb-4">Select columns to clean:</h3>
                        <div id="fieldCheckboxes"></div>
                        <div class="flex gap-2 mt-4">
                            <button type="button" id="selectAllBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" style="cursor: pointer;">Select All</button>
                            <button type="button" id="clearAllBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" style="cursor: pointer;">Clear All</button>
                            <button type="button" id="autoSelectBtn" class="px-4 py-2 bg-blue-200 rounded hover:bg-blue-300" style="cursor: pointer;">Auto-Select</button>
                        </div>
                        <div id="fieldSelectionStatus" class="mt-3"></div>

                        <!-- Phone Number Format Selection -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold mb-3">Phone Number Format:</h4>
                            <div class="flex gap-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="phoneFormat" value="international" checked class="mr-2">
                                    <span>International (+44 7700 900123)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="phoneFormat" value="uk" class="mr-2">
                                    <span>UK (07700 900123)</span>
                                </label>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Choose how you want phone numbers formatted in the output</p>
                        </div>
                    </div>

                    <!-- Process Button (hidden by default) -->
                    <button type="button" id="processBtn" class="hidden w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Clean My Data
                    </button>

                    <!-- Error Display (hidden by default) -->
                    <div id="errorDisplay" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                        <p id="errorMessage" class="text-red-800"></p>
                    </div>

                    <!-- Results Section (hidden by default) -->
                    <div id="resultsSection" class="hidden mt-8">
                        <h3 class="text-2xl font-bold mb-4">Results</h3>
                        <div id="summaryCards" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Rows</p>
                                <p class="text-2xl font-bold" id="totalRows">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Valid</p>
                                <p class="text-2xl font-bold text-green-600" id="totalValid">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Fixed</p>
                                <p class="text-2xl font-bold text-blue-600" id="totalFixed">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Invalid</p>
                                <p class="text-2xl font-bold text-red-600" id="totalInvalid">0</p>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="border-b mb-4">
                            <button type="button" class="tab-btn border-b-2 border-blue-500 text-blue-600 px-4 py-2 font-semibold" data-tab="summary">Summary</button>
                            <button type="button" class="tab-btn border-b-2 border-transparent text-gray-500 px-4 py-2 font-semibold" data-tab="cleaned">Cleaned <span id="cleanedCount">0</span></button>
                            <button type="button" class="tab-btn border-b-2 border-transparent text-gray-500 px-4 py-2 font-semibold" data-tab="issues">Issues <span id="issuesCount">0</span></button>
                        </div>

                        <!-- Tab Content -->
                        <div id="summaryTab" class="tab-content active">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left">Row</th>
                                            <th class="px-4 py-2 text-left">Column</th>
                                            <th class="px-4 py-2 text-left">Original</th>
                                            <th class="px-4 py-2 text-left">Cleaned</th>
                                        </tr>
                                    </thead>
                                    <tbody id="summaryTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="cleanedTab" class="tab-content hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left">Row</th>
                                            <th class="px-4 py-2 text-left">Column</th>
                                            <th class="px-4 py-2 text-left">Original</th>
                                            <th class="px-4 py-2 text-left">Cleaned</th>
                                            <th class="px-4 py-2 text-left">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cleanedTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="issuesTab" class="tab-content hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left">Row</th>
                                            <th class="px-4 py-2 text-left">Column</th>
                                            <th class="px-4 py-2 text-left">Value</th>
                                            <th class="px-4 py-2 text-left">Error</th>
                                            <th class="px-4 py-2 text-left">Standard</th>
                                        </tr>
                                    </thead>
                                    <tbody id="issuesTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Export Options -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="includeCleanedColumn" class="mr-2" checked>
                                <span class="text-sm text-gray-700">Include "Cleaned" columns in download (shows "Yes"/"No" for each cleaned field)</span>
                            </label>
                        </div>

                        <!-- Export Buttons -->
                        <div class="mt-8 space-x-4">
                            <button type="button" id="exportCleanedBtn" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Download Cleaned CSV</button>
                            <button type="button" id="exportExcelBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Download Excel</button>
                            <button type="button" id="exportJsonBtn" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Download JSON</button>
                            <button type="button" id="processNewBtn" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">Upload New File</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- Features Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">What We Clean</h2>
            <p class="text-center text-gray-600 mb-12 max-w-3xl mx-auto">
                HMRC-compliant validation for sensitive UK business data. All processing happens in your browser -
                no data ever transmitted to our servers.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Phone Numbers -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Phone Numbers</h3>
                    <p class="text-gray-600">Format UK mobile and landline numbers with proper spacing</p>
                </div>

                <!-- NI Numbers -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-purple-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">NI Numbers</h3>
                    <p class="text-gray-600">HMRC compliant validation with proper formatting</p>
                </div>

                <!-- Postcodes -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-green-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Postcodes</h3>
                    <p class="text-gray-600">Validate and format UK postcodes correctly</p>
                </div>

                <!-- Sort Codes -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="text-yellow-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sort Codes</h3>
                    <p class="text-gray-600">Format bank sort codes with proper hyphens</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Simple Data Cleaner</h3>
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
                            <li><a href="#" class="hover:text-white transition-colors">Phone Numbers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">NI Numbers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Postcodes</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Sort Codes</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Resources</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="/api-docs.php" class="hover:text-white transition-colors">API Documentation</a></li>
                            <li><a href="/validation-rules.php" class="hover:text-white transition-colors">Validation Rules</a></li>
                            <li><a href="/pricing.php" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="/support.php" class="hover:text-white transition-colors">Support</a></li>
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
                            <a href="/api-docs.php" class="text-white hover:text-blue-400 transition-colors">
                                API Access
                            </a>
                            <div class="flex items-center space-x-2">
                                <span class="text-green-400">🔒</span>
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

    <!-- Scripts -->
    <script src="validators.js?v=<?php echo time(); ?>"></script>
    <script src="fileProcessor.js?v=<?php echo time(); ?>"></script>
    <script src="app.js?v=<?php echo time(); ?>"></script>

    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>