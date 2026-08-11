<?php
require_once __DIR__ . '/../includes/init.php';

// Set page meta
$pageTitle = 'Blog';
$pageDescription = 'Guides on UK data cleaning, validation, and GDPR compliance - phone numbers, NI numbers, postcodes, and sort codes.';

// Posts listed newest first. Add new posts here so they show up automatically.
$posts = [
    [
        'url' => '/blog/uk-data-cleansing-gdpr-guide.php',
        'title' => 'UK Data Cleansing for GDPR Compliance: Consultant or Self-Serve Tool?',
        'excerpt' => 'What UK GDPR actually requires when it comes to data accuracy - and how to decide between hiring a data cleansing consultant and using a browser-based tool.',
        'date' => 'August 11, 2026',
        'readTime' => '6 min read',
    ],
    [
        'url' => '/blog/ai-data-cleaning-limitations.php',
        'title' => "Why AI Isn't Always the Best Solution for Data Cleaning",
        'excerpt' => 'While AI has transformed many industries, rule-based validation still excels for precise data cleaning - especially for UK data formats.',
        'date' => 'January 4, 2026',
        'readTime' => '8 min read',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/blog/">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/blog/">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:site_name" content="Simple Data Cleaner">

    <!-- Blog Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      "name": "Simple Data Cleaner Blog",
      "description": "<?php echo htmlspecialchars($pageDescription); ?>",
      "url": "https://simple-data-cleaner.com/blog/"
    }
    </script>

    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main-content" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <header class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Blog</h1>
            <p class="text-xl text-neutral-400 max-w-2xl mx-auto">
                Guides on UK data cleaning, validation, and GDPR compliance.
            </p>
        </header>

        <div class="space-y-6">
            <?php foreach ($posts as $post): ?>
                <article class="ds-card ds-hover-lift p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-neutral-500 mb-3">
                        <span><?php echo htmlspecialchars($post['date']); ?></span>
                        <span aria-hidden="true">&middot;</span>
                        <span><?php echo htmlspecialchars($post['readTime']); ?></span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">
                        <a href="<?php echo htmlspecialchars($post['url']); ?>" class="hover:text-yellow-400 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </h2>
                    <p class="text-neutral-400 leading-relaxed mb-4">
                        <?php echo htmlspecialchars($post['excerpt']); ?>
                    </p>
                    <a href="<?php echo htmlspecialchars($post['url']); ?>" class="inline-flex items-center gap-1.5 text-yellow-400 hover:text-yellow-300 font-medium text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-950 rounded">
                        Read more
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
