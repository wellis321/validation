<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'UK Phone, NI, Postcode & Sort Code Rules';
$pageDescription = 'See the exact UK format rules for phone numbers, NI numbers, postcodes and sort codes - then validate and clean your data free, right in your browser.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/validation-rules.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://simple-data-cleaner.com/validation-rules.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:site_name" content="Simple Data Cleaner">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">

    <!-- Article Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "TechArticle",
      "headline": "<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner",
      "description": "<?php echo htmlspecialchars($pageDescription); ?>",
      "author": {
        "@type": "Organization",
        "name": "Simple Data Cleaner"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Simple Data Cleaner",
        "logo": {
          "@type": "ImageObject",
          "url": "https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png"
        }
      },
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://simple-data-cleaner.com/validation-rules.php"
      }
    }
    </script>

    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>

<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">UK Phone, NI, Postcode & Sort Code Format Rules</h1>
            <p class="text-xl text-neutral-400 max-w-4xl mx-auto">
                The exact rules our validator checks for UK phone numbers, National Insurance numbers, postcodes,
                bank sort codes, and email addresses - with examples of automatic fixes and what makes data valid or invalid.
            </p>

            <!-- Navigation back to main validator -->
            <div class="mt-6">
                <a href="/"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Data Cleaner
                </a>
            </div>
        </header>

        <!-- Tab Navigation -->
        <div id="validation-tab-nav" class="bg-neutral-800/60 border border-neutral-600 shadow-lg p-6 mb-8">
            <div class="border-b border-neutral-600">
                <nav class="-mb-px flex space-x-8 overflow-x-auto">
                    <button
                        class="tab-btn active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-yellow-500 text-yellow-400"
                        data-tab="phone_numbers">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Phone Numbers
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="national_insurance">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        NI Numbers
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="postcodes">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Postcodes
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="sort_codes">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Sort Codes
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="bank_account">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Bank Accounts
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="emails">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </button>
                    <button
                        class="tab-btn whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-neutral-400 hover:text-neutral-300 hover:border-neutral-500"
                        data-tab="names">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Names
                    </button>
                </nav>
            </div>
        </div>

        <!-- Phone Numbers Tab -->
        <div id="phone_numbersTab" class="tab-content active">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Phone Numbers</h2>
                        <p class="text-lg text-gray-600">UK mobile and landline phone number validation with automatic
                            formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We take your phone number input and automatically check it against UK phone
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
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">Output Format Options</h3>
                    <p class="text-amber-800 mb-4">Choose how you want your phone numbers formatted in the results:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div class="bg-white rounded-lg p-4">
                            <h4 class="font-medium text-amber-800 mb-2">International (+44)</h4>
                            <p class="text-amber-800 text-sm mb-2">Always includes +44 country code</p>
                            <code
                                class="inline-block bg-amber-100 px-2 py-1 rounded text-sm font-mono text-amber-800">+44 7700 900123</code>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <h4 class="font-medium text-amber-800 mb-2">UK (0)</h4>
                            <p class="text-amber-800 text-sm mb-2">UK domestic format starting with 0</p>
                            <code
                                class="inline-block bg-amber-100 px-2 py-1 rounded text-sm font-mono text-amber-800">07700 900123</code>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 mt-4 border border-amber-200">
                        <p class="text-amber-800">
                            <strong>Supported formats:</strong> We clean 100+ phone number variations including Excel scientific notation,
                            labels, names, extensions, and multiple formats.
                        </p>
                        <a href="phone-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors font-medium">
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
                    <svg class="w-10 h-10 mr-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">National Insurance Numbers</h2>
                        <p class="text-lg text-gray-600">UK National Insurance number validation and formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We validate UK National Insurance numbers by checking their format
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
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">HMRC Compliance Standards</h3>
                    <p class="text-amber-800 mb-4">Your NI numbers are validated against official HMRC standards. Common
                        rejection reasons:</p>
                    <ul class="text-amber-800 space-y-1 ml-4">
                        <li>• <strong>Banned prefixes:</strong> BG, GB, KN, NK, NT, TN, ZZ</li>
                        <li>• <strong>Invalid letters:</strong> D, F, I, Q, U, V in first position; O in second position
                        </li>
                        <li>• <strong>TRN format:</strong> 11 a1 11 11 (not a valid NI number)</li>
                        <li>• <strong>Administrative prefixes:</strong> OO, FY, NC, PZ (special use only)</li>
                    </ul>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-amber-200">
                    <p class="text-amber-800">
                        <strong>Supported formats:</strong> We clean NI numbers from many variations including different
                        separators (spaces, hyphens, dots, slashes, commas, pipes, and more), labels and prefixes, wrapping characters, and case variations.
                    </p>
                    <a href="ni-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors font-medium">
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
                    <svg class="w-10 h-10 mr-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">UK Postcodes</h2>
                        <p class="text-lg text-gray-600">UK postcode validation with automatic formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We validate UK postcodes by checking their structure and applying automatic
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
                <div class="bg-white rounded-lg p-4 border border-amber-200">
                    <p class="text-amber-800">
                        <strong>Supported formats:</strong> We clean postcodes from many variations including different
                        separators (dashes, dots, slashes, and more), labels and prefixes (Postcode:, PC:, UK:, city names), wrapping characters, and even with addresses attached.
                    </p>
                    <a href="postcode-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors font-medium">
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
                    <svg class="w-10 h-10 mr-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Bank Sort Codes</h2>
                        <p class="text-lg text-gray-600">UK bank sort code validation and formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We validate UK bank sort codes by checking their digit structure and
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
                <div class="bg-white rounded-lg p-4 border border-amber-200">
                    <p class="text-amber-800">
                        <strong>Supported formats:</strong> We clean sort codes from many variations including different
                        separators, labels and prefixes (Sort Code:, SC:, Bank:, UK banks), wrapping characters, and even with account numbers attached.
                    </p>
                    <a href="sort-code-variations-coverage.php" class="inline-flex items-center mt-3 px-4 py-2 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        See Full List of Supported Formats
                    </a>
                </div>
            </div>
        </div>

        <!-- Bank Account Numbers Tab -->
        <div id="bank_accountTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Bank Account Numbers</h2>
                        <p class="text-lg text-gray-600">UK bank account number validation and formatting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We validate UK bank account numbers by checking their digit structure and applying automatic formatting. UK bank account numbers are typically 7-12 digits long, with 8 digits being the most common format. Our system handles various formatting issues automatically, including spacing, labels, and scientific notation from Excel.</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Number length (7-12 digits, typically 8)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Digit-only format validation</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Spacing and formatting consistency</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Labels and prefixes removal</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Wrapping characters (quotes, brackets)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Scientific notation handling (Excel)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Separator standardization</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Combined sort code and account number separation</span>
                        </div>
                    </div>
                </div>

                <!-- Automatic Fixes -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Automatic Fixes We Apply</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Spacing Standardization</h4>
                            <p class="text-gray-600 mb-4">Remove or standardize spacing for consistent formatting</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">1234 5678 → 12345678</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">1234-5678 → 12345678</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Label and Prefix Removal</h4>
                            <p class="text-gray-600 mb-4">Remove common prefixes and labels</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Account: 12345678 → 12345678</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Acc No. 12345678 → 12345678</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Scientific Notation Conversion</h4>
                            <p class="text-gray-600 mb-4">Convert Excel scientific notation to standard format</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">1.2345678E+7 → 12345678</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">1.23E+7 → 12300000</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Wrapping Character Removal</h4>
                            <p class="text-gray-600 mb-4">Remove quotes, brackets, and other wrapping characters</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">"12345678" → 12345678</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">(12345678) → 12345678</code>
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
                                <h4 class="font-medium text-green-800">Standard Format (8 digits)</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">8 digits</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Most common UK bank account number format</p>
                            <div class="space-x-2">
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">12345678</code>
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">87654321</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">With Spaces</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">xxxx xxxx</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">8 digits with space separator (formatted)</p>
                            <div class="space-x-2">
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">1234 5678</code>
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">8765 4321</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Extended Format (7-12 digits)</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">7-12 digits</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Some banks use longer account numbers</p>
                            <div class="space-x-2">
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">1234567</code>
                                <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">123456789012</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-amber-200">
                    <p class="text-amber-800">
                        <strong>Supported formats:</strong> We clean bank account numbers from many variations including different separators (spaces, hyphens, dots), labels and prefixes (Account:, Acc:, Bank Account:, Account Number:), wrapping characters (quotes, brackets), scientific notation from Excel, and even when combined with sort codes.
                    </p>
                </div>
            </div>
        </div>

        <!-- Email Tab -->
        <div id="emailsTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-slate-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Email</h2>
                        <p class="text-lg text-gray-600">Email validation and cleaning for system-to-system data moves</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We trim whitespace, validate email format (local@domain), fix common domain typos (e.g. gmial → gmail, yaho → yahoo), and optionally normalise to lowercase so your data is consistent for the next system. All processing happens in your browser — your data never leaves your device.</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Valid format: local part @ domain</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Domain has at least one dot (e.g. example.com)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Local part: letters, digits, . _ % + -</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Reasonable length (local ≤ 64, domain ≤ 253)</span>
                        </div>
                    </div>
                </div>

                <!-- What We Fix -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Automatic Fixes We Apply</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Trimming</h4>
                            <p class="text-gray-600 mb-4">Remove leading and trailing whitespace</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800"> user@example.com  → user@example.com</code>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Common domain typos</h4>
                            <p class="text-gray-600 mb-4">Fix frequent misspellings in the domain part</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">user@gmial.com → user@gmail.com</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">user@yaho.com → user@yahoo.com</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">user@hotmial.com → user@hotmail.com</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">user@outlok.com → user@outlook.com</code>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Case normalisation</h4>
                            <p class="text-gray-600 mb-4">Lowercase for consistent system-to-system output</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">User@Example.COM → user@example.com</code>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Your own domain corrections</h4>
                            <p class="text-gray-600 mb-4">When you select an email column, you can add custom typo fixes for your organisation’s domain (e.g. <code class="bg-gray-100 px-1 rounded">my-orgcom</code> → <code class="bg-gray-100 px-1 rounded">myorg.com</code>). One per line in the “Custom email domain corrections” box.</p>
                        </div>
                    </div>
                </div>

                <!-- Examples -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Valid examples</h3>
                    <div class="space-y-2">
                        <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">user@example.com</code>
                        <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">first.last@company.co.uk</code>
                        <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">name+tag@gmail.com</code>
                    </div>
                    <h3 class="text-xl font-semibold text-green-900 mb-4 mt-6">Invalid (we report as issues)</h3>
                    <p class="text-green-800 text-sm">Missing @, domain without a dot, invalid characters in local part, or empty value.</p>
                </div>
            </div>
        </div>

        <!-- Names Tab -->
        <div id="namesTab" class="tab-content">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <svg class="w-10 h-10 mr-4 text-pink-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Names</h2>
                        <p class="text-lg text-gray-600">UK name validation and intelligent name splitting</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">How It Works</h3>
                    <p class="text-amber-800">We process full names and intelligently split them into their component parts: title (Mr, Mrs, Dr, etc.), first name, and last name. Our system handles common UK name formats, including middle names, suffixes, compound surnames, and various title formats. The splitting process preserves the original data while creating new structured columns for easier data management.</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Title detection (Mr, Mrs, Miss, Ms, Dr, Prof, etc.)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">First name extraction</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Last name identification</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Middle name handling</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Suffix recognition (Jr, Sr, II, III, etc.)</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Compound surname support</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Hyphenated names handling</span>
                        </div>
                        <div class="flex items-start">
                            <span class="text-green-500 mr-3 mt-1">✓</span>
                            <span class="text-gray-700">Multiple word surname detection</span>
                        </div>
                    </div>
                </div>

                <!-- Automatic Processing -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Automatic Processing We Apply</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Title Extraction</h4>
                            <p class="text-gray-600 mb-4">Identify and extract titles from full names</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Mr John Smith → Title: Mr</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Dr Sarah Johnson → Title: Dr</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Name Component Separation</h4>
                            <p class="text-gray-600 mb-4">Split names into first and last name components</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">John Smith → First: John, Last: Smith</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Mary Smith-Jones → First: Mary, Last: Smith-Jones</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Middle Name Handling</h4>
                            <p class="text-gray-600 mb-4">Include middle names with first name</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">John Michael Smith → First: John Michael, Last: Smith</code>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Suffix Recognition</h4>
                            <p class="text-gray-600 mb-4">Handle name suffixes correctly</p>
                            <div class="space-y-2">
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">John Smith Jr → First: John, Last: Smith Jr</code>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <code class="text-sm font-mono text-gray-800">Robert Williams III → First: Robert, Last: Williams III</code>
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
                                <h4 class="font-medium text-green-800">Standard Format</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">Title First Last</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Full name with title</p>
                            <div class="space-y-2">
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Mr John Smith</code>
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Dr Sarah Johnson</code>
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Mrs Emma Brown</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">With Middle Name</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">Title First Middle Last</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Full name with middle name</p>
                            <div class="space-y-2">
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Mr John Michael Smith</code>
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Mrs Emma Louise Brown</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">With Suffix</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">First Last Suffix</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Name with suffix (Jr, Sr, II, III)</p>
                            <div class="space-y-2">
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">John Smith Jr</code>
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Robert Williams III</code>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-green-800">Compound Surnames</h4>
                                <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">First Last-Last</code>
                            </div>
                            <p class="text-green-700 text-sm mb-3">Names with hyphenated or compound surnames</p>
                            <div class="space-y-2">
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">Mary Smith-Jones</code>
                                <code class="block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">David O'Brien</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Output Format -->
                <div class="bg-amber-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">Output Format</h3>
                    <p class="text-amber-800 mb-4">When name splitting is enabled, we create three new columns:</p>
                    <div class="space-y-3">
                        <div class="bg-white rounded-lg p-4 border border-amber-200">
                            <h4 class="font-semibold text-amber-800 mb-2">title</h4>
                            <p class="text-amber-800 text-sm">Extracted title (Mr, Mrs, Dr, etc.) or empty if no title detected</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-amber-200">
                            <h4 class="font-semibold text-amber-800 mb-2">first_name</h4>
                            <p class="text-amber-800 text-sm">First name (and middle name if present)</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-amber-200">
                            <h4 class="font-semibold text-amber-800 mb-2">last_name</h4>
                            <p class="text-amber-800 text-sm">Last name (including suffixes and compound surnames)</p>
                        </div>
                    </div>
                </div>

                <!-- Supported Variations -->
                <div class="bg-white rounded-lg p-4 border border-amber-200">
                    <p class="text-amber-800 mb-3">
                        <strong>Supported formats:</strong> We handle names in many variations including titles (Mr, Mrs, Miss, Ms, Dr, Prof, Rev, etc.), middle names, suffixes (Jr, Sr, II, III, etc.), compound surnames (hyphenated and multi-word), and various spacing formats. For detailed information about name splitting options and advanced features, see our <a href="/documentation.php#name-splitting" class="text-yellow-500 hover:text-amber-800 underline font-semibold">name splitting documentation</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Browser Capabilities -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Browser Compatibility & File Size Limits</h2>

            <div class="bg-amber-50 rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-amber-900 mb-4">How File Size Limits Are Calculated</h3>
                <p class="text-amber-800 mb-4">
                    Since all processing happens in your browser, file size limits depend on your device's memory and browser capabilities. Our system automatically detects your setup and recommends an appropriate file size limit.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chrome -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center mb-3">
                        <img src="/assets/images/browser-images/chrome.png" alt="Google Chrome logo" class="w-10 h-10 mr-3 rounded-lg shadow-sm">
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
                <div class="bg-gradient-to-br from-amber-50 to-yellow-100 rounded-lg p-6 border border-amber-200">
                    <div class="flex items-center mb-3">
                        <img src="/assets/images/browser-images/edge.png" alt="Microsoft Edge logo" class="w-10 h-10 mr-3 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-amber-900">Microsoft Edge</h3>
                    </div>
                    <p class="text-amber-800 mb-3">Also provides accurate file size detection like Chrome.</p>
                    <ul class="text-amber-800 space-y-2 ml-5 list-disc">
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
                        <img src="/assets/images/browser-images/firefox.png" alt="Mozilla Firefox logo" class="w-10 h-10 mr-3 rounded-lg shadow-sm">
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
                <div class="bg-gradient-to-br from-amber-50 to-yellow-100 rounded-lg p-6 border border-amber-200">
                    <div class="flex items-center mb-3">
                        <img src="/assets/images/browser-images/safari.png" alt="Safari browser logo" class="w-10 h-10 mr-3 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-amber-900">Safari</h3>
                    </div>
                    <p class="text-amber-800 mb-3">Similar to Firefox with conservative limits.</p>
                    <ul class="text-amber-800 space-y-2 ml-5 list-disc">
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
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">planned</span>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <svg class="w-10 h-10 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">UK Driving Licenses</h3>
                    <p class="text-gray-600 text-sm mb-3">UK driving license number validation and format checking</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">planned</span>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <svg class="w-10 h-10 mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">UK Passport Numbers</h3>
                    <p class="text-gray-600 text-sm mb-3">UK passport number validation and format verification</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">planned</span>
                </div>
            </div>
        </div>

        <!-- CTA: put the rules into practice -->
        <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 border border-neutral-700 rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-3">Ready to clean your own data?</h2>
            <p class="text-neutral-400 mb-6 max-w-2xl mx-auto">
                Every rule above runs automatically when you upload a file - right in your browser, nothing ever leaves your device.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/example.php" class="inline-flex items-center justify-center gap-2 border-2 border-neutral-600 text-neutral-200 hover:border-yellow-500/60 hover:text-white px-6 py-3 rounded-lg font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                    Try it free - no signup
                </a>
                <a href="/register.php" class="inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                    Start free trial
                </a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>

    <script <?php echo script_nonce(); ?>>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            function switchTab(targetTab) {
                // Update active tab button
                tabBtns.forEach(b => {
                    if (b.dataset.tab === targetTab) {
                        b.classList.add('border-yellow-500', 'text-yellow-400');
                        b.classList.remove('border-transparent', 'text-neutral-400');
                    } else {
                        b.classList.remove('border-yellow-500', 'text-yellow-400');
                        b.classList.add('border-transparent', 'text-neutral-400');
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
                            const tabSection = document.getElementById('validation-tab-nav');
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
