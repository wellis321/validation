<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Sample Reports';
$pageDescription = 'View sample reports from Simple Data Cleaner: issues report, cleaned data report, and full preview. See what you get before uploading your own files.';
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
        <div class="mb-10 ds-animate-fade-slide ds-animate-delay-1">
            <a href="/index.php" class="group inline-flex items-center gap-2 text-neutral-400 hover:text-yellow-400 transition-colors text-sm font-medium mb-4">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to upload
            </a>
            <h1 class="text-2xl md:text-4xl font-bold text-white mb-2">Sample Reports</h1>
            <p class="text-neutral-400 max-w-2xl">See exactly what you get. Pick any report to explore a full sample — <span class="inline-flex items-center gap-1.5 text-neutral-300"><svg class="w-3.5 h-3.5 text-green-500/80 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>no signup or file upload required.</span></p>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            <!-- Issues Report -->
            <a href="/issues-report-demo.php" class="group block rounded-xl border border-neutral-600 bg-neutral-800/60 overflow-hidden hover:border-red-500/50 ds-animate-fade-slide ds-animate-delay-2 ds-hover-lift transition-colors">
                <div class="aspect-video bg-neutral-900 overflow-hidden">
                    <img src="/assets/images/issues-report.png" alt="" class="w-full h-full object-cover object-top group-hover:scale-[1.02] transition-transform duration-300" aria-hidden="true">
                </div>
                <div class="p-5">
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-red-500/20 text-red-400 mb-3">Issues</span>
                    <h2 class="text-lg font-bold text-white group-hover:text-red-400 transition-colors">Issues Report</h2>
                    <p class="text-neutral-400 text-sm mt-1">Invalid values, error messages, and fix guidance for every problem found.</p>
                </div>
            </a>

            <!-- Cleaned Data Report -->
            <a href="/cleaned-data-report-demo.php" class="group block rounded-xl border border-neutral-600 bg-neutral-800/60 overflow-hidden hover:border-green-500/50 ds-animate-fade-slide ds-animate-delay-3 ds-hover-lift transition-colors">
                <div class="aspect-video bg-neutral-900 overflow-hidden">
                    <img src="/assets/images/cleaned-data-report.png" alt="" class="w-full h-full object-cover object-top group-hover:scale-[1.02] transition-transform duration-300" aria-hidden="true">
                </div>
                <div class="p-5">
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-green-500/20 text-green-400 mb-3">Cleaned</span>
                    <h2 class="text-lg font-bold text-white group-hover:text-green-400 transition-colors">Cleaned Data Report</h2>
                    <p class="text-neutral-400 text-sm mt-1">Original vs cleaned values side by side for every field you validate.</p>
                </div>
            </a>

            <!-- Full Preview Report -->
            <a href="/full-preview-report-demo.php" class="group block rounded-xl border border-neutral-600 bg-neutral-800/60 overflow-hidden hover:border-yellow-500/50 ds-animate-fade-slide ds-animate-delay-4 ds-hover-lift transition-colors">
                <div class="aspect-video bg-neutral-900 overflow-hidden">
                    <img src="/assets/images/full-preview-report.png" alt="" class="w-full h-full object-cover object-top group-hover:scale-[1.02] transition-transform duration-300" aria-hidden="true">
                </div>
                <div class="p-5">
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-yellow-500/20 text-yellow-400 mb-3">Preview</span>
                    <h2 class="text-lg font-bold text-white group-hover:text-yellow-400 transition-colors">Full Preview Report</h2>
                    <p class="text-neutral-400 text-sm mt-1">Exactly what your downloaded file will contain, with color-coded changes.</p>
                </div>
            </a>
        </div>

        <div class="mt-12 flex flex-wrap gap-4 ds-animate-fade-slide ds-animate-delay-5">
            <a href="/example.php" class="group inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 active:scale-[0.98] text-black px-6 py-3 rounded-lg font-semibold transition-all duration-150">
                Try it with sample data
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
            <a href="/index.php" class="inline-flex items-center gap-2 bg-neutral-700 hover:bg-neutral-600 active:scale-[0.98] text-white px-6 py-3 rounded-lg font-semibold transition-all duration-150 border border-neutral-600">
                Upload your own file
            </a>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
