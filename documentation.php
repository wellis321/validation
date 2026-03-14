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
            white-space: pre-wrap;
        }

        /* Colour swatch styles */
        .color-swatch {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 0.25rem;
            vertical-align: middle;
            margin-right: 0.5rem;
        }

        /* FAQ accordion – details/summary with smooth expand */
        .ds-faq-item {
            border: 1px solid rgba(64, 64, 64, 0.8);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .ds-faq-item:hover {
            border-color: rgba(82, 82, 82, 0.9);
        }
        .ds-faq-item[open] {
            border-color: rgba(234, 179, 8, 0.4);
            box-shadow: 0 0 0 1px rgba(234, 179, 8, 0.15);
        }
        .ds-faq-item summary {
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: #fafafa;
            cursor: pointer;
            list-style: none;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            transition: background-color 0.2s ease;
        }
        .ds-faq-item summary::-webkit-details-marker { display: none; }
        .ds-faq-item summary::before {
            content: '';
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.15rem;
            border: 2px solid rgba(234, 179, 8, 0.6);
            border-radius: 0.25rem;
            background: transparent;
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1), background-color 0.2s ease;
        }
        .ds-faq-item[open] summary::before {
            transform: rotate(90deg);
            background: rgba(234, 179, 8, 0.2);
        }
        .ds-faq-item summary:hover {
            background: rgba(255, 255, 255, 0.03);
        }
        .ds-faq-item .ds-faq-answer {
            padding: 0.75rem 1.25rem 1.25rem 2.5rem;
            font-size: 0.875rem;
            color: #a3a3a3;
            line-height: 1.6;
        }
        @media (prefers-reduced-motion: reduce) {
            .ds-faq-item summary::before { transition: none; }
        }
    </style>
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <header class="ds-scroll-reveal text-center mb-12">
            <h1 class="ds-reveal-item text-4xl md:text-5xl font-bold text-white mb-4">Documentation</h1>
            <p class="ds-reveal-item text-xl text-neutral-400 max-w-3xl mx-auto">
                Everything you need to know about Simple Data Cleaner.<br class="hidden sm:inline"> Clean and validate your UK data.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Table of Contents (Sidebar) -->
            <aside class="lg:col-span-1">
                <nav class="sticky-toc ds-card p-6 ds-scroll-reveal" aria-label="Table of contents">
                    <h3 class="ds-reveal-item text-sm font-semibold uppercase tracking-wider text-neutral-500 mb-4">Contents</h3>
                    <ul class="space-y-0.5" role="list">
                        <li class="ds-reveal-item"><a href="#getting-started" class="doc-toc-link">Getting Started</a></li>
                        <li class="ds-reveal-item"><a href="#interactive-example" class="doc-toc-link">Interactive Example</a></li>
                        <li class="ds-reveal-item"><a href="#supported-formats" class="doc-toc-link">Supported Formats</a></li>
                        <li class="ds-reveal-item"><a href="#upload-process" class="doc-toc-link">Upload Process</a></li>
                        <li class="ds-reveal-item"><a href="#field-selection" class="doc-toc-link">Field Selection</a></li>
                        <li class="ds-reveal-item"><a href="#protected-columns" class="doc-toc-link">Protected Columns</a></li>
                        <li class="ds-reveal-item"><a href="#data-profiling" class="doc-toc-link">Data Profiling</a></li>
                        <li class="ds-reveal-item"><a href="#full-preview" class="doc-toc-link">Full Preview</a></li>
                        <li class="ds-reveal-item"><a href="#color-coding" class="doc-toc-link">Colour Coding System</a></li>
                        <li class="ds-reveal-item"><a href="#duplicate-handling" class="doc-toc-link">Duplicate Handling</a></li>
                        <li class="ds-reveal-item"><a href="#export-options" class="doc-toc-link">Export Options</a></li>
                        <li class="ds-reveal-item"><a href="#validation-rules" class="doc-toc-link">Validation Rules</a></li>
                        <li class="ds-reveal-item"><a href="#troubleshooting" class="doc-toc-link">Troubleshooting</a></li>
                        <li class="ds-reveal-item"><a href="#faq" class="doc-toc-link">FAQ</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-12">

                <!-- Getting Started -->
                <section id="getting-started" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Getting Started</h2>
                    <div class="prose max-w-none">
                        <p class="text-neutral-300 mb-4">
                            Simple Data Cleaner helps you validate and clean UK data formats including phone numbers, National Insurance numbers, postcodes, bank sort codes, and email addresses. The entire process happens in your browser - your data never leaves your device.
                        </p>

                        <h3 class="text-xl font-semibold text-white mt-6 mb-3">Quick Start:</h3>
                        <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                            <li>Upload your CSV, Excel (.xlsx/.xls), or JSON file</li>
                            <li>Select which columns contain UK data to clean (or use Auto-Select)</li>
                            <li>Click "Clean My Data" to process</li>
                            <li>Review results in the Full Preview tab</li>
                            <li>Customise export options (format, duplicates, whitespace)</li>
                            <li>Download your cleaned file</li>
                        </ol>

                        <div class="bg-yellow-500/10 border-l-4 border-yellow-500 p-4 mt-6">
                            <p class="text-sm text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Pro Tip:</strong> Always use the Full Preview feature before downloading to ensure the cleaning results match your expectations.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Interactive Example -->
                <section id="interactive-example" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Interactive Example</h2>
                    <div class="prose max-w-none">
                        <p class="text-neutral-300 mb-4">
                            Want to try Simple Data Cleaner without uploading your own file? Visit our <a href="/example.php" class="text-yellow-400 hover:text-yellow-300 underline">Interactive Example page</a> to explore the tool with pre-loaded sample data.
                        </p>

                        <h3 class="text-xl font-semibold text-white mt-6 mb-3">What's Included in the Example:</h3>
                        <p class="text-neutral-300 mb-4">The example dataset includes 23 rows with various UK data formats, including:</p>
                        <ul class="list-disc list-inside space-y-2 text-neutral-300 ml-4 mb-6">
                            <li><strong>Names with titles:</strong> "Mr. John Smith", "Mrs. Jane Doe", "Dr. Bob Johnson" - perfect for testing name splitting</li>
                            <li><strong>Email addresses:</strong> Valid emails and columns for testing email cleaning (trim, typo fixes, format validation)</li>
                            <li><strong>Phone numbers:</strong> Various formats (international, UK mobile, landline) - some valid, some invalid</li>
                            <li><strong>Postcodes:</strong> Different formats (lowercase, no spaces, with spaces) that will be cleaned to standard UK format</li>
                            <li><strong>Sort codes:</strong> Various formats (no dashes, with spaces, with dots) that will be cleaned to XX-XX-XX format</li>
                            <li><strong>Bank account numbers:</strong> 8-digit account numbers that will be validated and formatted</li>
                            <li><strong>National Insurance numbers:</strong> Valid and invalid examples</li>
                            <li><strong>Duplicate rows:</strong> Rows 21-23 are duplicates of rows 1-3, perfect for testing duplicate detection</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-white mt-6 mb-3">How to Use the Example Page:</h3>
                        <ol class="list-decimal list-inside space-y-3 text-neutral-300 ml-4 mb-6">
                            <li><strong>Load Example Data:</strong> Click the "Load Example Data" button to automatically load the sample dataset</li>
                            <li><strong>Select Columns:</strong> Use "Auto-Select" to automatically detect cleanable columns, or manually select which fields to clean</li>
                            <li><strong>Choose Phone Format:</strong> Select whether you want phone numbers formatted as International (+44) or UK (0) format</li>
                            <li><strong>Clean the Data:</strong> Click "Clean My Data" to process the example file</li>
                            <li><strong>Explore Results:</strong>
                                <ul class="list-disc list-inside ml-6 mt-2 space-y-1">
                                    <li>View the <strong>Summary</strong> tab to see statistics</li>
                                    <li>Check the <strong>Full Preview</strong> tab to see all cleaned data with green highlighting for modified cells</li>
                                    <li>Open the <strong>Full Preview Report</strong> for a detailed HTML view</li>
                                    <li>View the <strong>Cleaned</strong> tab to see what was fixed (emails, postcodes, sort codes, names split, etc.)</li>
                                    <li>Check the <strong>Issues</strong> tab to see validation errors</li>
                                </ul>
                            </li>
                            <li><strong>Export Options:</strong> Customise your download format (CSV, Excel, JSON) and options (remove duplicates, trim whitespace, export only rows with issues)</li>
                            <li><strong>Download:</strong> Download the cleaned file to see the results</li>
                            <li><strong>Reset Demo:</strong> Click "Reset Demo" to clear all data and start over - perfect for trying different cleaning options</li>
                        </ol>

                        <div class="bg-green-500/10 border-l-4 border-green-500 p-4 mt-6">
                            <p class="text-base text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-green-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Perfect for Learning:</strong> The example data is specifically designed to demonstrate all features. You'll see emails cleaned (typos fixed, case normalised), postcodes cleaned from lowercase to uppercase, sort codes formatted from various formats to XX-XX-XX, names split into title/first_name/last_name, and duplicate rows highlighted.
                            </p>
                        </div>

                        <div class="bg-yellow-500/10 border-l-4 border-yellow-500 p-4 mt-6">
                            <p class="text-base text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Reset Demo Button:</strong> The "Reset Demo" button clears all loaded data and results, allowing you to start fresh and try different cleaning options. This is especially useful for experimenting with different field selections, phone number formats, and export options without having to reload the page.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Supported Formats -->
                <section id="supported-formats" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Supported File Formats</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- CSV -->
                        <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">CSV</h3>
                            </div>
                            <p class="text-sm text-neutral-400 mb-2">Comma Separated Values</p>
                            <ul class="text-sm text-neutral-400 space-y-1">
                                <li>• Extension: .csv</li>
                                <li>• Universal compatibility</li>
                                <li>• Best for spreadsheets</li>
                            </ul>
                        </div>

                        <!-- Excel -->
                        <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">Excel</h3>
                            </div>
                            <p class="text-sm text-neutral-400 mb-2">Microsoft Excel Format</p>
                            <ul class="text-sm text-neutral-400 space-y-1">
                                <li>• Extensions: .xlsx, .xls</li>
                                <li>• Native Excel format</li>
                                <li>• Preserves formatting</li>
                            </ul>
                        </div>

                        <!-- JSON -->
                        <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">JSON</h3>
                            </div>
                            <p class="text-sm text-neutral-400 mb-2">JavaScript Object Notation</p>
                            <ul class="text-sm text-neutral-400 space-y-1">
                                <li>• Extension: .json</li>
                                <li>• Perfect for developers</li>
                                <li>• Structured data format</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                        <p class="text-sm text-neutral-200">
                            <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg> Format Conversion:</strong> Upload in any format, download in any format. For example, upload a CSV file and download as Excel or JSON!
                        </p>
                    </div>
                </section>

                <!-- Upload Process -->
                <section id="upload-process" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Upload Process</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">File Size Limits</h3>
                            <p class="text-neutral-300 mb-3">File size limits depend on your browser and device memory:</p>
                            <ul class="list-disc list-inside space-y-1 text-neutral-300 ml-4">
                                <li><strong>Free users:</strong> Files up to several hundred MB</li>
                                <li><strong>Premium users:</strong> Larger files supported (browser-dependent)</li>
                                <li>Processing time increases with file size</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">File Requirements</h3>
                            <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                                <ul class="space-y-2 text-sm text-neutral-300">
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
                            <h3 class="text-xl font-semibold text-white mb-3">Privacy Guarantee</h3>
                            <div class="bg-green-500/10 border-l-4 border-green-500 p-4">
                                <p class="text-sm text-neutral-200">
                                    <strong><svg class="inline w-5 h-5 text-green-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> 100% Private:</strong> Your file is processed entirely in your browser using JavaScript. No data is transmitted to our servers, stored in any database, or accessed by third parties. We never see your data.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Field Selection -->
                <section id="field-selection" class="ds-card p-8 ds-scroll-reveal">
                    <h2 class="ds-reveal-item text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Field Selection</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Supported UK Data Types</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg> Phone Numbers</h4>
                                    <p class="text-sm text-neutral-400 mb-2">UK mobile and landline numbers</p>
                                    <div class="text-sm text-neutral-400">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>07123456789</li>
                                            <li>+44 7123 456789</li>
                                            <li>0207 123 4567</li>
                                            <li>(020) 7123 4567</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg> National Insurance</h4>
                                    <p class="text-sm text-neutral-400 mb-2">UK NI numbers</p>
                                    <div class="text-sm text-neutral-400">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>AB123456C</li>
                                            <li>AB 12 34 56 C</li>
                                            <li>ab-123456-c</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg> Postcodes</h4>
                                    <p class="text-sm text-neutral-400 mb-2">UK postal codes</p>
                                    <div class="text-sm text-neutral-400">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>SW1A 1AA</li>
                                            <li>sw1a1aa</li>
                                            <li>M1 1AA</li>
                                            <li>EC1A 1BB</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg> Sort Codes</h4>
                                    <p class="text-sm text-neutral-400 mb-2">UK bank sort codes</p>
                                    <div class="text-sm text-neutral-400">
                                        <p class="font-medium mb-1">Accepts:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>12-34-56</li>
                                            <li>123456</li>
                                            <li>12 34 56</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="md:col-span-2 border border-pink-500/30 rounded-lg p-4 bg-pink-500/10">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Full Names (Split)</h4>
                                    <p class="text-sm text-neutral-400 mb-2">Split full names into separate columns</p>
                                    <div class="text-sm text-neutral-400">
                                        <p class="font-medium mb-1">Creates:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>title (Mr, Mrs, Dr, etc.)</li>
                                            <li>first_name</li>
                                            <li>last_name</li>
                                        </ul>
                                        <p class="font-medium mt-2 mb-1">Example:</p>
                                        <ul class="list-disc list-inside ml-2">
                                            <li>"Mr. John Smith" → title: "Mr", first_name: "John", last_name: "Smith"</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ds-reveal-item hiw-step-card ds-hover-lift flex items-start gap-5 p-6" style="animation-delay: 0.08s;">
                            <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20" aria-hidden="true">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" /></svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-semibold text-white mb-2">Auto-Select</h3>
                                <p class="text-neutral-400 mb-3">
                                    One click and we&rsquo;ll detect your cleanable columns. Click the &ldquo;Auto-Select&rdquo; button and we analyse:
                                </p>
                                <ul class="list-disc list-inside space-y-1.5 text-neutral-300 text-sm md:text-base">
                                    <li><strong class="text-neutral-200">Column names</strong> — Matches keywords like "phone", "mobile", "postcode", "ni_number", "sort_code", "email", "e-mail", "name", "full_name"</li>
                                    <li><strong class="text-neutral-200">Data content</strong> — Sample values to identify UK patterns and name formats</li>
                                    <li><strong class="text-neutral-200">Smart suggestions</strong> — Recommends the right data type for each column, including name splitting where needed</li>
                                </ul>
                            </div>
                        </div>

                        <div class="ds-reveal-item hiw-step-card ds-hover-lift flex items-start gap-5 p-6" style="animation-delay: 0.16s;">
                            <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-neutral-700/60 flex items-center justify-center border border-neutral-600" aria-hidden="true">
                                <svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-semibold text-white mb-2">Manual Selection</h3>
                                <p class="text-neutral-400 mb-3">
                                    Prefer full control? Pick columns and validation types yourself:
                                </p>
                                <ol class="list-decimal list-inside space-y-2 text-neutral-300 text-sm md:text-base">
                                    <li>Check the box next to each column you want to clean</li>
                                    <li>Select the data type from the dropdown (Phone, NI Number, Postcode, Sort Code, Email)</li>
                                    <li>For name columns, check &ldquo;Split into first_name and last_name&rdquo; to split full names</li>
                                    <li>We validate and clean based on your selection</li>
                                </ol>
                                <div class="bg-pink-500/10 border-l-4 border-pink-500 p-4 mt-4 rounded-r-lg">
                                    <p class="text-sm text-neutral-200">
                                        <strong><svg class="inline w-5 h-5 text-pink-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Name Splitting:</strong> When you select a name column for splitting, it creates three new columns: <code class="bg-neutral-800 px-1.5 py-0.5 rounded">title</code>, <code class="bg-neutral-800 px-1.5 py-0.5 rounded">first_name</code>, and <code class="bg-neutral-800 px-1.5 py-0.5 rounded">last_name</code>. The original name column is preserved unless you choose to remove it during export.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Protected Columns -->
                <section id="protected-columns" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Protected Columns</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-neutral-300 mb-4">
                                Protected columns are automatically detected and <strong>never modified</strong> during the cleaning process. This ensures your data relationships and unique identifiers remain intact.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">What Gets Protected?</h3>
                            <p class="text-neutral-300 mb-3">Columns matching these patterns are automatically protected:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>id</code>
                                </div>
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>*_id</code>
                                </div>
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>*_key</code>
                                </div>
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>pk</code>
                                </div>
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>*_number</code>
                                </div>
                                <div class="bg-neutral-800/60 border border-neutral-600 rounded px-3 py-2 text-sm text-neutral-300">
                                    <code>reference</code>
                                </div>
                            </div>
                            <p class="text-sm text-neutral-400 mt-3">
                                Examples: customer_id, order_number, transaction_key, account_id, reference_code
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Visual Indicators</h3>
                            <ul class="space-y-2 text-neutral-300">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-neutral-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Protected columns show a lock icon in the field selection area</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-neutral-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span>Lock icon appears in the Full Preview table headers</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-neutral-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span>Listed in the download summary under "Protected Columns"</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-yellow-500/10 border-l-4 border-yellow-500 p-4">
                            <p class="text-sm text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Why Protected?</strong> ID and key columns often contain unique identifiers, order numbers, or reference codes that have specific meaning in your systems. Modifying these could break data relationships or cause integration issues.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Data Profiling -->
                <section id="data-profiling" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Data Profiling</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-neutral-300 mb-4">
                                After processing your file, you'll see a Data Profiling section with key insights about your data quality:
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <h4 class="font-semibold text-white">Missing Values</h4>
                                </div>
                                <p class="text-sm text-neutral-400">Count of empty or null cells across all columns</p>
                            </div>

                            <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h4 class="font-semibold text-white">Duplicate Rows</h4>
                                </div>
                                <p class="text-sm text-neutral-400">Count of exact duplicate rows found in your data</p>
                            </div>

                            <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="font-semibold text-white">Unique Rows</h4>
                                </div>
                                <p class="text-sm text-neutral-400">Count of unique rows (total minus duplicates)</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Missing Values by Column</h3>
                            <p class="text-neutral-300 mb-3">
                                If your file has missing values, you'll see a detailed breakdown table showing:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-neutral-300 ml-4">
                                <li>Which columns have missing data</li>
                                <li>Count of missing values per column</li>
                                <li>Percentage of rows affected</li>
                            </ul>
                            <p class="text-sm text-neutral-400 mt-3">
                                This helps you identify data quality issues and decide if you need to fill in missing values before using the data.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Full Preview -->
                <section id="full-preview" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Full Preview Feature</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-neutral-300 mb-4">
                                The Full Preview tab shows you <strong>exactly</strong> what your downloaded file will contain. This gives you complete confidence before downloading.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">What You'll See:</h3>
                            <ul class="space-y-2 text-neutral-300">
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
                                    <span><strong>Colour coding</strong> to highlight changes and issues</span>
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

                        <div class="bg-yellow-500/10 border-l-4 border-yellow-500 p-4">
                            <p class="text-base text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Preview Benefits:</strong> The Full Preview eliminates surprises. You can verify the cleaning results, check for any issues, and ensure the output matches your expectations before committing to a download.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Full Preview HTML Report</h3>
                            <p class="text-neutral-300 mb-3">
                                In addition to viewing the preview in the tab, you can open a dedicated HTML report page for a better viewing experience:
                            </p>
                            <ol class="list-decimal list-inside space-y-2 text-neutral-300 ml-4">
                                <li>After processing your file, go to the <strong>"Full Preview"</strong> tab</li>
                                <li>Click the <strong>"View Full Preview Report"</strong> button</li>
                                <li>A comprehensive HTML report opens in a new page with the complete cleaned dataset</li>
                                <li>The report includes highlighting for duplicate rows and modified cells</li>
                                <li>You can print or bookmark this report page for easy reference</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Colour Coding System -->
                <section id="color-coding" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Colour Coding System</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-neutral-300 mb-4">
                                The Full Preview uses a colour coding system to help you quickly identify different types of data and changes:
                            </p>
                        </div>

                        <div class="space-y-4">
                            <!-- Amber Rows -->
                            <div class="border-l-4 border-yellow-500 bg-yellow-500/10 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-yellow-500/30 border-2 border-yellow-500"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-neutral-200 mb-1">Amber Rows</h4>
                                        <p class="text-sm text-neutral-200 mb-2">Original rows that have duplicates elsewhere in the file</p>
                                        <div class="bg-amber-100 rounded px-2 py-1 inline-block text-xs font-medium text-amber-950">
                                            Badge: "HAS DUPLICATES"
                                        </div>
                                        <p class="text-sm text-neutral-200 mt-2">
                                            <strong>Meaning:</strong> This is the first occurrence - it will be kept even if "Remove duplicates" is checked
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Yellow Rows -->
                            <div class="border-l-4 border-amber-400 bg-amber-500/10 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-amber-500/30 border-2 border-amber-400"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-neutral-200 mb-1">Yellow Rows</h4>
                                        <p class="text-sm text-neutral-200 mb-2">Duplicate rows (exact copies of earlier rows)</p>
                                        <div class="bg-amber-200 rounded px-2 py-1 inline-block text-xs font-medium text-amber-950">
                                            Badge: "DUPLICATE"
                                        </div>
                                        <p class="text-sm text-neutral-300 mt-2">
                                            <strong>Meaning:</strong> This row will be removed if you check "Remove duplicate rows"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Green Cells -->
                            <div class="border-l-4 border-green-400 bg-green-500/10 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-green-500/30 border-2 border-green-400"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-neutral-200 mb-1">Green Cells</h4>
                                        <p class="text-sm text-neutral-200 mb-2">Individual cells that were cleaned, validated, or fixed</p>
                                        <p class="text-sm text-neutral-300 mt-2">
                                            <strong>Meaning:</strong> This specific value was modified by the validation process (e.g., phone number formatted to +44 format)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- White/Gray Rows -->
                            <div class="border-l-4 border-neutral-500 bg-neutral-800/60 rounded-r-lg p-4">
                                <div class="flex items-start gap-3">
                                    <div class="color-swatch bg-neutral-600 border-2 border-neutral-500"></div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-white mb-1">White/Gray Rows</h4>
                                        <p class="text-sm text-neutral-300 mb-2">Normal rows with no duplicates (alternating white and light gray for readability)</p>
                                        <p class="text-sm text-neutral-400 mt-2">
                                            <strong>Meaning:</strong> Standard row with no special status
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                            <h4 class="font-semibold text-white mb-2">Example Preview:</h4>
                            <div class="text-xs space-y-1 font-mono text-neutral-300">
                                <div class="p-2 bg-neutral-800/60 border-l-2 border-neutral-600">Row 1: John Doe | <span class="bg-green-500/30 px-1">+44 7123 456789</span> ← Normal row, phone cleaned (green)</div>
                                <div class="p-2 bg-neutral-800/40 border-l-2 border-neutral-600">Row 2: Jane Smith | [empty] ← Normal row</div>
                                <div class="p-2 bg-yellow-500/10 border-l-4 border-yellow-500"><span class="bg-amber-400/80 px-1 text-amber-950 text-xs font-medium rounded">HAS DUPLICATES</span> Row 3: Bob Johnson | <span class="bg-green-500/30 px-1">+44 7987 654321</span> ← Amber (has duplicate at row 6)</div>
                                <div class="p-2 bg-amber-500/10 border-l-4 border-amber-400"><span class="bg-amber-400/80 px-1 text-amber-950 text-xs font-medium rounded">DUPLICATE</span> Row 4: John Doe | <span class="bg-green-500/30 px-1">+44 7123 456789</span> ← Yellow (duplicate of row 1)</div>
                                <div class="p-2 bg-neutral-800/60 border-l-2 border-neutral-600">Row 5: Alice Brown | <span class="bg-green-500/30 px-1">+44 7111 111111</span> ← Normal row</div>
                                <div class="p-2 bg-amber-500/10 border-l-4 border-amber-400"><span class="bg-amber-400/80 px-1 text-amber-950 text-xs font-medium rounded">DUPLICATE</span> Row 6: Bob Johnson | <span class="bg-green-500/30 px-1">+44 7987 654321</span> ← Yellow (duplicate of row 3)</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Duplicate Handling -->
                <section id="duplicate-handling" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Duplicate Row Handling</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">How Duplicates Are Detected</h3>
                            <p class="text-neutral-300 mb-3">
                                The system identifies <strong>exact duplicate rows</strong> by comparing all column values:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-neutral-300 ml-4">
                                <li>Two rows are duplicates if <strong>all</strong> column values match exactly</li>
                                <li>The first occurrence is considered the "original"</li>
                                <li>Subsequent identical rows are marked as "duplicates"</li>
                                <li>Case-sensitive comparison (unless cleaned values are used)</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Removal Options</h3>
                            <p class="text-neutral-300 mb-3">
                                In the Export Options section, you'll find a checkbox: <strong>"Remove Duplicate Rows (Keep First Occurrence)"</strong>
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" /></svg> Checked (Remove)</h4>
                                    <ul class="text-sm text-neutral-300 space-y-1">
                                        <li>• Only first occurrence kept</li>
                                        <li>• Duplicate rows excluded from download</li>
                                        <li>• Row count reduced</li>
                                        <li>• Data relationships preserved</li>
                                    </ul>
                                </div>
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <h4 class="font-semibold text-white mb-2 flex items-center gap-2"><svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Unchecked (Keep All)</h4>
                                    <ul class="text-sm text-neutral-300 space-y-1">
                                        <li>• All rows included in download</li>
                                        <li>• Both originals and duplicates kept</li>
                                        <li>• Original row count maintained</li>
                                        <li>• Useful for audit purposes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Visual Preview</h3>
                            <p class="text-neutral-300 mb-3">
                                Before removing duplicates, always check the Full Preview tab to verify:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-neutral-300 ml-4">
                                <li><strong class="text-yellow-500">Amber rows</strong> show which records will be kept (originals)</li>
                                <li><strong class="text-amber-600">Yellow rows</strong> show which records will be removed (duplicates)</li>
                                <li>Duplicate count shown in the Export Options section</li>
                                <li>Total affected rows count displayed (originals + duplicates)</li>
                            </ul>
                        </div>

                        <div class="bg-amber-500/10 border-l-4 border-amber-500 p-4">
                            <p class="text-sm text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-amber-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Important:</strong> Duplicate removal is applied AFTER data cleaning. This means the system will detect duplicates based on the cleaned, normalized values - not the original raw data.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Export Options -->
                <section id="export-options" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Export Options</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Download Format Selection</h3>
                            <p class="text-neutral-300 mb-3">Choose your preferred download format:</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="border border-green-500/30 bg-green-500/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-neutral-200 mb-2">CSV</h4>
                                    <ul class="text-sm text-neutral-200 space-y-1">
                                        <li>• Universal compatibility</li>
                                        <li>• Opens in any spreadsheet</li>
                                        <li>• Smallest file size</li>
                                    </ul>
                                </div>
                                <div class="border border-amber-500/30 bg-amber-500/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-neutral-200 mb-2">Excel (.xlsx)</h4>
                                    <ul class="text-sm text-neutral-200 space-y-1">
                                        <li>• Native Excel format</li>
                                        <li>• Ready to use in Excel</li>
                                        <li>• Preserves data types</li>
                                    </ul>
                                </div>
                                <div class="border border-purple-500/30 bg-purple-500/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-neutral-200 mb-2">JSON</h4>
                                    <ul class="text-sm text-neutral-300 space-y-1">
                                        <li>• Developer-friendly</li>
                                        <li>• Structured format</li>
                                        <li>• Easy to parse</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Data Cleaning Options</h3>
                            <div class="space-y-4">
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-white mb-1">Remove Duplicate Rows</h4>
                                            <p class="text-sm text-neutral-400">Automatically removes exact duplicate rows, keeping only the first occurrence. Duplicates are highlighted in the preview so you can review before removing.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" checked disabled>
                                        <div>
                                            <h4 class="font-semibold text-white mb-1">Clean Whitespace in All Cells</h4>
                                            <p class="text-sm text-neutral-400">Trims leading/trailing spaces and normalizes multiple spaces to single spaces across all cells. This ensures consistent formatting. Enabled by default.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3">Additional Export Options</h3>
                            <div class="space-y-4">
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-white mb-1">Include "Issues" Column</h4>
                                            <p class="text-sm text-neutral-400">Adds an extra column listing any validation issues found in each row. Helps you quickly identify which rows may need manual review.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-neutral-600 rounded-lg p-4 bg-neutral-800/40">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" class="mt-1" disabled>
                                        <div>
                                            <h4 class="font-semibold text-white mb-1">Export Only Rows With Issues</h4>
                                            <p class="text-sm text-neutral-400">Downloads ONLY the rows that have validation problems. Perfect for creating a focused review file that you can fix manually and merge back into your main dataset.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Issues Report Section -->
                        <div class="mt-8 bg-neutral-900 border border-neutral-700 rounded-2xl p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-white mb-2">Detailed Issues Report</h3>
                                    <p class="text-neutral-300 mb-4">
                                        Get comprehensive, actionable explanations for every validation issue. No more guessing what's wrong with your data - we tell you exactly what the problem is and how to fix it.
                                    </p>
                                    
                                    <div class="bg-neutral-800/60 rounded-lg p-4 mb-4 border border-neutral-600">
                                        <h4 class="font-semibold text-white mb-3">How It Works</h4>
                                        <ol class="list-decimal list-inside space-y-2 text-base text-neutral-300">
                                            <li>After processing your file, go to the <strong>"Issues"</strong> tab</li>
                                            <li>Click the <strong>"View Issues Report"</strong> button</li>
                                            <li>A comprehensive HTML report opens in a new page with detailed explanations for each issue</li>
                                            <li>Each issue shows: the invalid value, specific problem, explanation, and actionable guidance</li>
                                        </ol>
                                        
                                        <div class="mt-4 pt-4 border-t border-neutral-600">
                                            <h5 class="font-semibold text-white mb-2 text-base">Report Features:</h5>
                                            <ul class="list-disc list-inside space-y-1 text-base text-neutral-300">
                                                <li><strong>Dedicated HTML Page:</strong> Opens in a separate page for better viewing and printing</li>
                                                <li><strong>Persistent Storage:</strong> Reports survive page refreshes. Your browser's localStorage keeps the report available even after refreshing.</li>
                                                <li><strong>Print & Download:</strong> Use the print button to print the report, or download it as an HTML file for permanent storage and sharing.</li>
                                                <li><strong>Navigation Sidebar:</strong> Quick links to jump to specific data type sections (NI Numbers, Phone Numbers, Postcodes, etc.)</li>
                                                <li><strong>Detailed Explanations:</strong> Each issue includes specific problem identification, why it's invalid, and actionable steps to fix it</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-neutral-800/60 rounded-lg p-4 border border-neutral-600">
                                            <h4 class="font-semibold text-white mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                What You Get
                                            </h4>
                                            <ul class="text-sm text-neutral-300 space-y-1">
                                                <li>• Specific problem identification</li>
                                                <li>• Clear explanations of why values are invalid</li>
                                                <li>• Actionable guidance on how to fix issues</li>
                                                <li>• Professional HTML report format</li>
                                            </ul>
                                        </div>
                                        <div class="bg-neutral-800/60 rounded-lg p-4 border border-neutral-600">
                                            <h4 class="font-semibold text-white mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Example Explanations
                                            </h4>
                                            <ul class="text-sm text-neutral-300 space-y-1">
                                                <li>• NI Numbers: Which letter is invalid and why</li>
                                                <li>• Phone Numbers: Format issues and corrections</li>
                                                <li>• Postcodes: Missing spaces or wrong format</li>
                                                <li>• Sort Codes: Wrong digit count or letters</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="bg-yellow-500/10 border-l-4 border-yellow-500 p-4 rounded">
                                        <p class="text-base text-neutral-200 mb-2">
                                            <strong><svg class="inline w-5 h-5 text-yellow-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Pro Tip:</strong> The detailed issues report is perfect for sharing with your team or documenting data quality issues. Each explanation includes the specific problem, why it's invalid according to UK standards, and clear steps to fix it.
                                        </p>
                                        <p class="text-base text-neutral-200">
                                            <strong><svg class="inline w-5 h-5 text-amber-500 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> Important:</strong> The report is stored in your browser's session storage, so if you refresh the page, it will automatically restore. You can also print the report directly from the browser or download it as an HTML file for permanent storage.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cleaned Data Report Section -->
                        <div class="mt-8 bg-green-500/10 border border-green-500/30 rounded-lg p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-white mb-2">Cleaned Data Report</h3>
                                    <p class="text-neutral-300 mb-4">
                                        View a comprehensive report of all values that were automatically cleaned during processing. See the original values alongside their cleaned versions, organised by data type.
                                    </p>
                                    
                                    <div class="bg-neutral-800/60 rounded-lg p-4 mb-4 border border-neutral-600">
                                        <h4 class="font-semibold text-white mb-3">How It Works</h4>
                                        <ol class="list-decimal list-inside space-y-2 text-base text-neutral-300">
                                            <li>After processing your file, go to the <strong>"Cleaned"</strong> tab</li>
                                            <li>Click the <strong>"View Cleaned Report"</strong> button</li>
                                            <li>A comprehensive HTML report opens in a new page showing all cleaned values</li>
                                            <li>Values are organised by type (Phone Numbers, Postcodes, NI Numbers, Sort Codes, Name Splits, etc.)</li>
                                            <li>Each entry shows the original value and the cleaned/fixed value side by side</li>
                                        </ol>
                                        
                                        <div class="mt-4 pt-4 border-t border-neutral-600">
                                            <h5 class="font-semibold text-white mb-2 text-base">Report Features:</h5>
                                            <ul class="list-disc list-inside space-y-1 text-base text-neutral-300">
                                                <li><strong>Dedicated HTML Page:</strong> Opens in a separate page for better viewing and printing</li>
                                                <li><strong>Organised by Type:</strong> Values are grouped by data type (Phone Numbers, Postcodes, etc.) for easy navigation</li>
                                                <li><strong>Before & After:</strong> See original values alongside their cleaned versions</li>
                                                <li><strong>Navigation Sidebar:</strong> Quick links to jump to specific data type sections</li>
                                                <li><strong>Persistent Storage:</strong> Reports survive page refreshes via browser localStorage</li>
                                                <li><strong>Print & Share:</strong> Perfect for documenting your data cleaning process and sharing with your team</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="bg-green-500/10 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <p class="text-base text-neutral-200">
                                            <strong><svg class="inline w-5 h-5 text-green-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Pro Tip:</strong> The cleaned data report is excellent for auditing your data cleaning process, tracking what changes were made, and documenting your data quality improvements for stakeholders.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-500/10 border-l-4 border-red-500 p-4 rounded-r-lg">
                            <p class="text-base text-neutral-200">
                                <strong><svg class="inline w-5 h-5 text-red-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Important:</strong> Your cleaned data only exists in your browser session. Once you close the tab or refresh the page, it's gone. Make sure to download and save your file immediately after processing!
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Validation Rules -->
                <section id="validation-rules" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Validation Rules</h2>

                    <div class="space-y-6">
                        <!-- Phone Numbers -->
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg> Phone Number Validation</h3>
                            <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                                <h4 class="font-semibold text-white mb-2">Accepts:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>• UK mobile numbers (07xxx xxxxxx)</li>
                                    <li>• UK landline numbers (01xxx / 02xxx / 03xxx)</li>
                                    <li>• International format (+44)</li>
                                    <li>• Various spacing and formatting styles</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>1. Removes all non-digit characters (spaces, hyphens, parentheses)</li>
                                    <li>2. Validates length (10-11 digits for UK numbers)</li>
                                    <li>3. Converts to +44 format</li>
                                    <li>4. Adds spacing for readability (+44 7123 456789)</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Examples:</h4>
                                <div class="code-block">Original value → Cleaned result
07123456789        →  +44 7123 456789
+447123456789      →  +44 7123 456789
(020) 7123 4567    →  +44 20 7123 4567
0207-123-4567      →  +44 20 7123 4567</div>
                            </div>
                        </div>

                        <!-- NI Numbers -->
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg> National Insurance Number Validation</h3>
                            <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                                <h4 class="font-semibold text-white mb-2">Format:</h4>
                                <p class="text-sm text-neutral-300 mb-3">Two letters, six digits, one letter (e.g., AB123456C)</p>
                                <h4 class="font-semibold text-white mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>1. Removes spaces, hyphens, and special characters</li>
                                    <li>2. Converts to uppercase</li>
                                    <li>3. Validates prefix (excludes invalid prefixes like BG, GB, NK, etc.)</li>
                                    <li>4. Formats with spaces (AB 12 34 56 C)</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Examples:</h4>
                                <div class="code-block">Original value → Cleaned result
ab123456c          →  AB 12 34 56 C
AB-123456-C        →  AB 12 34 56 C
ab 12 34 56 c      →  AB 12 34 56 C</div>
                            </div>
                        </div>

                        <!-- Postcodes -->
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg> Postcode Validation</h3>
                            <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                                <h4 class="font-semibold text-white mb-2">Accepts:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>• All UK postcode formats</li>
                                    <li>• With or without spaces</li>
                                    <li>• Mixed case</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>1. Converts to uppercase</li>
                                    <li>2. Removes extra spaces</li>
                                    <li>3. Adds proper spacing (outward code + space + inward code)</li>
                                    <li>4. Validates format against UK postcode patterns</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Examples:</h4>
                                <div class="code-block">Original value → Cleaned result
sw1a1aa            →  SW1A 1AA
m11aa              →  M1 1AA
EC1A1BB            →  EC1A 1BB
w1a 1aa            →  W1A 1AA</div>
                            </div>
                        </div>

                        <!-- Sort Codes -->
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-3 flex items-center gap-2"><svg class="w-6 h-6 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg> Sort Code Validation</h3>
                            <div class="bg-neutral-800/60 border border-neutral-600 rounded-lg p-4">
                                <h4 class="font-semibold text-white mb-2">Format:</h4>
                                <p class="text-sm text-neutral-300 mb-3">Six digits formatted as XX-XX-XX</p>
                                <h4 class="font-semibold text-white mb-2">Cleaning Process:</h4>
                                <ul class="text-sm text-neutral-300 space-y-1 mb-3">
                                    <li>1. Removes all non-digit characters</li>
                                    <li>2. Validates length (must be exactly 6 digits)</li>
                                    <li>3. Formats with hyphens (XX-XX-XX)</li>
                                </ul>
                                <h4 class="font-semibold text-white mb-2">Examples:</h4>
                                <div class="code-block">Original value → Cleaned result
123456             →  12-34-56
12 34 56           →  12-34-56
12-34-56           →  12-34-56</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Troubleshooting -->
                <section id="troubleshooting" class="ds-card p-8">
                    <h2 class="text-3xl font-bold text-white mb-6 border-b-2 border-yellow-500 pb-2">Troubleshooting</h2>

                    <div class="space-y-6">
                        <div class="border-l-4 border-red-500 bg-red-500/10 rounded-r-lg p-4">
                            <h4 class="font-semibold text-neutral-200 mb-2">File won't upload or processing fails</h4>
                            <ul class="text-sm text-neutral-300 space-y-1 ml-4">
                                <li>• Check file size - very large files may exceed browser memory</li>
                                <li>• Ensure file has a valid header row</li>
                                <li>• For CSV files, check for consistent delimiters (commas)</li>
                                <li>• For Excel files, ensure data is in the first sheet</li>
                                <li>• Try a different browser (Chrome recommended)</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-amber-400 bg-amber-500/10 rounded-r-lg p-4">
                            <h4 class="font-semibold text-neutral-200 mb-2">Values not being cleaned as expected</h4>
                            <ul class="text-sm text-neutral-200 space-y-1 ml-4">
                                <li>• Verify you selected the correct data type (Phone vs. Postcode, etc.)</li>
                                <li>• Check if the column is protected (has <svg class="inline w-4 h-4 text-neutral-400 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> lock icon) - protected columns are never modified</li>
                                <li>• Ensure data is in the correct format (UK phone numbers, not international)</li>
                                <li>• Review the validation rules for your data type</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-yellow-500 bg-yellow-500/10 rounded-r-lg p-4">
                            <h4 class="font-semibold text-neutral-200 mb-2">Download not starting or file is empty</h4>
                            <ul class="text-sm text-neutral-200 space-y-1 ml-4">
                                <li>• Check browser popup blocker settings</li>
                                <li>• Ensure you clicked "Clean My Data" before downloading</li>
                                <li>• Try a different download format (CSV if Excel fails)</li>
                                <li>• Clear browser cache and try again</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-purple-500 bg-purple-500/10 rounded-r-lg p-4">
                            <h4 class="font-semibold text-neutral-200 mb-2">Duplicate detection seems incorrect</h4>
                            <ul class="text-sm text-neutral-300 space-y-1 ml-4">
                                <li>• Duplicates are detected AFTER cleaning - compare cleaned values, not original</li>
                                <li>• Check the Full Preview to see which rows are marked as duplicates</li>
                                <li>• Amber rows = originals, Yellow rows = duplicates</li>
                                <li>• Duplicates must match in ALL columns, not just some</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-green-400 bg-green-500/10 rounded-r-lg p-4">
                            <h4 class="font-semibold text-neutral-200 mb-2">Preview not showing or loads slowly</h4>
                            <ul class="text-sm text-neutral-200 space-y-1 ml-4">
                                <li>• Large files (10,000+ rows) may take time to render</li>
                                <li>• Try closing other browser tabs to free memory</li>
                                <li>• Use a modern browser with good JavaScript performance</li>
                                <li>• Consider splitting very large files into smaller chunks</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- FAQ -->
                <section id="faq" class="ds-card p-8 ds-scroll-reveal">
                    <h2 class="ds-reveal-item text-3xl font-bold text-white mb-2 border-b-2 border-yellow-500 pb-2">Frequently Asked Questions</h2>
                    <p class="ds-reveal-item text-neutral-400 mb-6">Quick answers to common questions. Click any question to expand.</p>

                    <div class="space-y-3">
                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.05s;">
                            <summary>Is my data really private?</summary>
                            <div class="ds-faq-answer">Yes, 100%. All processing happens in your browser using JavaScript. Your file is never uploaded to our servers, never stored in any database, and never transmitted over the network. We physically cannot see your data — it never leaves your device.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.1s;">
                            <summary>What happens to my data after I close the browser?</summary>
                            <div class="ds-faq-answer">It's cleared from memory. Since everything runs in your browser and nothing is stored on servers, closing the tab or refreshing permanently removes the cleaned data. Download your file right after processing to keep it.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.15s;">
                            <summary>Can I clean non-UK data?</summary>
                            <div class="ds-faq-answer">Right now we specialise in UK formats: UK phone numbers, NI numbers, postcodes, sort codes, and email validation. International phone and postcode formats aren't supported yet.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.2s;">
                            <summary>Why can't I select certain columns for cleaning?</summary>
                            <div class="ds-faq-answer">Columns with a <svg class="inline w-4 h-4 text-neutral-400 align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> lock icon are protected — usually IDs or reference fields. We never modify them so your data relationships stay intact.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.25s;">
                            <summary>What does "Keep First Occurrence" mean for duplicates?</summary>
                            <div class="ds-faq-answer">When removing duplicates, we keep the first row and remove later copies. That preserves your original order, and the amber "original" row is always the one kept.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.3s;">
                            <summary>Can I undo changes after downloading?</summary>
                            <div class="ds-faq-answer">Downloads are final, but your original file stays untouched on your computer. Keep a backup before processing, and use the Full Preview to double-check everything before you download.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.35s;">
                            <summary>Why are some phone numbers marked as invalid?</summary>
                            <div class="ds-faq-answer">The validator checks UK format and length. Typical issues: wrong area codes, incorrect digit count, or non-UK numbers. See the validation rules section for format details.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.4s;">
                            <summary>Can I clean multiple files at once?</summary>
                            <div class="ds-faq-answer">One file at a time. For multiple files, process them one by one — or open several tabs and switch between them.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.45s;">
                            <summary>What's "Export Only Rows With Issues" for?</summary>
                            <div class="ds-faq-answer">A normal download gives you the full file with all rows. "Export Only Rows With Issues" gives you just the rows that have problems — handy when you want a focused list to fix manually and merge back later.</div>
                        </details>

                        <details class="ds-reveal-item ds-faq-item" style="animation-delay: 0.5s;">
                            <summary>How do I know if cleaning was successful?</summary>
                            <div class="ds-faq-answer">Check the Results Summary for valid vs invalid counts, the Full Preview for green-highlighted cleaned cells, and Data Profiling for overall quality. Green cells = successfully cleaned.</div>
                        </details>
                    </div>
                </section>

                <!-- Contact Support -->
                <section class="ds-scroll-reveal bg-neutral-900 rounded-2xl border border-neutral-700 p-8 md:p-10 text-center">
                    <h2 class="ds-reveal-item text-2xl font-bold text-white mb-3">Still Have Questions?</h2>
                    <p class="ds-reveal-item text-neutral-400 mb-6 max-w-2xl mx-auto">
                        Can't find what you're looking for? Our support team is here to help.
                    </p>
                    <a href="/contact.php" class="ds-btn-primary inline-block px-6 py-2.5 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                        Contact Support
                    </a>
                </section>

            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>

    <script <?php echo script_nonce(); ?>>
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

        // Active TOC link based on section in view
        (function() {
            const sections = document.querySelectorAll('main section[id]');
            const tocLinks = document.querySelectorAll('.doc-toc-link');
            const ZONE_BOTTOM = 180; // px from top of viewport – section in this zone is "active"

            function setActiveLink() {
                let activeSection = null;
                sections.forEach(function(section) {
                    const rect = section.getBoundingClientRect();
                    if (rect.top < ZONE_BOTTOM && rect.bottom > 0 && !activeSection) {
                        activeSection = section;
                    }
                });
                if (!activeSection && sections.length) {
                    activeSection = sections[0];
                }
                tocLinks.forEach(function(link) {
                    const href = link.getAttribute('href');
                    if (activeSection && href === '#' + activeSection.id) {
                        link.classList.add('is-active');
                    } else {
                        link.classList.remove('is-active');
                    }
                });
            }

            var ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        setActiveLink();
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });
            setActiveLink();
        })();
    </script>
</body>
</html>
