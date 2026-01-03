<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'How It Works';
$pageDescription = 'Learn how Simple Data Cleaner works - upload your file, clean your data in your browser, and download in any format. 100% private, no data leaves your device.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/how-it-works.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/how-it-works.php">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:site_name" content="Simple Data Cleaner">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    
    <!-- HowTo Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "HowTo",
      "name": "How to Clean UK Data with Simple Data Cleaner",
      "description": "Step-by-step guide to cleaning and validating UK data formats in your browser",
      "step": [
        {
          "@type": "HowToStep",
          "position": 1,
          "name": "Upload Your File",
          "text": "Upload your CSV, Excel (.xlsx, .xls), or JSON file containing UK phone numbers, National Insurance numbers, postcodes, or bank sort codes.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step1"
        },
        {
          "@type": "HowToStep",
          "position": 2,
          "name": "Select Columns to Clean",
          "text": "Choose which columns you want to clean. Our system can automatically detect phone numbers, NI numbers, postcodes, and sort codes, or you can manually select the columns.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step2"
        },
        {
          "@type": "HowToStep",
          "position": 3,
          "name": "Review and Process",
          "text": "Review your selections and click 'Clean My Data' to process. All validation happens in your browser - your data never leaves your device.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step3"
        },
        {
          "@type": "HowToStep",
          "position": 4,
          "name": "Download Cleaned Data",
          "text": "Download your validated and cleaned data in CSV, Excel, or JSON format. Optionally include an Issues column or filter to only rows with problems.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step4"
        }
      ]
    }
    </script>
    
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
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Clean your UK data in 4 simple steps. Everything happens in your browser - your data never leaves your device.
            </p>
        </header>

        <!-- Steps -->
        <div class="space-y-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                            1
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Upload Your File</h2>
                        <p class="text-gray-600 mb-4">
                            Upload your CSV, Excel (.xlsx, .xls), or JSON file containing UK phone numbers, National Insurance numbers, postcodes, or bank sort codes.
                        </p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-base text-blue-900">
                                <strong><svg class="inline w-5 h-5 text-blue-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Tip:</strong> We support files up to several hundred MB, depending on your browser and device memory. All processing happens in your browser, so larger files may take a bit longer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                            2
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Select Columns to Clean</h2>
                        <p class="text-gray-600 mb-4">
                            Choose which columns you want to clean. Our system can automatically detect phone numbers, NI numbers, postcodes, and sort codes, or you can manually select the columns.
                        </p>
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-3">
                            <p class="text-base text-indigo-900">
                                <strong><svg class="inline w-5 h-5 text-indigo-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg> Auto-Select:</strong> Click "Auto-Select" to have our system automatically detect and select all cleanable columns based on column names and content.
                            </p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-base text-green-900">
                                <strong><svg class="inline w-5 h-5 text-green-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Protected Columns:</strong> ID and key columns (like customer_id, order_number) are automatically protected and will never be modified - preserving your data relationships.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                            3
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Process in Your Browser</h2>
                        <p class="text-gray-600 mb-4">
                            Click "Clean My Data" and watch as your data is validated and cleaned instantly - all in your browser. We never see, store, or transmit your data. It's 100% private.
                        </p>
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-3">
                            <p class="text-base text-purple-900">
                                <strong><svg class="inline w-5 h-5 text-purple-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Privacy First:</strong> Your file is processed entirely in your browser using JavaScript. No uploads to our servers, no database storage, no third-party access.
                            </p>
                        </div>
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                            <p class="text-base text-indigo-900">
                                <strong><svg class="inline w-5 h-5 text-indigo-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Data Insights:</strong> Get instant insights including missing values count, duplicate row detection, and data quality profiling before you download.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                            4
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Download Your Cleaned Data</h2>
                        <p class="text-gray-600 mb-4">
                            Review the complete cleaned dataset with our Full Preview feature, customize your download options, and export with confidence knowing exactly what you're getting.
                        </p>

                        <!-- Full Preview Feature -->
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-4">
                            <p class="text-sm font-semibold text-indigo-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Full Preview - See Everything Before Download:
                            </p>
                            <ul class="text-base text-indigo-800 space-y-1 ml-7">
                                <li>• View your complete cleaned dataset with all rows and columns</li>
                                <li>• <strong class="text-blue-600">Blue rows</strong> = Original rows that have duplicates elsewhere</li>
                                <li>• <strong class="text-amber-600">Yellow rows</strong> = Duplicate rows (removable via checkbox)</li>
                                <li>• <strong class="text-green-600">Green cells</strong> = Values that were cleaned or fixed</li>
                                <li>• <svg class="inline w-4 h-4 text-indigo-600 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Protected columns (IDs, keys) are marked and never modified</li>
                            </ul>
                        </div>

                        <!-- Format Selection -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Select Your Download Format:
                            </p>
                            <ul class="text-base text-blue-800 space-y-1 ml-7">
                                <li>• <strong>CSV</strong> - Comma Separated Values (great for spreadsheets)</li>
                                <li>• <strong>Excel (.xlsx)</strong> - Native Excel format (ready to open in Excel)</li>
                                <li>• <strong>JSON</strong> - Structured data format (perfect for developers)</li>
                            </ul>
                            <p class="text-sm text-blue-700 mt-2 ml-7">
                                <strong>Format Conversion:</strong> Upload in CSV? Download as Excel or JSON. Upload in Excel? Download as CSV or JSON. We support complete format conversion!
                            </p>
                        </div>

                        <!-- Export Options -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                            <p class="text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Export Customization Options:
                            </p>
                            <div class="space-y-3 ml-7">
                                <div>
                                    <p class="text-base text-gray-800 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Remove Duplicate Rows</p>
                                    <p class="text-sm text-gray-600">Automatically removes exact duplicate rows, keeping only the first occurrence. Duplicates are highlighted in the preview so you can review before removing.</p>
                                </div>
                                <div>
                                    <p class="text-base text-gray-800 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Clean Whitespace</p>
                                    <p class="text-sm text-gray-600">Trims leading/trailing spaces and normalizes multiple spaces to single spaces across all cells for consistent formatting.</p>
                                </div>
                                <div>
                                    <p class="text-base text-gray-800 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Include "Issues" Column</p>
                                    <p class="text-sm text-gray-600">Adds an "Issues" column that lists any fields that still need attention. This helps you quickly identify which rows may require manual review after downloading.</p>
                                </div>
                                <div>
                                    <p class="text-base text-gray-800 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Export Only Rows With Issues (Optional)</p>
                                    <p class="text-sm text-gray-600">When enabled, you'll download <strong>only</strong> the rows that have validation issues (instead of the complete cleaned file). Perfect for creating a focused review file that you can fix manually and merge back into your main dataset.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Important Warning -->
                        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-base text-red-900 font-semibold mb-1">Important: Download and Save Your File</p>
                                    <p class="text-sm text-red-800">
                                        Your cleaned data is only available in your browser session. <strong>Once you close the browser tab or refresh the page, your cleaned data will be gone.</strong> We don't store files on our servers - make sure to download and save your cleaned file immediately after processing!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Features -->
        <div class="mt-16 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">100% Private</h3>
                        <p class="text-gray-600 text-base">All processing happens in your browser. Your data never leaves your device.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">GDPR Compliant</h3>
                        <p class="text-gray-600 text-base">We're not a data processor - you maintain full control and compliance.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Format Conversion</h3>
                        <p class="text-gray-600 text-base">Upload CSV, download Excel. Upload Excel, download JSON. We support format conversion.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Instant Processing</h3>
                        <p class="text-gray-600 text-base">No upload wait times, no network bottlenecks. Process instantly in your browser.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learn More Section -->
        <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Want More Details?</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Check out our comprehensive documentation for detailed guides, visual examples, troubleshooting tips, and advanced features.
            </p>
            <a href="/documentation.php" class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg font-medium mr-4">
                View Full Documentation
            </a>
        </div>

        <!-- CTA -->
        <div class="mt-12 text-center">
            <a href="/register.php" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl font-semibold text-lg">
                Get Started Free
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
