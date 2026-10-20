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
            <h1 class="text-2xl font-bold text-center text-white mb-2">Try with Example Data</h1>
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
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Load sample data to try the tool</h2>
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

            <!-- Loading Overlay – spinner and success (same as logged-in index.php) -->
            <div id="loadingOverlay" class="hidden fixed inset-0 flex items-center justify-center z-50 ds-loading-overlay-backdrop" style="background: rgba(0,0,0,0.75);">
                <div id="loadingOverlayCard" class="ds-loading-overlay-card bg-neutral-900 rounded-2xl border border-neutral-700 shadow-2xl p-6 md:p-8 max-w-md w-full mx-4 overflow-hidden">
                    <div id="loadingProcessingState" class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-yellow-500/15 flex items-center justify-center">
                                <svg class="animate-spin h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-neutral-400 uppercase tracking-wide">Processing</p>
                                <p class="text-lg font-semibold text-white truncate" id="loadingFileName">Your file</p>
                                <p class="text-sm text-neutral-500" id="loadingFileSize">—</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="ds-progress-bar-track w-full bg-neutral-800 rounded-full h-2.5">
                                <div id="loadingProgressBar" class="ds-progress-bar-fill bg-gradient-to-r from-yellow-500 to-yellow-400 h-2.5 rounded-full" style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-400" id="loadingMessage">Validating your data…</span>
                                <span class="font-medium text-yellow-400 tabular-nums" id="loadingProgress">0%</span>
                            </div>
                        </div>
                    </div>
                    <div id="loadingSuccessState" class="hidden flex flex-col items-center justify-center py-4 text-center">
                        <div class="ds-loading-success-glow relative w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center mb-3">
                            <div class="ds-loading-success-circle w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path class="ds-check-path" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-lg font-semibold text-white">Complete!</p>
                        <p class="text-sm text-neutral-400 mt-0.5">Your data is ready</p>
                    </div>
                </div>
            </div>

            <!-- Results Section (hidden initially) - matches index.php logged-in styling -->
            <div id="resultsSection" class="hidden mt-8">
                <h3 class="text-2xl font-bold text-white mb-4">Results</h3>
                <!-- Summary Cards -->
                <div id="summaryCards" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="ds-card-compact p-4">
                        <p class="text-sm text-neutral-400">Total Rows</p>
                        <p class="text-2xl font-bold text-white" id="totalRows">0</p>
                    </div>
                    <div class="ds-card-compact p-4">
                        <p class="text-sm text-neutral-400">Valid</p>
                        <p class="text-2xl font-bold text-green-400" id="validCount">0</p>
                    </div>
                    <div class="ds-card-compact p-4">
                        <p class="text-sm text-neutral-400">Cleaned</p>
                        <p class="text-2xl font-bold text-yellow-400" id="cleanedCount">0</p>
                    </div>
                    <div class="ds-card-compact p-4">
                        <p class="text-sm text-neutral-400">Issues</p>
                        <p class="text-2xl font-bold text-red-400" id="issuesCount">0</p>
                    </div>
                </div>

                <!-- Tabs – segmented control matching index.php -->
                <div class="tab-bar flex flex-nowrap bg-neutral-800 border border-neutral-600 mb-4" data-tab-theme="dark" role="tablist" aria-label="Results view">
                    <button type="button" class="tab-btn flex-1 min-w-0 bg-yellow-500 text-black py-3 font-semibold text-sm transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-inset focus-visible:ring-offset-0 border-r border-neutral-600 flex items-center justify-center gap-2" data-tab="summary" role="tab" aria-selected="true">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                        Summary
                    </button>
                    <button type="button" class="tab-btn flex-1 min-w-0 bg-transparent text-neutral-400 py-3 font-semibold text-sm hover:bg-neutral-700 hover:text-white transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-inset focus-visible:ring-offset-0 border-r border-neutral-600 flex items-center justify-center gap-2" data-tab="preview" role="tab" aria-selected="false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        Full Preview
                    </button>
                    <button type="button" class="tab-btn flex-1 min-w-0 bg-transparent text-neutral-400 py-3 font-semibold text-sm hover:bg-neutral-700 hover:text-white transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-inset focus-visible:ring-offset-0 border-r border-neutral-600 flex items-center justify-center gap-2" data-tab="cleaned" role="tab" aria-selected="false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Cleaned
                    </button>
                    <button type="button" class="tab-btn flex-1 min-w-0 bg-transparent text-neutral-400 py-3 font-semibold text-sm hover:bg-neutral-700 hover:text-white transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-inset focus-visible:ring-offset-0 flex items-center justify-center gap-2" data-tab="issues" role="tab" aria-selected="false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Issues
                    </button>
                </div>

                <!-- Tab Content -->
                <div id="summaryTab" class="tab-content active bg-neutral-900 border border-neutral-600 border-t-0 px-4 py-4">
                    <p class="text-sm text-neutral-400 mb-3">Sample of validated fields (prioritizes rows where values were changed)</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Row</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Column</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Original</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Cleaned</th>
                                </tr>
                            </thead>
                            <tbody id="summaryTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <div id="previewTab" class="tab-content hidden bg-neutral-900 border border-neutral-600 border-t-0 px-4 py-4">
                    <div class="border border-yellow-500/40 bg-neutral-800/60 p-6 text-center">
                        <svg class="w-12 h-12 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-2">View Full Preview Report</h3>
                        <p class="text-neutral-400 mb-4">See exactly what your downloaded file will contain. All columns preserved in their original order, with cleaned values applied only to selected fields.</p>
                        <button type="button" id="previewReportBtn" class="ds-btn-primary px-6 py-3 flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Open Full Preview Report
                        </button>
                    </div>
                </div>

                <div id="cleanedTab" class="tab-content hidden bg-neutral-900 border border-neutral-600 border-t-0 px-4 py-4">
                    <div class="border border-yellow-500/40 bg-neutral-800/60 p-6 text-center">
                        <svg class="w-12 h-12 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-2">View Cleaned Data Report</h3>
                        <p class="text-neutral-400 mb-4">See a detailed report of all cleaned data with original and fixed values</p>
                        <button type="button" id="cleanedReportBtn" class="ds-btn-primary px-6 py-3 flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Open Cleaned Data Report
                        </button>
                    </div>
                </div>

                <div id="issuesTab" class="tab-content hidden bg-neutral-900 border border-neutral-600 border-t-0 px-4 py-4">
                    <div class="border border-red-500/40 bg-red-900/20 p-6 text-center">
                        <svg class="w-12 h-12 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-2">View Issues Report</h3>
                        <p class="text-neutral-400 mb-4">See a detailed report of all validation issues found in your data</p>
                        <button type="button" id="issuesReportBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-semibold flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Open Issues Report
                        </button>
                    </div>
                </div>

                <!-- Important Warning -->
                <div class="mt-6 border border-red-500/40 bg-red-900/20 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-red-300 font-semibold mb-1">Important: Download and Save Your File</p>
                            <p class="text-neutral-300 text-sm">
                                Your cleaned data is only available in your browser session. Once you close this tab or refresh the page, your cleaned data will be gone. We don't store files on our servers — <strong class="text-white">make sure to download and save your file immediately!</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Export Options -->
                <div class="mt-6 ds-card-compact p-6 space-y-5">
                    <div>
                        <h4 class="text-base font-bold text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Download Options - Customize Your Export
                        </h4>
                        <p class="text-sm text-neutral-400 mb-4">Choose your preferred format and export options before downloading your cleaned file:</p>
                    </div>

                    <div class="group/format">
                        <label class="flex items-center gap-2 text-sm font-semibold text-neutral-200 mb-2">
                            <svg class="w-4 h-4 text-yellow-400/80 transition-colors group-hover/format:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Select Your Download Format
                        </label>
                        <select id="downloadFormat" class="ds-download-format-select w-full px-4 py-2.5 rounded-lg border-2 border-neutral-600 bg-neutral-800 text-white font-medium focus:outline-none focus:ring-0 focus:border-yellow-500 cursor-pointer">
                            <option value="csv">CSV (Comma Separated Values)</option>
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="json">JSON</option>
                        </select>
                        <p class="text-xs text-yellow-400/90 mt-2 flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <span>You can download in any format, regardless of what you uploaded!</span>
                        </p>
                    </div>

                    <div class="bg-neutral-800/60 p-4 border border-neutral-600">
                        <h5 class="text-sm font-semibold text-white mb-3">Data Cleaning Options:</h5>
                        <div class="space-y-4">
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded -m-2 transition-colors">
                                <input type="checkbox" id="removeDuplicates" class="mt-1 mr-3 h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-neutral-600 rounded bg-neutral-800">
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-neutral-200 block">Remove Duplicate Rows (Keep First Occurrence)</span>
                                    <span class="text-sm text-neutral-400 block mt-1">
                                        <span id="duplicateCountMessage">Checking for duplicates...</span>
                                        <span class="block mt-1 text-yellow-400/90"><svg class="inline w-4 h-4 text-yellow-400 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> In the Full Preview tab: <strong class="text-amber-300">Amber</strong> = original rows with duplicates, <strong class="text-yellow-300">Yellow</strong> = duplicate rows to be removed.</span>
                                    </span>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded -m-2 transition-colors">
                                <input type="checkbox" id="trimWhitespace" class="mt-1 mr-3 h-4 w-4 text-green-500 focus:ring-green-500 border-neutral-600 rounded bg-neutral-800" checked>
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-neutral-200 block">Clean Whitespace in All Cells</span>
                                    <span class="text-sm text-neutral-400 block mt-1">Remove leading/trailing spaces and extra spaces between words. Already applied to cleaned fields, this ensures all other columns are clean too.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-neutral-800/60 p-4 border border-neutral-600">
                        <h5 class="text-sm font-semibold text-white mb-3">Export Customisation:</h5>
                        <div class="space-y-4">
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded -m-2 transition-colors">
                                <input type="checkbox" id="includeIssuesColumn" class="mt-1 mr-3 h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-neutral-600 rounded bg-neutral-800" checked>
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-neutral-200 block">Include "Issues" Column</span>
                                    <span class="text-sm text-neutral-400 block mt-1">Add a column listing any fields that still need attention. This helps you identify which rows may require manual review.</span>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded -m-2 transition-colors">
                                <input type="checkbox" id="onlyRowsWithIssues" class="mt-1 mr-3 h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-neutral-600 rounded bg-neutral-800">
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-neutral-200 block">Export Only Rows With Issues (Optional)</span>
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

