<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/example.php">
    <title>Try Simple Data Cleaner - Interactive Demo | Free Example</title>
    <meta name="description" content="Try Simple Data Cleaner with example data. Experience our UK data validation tool with a pre-loaded sample dataset. No sign-up required.">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="/assets/css/output.css">
    <script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js" 
            integrity="sha384-7hwyYzxURfZMLwHgvEKrYEmM5tX+1DVWK5iDR4R69bOQeY90Q8B8n9Cobuyqybhw" 
            crossorigin="anonymous" 
            defer></script>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- File Upload Section (Demo Mode) -->
        <div class="max-w-4xl mx-auto bg-neutral-900 rounded-xl shadow-lg border border-neutral-700 p-8 mt-8">
            <h2 class="text-2xl font-bold text-center text-white mb-2">Try with Example Data</h2>
            <p class="text-center text-neutral-400 mb-6 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Your files are processed in your browser - 100% private & secure
            </p>

            <!-- Demo: Empty state with clear value proposition -->
            <div class="example-cta-zone border-2 border-dashed border-neutral-500 rounded-2xl p-10 md:p-14 lg:p-16 text-center bg-yellow-500/[0.04] hover:bg-yellow-500/[0.06] hover:border-yellow-500/60 transition-all duration-300">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full ring-2 ring-yellow-500/25 ring-offset-4 ring-offset-neutral-900 mb-8">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Load sample data to try the tool</h3>
                <p class="text-base text-neutral-400 max-w-lg mx-auto mb-2">A sample dataset with UK phone numbers, NI numbers, postcodes, sort codes, emails, and names. You’ll pick columns, clean, then export — all in your browser.</p>
                <p class="text-sm text-neutral-500 mb-8">No sign-up. No uploads. Your data stays private.</p>
                <button type="button" id="loadExampleBtn" class="ds-btn-primary px-8 py-4 text-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded-lg">
                    <svg class="w-6 h-6 inline-block mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Load Example Data
                </button>
            </div>

            <!-- File Selected Section (hidden initially) -->
            <div id="fileSelected" class="hidden mt-6 bg-green-500/10 border border-green-500/30 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-white" id="fileName">example-data.csv</p>
                            <p class="text-sm text-neutral-400" id="fileSize">Sample dataset loaded</p>
                        </div>
                    </div>
                    <button type="button" id="chooseDifferentBtn" class="text-neutral-400 hover:text-white transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 rounded px-2 py-1">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Field Selection Section (hidden initially) -->
            <div id="fieldSelection" class="hidden mt-6 space-y-6">
                <div class="ds-card-compact">
                    <h3 class="text-lg font-semibold text-white mb-1">Select columns to clean</h3>
                    <p class="text-sm text-neutral-400 mb-4">Pick which columns contain UK data to validate. Use Auto-Select to detect phone, NI, postcode, sort code, email, and name columns automatically.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" id="selectAllBtn" class="px-4 py-2 bg-neutral-700 text-white rounded-lg hover:bg-neutral-600 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                            Select All
                        </button>
                        <button type="button" id="clearAllBtn" class="px-4 py-2 bg-neutral-700 text-white rounded-lg hover:bg-neutral-600 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                            Clear All
                        </button>
                        <button type="button" id="autoSelectBtn" class="px-4 py-2 ds-btn-primary text-sm">
                            Auto-Select
                        </button>
                    </div>
                    <div id="fieldCheckboxes" class="space-y-2">
                        <!-- Field checkboxes will be rendered here -->
                    </div>
                </div>

                <!-- Phone Number Format Selection -->
                <div class="ds-card-compact">
                    <h4 class="font-semibold text-white mb-3">Phone Number Format</h4>
                    <div class="flex flex-wrap gap-6">
                        <label class="flex items-center gap-2 cursor-pointer text-neutral-300 hover:text-white transition-colors">
                            <input type="radio" name="phoneFormat" value="international" checked class="w-4 h-4 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-neutral-900 border-neutral-600 bg-neutral-800">
                            <span>International (+44 7700 900123)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-neutral-300 hover:text-white transition-colors">
                            <input type="radio" name="phoneFormat" value="uk" class="w-4 h-4 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-neutral-900 border-neutral-600 bg-neutral-800">
                            <span>UK (07700 900123)</span>
                        </label>
                    </div>
                    <p class="text-sm text-neutral-500 mt-2">Choose how you want phone numbers formatted in the output</p>
                </div>

                <!-- Custom email domain corrections (shown when an email column is selected) -->
                <div id="emailDomainTyposSection" class="hidden ds-card-compact">
                    <h4 class="font-semibold text-white mb-2">Custom email domain corrections</h4>
                    <p class="text-sm text-neutral-400 mb-2">Add your own domain typo fixes (e.g. <code class="bg-neutral-700 px-1.5 py-0.5 rounded text-yellow-400 font-mono text-xs">my-orgcom</code> → <code class="bg-neutral-700 px-1.5 py-0.5 rounded text-yellow-400 font-mono text-xs">myorg.com</code>). One per line: <code class="bg-neutral-700 px-1 rounded text-neutral-300 font-mono text-xs">typo → correct</code> or <code class="bg-neutral-700 px-1 rounded text-neutral-300 font-mono text-xs">typo=correct</code>.</p>
                    <textarea id="emailDomainTyposInput" class="w-full rounded-lg border border-neutral-600 bg-neutral-800 px-3 py-2 text-sm font-mono text-white placeholder-neutral-500 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 min-h-[80px]" placeholder="my-orgcom → myorg.com&#10;myorgcom → myorg.com"></textarea>
                </div>

                <button type="button" id="processBtn" class="hidden w-full ds-btn-primary py-4 text-lg shadow-lg shadow-yellow-500/20 hover:shadow-yellow-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                    Clean My Data
                </button>
            </div>

            <!-- Results Section (hidden initially) -->
            <div id="resultsSection" class="hidden mt-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Total Rows</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalRows">0</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Valid</p>
                        <p class="text-2xl font-bold text-green-600" id="validCount">0</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Cleaned</p>
                        <p class="text-2xl font-bold text-amber-800" id="cleanedCount">0</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Issues</p>
                        <p class="text-2xl font-bold text-red-600" id="issuesCount">0</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="tab-bar border-b border-neutral-700 mb-4" data-tab-theme="dark" role="tablist" aria-label="Results tabs">
                    <button type="button" role="tab" aria-selected="true" class="tab-btn tab-active border-b-2 border-yellow-500 text-white px-4 py-2.5 font-semibold transition-colors duration-200 hover:text-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded-t" data-tab="summary">Summary</button>
                    <button type="button" role="tab" aria-selected="false" class="tab-btn border-b-2 border-transparent text-neutral-400 hover:text-white px-4 py-2.5 font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded-t" data-tab="preview">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Full Preview
                        </span>
                    </button>
                    <button type="button" role="tab" aria-selected="false" class="tab-btn border-b-2 border-transparent text-neutral-400 hover:text-white px-4 py-2.5 font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded-t" data-tab="cleaned">Cleaned</button>
                    <button type="button" role="tab" aria-selected="false" class="tab-btn border-b-2 border-transparent text-neutral-400 hover:text-white px-4 py-2.5 font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded-t" data-tab="issues">Issues</button>
                </div>

                <!-- Tab Content -->
                <div id="summaryTab" class="tab-content active">
                    <!-- Summary content will be rendered here -->
                </div>

                <div id="previewTab" class="tab-content hidden">
                    <div class="bg-amber-50 border-2 border-yellow-500/60 p-6 rounded text-center">
                        <svg class="w-12 h-12 text-amber-800 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">View Full Preview Report</h3>
                        <p class="text-gray-600 mb-4">See exactly what your downloaded file will contain. All columns preserved in their original order, with cleaned values applied only to selected fields.</p>
                        <button type="button" id="previewReportBtn" class="px-6 py-3 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Open Full Preview Report
                        </button>
                    </div>
                </div>

                <div id="cleanedTab" class="tab-content hidden">
                    <div class="bg-amber-50 border-2 border-yellow-500/60 p-6 rounded text-center">
                        <svg class="w-12 h-12 text-amber-800 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">View Cleaned Data Report</h3>
                        <p class="text-gray-600 mb-4">See a detailed report of all cleaned data with original and fixed values</p>
                        <button type="button" id="cleanedReportBtn" class="px-6 py-3 bg-yellow-500 text-black rounded-lg hover:bg-yellow-400 transition-colors flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Open Cleaned Data Report
                        </button>
                    </div>
                </div>

                <div id="issuesTab" class="tab-content hidden">
                    <div class="bg-red-50 border-2 border-red-400 p-6 rounded text-center">
                        <svg class="w-12 h-12 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">View Issues Report</h3>
                        <p class="text-gray-600 mb-4">See a detailed report of all validation issues found in your data</p>
                        <button type="button" id="issuesReportBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Open Issues Report
                        </button>
                    </div>
                </div>

                <!-- Export Options -->
                <div class="mt-6 ds-card-compact space-y-6">
                    <div>
                        <h4 class="text-base font-bold text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Download Options — Customize Your Export
                        </h4>
                        <p class="text-sm text-neutral-400 mb-4">Choose your preferred format and export options before downloading your cleaned file:</p>
                    </div>

                    <div>
                        <label for="downloadFormat" class="block text-sm font-semibold text-white mb-2">Select Your Download Format</label>
                        <select id="downloadFormat" class="w-full px-4 py-2.5 border border-neutral-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-neutral-800 font-medium text-white">
                            <option value="csv">CSV (Comma Separated Values)</option>
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="json">JSON</option>
                        </select>
                        <p class="text-xs text-neutral-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <span>You can download in any format, regardless of what you uploaded</span>
                        </p>
                    </div>

                    <div class="bg-neutral-800/80 rounded-lg p-4 border border-neutral-700">
                        <h5 class="text-sm font-semibold text-white mb-3">Data Cleaning Options</h5>
                        <div class="space-y-4">
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded-lg -m-2 transition-colors">
                                <input type="checkbox" id="removeDuplicates" class="mt-1 mr-3 h-4 w-4 text-yellow-500 bg-neutral-700 border-neutral-600 rounded focus:ring-yellow-500 focus:ring-2 focus:ring-offset-0">
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-white block">Remove Duplicate Rows (Keep First Occurrence)</span>
                                    <span class="text-sm text-neutral-400 block mt-1">
                                        <span id="duplicateCountMessage">Checking for duplicates...</span>
                                        <span class="block mt-1">In the Full Preview tab: original rows with duplicates and duplicate rows to be removed are highlighted.</span>
                                    </span>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded-lg -m-2 transition-colors">
                                <input type="checkbox" id="trimWhitespace" class="mt-1 mr-3 h-4 w-4 text-yellow-500 bg-neutral-700 border-neutral-600 rounded focus:ring-yellow-500 focus:ring-2 focus:ring-offset-0" checked>
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-white block">Clean Whitespace in All Cells</span>
                                    <span class="text-sm text-neutral-400 block mt-1">Remove leading/trailing spaces and extra spaces between words. Already applied to cleaned fields, this ensures all other columns are clean too.</span>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded-lg -m-2 transition-colors">
                                <input type="checkbox" id="onlyRowsWithIssues" class="mt-1 mr-3 h-4 w-4 text-yellow-500 bg-neutral-700 border-neutral-600 rounded focus:ring-yellow-500 focus:ring-2 focus:ring-offset-0">
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-white block">Export Only Rows With Issues (Optional)</span>
                                    <span class="text-sm text-neutral-400 block mt-1">When checked, you'll download <strong class="text-white">only</strong> the rows that have validation issues (instead of the full file). Perfect for creating a focused review file to fix manually before merging back into your main dataset.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <button type="button" id="exportBtn" class="ds-btn-primary px-8 py-3 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                        Download Cleaned File
                    </button>
                    <button type="button" id="processNewBtn" class="px-6 py-3 bg-neutral-700 text-white rounded-lg hover:bg-neutral-600 font-semibold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                        Reset Demo
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <section class="max-w-4xl mx-auto mt-12 ds-card" aria-labelledby="experience-heading">
            <h2 id="experience-heading" class="text-2xl font-bold text-center text-white mb-2">What You'll Experience</h2>
            <p class="text-center text-neutral-400 text-sm mb-8">Everything in your browser — no uploads, no servers.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <article class="flex items-start gap-3 pl-8 border-l-2 border-yellow-500/40 transition-colors duration-200 hover:border-yellow-500/50">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-white mb-1">Data Validation</h3>
                        <p class="text-sm text-neutral-400">See how we validate UK phone numbers, postcodes, NI numbers, sort codes, and email addresses according to UK standards.</p>
                    </div>
                </article>
                <article class="flex items-start gap-3 pl-8 border-l-2 border-yellow-500/40 transition-colors duration-200 hover:border-yellow-500/50">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-white mb-1">Detailed Reports</h3>
                        <p class="text-sm text-neutral-400">Explore comprehensive HTML reports showing issues, cleaned data, and full previews with explanations.</p>
                    </div>
                </article>
                <article class="flex items-start gap-3 pl-8 border-l-2 border-yellow-500/40 transition-colors duration-200 hover:border-yellow-500/50">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-white mb-1">100% Private</h3>
                        <p class="text-sm text-neutral-400">All processing happens in your browser. Your data never leaves your device — perfect for sensitive information.</p>
                    </div>
                </article>
                <article class="flex items-start gap-3 pl-8 border-l-2 border-yellow-500/40 transition-colors duration-200 hover:border-yellow-500/50">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-white mb-1">Export Options</h3>
                        <p class="text-sm text-neutral-400">Download cleaned data in CSV, Excel, or JSON format. Filter to only rows with issues if needed.</p>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="/validators.js" defer></script>
    <script src="/fileProcessor.js" defer></script>
    <script src="/app.js" defer></script>
    
    <!-- Example Data -->
    <script <?php echo script_nonce(); ?>>
        // Example CSV data embedded in the page
        const EXAMPLE_CSV_DATA = `ID,Name,Email,Phone Number,Mobile,National Insurance,Postcode,Sort Code,Bank Account,Address
1,Mr. John Smith,john.smith@example.com,020 7946 0958,07700 900123,AB123456C,sw1a1aa,123456,12345678,10 Downing Street
2,Mrs. Jane Doe,jane.doe@example.com,+44 20 7946 0958,07700900123,CD234567D,m1 1aa,234567,23456789,123 Main Street
3,Dr. Bob Johnson,bob.johnson@example.com,02079460958,07700 900 123,EF345678E,ec1a1bb,34 56 78,34567890,456 High Street
4,Alice Brown,alice.brown@example.com,+442079460958,07700900123,GH456789F,w1a1aa,45.67.89,45678901,789 Park Avenue
5,Prof. Charlie Wilson,charlie.wilson@example.com,020 7946 0958,07700-900-123,IJ567890G,cr2 6xh,567890,56789012,321 Oak Road
6,David Lee,david.lee@example.com,02079460958,07700.900.123,KL678901H,m60 1aa,67 89 01,67890123,654 Elm Street
7,Miss Emma Davis,emma.davis@example.com,+44 20 7946 0958,07700900123,MN789012I,SW1A 1AA,78-90-12,78901234,987 Pine Lane
8,Frank Miller,frank.miller@example.com,020 7946 0958,07700 900123,OP890123J,ec1a1bb,890123,89012345,147 Maple Drive
9,Ms. Grace Taylor,grace.taylor@example.com,02079460958,07700900123,QR901234K,w1a 1aa,90 12 34,90123456,258 Cedar Court
10,Henry White,henry.white@example.com,+44 20 7946 0958,07700 900123,ST012345L,cr2 6xh,012345,01234567,369 Birch Way
11,Michael Thompson,michael.thompson@example.com,++44 7700 900123,07700 900123,AB123456C,SW1A 1AA,12-34-56,12345678,10 Test Street
12,Patricia Anderson,patricia.anderson@example.com,020 7946,07700 900123,AB123456C,SW1A 1AA,12-34-56,12345678,11 Test Street
13,Christopher Mitchell,christopher.mitchell@example.com,020 7946 0958,07700 900123,AB123456C,SW1A1,12-34-56,12345678,12 Test Street
14,Jennifer Roberts,jennifer.roberts@example.com,020 7946 0958,07700 900123,AB123456C,SW1A1AA,12-34-56,12345678,13 Test Street
15,Daniel Campbell,daniel.campbell@example.com,020 7946 0958,07700 900123,AB123456C,SW1A 1AA,12-34-5,12345678,14 Test Street
16,Lisa Parker,lisa.parker@example.com,020 7946 0958,07700 900123,AB123456C,SW1A 1AA,AB-34-56,12345678,15 Test Street
17,James Turner,james.turner@example.com,020 7946 0958,07700 900123,BG123456C,SW1A 1AA,12-34-56,12345678,16 Test Street
18,Amanda Foster,amanda.foster@example.com,020 7946 0958,07700 900123,AB12345,SW1A 1AA,12-34-56,12345678,17 Test Street
19,Robert Taylor III,smith@example.com,020 7946 0958,07700 900123,AB123456C,SW1A 1AA,12-34-56,12345678,18 Test Street
20,Sarah Williams,jane@example.com,020 7946 0958,07700 900123,CD234567D,SW1A 1AA,12-34-56,12345678,19 Test Street
21,Mr. John Smith,john.smith@example.com,020 7946 0958,07700 900123,AB123456C,sw1a1aa,123456,12345678,10 Downing Street
22,Mrs. Jane Doe,jane.doe@example.com,+44 20 7946 0958,07700900123,CD234567D,m1 1aa,234567,23456789,123 Main Street
23,Dr. Bob Johnson,bob.johnson@example.com,02079460958,07700 900 123,EF345678E,ec1a1bb,34 56 78,34567890,456 High Street`;

        // Wait for app to initialize, then add demo functionality
        document.addEventListener('DOMContentLoaded', () => {
            // Wait a bit for app.js to initialize
            setTimeout(() => {
                const loadExampleBtn = document.getElementById('loadExampleBtn');
                if (loadExampleBtn && window.app) {
                    loadExampleBtn.addEventListener('click', () => {
                        loadExampleData();
                    });
                }
            }, 500);
        });

        function loadExampleData() {
            // Create a File object from the CSV string
            const blob = new Blob([EXAMPLE_CSV_DATA], { type: 'text/csv' });
            const file = new File([blob], 'example-data.csv', { type: 'text/csv' });

            // Use the app's handleFile method to process it
            if (window.app && typeof window.app.handleFile === 'function') {
                window.app.handleFile(file);
            } else {
                console.error('App not initialized or handleFile method not available');
            }
        }
    </script>
</body>
</html>

