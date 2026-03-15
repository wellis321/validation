<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Sample Issues Report';
$pageDescription = 'View a sample validation issues report showing how Simple Data Cleaner highlights problems in your data with clear fix guidance.';
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
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Sample Issues Report</h1>
            <p class="text-neutral-400 max-w-2xl">This is what you get when validation finds problems in your data. Each issue includes the invalid value, error message, and clear guidance on how to fix it — all UK-standard compliant.</p>
        </div>

        <div class="rounded-xl border border-neutral-700 overflow-hidden bg-neutral-900 shadow-2xl">
            <img src="/assets/images/issues-report.png" alt="Detailed Validation Issues Report — sample showing National Insurance validation errors with row, column, invalid value, error message, and fix guidance" class="w-full h-auto block">
        </div>

        <div class="mt-10">
            <h2 class="text-lg font-semibold text-white mb-4">Other sample reports</h2>
            <div class="grid grid-cols-2 gap-4">
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
                <a href="/full-preview-report-demo.php" class="group flex gap-4 rounded-xl border border-neutral-600 bg-neutral-800/60 p-4 hover:border-yellow-500/50 transition-colors">
                    <div class="flex-shrink-0 w-24 h-16 rounded-lg bg-neutral-900 overflow-hidden">
                        <img src="/assets/images/full-preview-report.png" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-xs font-semibold text-yellow-400">Preview</span>
                        <h3 class="font-semibold text-white group-hover:text-yellow-400 transition-colors">Full Preview Report</h3>
                        <p class="text-sm text-neutral-400 mt-0.5">What your downloaded file will contain</p>
                    </div>
                    <svg class="w-5 h-5 text-neutral-500 group-hover:text-yellow-400 flex-shrink-0 self-center" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
