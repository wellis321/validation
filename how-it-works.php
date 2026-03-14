<?php
require_once __DIR__ . '/includes/init.php';

// Set page meta
$pageTitle = 'How It Works - UK Data Cleaning Tool | Browser-Based Processing';
$pageDescription = 'Learn how Simple Data Cleaner works - upload your file, clean UK data formats in your browser, and download in any format. 100% private, GDPR compliant, no data leaves your device. Perfect for UK businesses.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/how-it-works.php">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="UK data cleaning how it works, browser-based data validation, GDPR compliant data cleaning process, UK data validation tool, clean UK phone numbers postcodes NI numbers">
    
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
          "text": "Upload your CSV, Excel (.xlsx, .xls), or JSON file containing UK phone numbers, National Insurance numbers, postcodes, bank sort codes, bank account numbers, email addresses, or full names.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step1"
        },
        {
          "@type": "HowToStep",
          "position": 2,
          "name": "Select Columns to Clean",
          "text": "Choose which columns you want to clean. Use Auto-Select for automatic detection, or manually select columns. For full name columns, you can choose to split them into title, first_name, and last_name. Select your preferred phone number format (International or UK).",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step2"
        },
        {
          "@type": "HowToStep",
          "position": 3,
          "name": "Review and Process",
          "text": "Review your selections and click 'Clean My Data' to process. All validation happens in your browser - your data never leaves your device. View comprehensive reports including Full Preview, Issues Report, and Cleaned Report.",
          "url": "https://simple-data-cleaner.com/how-it-works.php#step3"
        },
        {
          "@type": "HowToStep",
          "position": 4,
          "name": "Download Cleaned Data",
          "text": "Customise your export options (format, remove duplicates, trim whitespace, include issues column, export only rows with issues, remove original name columns) and download your validated and cleaned data in CSV, Excel, or JSON format.",
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
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <header class="ds-scroll-reveal text-center mb-16 max-w-3xl mx-auto">
            <h1 class="ds-reveal-item text-4xl font-bold text-white mb-4">How It Works</h1>
            <p class="ds-reveal-item text-xl text-neutral-400">
                Clean your UK data in 4 simple steps. Everything happens in your browser — your data never leaves your device.
            </p>
        </header>

        <!-- Steps -->
        <div class="ds-scroll-reveal space-y-6 max-w-4xl mx-auto">
            <!-- Step 1 -->
            <div class="ds-reveal-item hiw-step-card flex gap-5 group">
                <span class="hiw-step-num flex-shrink-0 w-12 h-12 rounded-none bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold text-lg ring-1 ring-yellow-500/25" aria-hidden="true">1</span>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl font-bold text-white mb-3">Upload Your File</h2>
                    <p class="text-neutral-300 mb-4">
                        Upload your CSV, Excel (.xlsx, .xls), or JSON file containing UK phone numbers, National Insurance numbers, postcodes, bank sort codes, bank account numbers, email addresses, or full names.
                    </p>
                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                        <p class="text-base text-neutral-200">
                            <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Tip:</strong> We support files up to several hundred MB, depending on your browser and device memory. All processing happens in your browser, so larger files may take a bit longer.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="ds-reveal-item hiw-step-card flex gap-5 group">
                <span class="hiw-step-num flex-shrink-0 w-12 h-12 rounded-none bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold text-lg ring-1 ring-yellow-500/25" aria-hidden="true">2</span>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl font-bold text-white mb-3">Select Columns to Clean</h2>
                    <p class="text-neutral-300 mb-4">
                        Choose which columns you want to clean. Our system can automatically detect phone numbers, NI numbers, postcodes, sort codes, bank account numbers, email addresses, and full names, or you can manually select the columns.
                    </p>
                    <div class="space-y-3">
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg> Auto-Select:</strong> Click "Auto-Select" to have our system automatically detect and select all cleanable columns based on column names and content. For full name columns, it will also suggest name splitting.
                            </p>
                        </div>
                        <div class="bg-pink-500/10 border border-pink-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-pink-400"><svg class="inline w-5 h-5 text-pink-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Name Splitting:</strong> For full name columns, you can choose to split them into separate `title`, `first_name`, and `last_name` columns. The system automatically extracts titles (Mr, Mrs, Dr, etc.) and handles name suffixes (like Jr., Sr., II, III) that appear after the last name.
                            </p>
                        </div>
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg> Phone Number Format:</strong> Choose between International format (+44) or UK format (0) for phone number output. This applies to all phone and mobile columns you select.
                            </p>
                        </div>
                        <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-green-400"><svg class="inline w-5 h-5 text-green-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Protected Columns:</strong> ID and key columns (like customer_id, order_number) are automatically protected and will never be modified - preserving your data relationships.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="ds-reveal-item hiw-step-card flex gap-5 group">
                <span class="hiw-step-num flex-shrink-0 w-12 h-12 rounded-none bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold text-lg ring-1 ring-yellow-500/25" aria-hidden="true">3</span>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl font-bold text-white mb-3">Process in Your Browser</h2>
                    <p class="text-neutral-300 mb-4">
                        Click "Clean My Data" and watch as your data is validated and cleaned instantly - all in your browser. We never see, store, or transmit your data. It's 100% private.
                    </p>
                    <div class="space-y-3">
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Privacy First:</strong> Your file is processed entirely in your browser using JavaScript. No uploads to our servers, no database storage, no third-party access.
                            </p>
                        </div>
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Data Insights:</strong> Get instant insights including missing values count, duplicate row detection, and data quality profiling before you download.
                            </p>
                        </div>
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-base text-neutral-200">
                                <strong class="text-yellow-400"><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Comprehensive Reports:</strong> Access three detailed HTML reports: <strong>Full Preview</strong> (complete dataset with colour coding), <strong>Issues Report</strong> (invalid values with explanations), and <strong>Cleaned Report</strong> (all cleaned values with before/after). All reports persist on page refresh.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="ds-reveal-item hiw-step-card flex gap-5 group">
                <span class="hiw-step-num flex-shrink-0 w-12 h-12 rounded-none bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold text-lg ring-1 ring-yellow-500/25" aria-hidden="true">4</span>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl font-bold text-white mb-3">Download Your Cleaned Data</h2>
                    <p class="text-neutral-300 mb-4">
                        Review the complete cleaned dataset with our Full Preview feature, customise your download options, and export with confidence knowing exactly what you're getting.
                    </p>

                    <div class="space-y-4">
                        <!-- Full Preview Feature -->
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-sm font-semibold text-yellow-400 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Full Preview - See Everything Before Download:
                            </p>
                            <ul class="text-base text-neutral-300 space-y-1 ml-7">
                                <li>• View your complete cleaned dataset with all rows and columns</li>
                                <li>• <strong class="text-amber-400">Amber rows</strong> = Original rows that have duplicates elsewhere</li>
                                <li>• <strong class="text-yellow-400">Yellow rows</strong> = Duplicate rows (removable via checkbox)</li>
                                <li>• <strong class="text-green-400">Green cells</strong> = Values that were cleaned or fixed</li>
                                <li>• <strong class="text-red-400">Red cells</strong> = Invalid values detected but cannot be cleaned (require manual correction)</li>
                                <li>• <svg class="inline w-4 h-4 text-yellow-500 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Protected columns (IDs, keys) are marked and never modified</li>
                            </ul>
                        </div>

                        <!-- Format Selection -->
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                            <p class="text-sm font-semibold text-yellow-400 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Select Your Download Format:
                            </p>
                            <ul class="text-base text-neutral-300 space-y-1 ml-7">
                                <li>• <strong>CSV</strong> - Comma Separated Values (great for spreadsheets)</li>
                                <li>• <strong>Excel (.xlsx)</strong> - Native Excel format (ready to open in Excel)</li>
                                <li>• <strong>JSON</strong> - Structured data format (perfect for developers)</li>
                            </ul>
                            <p class="text-sm text-neutral-400 mt-2 ml-7">
                                <strong class="text-neutral-200">Format Conversion:</strong> Upload in CSV? Download as Excel or JSON. Upload in Excel? Download as CSV or JSON. We support complete format conversion!
                            </p>
                        </div>

                        <!-- Export Options -->
                        <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                            <p class="text-sm font-semibold text-white mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Export Customisation Options:
                            </p>
                            <div class="space-y-3 ml-7">
                                <div>
                                    <p class="text-base text-neutral-200 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Remove Duplicate Rows</p>
                                    <p class="text-base text-neutral-400">Automatically removes exact duplicate rows, keeping only the first occurrence. Duplicates are highlighted in the preview so you can review before removing.</p>
                                </div>
                                <div>
                                    <p class="text-base text-neutral-200 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Clean Whitespace</p>
                                    <p class="text-base text-neutral-400">Trims leading/trailing spaces and normalizes multiple spaces to single spaces across all cells for consistent formatting.</p>
                                </div>
                                <div>
                                    <p class="text-base text-neutral-200 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Include "Issues" Column</p>
                                    <p class="text-base text-neutral-400">Adds an "Issues" column that lists any fields that still need attention. This helps you quickly identify which rows may require manual review after downloading.</p>
                                </div>
                                <div>
                                    <p class="text-base text-neutral-200 font-medium flex items-center gap-2"><svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Export Only Rows With Issues (Optional)</p>
                                    <p class="text-base text-neutral-400">When enabled, you'll download <strong>only</strong> the rows that have validation issues (instead of the complete cleaned file). Perfect for creating a focused review file that you can fix manually and merge back into your main dataset.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Important Warning -->
                        <div class="bg-red-500/10 border-2 border-red-500/40 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-base text-red-300 font-semibold mb-1">Important: Download and Save Your File</p>
                                    <p class="text-sm text-red-200/90">
                                        Your cleaned data is only available in your browser session. <strong class="text-red-200">Once you close the browser tab or refresh the page, your cleaned data will be gone.</strong> We don't store files on our servers - make sure to download and save your cleaned file immediately after processing!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Features -->
        <div class="ds-scroll-reveal mt-16 ds-card p-8 max-w-4xl mx-auto">
            <h2 class="ds-reveal-item text-2xl font-bold text-white mb-6 text-center">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="ds-reveal-item flex items-start gap-4">
                    <span class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-white mb-2">100% Private</h3>
                        <p class="text-neutral-400 text-base">All processing happens in your browser. Your data never leaves your device.</p>
                    </div>
                </div>
                <div class="ds-reveal-item flex items-start gap-4">
                    <span class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center border border-green-500/20">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-white mb-2">GDPR Compliant</h3>
                        <p class="text-neutral-400 text-base">We're not a data processor - you maintain full control and compliance.</p>
                    </div>
                </div>
                <div class="ds-reveal-item flex items-start gap-4">
                    <span class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-white mb-2">Format Conversion</h3>
                        <p class="text-neutral-400 text-base">Upload CSV, download Excel. Upload Excel, download JSON. We support format conversion.</p>
                    </div>
                </div>
                <div class="ds-reveal-item flex items-start gap-4">
                    <span class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-white mb-2">Instant Processing</h3>
                        <p class="text-neutral-400 text-base">No upload wait times, no network bottlenecks. Process instantly in your browser.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learn More Section -->
        <div class="ds-scroll-reveal mt-16 bg-neutral-900 rounded-2xl border border-neutral-700 p-8 md:p-10 text-center">
            <h2 class="ds-reveal-item text-2xl font-bold text-white mb-3">Want More Details?</h2>
            <p class="ds-reveal-item text-neutral-400 mb-6 max-w-2xl mx-auto">
                Check out our comprehensive documentation for detailed guides, visual examples, troubleshooting tips, and advanced features.
            </p>
            <a href="/documentation.php" class="ds-reveal-item ds-btn-primary inline-block px-6 py-2.5 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                View Full Documentation
            </a>
        </div>

        <!-- CTA -->
        <div class="ds-scroll-reveal mt-12 text-center">
            <a href="/register.php" class="ds-btn-primary inline-block px-8 py-3 rounded-lg font-semibold text-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                Get Started Free
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
