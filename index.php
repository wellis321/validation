<?php
require_once __DIR__ . '/includes/init.php';

// Get user's subscription if logged in and database is available
$subscription = null;
$remainingRequests = 0;
if ($user) {
    try {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            $userModel = new User();
            $userModel->id = $user['id']; // Set the user ID
            $subscription = $userModel->getCurrentSubscription();
            $remainingRequests = $userModel->getRemainingRequests();
        }
    } catch (Exception $e) {
        // Database not available - app can still work for data cleaning
        $subscription = null;
        $remainingRequests = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/">
    <title>Simple Data Cleaner - 100% Private UK Data Validation | GDPR Compliant</title>
    <meta name="description" content="Clean and validate UK phone numbers, NI numbers, postcodes, and bank sort codes in your browser. 100% private - your data never leaves your device. Perfect for businesses handling sensitive PII. GDPR compliant data cleaning.">
    <meta name="keywords" content="UK data validation, phone number cleaning, NI number validation, GDPR compliant data cleaning, browser-based data processing, UK postcode validation">
    <meta property="og:title" content="Simple Data Cleaner - 100% Private UK Data Validation">
    <meta property="og:description" content="Clean UK data in your browser. Your data never leaves your device. Perfect for sensitive PII.">
    <meta property="og:type" content="website">
    <meta name="google-site-verification" content="xNV1Ea4p8zh3UTiU_dspG9ii8-ppLxE4_VnbiVYU2G4" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (!$user): ?>
            <!-- Hero Section for Non-Authenticated Users -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-amber-100 text-amber-900 text-sm font-semibold tracking-wide uppercase mb-5">
                    Open Beta - lifetime access available now
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Clean Your UK Data <span class="text-slate-700">Instantly</span>
                </h1>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 mb-6 max-w-4xl mx-auto">
                    <p class="text-xl text-gray-600 text-center md:text-left flex-1">
                        The only UK data validation tool that processes everything in your browser.
                        Personally Identifiable Information (PII) <strong>never leaves your device</strong> - perfect for GDPR compliance.
                        Join our beta to lock in lifetime access to phone numbers, bank sort codes, NI numbers, and postcode cleaning for just £99.99.
                    </p>
                    <div class="flex-shrink-0">
                        <img src="/assets/images/transparent-logo.png" alt="Simple Data Cleaner Logo" class="h-24 w-auto">
                    </div>
                </div>
                <div class="max-w-3xl mx-auto bg-amber-50 border border-amber-200 text-amber-900 rounded-xl p-4 mb-8">
                    <p class="text-sm md:text-base">
                        Lifetime beta licence covers today's feature set forever. As we add new data types, you'll be first in line to preview them, and we'll use your feedback to shape the roadmap.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/beta-offer.php" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        Join Lifetime Beta (£99.99)
                    </a>
                    <a href="/feedback.php" class="inline-block bg-white text-slate-700 border border-slate-300 px-8 py-3 rounded-lg hover:border-slate-500 font-semibold transition-colors">
                        Share Your Feedback
                    </a>
                    <a href="/pricing.php" class="inline-block text-slate-700 hover:text-slate-900 font-semibold border-b-2 border-transparent hover:border-slate-700 transition-colors">
                        View Full Pricing
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
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No server-side processing costs
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No database scaling concerns
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No compliance documentation needed
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-7 h-7 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Works with files up to several hundred MB
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                No API rate limits
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-slate-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Export results instantly
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto bg-slate-900 text-white rounded-2xl shadow-xl p-8 md:p-12 mb-16" id="beta-program">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-bold mb-4">Help Shape Simple Data Cleaner</h2>
                        <p class="text-slate-200 text-base md:text-lg mb-6">
                            We're in active beta and focused on the core UK data validators you already use daily. Purchase the lifetime licence once, keep access to phone numbers, NI numbers, postcodes, and sort codes forever, and tell us what to improve next.
                        </p>
                        <ul class="space-y-4 text-sm md:text-base text-slate-200">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Lifetime access to today's feature set (phone numbers, NI numbers, postcodes, sort codes)
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Direct feedback channel with the product team - influence our roadmap
                            </li>
                        </ul>
                    </div>
                    <div class="lg:w-2/5 bg-white/10 border border-white/10 rounded-xl p-6">
                        <h3 class="text-xl font-semibold mb-4">How the beta works</h3>
                        <ol class="space-y-4 text-slate-100 text-sm md:text-base">
                            <li>
                                <span class="block font-semibold text-sky-300">1. Purchase the lifetime beta licence</span>
                                <span class="block mt-1">One-time £99.99 payment - no renewals. Access stays active for all current validators forever.</span>
                            </li>
                            <li>
                                <span class="block font-semibold text-sky-300">2. Clean your data securely</span>
                                <span class="block mt-1">Run files locally in your browser and see improvements as we ship them.</span>
                            </li>
                            <li>
                                <span class="block font-semibold text-sky-300">3. Share feedback any time</span>
                                <span class="block mt-1">Use our feedback form to report wins, pain points, or custom validator requests.</span>
                            </li>
                        </ol>
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-4">
                            <a href="/beta-offer.php" class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all">
                                Lock in lifetime access
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                            <a href="/feedback.php" class="inline-flex items-center justify-center gap-2 text-slate-200 hover:text-white font-semibold">
                                Give feedback now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M12 4h9M3 4h.01M3 20h.01M3 12h18" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- File Upload Section -->
        <?php if ($user): ?>
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-center mb-2">Upload & Clean Your Data</h2>
                <p class="text-center text-slate-700 mb-6 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Your files are processed in your browser - 100% private & secure
                </p>

                <?php if (!$subscription): ?>
                    <!-- Subscription Info Message -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Choose a Plan to Get Started</h3>
                        <p class="text-gray-700 mb-4">
                            Choose Lifetime Beta (£99.99 one-time) or subscribe monthly (£29.99) or annually (£249.99) for ongoing access.
                        </p>
                        <a href="/pricing.php" class="inline-block bg-slate-700 text-white px-6 py-2 rounded-lg hover:bg-slate-800 transition-colors">
                            View Plans
                        </a>
                    </div>
                <?php endif; ?>

                <!-- File Upload Form (always visible to authenticated users) -->
                <form id="uploadForm" class="space-y-6 <?php echo !$subscription ? 'opacity-50 pointer-events-none' : ''; ?>">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                        <input type="file" id="fileInput" class="hidden" accept=".csv,.xlsx,.xls,.txt,.json" <?php echo !$subscription ? 'disabled' : ''; ?>>
                        <label for="fileInput" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-lg text-gray-600">Drop your file here or click to browse</p>
                            <p class="text-sm text-gray-500 mt-2">Supports CSV, Excel, JSON, and text files</p>
                            <p id="fileSizeLimit" class="text-xs text-gray-400 mt-1"></p>
                        </label>
                    </div>

                    <?php if ($subscription): ?>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Your Plan Benefits:
                            </h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Large files supported (processed in your browser)
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Unlimited files
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    All data types: Phone, NI, Postcodes, Sort Codes
                                </li>
                                <?php
                                $features = json_decode($subscription['features'], true);
                                ?>
                                <?php if ($features['priority_support']): ?>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Priority email support
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- File Selected State (hidden by default) -->
                    <div id="fileSelected" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-gray-800"><strong>Selected:</strong> <span id="fileName"></span> <span id="fileSize"></span></p>
                    </div>

                    <!-- Field Selection (hidden by default) -->
                    <div id="fieldSelection" class="hidden">
                        <h3 class="text-lg font-bold mb-4">Select columns to clean:</h3>
                        <div id="fieldCheckboxes"></div>
                        <div class="flex gap-2 mt-4">
                            <button type="button" id="selectAllBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" style="cursor: pointer;">Select All</button>
                            <button type="button" id="clearAllBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" style="cursor: pointer;">Clear All</button>
                            <button type="button" id="autoSelectBtn" class="px-4 py-2 bg-slate-200 rounded hover:bg-slate-300 transition-colors" style="cursor: pointer;">Auto-Select</button>
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
                    <button type="button" id="processBtn" class="hidden w-full bg-slate-700 text-white py-3 rounded-lg hover:bg-slate-800 font-semibold transition-colors">
                        Clean My Data
                    </button>

                    <!-- Error Display (hidden by default) -->
                    <div id="errorDisplay" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                        <p id="errorMessage" class="text-red-800"></p>
                    </div>

                    <!-- Results Section (hidden by default) -->
                    <div id="resultsSection" class="hidden mt-8">
                        <h3 class="text-2xl font-bold mb-4">Results</h3>
                        <!-- Data Profiling Section -->
                        <div id="dataProfilingSection" class="mb-8 hidden">
                            <h4 class="text-xl font-bold mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                1. Data Profiling
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-700 font-medium">Missing Values</p>
                                    <p class="text-2xl font-bold text-blue-900" id="totalMissing">0</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                    <p class="text-sm text-purple-700 font-medium">Duplicate Rows</p>
                                    <p class="text-2xl font-bold text-purple-900" id="totalDuplicates">0</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                    <p class="text-sm text-green-700 font-medium">Unique Rows</p>
                                    <p class="text-2xl font-bold text-green-900" id="uniqueRows">0</p>
                                </div>
                            </div>

                            <!-- Missing Values by Column -->
                            <div id="missingValuesTable" class="hidden mb-6">
                                <h5 class="text-lg font-semibold mb-3 text-gray-800">Missing Values by Column</h5>
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Column</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Missing Count</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody id="missingValuesTableBody" class="divide-y divide-gray-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div id="summaryCards" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Rows</p>
                                <p class="text-2xl font-bold" id="totalRows">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Valid</p>
                                <p class="text-2xl font-bold text-slate-700" id="totalValid">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Fixed</p>
                                <p class="text-2xl font-bold text-slate-700" id="totalFixed">0</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Invalid</p>
                                <p class="text-2xl font-bold text-red-600" id="totalInvalid">0</p>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="border-b mb-4">
                            <button type="button" class="tab-btn border-b-2 border-slate-700 text-slate-700 px-4 py-2 font-semibold" data-tab="summary">Summary</button>
                            <button type="button" class="tab-btn border-b-2 border-transparent text-gray-500 px-4 py-2 font-semibold" data-tab="preview">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Full Preview
                                </span>
                            </button>
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

                        <div id="previewTab" class="tab-content hidden">
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>This is exactly what your downloaded file will contain.</strong> All columns are preserved in their original order, with cleaned values applied only to the fields you selected.
                                            <span class="inline-flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Columns marked with 🔒 were protected and left unchanged.
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Color Legend -->
                            <div class="mb-4 bg-white rounded-lg border border-gray-200 p-4">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Row Color Guide:</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-6 bg-blue-50 border-l-4 border-blue-400 rounded"></div>
                                        <div>
                                            <span class="font-medium text-blue-800">Blue</span> - Original row that has duplicates elsewhere
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-6 bg-amber-50 border-l-4 border-amber-400 rounded"></div>
                                        <div>
                                            <span class="font-medium text-amber-800">Yellow</span> - Duplicate row (will be removed if option checked)
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-6 bg-green-50 border border-gray-200 rounded flex items-center justify-center text-green-600">✓</div>
                                        <div>
                                            <span class="font-medium text-green-800">Green cells</span> - Values that were cleaned/fixed
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full border-collapse" id="previewTable">
                                    <thead>
                                        <tr class="bg-gray-100" id="previewTableHeader">
                                            <!-- Headers will be inserted here -->
                                        </tr>
                                    </thead>
                                    <tbody id="previewTableBody">
                                        <!-- Full dataset preview will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-sm text-gray-600 text-center">
                                Showing <span id="previewRowCount">0</span> rows × <span id="previewColCount">0</span> columns
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

                        <!-- Important Warning -->
                        <div class="mt-6 bg-red-50 border-2 border-red-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-red-900 font-semibold mb-1">Important: Download and Save Your File</p>
                                    <p class="text-red-800 text-sm">
                                        Your cleaned data is only available in your browser session. Once you close this tab or refresh the page, your cleaned data will be gone. We don't store files on our servers - <strong>make sure to download and save your file immediately!</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Export Options -->
                        <div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-lg p-6 space-y-5">
                            <div>
                                <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Download Options - Customize Your Export
                                </h4>
                                <p class="text-sm text-gray-700 mb-4">Choose your preferred format and export options before downloading your cleaned file:</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Select Your Download Format:</label>
                                <select id="downloadFormat" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white font-medium text-gray-900">
                                    <option value="csv">CSV (Comma Separated Values)</option>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="json">JSON</option>
                                </select>
                                <p class="text-xs text-blue-700 mt-2 flex items-center gap-1 font-medium">
                                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <span>You can download in any format, regardless of what you uploaded!</span>
                                </p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3">Data Cleaning Options:</h5>
                                <div class="space-y-4">
                                    <label class="flex items-start cursor-pointer group hover:bg-gray-50 p-2 rounded -m-2 transition-colors">
                                        <input type="checkbox" id="removeDuplicates" class="mt-1 mr-3 h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900 block">Remove Duplicate Rows (Keep First Occurrence)</span>
                                            <span class="text-xs text-gray-600 block mt-1">
                                                <span id="duplicateCountMessage">Checking for duplicates...</span>
                                                <span class="block mt-1 text-blue-700">💡 In the Full Preview tab: <strong>Blue</strong> = original rows with duplicates, <strong>Yellow</strong> = duplicate rows to be removed.</span>
                                            </span>
                                        </div>
                                    </label>
                                    <label class="flex items-start cursor-pointer group hover:bg-gray-50 p-2 rounded -m-2 transition-colors">
                                        <input type="checkbox" id="trimWhitespace" class="mt-1 mr-3 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" checked>
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900 block">Clean Whitespace in All Cells</span>
                                            <span class="text-xs text-gray-600 block mt-1">Remove leading/trailing spaces and extra spaces between words. Already applied to cleaned fields, this ensures all other columns are clean too.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <h5 class="text-sm font-semibold text-gray-900 mb-3">Export Customization:</h5>
                                <div class="space-y-4">
                                    <label class="flex items-start cursor-pointer group hover:bg-gray-50 p-2 rounded -m-2 transition-colors">
                                        <input type="checkbox" id="includeIssuesColumn" class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900 block">Include "Issues" Column</span>
                                            <span class="text-xs text-gray-600 block mt-1">Add a column listing any fields that still need attention. This helps you identify which rows may require manual review.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start cursor-pointer group hover:bg-gray-50 p-2 rounded -m-2 transition-colors">
                                        <input type="checkbox" id="onlyRowsWithIssues" class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900 block">Export Only Rows With Issues (Optional)</span>
                                            <span class="text-xs text-gray-600 block mt-1">When checked, you'll download <strong>only</strong> the rows that have validation issues (instead of the full file). Perfect for creating a focused review file to fix manually before merging back into your main dataset.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Download Confirmation Summary -->
                        <div id="downloadSummary" class="hidden mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl p-6 shadow-md">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ready to Download
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-white rounded-lg p-4 border border-blue-200">
                                    <div class="text-2xl font-bold text-blue-600" id="summaryTotalRows">0</div>
                                    <div class="text-sm text-gray-600">Total rows</div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-green-200">
                                    <div class="text-2xl font-bold text-green-600" id="summaryCleanedFields">0</div>
                                    <div class="text-sm text-gray-600">Fields cleaned</div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-amber-200">
                                    <div class="text-2xl font-bold text-amber-600" id="summaryIssueRows">0</div>
                                    <div class="text-sm text-gray-600">Rows with issues</div>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-blue-200 space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-gray-900">Row order:</span>
                                    <span class="text-gray-700">Preserved as uploaded</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-gray-900">Column structure:</span>
                                    <span class="text-gray-700">All <span id="summaryTotalCols">0</span> columns preserved</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-gray-900">Protected columns:</span>
                                    <span class="text-gray-700" id="summaryProtectedCols">None detected</span>
                                </div>
                                <div class="flex items-center gap-2" id="summaryDuplicatesRow">
                                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-gray-900">Duplicate rows:</span>
                                    <span class="text-gray-700" id="summaryDuplicates">Checking...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Export Buttons -->
                        <div class="mt-8 flex flex-wrap gap-4">
                            <button type="button" id="exportBtn" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl font-semibold">
                                Download Cleaned File
                            </button>
                            <button type="button" id="processNewBtn" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                                Upload New File
                            </button>
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
                <a href="/validation-rules.php#phone_numbersTab" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow group border border-gray-100">
                    <div class="text-blue-600 mb-4 group-hover:text-blue-700 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 group-hover:text-blue-600 transition-colors">Phone Numbers</h3>
                    <p class="text-gray-600">Format UK mobile and landline numbers with proper spacing</p>
                </a>

                <!-- NI Numbers -->
                <a href="/validation-rules.php#national_insuranceTab" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow group border border-gray-100">
                    <div class="text-indigo-600 mb-4 group-hover:text-indigo-700 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 group-hover:text-indigo-600 transition-colors">NI Numbers</h3>
                    <p class="text-gray-600">HMRC compliant validation with proper formatting</p>
                </a>

                <!-- Postcodes -->
                <a href="/validation-rules.php#postcodesTab" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow group border border-gray-100">
                    <div class="text-teal-600 mb-4 group-hover:text-teal-700 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 group-hover:text-teal-600 transition-colors">Postcodes</h3>
                    <p class="text-gray-600">Validate and format UK postcodes correctly</p>
                </a>

                <!-- Sort Codes -->
                <a href="/validation-rules.php#sort_codesTab" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow group border border-gray-100">
                    <div class="text-amber-600 mb-4 group-hover:text-amber-700 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 group-hover:text-amber-600 transition-colors">Sort Codes</h3>
                    <p class="text-gray-600">Format bank sort codes with proper hyphens</p>
                </a>
            </div>
        </div>

        <!-- Bespoke & Enterprise Services -->
        <section id="bespoke-services" class="mt-20">
            <div class="max-w-6xl mx-auto bg-slate-900 text-white rounded-2xl shadow-2xl p-10 md:p-14 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at top right, #38bdf8 0%, transparent 55%), radial-gradient(circle at bottom left, #6366f1 0%, transparent 60%);"></div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wide uppercase bg-slate-800/70 border border-slate-700">Bespoke Data Cleaning</span>
                        <h2 class="mt-4 text-3xl md:text-4xl font-bold leading-tight">Need specialist rules for internal data?</h2>
                        <p class="mt-4 text-slate-200 text-base md:text-lg leading-relaxed">
                            We partner with compliance, ops, and data teams to build in-browser validation for bespoke fields - everything from <span class="font-semibold">region_description</span> to <span class="font-semibold">staff_employee_number</span> and beyond. Share your edge cases and we'll deliver tailor-made rules that run entirely in your users' browsers, keeping sensitive records on-premise and fully GDPR aligned.
                        </p>
                        <ul class="mt-6 space-y-3 text-slate-200 text-sm md:text-base">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Custom validators for proprietary fields and internal reference codes</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Browser-based deployment ensures zero data leaves your environment</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Direct collaboration with your domain experts to codify complex rules</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-8 backdrop-blur">
                        <h3 class="text-xl font-semibold">How the bespoke process works</h3>
                        <ol class="mt-4 space-y-4 text-slate-100 text-sm md:text-base">
                            <li>
                                <span class="block font-semibold text-sky-300">1. Discovery workshop</span>
                                <span class="block mt-1">Share the fields, sample data, and desired outcomes. We map the validation flow together.</span>
                            </li>
                            <li>
                                <span class="block font-semibold text-sky-300">2. Prototype & testing</span>
                                <span class="block mt-1">We build tailored rules inside our client-side engine and iterate with your team.</span>
                            </li>
                            <li>
                                <span class="block font-semibold text-sky-300">3. Deployment & handover</span>
                                <span class="block mt-1">Validated rules are shipped into your Simple Data Cleaner workspace with full documentation.</span>
                            </li>
                        </ol>
                        <div class="mt-6 inline-flex flex-col sm:flex-row sm:items-center gap-4">
                            <a href="/bespoke.php" class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10a9 9 0 11-18 0 9 9 0 0118 0zm-9 3l-3-3m0 0l3-3m-3 3h8" /></svg>
                                Book a discovery call
                            </a>
                            <a href="/how-it-works.php" class="inline-flex items-center justify-center gap-2 text-slate-200 hover:text-white font-semibold">
                                Learn more about our approach
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="validators.js?v=<?php echo time(); ?>"></script>
    <script src="fileProcessor.js?v=<?php echo time(); ?>"></script>
    <script src="app.js?v=<?php echo time(); ?>"></script>

    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>