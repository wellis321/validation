<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Sample Full Preview Report';
$pageDescription = 'View a sample full preview report showing exactly what your downloaded file will contain, with color-coded cleaned values, invalid values, and duplicates.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
<?php include __DIR__ . '/includes/header.php'; ?>
<main id="main-content" class="py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="/sample-reports.php" class="inline-flex items-center gap-2 text-neutral-400 hover:text-yellow-400 transition-colors text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                All sample reports
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Sample Full Preview Report</h1>
            <p class="text-neutral-400 max-w-2xl mb-4">This is exactly what your downloaded file will contain. All columns are preserved in their original order, with cleaned values applied only to the fields you selected.</p>
            <ul class="flex flex-wrap gap-x-6 gap-y-2 text-sm" role="list" aria-label="Color legend">
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-green-500/40 border border-green-500/60 flex-shrink-0" aria-hidden="true"></span>
                    <span class="text-neutral-400">Fixed / cleaned values</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-red-500/40 border border-red-500/60 flex-shrink-0" aria-hidden="true"></span>
                    <span class="text-neutral-400">Invalid (requires manual correction)</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-amber-500/40 border border-amber-500/60 flex-shrink-0" aria-hidden="true"></span>
                    <span class="text-neutral-400">Original row with duplicates</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-sm bg-yellow-500/50 border border-yellow-500/70 flex-shrink-0" aria-hidden="true"></span>
                    <span class="text-neutral-400">Duplicate row (removed if option checked)</span>
                </li>
            </ul>
        </div>

        <div class="rounded-xl border border-neutral-700 overflow-hidden bg-neutral-900 shadow-2xl">
            <img src="/assets/images/full-preview-report.png" alt="Full Preview Report — sample showing color-coded data: green for cleaned values, red for invalid values, amber and yellow for duplicate rows" class="w-full h-auto block">
        </div>

        <div class="mt-10">
            <h2 class="text-lg font-semibold text-white mb-4">Other sample reports</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="/issues-report-demo.php" class="group flex gap-4 rounded-xl border border-neutral-600 bg-neutral-800/60 p-4 hover:border-red-500/50 transition-colors">
                    <div class="flex-shrink-0 w-24 h-16 rounded-lg bg-neutral-900 overflow-hidden">
                        <img src="/assets/images/issues-report.png" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-xs font-semibold text-red-400">Issues</span>
                        <h3 class="font-semibold text-white group-hover:text-red-400 transition-colors">Issues Report</h3>
                        <p class="text-sm text-neutral-400 mt-0.5">Invalid values and fix guidance</p>
                    </div>
                    <svg class="w-5 h-5 text-neutral-500 group-hover:text-red-400 flex-shrink-0 self-center" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="/cleaned-data-report-demo.php" class="group flex gap-4 rounded-xl border border-neutral-600 bg-neutral-800/60 p-4 hover:border-green-500/50 transition-colors">
                    <div class="flex-shrink-0 w-24 h-16 rounded-lg bg-neutral-900 overflow-hidden">
                        <img src="/assets/images/cleaned-data-report.png" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-xs font-semibold text-green-400">Cleaned</span>
                        <h3 class="font-semibold text-white group-hover:text-green-400 transition-colors">Cleaned Data Report</h3>
                        <p class="text-sm text-neutral-400 mt-0.5">Original vs cleaned values side by side</p>
                    </div>
                    <svg class="w-5 h-5 text-neutral-500 group-hover:text-green-400 flex-shrink-0 self-center" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-4">
            <a href="/example.php" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold transition-colors">
                Try it with sample data
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
            <a href="/index.php" class="inline-flex items-center gap-2 bg-neutral-700 hover:bg-neutral-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors border border-neutral-600">
                Upload your own file
            </a>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
