<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'Documentation';
$pageDescription = 'Complete documentation for Simple Data Cleaner - detailed guides, features, visual references, troubleshooting, and FAQs for cleaning UK data formats.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/documentation.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://simple-data-cleaner.com/documentation.php">
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
      "datePublished": "2025-01-01",
      "dateModified": "2025-01-02",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://simple-data-cleaner.com/documentation.php"
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
        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Table of contents sticky sidebar */
        @media (min-width: 1024px) {
            .sticky-toc {
                position: sticky;
                top: 2rem;
                max-height: calc(100vh - 4rem);
                overflow-y: auto;
            }
        }

        /* Code blocks */
        .code-block {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Color swatch styles */
        .color-swatch {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 0.25rem;
            vertical-align: middle;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-12 max-w-7xl">
        <header class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Documentation</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Everything you need to know about using Simple Data Cleaner to clean and validate your UK data.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Table of Contents (Sidebar) -->
            <aside class="lg:col-span-1">
                <nav class="sticky-toc bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contents</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#getting-started" class="text-blue-600 hover:text-blue-800 hover:underline">Getting Started</a></li>
                        <li><a href="#supported-formats" class="text-blue-600 hover:text-blue-800 hover:underline">Supported Formats</a></li>
                        <li><a href="#upload-process" class="text-blue-600 hover:text-blue-800 hover:underline">Upload Process</a></li>
                        <li><a href="#field-selection" class="text-blue-600 hover:text-blue-800 hover:underline">Field Selection</a></li>
                        <li><a href="#protected-columns" class="text-blue-600 hover:text-blue-800 hover:underline">Protected Columns</a></li>
                        <li><a href="#data-profiling" class="text-blue-600 hover:text-blue-800 hover:underline">Data Profiling</a></li>
                        <li><a href="#full-preview" class="text-blue-600 hover:text-blue-800 hover:underline">Full Preview</a></li>
                        <li><a href="#color-coding" class="text-blue-600 hover:text-blue-800 hover:underline">Color Coding System</a></li>
                        <li><a href="#duplicate-handling" class="text-blue-600 hover:text-blue-800 hover:underline">Duplicate Handling</a></li>
                        <li><a href="#export-options" class="text-blue-600 hover:text-blue-800 hover:underline">Export Options</a></li>
                        <li><a href="#validation-rules" class="text-blue-600 hover:text-blue-800 hover:underline">Validation Rules</a></li>
                        <li><a href="#troubleshooting" class="text-blue-600 hover:text-blue-800 hover:underline">Troubleshooting</a></li>
                        <li><a href="#faq" class="text-blue-600 hover:text-blue-800 hover:underline">FAQ</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-12">

                <!-- Getting Started -->
                <section id="getting-started" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Getting Started</h2>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 mb-4">
                            Simple Data Cleaner helps you validate and clean UK data formats including phone numbers, National Insurance numbers, postcodes, and bank sort codes. The entire process happens in your browser - your data never leaves your device.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-3">Quick Start:</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-700 ml-4">
                            <li>Upload your CSV, Excel (.xlsx/.xls), or JSON file</li>
                            <li>Select which columns contain UK data to clean (or use Auto-Select)</li>
                            <li>Click "Clean My Data" to process</li>
                            <li>Review results in the Full Preview tab</li>
                            <li>Customize export options (format, duplicates, whitespace)</li>
                            <li>Download your cleaned file</li>
                        </ol>

                        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mt-6">
                            <p class="text-sm text-blue-900">
                                <strong><svg class="inline w-5 h-5 text-blue-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Pro Tip:</strong> Always use the Full Preview feature before downloading to ensure the cleaning results match your expectations.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Supported Formats -->
                <section id="supported-formats" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Supported File Formats</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- CSV -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">CSV</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Comma Separated Values</p>
                            <ul class="text-sm text-gray-500 space-y-1">
                                <li>• Extension: .csv</li>
                                <li>• Universal compatibility</li>
                                <li>• Best for spreadsheets</li>
                            </ul>
                        </div>

                        <!-- Excel -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Excel</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Microsoft Excel Format</p>
                            <ul class="text-sm text-gray-500 space-y-1">
                                <li>• Extensions: .xlsx, .xls</li>
                                <li>• Native Excel format</li>
                                <li>• Preserves formatting</li>
                            </ul>
                        </div>

                        <!-- JSON -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">JSON</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">JavaScript Object Notation</p>
                            <ul class="text-sm text-gray-500 space-y-1">
                                <li>• Extension: .json</li>
                                <li>• Perfect for developers</li>
                                <li>• Structured data format</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                        <p class="text-sm text-indigo-900">
                            <strong>🔄 Format Conversion:</strong> Upload in any format, download in any format. For example, upload a CSV file and download as Excel or JSON!
                        </p>
                    </div>
                </section>

                <!-- Upload Process -->
                <section id="upload-process" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Upload Process</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">File Size Limits</h3>
                            <p class="text-gray-700 mb-3">File size limits depend on your browser and device memory:</p>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                <li><strong>Free users:</strong> Files up to several hundred MB</li>
                                <li><strong>Premium users:</strong> Larger files supported (browser-dependent)</li>
                                <li>Processing time increases with file size</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">File Requirements</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        File must have a header row (column names)
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        CSV files should be properly formatted with consistent delimiters
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Excel files: Only the first sheet is processed
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        JSON files should contain an array of objects with consistent keys
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Privacy Guarantee</h3>
                            <div class="bg-green-50 border-l-4 border-green-600 p-4">
                                <p class="text-sm text-green-900">
                                    <strong><svg class="inline w-5 h-5 text-green-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> 100% Private:</strong> Your file is processed entirely in your browser using JavaScript. No data is transmitted to our servers, stored in any database, or accessed by third parties. We never see your data.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Field Selection -->
                <section id="field-selection" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Field Selection</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Supported UK Data Types</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg> Phone Numbers</h4>
                                    <p class="text-sm text-gray-600 mb-2">UK mobile and landline numbers</p>
                                    <div class="text-sm text-gray-500">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>07123456789</li>
                                            <li>+44 7123 456789</li>
                                            <li>0207 123 4567</li>
                                            <li>(020) 7123 4567</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg> National Insurance</h4>
                                    <p class="text-sm text-gray-600 mb-2">UK NI numbers</p>
                                    <div class="text-sm text-gray-500">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>AB123456C</li>
                                            <li>AB 12 34 56 C</li>
                                            <li>ab-123456-c</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg> Postcodes</h4>
                                    <p class="text-sm text-gray-600 mb-2">UK postal codes</p>
                                    <div class="text-sm text-gray-500">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>SW1A 1AA</li>
                                            <li>sw1a1aa</li>
                                            <li>M1 1AA</li>
                                            <li>EC1A 1BB</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg> Sort Codes</h4>
                                    <p class="text-sm text-gray-600 mb-2">UK bank sort codes</p>
                                    <div class="text-sm text-gray-500">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>12-34-56</li>
                                            <li>123456</li>
                                            <li>12 34 56</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Auto-Select Feature</h3>
                            <p class="text-gray-700 mb-3">
                                Click the "Auto-Select" button to automatically detect and select all cleanable columns based on:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                <li><strong>Column names:</strong> Matches keywords like "phone", "mobile", "postcode", "ni_number", "sort_code"</li>
                                <li><strong>Data content:</strong> Analyzes sample values to identify UK data patterns</li>
                                <li><strong>Smart suggestions:</strong> Recommends the appropriate data type for each column</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Manual Selection</h3>
                            <p class="text-gray-700 mb-3">
                                You can manually select columns and choose the validation type:
                            </p>
                            <ol class="list-decimal list-inside space-y-2 text-gray-700 ml-4">
                                <li>Check the box next to each column you want to clean</li>
                                <li>Select the data type from the dropdown (Phone, NI Number, Postcode, Sort Code)</li>
                                <li>The system will validate and clean based on your selection</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Protected Columns -->
                <section id="protected-columns" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Protected Columns</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-700 mb-4">
                                Protected columns are automatically detected and <strong>never modified</strong> during the cleaning process. This ensures your data relationships and unique identifiers remain intact.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">What Gets Protected?</h3>
                            <p class="text-gray-700 mb-3">Columns matching these patterns are automatically protected:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>id</code>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>*_id</code>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>*_key</code>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>pk</code>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>*_number</code>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-700">
                                    <code>reference</code>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">
                                Examples: customer_id, order_number, transaction_key, account_id, reference_code
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Visual Indicators</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Protected columns show a lock icon in the field selection area</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Lock icon appears in the Full Preview table headers</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span>Listed in the download summary under "Protected Columns"</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-600 p-4">
                            <p class="text-sm text-blue-900">
                                <strong><svg class="inline w-5 h-5 text-blue-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Why Protected?</strong> ID and key columns often contain unique identifiers, order numbers, or reference codes that have specific meaning in your systems. Modifying these could break data relationships or cause integration issues.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Data Profiling -->
                <section id="data-profiling" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Data Profiling</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-700 mb-4">
                                After processing your file, you'll see a Data Profiling section with key insights about your data quality:
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <h4 class="font-semibold text-gray-900">Missing Values</h4>
                                </div>
                                <p class="text-sm text-gray-600">Count of empty or null cells across all columns</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h4 class="font-semibold text-gray-900">Duplicate Rows</h4>
                                </div>
                                <p class="text-sm text-gray-600">Count of exact duplicate rows found in your data</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="font-semibold text-gray-900">Unique Rows</h4>
                                </div>
                                <p class="text-sm text-gray-600">Count of unique rows (total minus duplicates)</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Missing Values by Column</h3>
                            <p class="text-gray-700 mb-3">
                                If your file has missing values, you'll see a detailed breakdown table showing:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                <li>Which columns have missing data</li>
                                <li>Count of missing values per column</li>
                                <li>Percentage of rows affected</li>
                            </ul>
                            <p class="text-sm text-gray-500 mt-3">
                                This helps you identify data quality issues and decide if you need to fill in missing values before using the data.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Full Preview -->
                <section id="full-preview" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Full Preview Feature</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-700 mb-4">
                                The Full Preview tab shows you <strong>exactly</strong> what your downloaded file will contain. This gives you complete confidence before downloading.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">What You'll See:</h3>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>All rows and columns</strong> from your original file</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>Cleaned values</strong> applied to validated fields</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>Color coding</strong> to highlight changes and issues</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>Protected columns</strong> marked with lock icons</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><strong>Row and column counts</strong> at the top</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-indigo-50 border-l-4 border-indigo-600 p-4">
                            <p class="text-sm text-indigo-900">
                                <strong><svg class="inline w-5 h-5 text-indigo-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Preview Benefits:</strong> The Full Preview eliminates surprises. You can verify the cleaning results, check for any issues, and ensure the output matches your expectations before committing to a download.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Color Coding System -->
                <section id="color-coding" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Color Coding System</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-700 mb-4">
                                The Full Preview uses a color coding system to help you quickly identify different types of data and changes:
                            </p>
                        </div>

                        <div class="space-y-4">
                            <!-- Blue Rows -->
                            <div class="border-l-4 border-blue-400 bg-blue-50 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-blue-50 border-2 border-blue-400"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-blue-900 mb-1">Blue Rows</h4>
                                        <p class="text-sm text-blue-800 mb-2">Original rows that have duplicates elsewhere in the file</p>
                                        <div class="bg-blue-100 rounded px-2 py-1 inline-block text-xs text-blue-900">
                                            Badge: "HAS DUPLICATES"
                                        </div>
                                        <p class="text-sm text-blue-700 mt-2">
                                            <strong>Meaning:</strong> This is the first occurrence - it will be kept even if "Remove duplicates" is checked
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Yellow Rows -->
                            <div class="border-l-4 border-amber-400 bg-amber-50 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-amber-50 border-2 border-amber-400"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-amber-900 mb-1">Yellow Rows</h4>
                                        <p class="text-sm text-amber-800 mb-2">Duplicate rows (exact copies of earlier rows)</p>
                                        <div class="bg-amber-200 rounded px-2 py-1 inline-block text-xs text-amber-900">
                                            Badge: "DUPLICATE"
                                        </div>
                                        <p class="text-sm text-amber-700 mt-2">
                                            <strong>Meaning:</strong> This row will be removed if you check "Remove duplicate rows"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Green Cells -->
                            <div class="border-l-4 border-green-400 bg-green-50 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-green-50 border-2 border-green-400"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-green-900 mb-1">Green Cells</h4>
                                        <p class="text-sm text-green-800 mb-2">Individual cells that were cleaned, validated, or fixed</p>
                                        <p class="text-sm text-green-700 mt-2">
                                            <strong>Meaning:</strong> This specific value was modified by the validation process (e.g., phone number formatted to +44 format)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- White/Gray Rows -->
                            <div class="border-l-4 border-gray-300 bg-white rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-white border-2 border-gray-300"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1">White/Gray Rows</h4>
                                        <p class="text-sm text-gray-700 mb-2">Normal rows with no duplicates (alternating white and light gray for readability)</p>
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Meaning:</strong> Standard row with no special status
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Example Preview:</h4>
                            <div class="text-xs space-y-1 font-mono text-gray-700">
                                <div class="p-2 bg-white border-l-2 border-gray-300">Row 1: John Doe | <span class="bg-green-100 px-1">+44 7123 456789</span> ← Normal row, phone cleaned (green)</div>
                                <div class="p-2 bg-gray-50 border-l-2 border-gray-300">Row 2: Jane Smith | [empty] ← Normal row</div>
                                <div class="p-2 bg-blue-50 border-l-4 border-blue-400"><span class="bg-blue-200 px-1 text-blue-900 text-xs">HAS DUPLICATES</span> Row 3: Bob Johnson | <span class="bg-green-100 px-1">+44 7987 654321</span> ← Blue (has duplicate at row 6)</div>
                                <div class="p-2 bg-amber-50 border-l-4 border-amber-400"><span class="bg-amber-200 px-1 text-amber-900 text-xs">DUPLICATE</span> Row 4: John Doe | <span class="bg-green-100 px-1">+44 7123 456789</span> ← Yellow (duplicate of row 1)</div>
                                <div class="p-2 bg-white border-l-2 border-gray-300">Row 5: Alice Brown | <span class="bg-green-100 px-1">+44 7111 111111</span> ← Normal row</div>
                                <div class="p-2 bg-amber-50 border-l-4 border-amber-400"><span class="bg-amber-200 px-1 text-amber-900 text-xs">DUPLICATE</span> Row 6: Bob Johnson | <span class="bg-green-100 px-1">+44 7987 654321</span> ← Yellow (duplicate of row 3)</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Duplicate Handling -->
                <section id="duplicate-handling" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Duplicate Row Handling</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">How Duplicates Are Detected</h3>
                            <p class="text-gray-700 mb-3">
                                The system identifies <strong>exact duplicate rows</strong> by comparing all column values:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                <li>Two rows are duplicates if <strong>all</strong> column values match exactly</li>
                                <li>The first occurrence is considered the "original"</li>
                                <li>Subsequent identical rows are marked as "duplicates"</li>
                                <li>Case-sensitive comparison (unless cleaned values are used)</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Removal Options</h3>
                            <p class="text-gray-700 mb-3">
                                In the Export Options section, you'll find a checkbox: <strong>"Remove Duplicate Rows (Keep First Occurrence)"</strong>
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">✓ Checked (Remove)</h4>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• Only first occurrence kept</li>
                                        <li>• Duplicate rows excluded from download</li>
                                        <li>• Row count reduced</li>
                                        <li>• Data relationships preserved</li>
                                    </ul>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">○ Unchecked (Keep All)</h4>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• All rows included in download</li>
                                        <li>• Both originals and duplicates kept</li>
                                        <li>• Original row count maintained</li>
                                        <li>• Useful for audit purposes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Visual Preview</h3>
                            <p class="text-gray-700 mb-3">
                                Before removing duplicates, always check the Full Preview tab to verify:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                <li><strong class="text-blue-600">Blue rows</strong> show which records will be kept (originals)</li>
                                <li><strong class="text-amber-600">Yellow rows</strong> show which records will be removed (duplicates)</li>
                                <li>Duplicate count shown in the Export Options section</li>
                                <li>Total affected rows count displayed (originals + duplicates)</li>
                            </ul>
                        </div>

                        <div class="bg-amber-50 border-l-4 border-amber-600 p-4">
                            <p class="text-sm text-amber-900">
                                <strong><svg class="inline w-5 h-5 text-amber-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Important:</strong> Duplicate removal is applied AFTER data cleaning. This means the system will detect duplicates based on the cleaned, normalized values - not the original raw data.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Export Options -->
                <section id="export-options" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Export Options</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Download Format Selection</h3>
                            <p class="text-gray-700 mb-3">Choose your preferred download format:</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-green-900 mb-2">CSV</h4>
                                    <ul class="text-sm text-green-800 space-y-1">
                                        <li>• Universal compatibility</li>
                                        <li>• Opens in any spreadsheet</li>
                                        <li>• Smallest file size</li>
                                    </ul>
                                </div>
                                <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-blue-900 mb-2">Excel (.xlsx)</h4>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        <li>• Native Excel format</li>
                                        <li>• Ready to use in Excel</li>
                                        <li>• Preserves data types</li>
                                    </ul>
                                </div>
                                <div class="border border-purple-200 bg-purple-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-purple-900 mb-2">JSON</h4>
                                    <ul class="text-sm text-purple-800 space-y-1">
                                        <li>• Developer-friendly</li>
                                        <li>• Structured format</li>
                                        <li>• Easy to parse</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Data Cleaning Options</h3>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Remove Duplicate Rows</h4>
                                            <p class="text-sm text-gray-600">Automatically removes exact duplicate rows, keeping only the first occurrence. Duplicates are highlighted in the preview so you can review before removing.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" checked disabled>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Clean Whitespace in All Cells</h4>
                                            <p class="text-sm text-gray-600">Trims leading/trailing spaces and normalizes multiple spaces to single spaces across all cells. This ensures consistent formatting. Enabled by default.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Additional Export Options</h3>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Include "Issues" Column</h4>
                                            <p class="text-sm text-gray-600">Adds an extra column listing any validation issues found in each row. Helps you quickly identify which rows may need manual review.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Export Only Rows With Issues</h4>
                                            <p class="text-sm text-gray-600">Downloads ONLY the rows that have validation problems. Perfect for creating a focused review file that you can fix manually and merge back into your main dataset.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Issues Report Section -->
                        <div class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2 flex items-center gap-2"><svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Detailed Issues Report</h3>
                                    <p class="text-gray-700 mb-4">
                                        Get comprehensive, actionable explanations for every validation issue. No more guessing what's wrong with your data - we tell you exactly what the problem is and how to fix it.
                                    </p>
                                    
                                    <div class="bg-white rounded-lg p-4 mb-4 border border-blue-100">
                                        <h4 class="font-semibold text-gray-900 mb-3">How It Works</h4>
                                        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                            <li>After processing your file, go to the <strong>"Issues"</strong> tab</li>
                                            <li>Click the <strong>"View Detailed Issues Report"</strong> button</li>
                                            <li>A comprehensive HTML report opens with detailed explanations for each issue</li>
                                            <li>Each issue shows: the invalid value, specific problem, explanation, and actionable guidance</li>
                                        </ol>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <h5 class="font-semibold text-gray-900 mb-2 text-sm">Report Features:</h5>
                                            <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                                                <li><strong>Auto-Update:</strong> Keep the report tab open! It automatically updates when you process new files - no need to close and reopen.</li>
                                                <li><strong>Persistent Storage:</strong> Reports survive page refreshes. Your browser's localStorage keeps the report available even after refreshing.</li>
                                                <li><strong>Print & Download:</strong> Use the print button to print the report, or download it as an HTML file for permanent storage and sharing.</li>
                                                <li><strong>Navigation Sidebar:</strong> Quick links to jump to specific data type sections (NI Numbers, Phone Numbers, Postcodes, etc.)</li>
                                                <li><strong>Detailed Explanations:</strong> Each issue includes specific problem identification, why it's invalid, and actionable steps to fix it</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                What You Get
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Specific problem identification</li>
                                                <li>• Clear explanations of why values are invalid</li>
                                                <li>• Actionable guidance on how to fix issues</li>
                                                <li>• Professional HTML report format</li>
                                            </ul>
                                        </div>
                                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Example Explanations
                                            </h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• NI Numbers: Which letter is invalid and why</li>
                                                <li>• Phone Numbers: Format issues and corrections</li>
                                                <li>• Postcodes: Missing spaces or wrong format</li>
                                                <li>• Sort Codes: Wrong digit count or letters</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="bg-blue-100 border-l-4 border-blue-600 p-4 rounded">
                                        <p class="text-sm text-blue-900 mb-2">
                                            <strong><svg class="inline w-5 h-5 text-blue-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Pro Tip:</strong> The detailed issues report is perfect for sharing with your team or documenting data quality issues. Each explanation includes the specific problem, why it's invalid according to UK standards, and clear steps to fix it.
                                        </p>
                                        <p class="text-sm text-blue-900">
                                            <strong>📌 Important:</strong> The report is stored in your browser's session storage, so if you refresh the page, it will automatically restore. You can also print the report directly from the browser or download it as an HTML file for permanent storage.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 border-l-4 border-red-600 p-4">
                            <p class="text-sm text-red-900">
                                <strong><svg class="inline w-5 h-5 text-red-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Important:</strong> Your cleaned data only exists in your browser session. Once you close the tab or refresh the page, it's gone. Make sure to download and save your file immediately after processing!
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Validation Rules -->
                <section id="validation-rules" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Validation Rules</h2>

                    <div class="space-y-6">
                        <!-- Phone Numbers -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg> Phone Number Validation</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Accepts:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>• UK mobile numbers (07xxx xxxxxx)</li>
                                    <li>• UK landline numbers (01xxx / 02xxx / 03xxx)</li>
                                    <li>• International format (+44)</li>
                                    <li>• Various spacing and formatting styles</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>1. Removes all non-digit characters (spaces, hyphens, parentheses)</li>
                                    <li>2. Validates length (10-11 digits for UK numbers)</li>
                                    <li>3. Converts to +44 format</li>
                                    <li>4. Adds spacing for readability (+44 7123 456789)</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Examples:</h4>
                                <div class="code-block">
07123456789      → +44 7123 456789
+447123456789    → +44 7123 456789
(020) 7123 4567  → +44 20 7123 4567
0207-123-4567    → +44 20 7123 4567</div>
                            </div>
                        </div>

                        <!-- NI Numbers -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg> National Insurance Number Validation</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Format:</h4>
                                <p class="text-sm text-gray-700 mb-3">Two letters, six digits, one letter (e.g., AB123456C)</p>
                                <h4 class="font-semibold text-gray-900 mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>1. Removes spaces, hyphens, and special characters</li>
                                    <li>2. Converts to uppercase</li>
                                    <li>3. Validates prefix (excludes invalid prefixes like BG, GB, NK, etc.)</li>
                                    <li>4. Formats with spaces (AB 12 34 56 C)</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Examples:</h4>
                                <div class="code-block">
ab123456c        → AB 12 34 56 C
AB-123456-C      → AB 12 34 56 C
ab 12 34 56 c    → AB 12 34 56 C</div>
                            </div>
                        </div>

                        <!-- Postcodes -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg> Postcode Validation</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Accepts:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>• All UK postcode formats</li>
                                    <li>• With or without spaces</li>
                                    <li>• Mixed case</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>1. Converts to uppercase</li>
                                    <li>2. Removes extra spaces</li>
                                    <li>3. Adds proper spacing (outward code + space + inward code)</li>
                                    <li>4. Validates format against UK postcode patterns</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Examples:</h4>
                                <div class="code-block">
sw1a1aa          → SW1A 1AA
m11aa            → M1 1AA
EC1A1BB          → EC1A 1BB
w1a 1aa          → W1A 1AA</div>
                            </div>
                        </div>

                        <!-- Sort Codes -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg> Sort Code Validation</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Format:</h4>
                                <p class="text-sm text-gray-700 mb-3">Six digits formatted as XX-XX-XX</p>
                                <h4 class="font-semibold text-gray-900 mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-gray-700 space-y-1 mb-3">
                                    <li>1. Removes all non-digit characters</li>
                                    <li>2. Validates length (must be exactly 6 digits)</li>
                                    <li>3. Formats with hyphens (XX-XX-XX)</li>
                                </ul>
                                <h4 class="font-semibold text-gray-900 mb-2">Examples:</h4>
                                <div class="code-block">
123456           → 12-34-56
12 34 56         → 12-34-56
12-34-56         → 12-34-56</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Troubleshooting -->
                <section id="troubleshooting" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Troubleshooting</h2>

                    <div class="space-y-6">
                        <div class="border-l-4 border-red-400 bg-red-50 rounded-r-lg p-4">
                            <h4 class="font-semibold text-red-900 mb-2">File won't upload or processing fails</h4>
                            <ul class="text-sm text-red-800 space-y-1 ml-4">
                                <li>• Check file size - very large files may exceed browser memory</li>
                                <li>• Ensure file has a valid header row</li>
                                <li>• For CSV files, check for consistent delimiters (commas)</li>
                                <li>• For Excel files, ensure data is in the first sheet</li>
                                <li>• Try a different browser (Chrome recommended)</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-amber-400 bg-amber-50 rounded-r-lg p-4">
                            <h4 class="font-semibold text-amber-900 mb-2">Values not being cleaned as expected</h4>
                            <ul class="text-sm text-amber-800 space-y-1 ml-4">
                                <li>• Verify you selected the correct data type (Phone vs. Postcode, etc.)</li>
                                <li>• Check if the column is protected (has <svg class="inline w-4 h-4 text-gray-600 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> lock icon) - protected columns are never modified</li>
                                <li>• Ensure data is in the correct format (UK phone numbers, not international)</li>
                                <li>• Review the validation rules for your data type</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-blue-400 bg-blue-50 rounded-r-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Download not starting or file is empty</h4>
                            <ul class="text-sm text-blue-800 space-y-1 ml-4">
                                <li>• Check browser popup blocker settings</li>
                                <li>• Ensure you clicked "Clean My Data" before downloading</li>
                                <li>• Try a different download format (CSV if Excel fails)</li>
                                <li>• Clear browser cache and try again</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-purple-400 bg-purple-50 rounded-r-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Duplicate detection seems incorrect</h4>
                            <ul class="text-sm text-purple-800 space-y-1 ml-4">
                                <li>• Duplicates are detected AFTER cleaning - compare cleaned values, not original</li>
                                <li>• Check the Full Preview to see which rows are marked as duplicates</li>
                                <li>• Blue rows = originals, Yellow rows = duplicates</li>
                                <li>• Duplicates must match in ALL columns, not just some</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-green-400 bg-green-50 rounded-r-lg p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Preview not showing or loads slowly</h4>
                            <ul class="text-sm text-green-800 space-y-1 ml-4">
                                <li>• Large files (10,000+ rows) may take time to render</li>
                                <li>• Try closing other browser tabs to free memory</li>
                                <li>• Use a modern browser with good JavaScript performance</li>
                                <li>• Consider splitting very large files into smaller chunks</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- FAQ -->
                <section id="faq" class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-600 pb-2">Frequently Asked Questions</h2>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Is my data really private?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> Yes, 100%. All processing happens in your browser using JavaScript. Your file is never uploaded to our servers, never stored in any database, and never transmitted over the network. We physically cannot see your data - it never leaves your device.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: What happens to my data after I close the browser?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> It's gone forever. Since everything happens in your browser's memory and nothing is stored on servers, closing the tab or refreshing the page will permanently delete the cleaned data. Always download your file immediately after processing.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Can I clean non-UK data?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> Currently, Simple Data Cleaner specializes in UK data formats only (UK phone numbers, NI numbers, postcodes, and sort codes). International data formats are not supported at this time.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Why can't I select certain columns for cleaning?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> If a column shows a <svg class="inline w-4 h-4 text-gray-600 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> lock icon, it's been automatically detected as a protected column (ID, key, or reference field). Protected columns are never modified to preserve data relationships and prevent breaking system integrations.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: What does "Keep First Occurrence" mean for duplicates?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> When removing duplicates, the system keeps the first row it encounters and removes all subsequent identical rows. This preserves the original order of your data and ensures the "original" record (blue row) is always kept.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Can I undo changes after downloading?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> No, downloads are final. However, your original file remains unchanged on your computer. Always keep a backup of your original file before processing. You can also use the Full Preview feature to verify results before downloading.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Why are some phone numbers marked as invalid?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> The validator checks for proper UK phone number format and length. Common issues: incorrect area codes, too few/many digits, or non-UK numbers. Review the validation rules section for specific format requirements.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: Can I clean multiple files at once?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> No, the app processes one file at a time. To clean multiple files, upload and process them individually. You can keep multiple browser tabs open to work on different files simultaneously.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: What's the difference between "Export Only Rows With Issues" and normal download?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> Normal download gives you the complete file with all rows (cleaned values applied). "Export Only Rows With Issues" creates a filtered file containing ONLY the rows that have validation problems - useful for creating a focused review file that you can fix manually and merge back later.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Q: How do I know if cleaning was successful?</h4>
                            <p class="text-sm text-gray-700 pl-4">
                                <strong>A:</strong> Check the Results Summary cards showing valid vs. invalid counts, review the Full Preview tab to see green-highlighted cleaned cells, and review the Data Profiling section for overall data quality insights. Green cells = successfully cleaned values.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Contact Support -->
                <section class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Still Have Questions?</h2>
                    <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                        Can't find what you're looking for? Our support team is here to help.
                    </p>
                    <a href="/contact.php" class="inline-block bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg font-medium">
                        Contact Support
                    </a>
                </section>

            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>

    <script>
        // Smooth scroll for table of contents links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
