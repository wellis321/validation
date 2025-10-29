<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'Validation Rules & Standards';
$pageDescription = 'Comprehensive guide to all validation rules for UK data formats including phone numbers, NI numbers, postcodes, and bank sort codes';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔧</text></svg>">
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Validation Rules & Standards</h1>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                Explore all the validation rules we currently support and see examples of how we process different data
                formats. Learn about automatic fixes and understand what makes data valid or invalid.
            </p>

            <!-- Navigation back to main validator -->
            <div class="mt-6">
                <a href="index.php"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Data Cleaner
                </a>
            </div>
        </header>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 overflow-x-auto">
                    <button
                        class="tab-btn active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600"
                        data-tab="phone_numbers">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Phone Numbers
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="national_insurance">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        NI Numbers
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="postcodes">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Postcodes
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="sort_codes">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Sort Codes
                    </button>
                </nav>
            </div>
        </div>

        <!-- Phone Numbers Tab -->
        <div id="phone_numbersTab" class="tab-content active">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Phone Numbers</h2>
                        <p class="text-lg text-gray-600">UK mobile and landline phone number validation with automatic
                            formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How It Works</h3>
                    <p class="text-blue-800">We take your phone number input and automatically check it against UK phone
                        number standards. Our system detects the type of number, validates the format, and applies
                        automatic fixes to ensure consistency. We can handle most common formatting issues
                        automatically, but some cases require manual correction.</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Number length and structure</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Country code format (+44)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">UK domestic format (0)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Mobile vs landline patterns</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Area code validity</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Spacing and formatting consistency</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Labels, icons, and descriptive text</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Extension-style clutter</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Quotes and wrapping characters</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Weird separators and whitespace</span>
                        </div>
                    </div>
                </div>

                <!-- Automatic Fixes -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Automatic Fixes We Apply</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Format Standardization</h4>
                            <p class="text-gray-600 mb-4">Convert between international (+44) and UK (0) formats</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">07700 900123 → +44 7700 900123</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">+44 7700 900123 → 07700 900123</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Country Code Correction</h4>
                            <p class="text-gray-600 mb-4">Fix missing or incorrect country codes</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">7700 900123 → +44 7700 900123</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code
                                        class="text-sm font-mono text-gray-800">0044 7700 900123 → +44 7700 900123</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Spacing and Punctuation</h4>
                            <p class="text-gray-600 mb-4">Standardize spacing and remove unnecessary characters</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code
                                        class="text-sm font-mono text-gray-800">+44 (0) 7700 900123 → +44 7700 900123</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">07700-900-123 → 07700 900123</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Label and Icon Removal</h4>
                            <p class="text-gray-600 mb-4">Remove common prefixes, suffixes, and emojis</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code
                                        class="text-sm font-mono text-gray-800">Mobile: 07700 900123 → +44 7700 900123</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code
                                        class="text-sm font-mono text-gray-800">Mobile: +44 7700 900123 → +44 7700 900123</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supported Formats -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Supported Formats</h3>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Mobile Numbers</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">7xxxxxxxxx</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">10-digit numbers starting with 7 (mobile phones)</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">07700 900123</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">7700 900123</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">+44 7700 900123</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Landline Numbers</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">0xxxxxxxxx</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">11-digit numbers starting with 0 (landlines)</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">020 7946 0958</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">02079460958</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">+44 20 7946 0958</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Output Format Options -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">Output Format Options</h3>
                    <p class="text-blue-700 mb-4">Choose how you want your phone numbers formatted in the results:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div class="bg-white rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">International (+44)</h4>
                            <p class="text-blue-700 text-sm mb-2">Always includes +44 country code</p>
                            <code
                                class="inline-block bg-blue-100 px-2 py-1 rounded text-sm font-mono text-blue-800">+44 7700 900123</code>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">UK (0)</h4>
                            <p class="text-blue-700 text-sm mb-2">UK domestic format starting with 0</p>
                            <code
                                class="inline-block bg-blue-100 px-2 py-1 rounded text-sm font-mono text-blue-800">07700 900123</code>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 mt-4 border border-blue-200">
                        <p class="text-blue-800">
                            <strong>Supported formats:</strong> We clean 100+ phone number variations including Excel scientific notation,
                            labels, names, extensions, and multiple formats.
                        </p>
                        <a href="phone-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            See Full List of Supported Formats
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- National Insurance Tab -->
        <div id="national_insuranceTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">National Insurance Numbers</h2>
                        <p class="text-lg text-gray-600">UK National Insurance number validation and formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How It Works</h3>
                    <p class="text-blue-800">We validate UK National Insurance numbers by checking their format
                        structure and applying automatic corrections for common issues.</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Format structure (2 letters + 6-8 digits + optional
                                letter)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Letter and digit combinations</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Spacing and formatting</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Case sensitivity</span>
                        </div>
                    </div>
                </div>

                <!-- Supported Formats -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Supported Formats</h3>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Standard Format</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">AB123456C</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">2 letters + 6 digits + 1 letter</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">AB123456C</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">AB 123456 C</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">ab123456c</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HMRC Compliance -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">HMRC Compliance Standards</h3>
                    <p class="text-blue-700 mb-4">Your NI numbers are validated against official HMRC standards. Common
                        rejection reasons:</p>
                    <ul class="text-blue-700 space-y-1 ml-4">
                        <li>• <strong>Banned prefixes:</strong> BG, GB, KN, NK, NT, TN, ZZ</li>
                        <li>• <strong>Invalid letters:</strong> D, F, I, Q, U, V in first position; O in second position
                        </li>
                        <li>• <strong>TRN format:</strong> 11 a1 11 11 (not a valid NI number)</li>
                        <li>• <strong>Administrative prefixes:</strong> OO, FY, NC, PZ (special use only)</li>
                    </ul>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-blue-800">
                        <strong>Supported formats:</strong> We clean NI numbers from many variations including different
                        separators (spaces, hyphens, dots, slashes, commas, pipes, and more), labels and prefixes, wrapping characters, and case variations.
                    </p>
                    <a href="ni-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        See Full List of Supported Formats
                    </a>
                </div>
            </div>
        </div>

        <!-- Postcodes Tab -->
        <div id="postcodesTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">UK Postcodes</h2>
                        <p class="text-lg text-gray-600">UK postcode validation with automatic formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How It Works</h3>
                    <p class="text-blue-800">We validate UK postcodes by checking their structure and applying automatic
                        formatting corrections.</p>
                </div>

                <!-- Supported Formats -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Supported Formats</h3>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Standard Postcode</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">A9 9AA</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">1 letter + 1 digit + space + 1 digit + 2 letters</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">M1 1AA</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">B33 8TH</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">London Postcode</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">A9A 9AA</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">1 letter + 1 digit + 1 letter + space + 1 digit + 2
                                letters</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">SW1A 1AA</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">W1A 1AA</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-blue-800">
                        <strong>Supported formats:</strong> We clean postcodes from many variations including different
                        separators (dashes, dots, slashes, and more), labels and prefixes (Postcode:, PC:, UK:, city names), wrapping characters, and even with addresses attached.
                    </p>
                    <a href="postcode-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        See Full List of Supported Formats
                    </a>
                </div>
            </div>
        </div>

        <!-- Sort Codes Tab -->
        <div id="sort_codesTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Bank Sort Codes</h2>
                        <p class="text-lg text-gray-600">UK bank sort code validation and formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How It Works</h3>
                    <p class="text-blue-800">We validate UK bank sort codes by checking their digit structure and
                        applying automatic formatting.</p>
                </div>

                <!-- Supported Formats -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Supported Formats</h3>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Standard Format</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">xx-xx-xx</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">6 digits with dashes between pairs</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">12-34-56</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">23-45-67</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Compact Format</h4>
                                <code
                                    class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">xxxxxx</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">6 digits without separators</p>
                            <div class="space-x-2">
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">123456</code>
                                <code
                                    class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">234567</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-blue-800">
                        <strong>Supported formats:</strong> We clean sort codes from many variations including different
                        separators, labels and prefixes (Sort Code:, SC:, Bank:, UK banks), wrapping characters, and even with account numbers attached.
                    </p>
                    <a href="sort-code-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        See Full List of Supported Formats
                    </a>
                </div>
            </div>
        </div>

        <!-- Browser Capabilities -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Browser Compatibility & File Size Limits</h2>

            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-blue-900 mb-4">How File Size Limits Are Calculated</h3>
                <p class="text-blue-800 mb-4">
                    Since all processing happens in your browser, file size limits depend on your device's memory and browser capabilities. Our system automatically detects your setup and recommends an appropriate file size limit.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chrome -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 mr-3 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C8.21 0 4.211 3.32 4.211 7.49c0 3.54 2.156 6.55 5.05 7.11L9 24h6L14.74 14.6c2.89-.56 5.05-3.57 5.05-7.11C19.789 3.32 15.79 0 12 0zm0 13.8c-2.76 0-5-2.23-5-5s2.24-5 5-5 5 2.23 5 5c0 2.77-2.24 5-5 5z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-green-900">Chrome</h3>
                    </div>
                    <p class="text-green-800 mb-3">Provides the most accurate file size detection.</p>
                    <ul class="text-green-700 space-y-2 ml-5 list-disc">
                        <li><strong>Accurate detection:</strong> Uses your actual RAM amount</li>
                        <li><strong>Typical limits:</strong></li>
                        <ul class="ml-6 space-y-1">
                            <li>2GB RAM: ~50-60 MB</li>
                            <li>4GB RAM: ~100-120 MB</li>
                            <li>8GB RAM: ~200-240 MB</li>
                            <li>16GB+ RAM: ~400-500 MB</li>
                        </ul>
                    </ul>
                </div>

                <!-- Edge -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 border border-blue-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.829 17.763c-.3-.19-1.638-.705-2.908-1.257-1.275-.55-1.494-.64-2.137-.64-.64 0-1.013.093-1.508.546-.315.292-.64.705-.84.913-.2.21-.47.293-.76.293-.183 0-.36-.033-.522-.093-.49-.19-1.214-.836-1.88-1.525-3.277-3.55-5.59-8.1-5.8-8.756-.21-.655-.25-.97-.047-1.256.202-.292.532-.365.885-.23.353.13 5.026 1.925 6.32 2.396.708.257 1.022.4 1.022.647 0 .25-.175.4-.69.77-.515.365-5.95 3.32-6.51 3.66-.568.35-.466.57-.048 1.05.403.49.89 1.115 1.387 1.763.496.65.973 1.256 1.053 1.35.08.093.14.23.14.36 0 .14-.048.28-.14.36-.195.195-2.35 2.743-2.8 3.255-.45.512-.33.82-.063 1.294.27.47.93 1.207 1.935 2.363 1.003 1.156 1.578 1.794 1.965 2.3.39.51.62.463 1.207.293.59-.175 5.832-2.128 6.835-2.518 1-.39 1.458-.714 1.458-1.246 0-.28-.07-.48-.17-.71z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-blue-900">Microsoft Edge</h3>
                    </div>
                    <p class="text-blue-800 mb-3">Also provides accurate file size detection like Chrome.</p>
                    <ul class="text-blue-700 space-y-2 ml-5 list-disc">
                        <li><strong>Accurate detection:</strong> Uses your actual RAM amount</li>
                        <li><strong>Typical limits:</strong></li>
                        <ul class="ml-6 space-y-1">
                            <li>2GB RAM: ~50-60 MB</li>
                            <li>4GB RAM: ~100-120 MB</li>
                            <li>8GB RAM: ~200-240 MB</li>
                            <li>16GB+ RAM: ~400-500 MB</li>
                        </ul>
                        <li><strong>Performance:</strong> Excellent for Windows users</li>
                    </ul>
                </div>

                <!-- Firefox -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 border border-orange-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 mr-3 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0L8.5 9.28L0 7.14l6.75 5.48L3.75 24l8.25-4.85L20.25 24l-3-11.38L24 7.14l-8.5 2.14L12 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-orange-900">Firefox</h3>
                    </div>
                    <p class="text-orange-800 mb-3">Conservative limit applied to ensure stable performance.</p>
                    <ul class="text-orange-700 space-y-2 ml-5 list-disc">
                        <li><strong>Conservative detection:</strong> Uses a safe estimate instead of actual memory</li>
                        <li><strong>Standard limit:</strong> 50 MB for most devices</li>
                        <li><strong>High-end devices:</strong> 75 MB (8+ CPU cores detected)</li>
                        <li><strong>Why lower?</strong> Firefox doesn't expose device memory info, so we err on the side of caution</li>
                    </ul>
                </div>

                <!-- Safari -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-8 h-8 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22c-5.514 0-10-4.486-10-10S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10zm1-15h-2v6h6v-2h-4V7z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-blue-900">Safari</h3>
                    </div>
                    <p class="text-blue-800 mb-3">Similar to Firefox with conservative limits.</p>
                    <ul class="text-blue-700 space-y-2 ml-5 list-disc">
                        <li><strong>Conservative detection:</strong> Uses a safe estimate</li>
                        <li><strong>Standard limit:</strong> 50 MB</li>
                        <li><strong>Note:</strong> Performance typically excellent on macOS devices</li>
                    </ul>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">💡 What This Means for You</h3>
                <ul class="text-yellow-800 space-y-2">
                    <li>• The limit shown is a <strong>recommendation</strong> to ensure your browser stays responsive</li>
                    <li>• You can still process larger files, but they may be slower or cause temporary unresponsiveness</li>
                    <li>• Your data is safe regardless - it never leaves your device during processing</li>
                    <li>• For the best experience, we recommend using Chrome or Edge for larger files</li>
                </ul>
            </div>
        </div>

        <!-- Future Data Types -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Coming Soon: More Data Types</h2>
            <p class="text-gray-600 mb-6">We're constantly expanding our validation capabilities. Here are some data
                types we're planning to add:</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <svg class="w-10 h-10 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Email Addresses</h3>
                    <p class="text-gray-600 text-sm mb-3">Email validation with domain checking and format verification
                    </p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">planned</span>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <svg class="w-10 h-10 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">UK Driving Licenses</h3>
                    <p class="text-gray-600 text-sm mb-3">UK driving license number validation and format checking</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">planned</span>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <svg class="w-10 h-10 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">UK Passport Numbers</h3>
                    <p class="text-gray-600 text-sm mb-3">UK passport number validation and format verification</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">planned</span>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            function switchTab(targetTab) {
                // Update active tab button
                tabBtns.forEach(b => {
                    if (b.dataset.tab === targetTab) {
                        b.classList.add('border-blue-500', 'text-blue-600');
                        b.classList.remove('border-transparent', 'text-gray-500');
                    } else {
                        b.classList.remove('border-blue-500', 'text-blue-600');
                        b.classList.add('border-transparent', 'text-gray-500');
                    }
                });

                // Update active tab content
                tabContents.forEach(content => {
                    if (content.id === `${targetTab}Tab`) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            }

            // Add click listeners to tab buttons
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetTab = this.dataset.tab;
                    switchTab(targetTab);
                });
            });

            // Handle hash anchor links (for footer navigation)
            function handleHashNavigation() {
                const hash = window.location.hash;
                if (hash && hash.startsWith('#')) {
                    const tabName = hash.replace('#', '').replace('Tab', '');
                    if (tabName && tabBtns.length > 0) {
                        switchTab(tabName);

                        // Scroll to the tab section after a brief delay to ensure tab is visible
                        setTimeout(() => {
                            const tabSection = document.querySelector('.bg-white.rounded-lg.shadow-lg.p-6.mb-8');
                            if (tabSection) {
                                tabSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }, 100);
                    }
                }
            }

            // Handle hash on page load
            handleHashNavigation();

            // Handle hash changes (when clicking links on the same page)
            window.addEventListener('hashchange', handleHashNavigation);
        });
    </script>
</body>

</html>
