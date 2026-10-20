<?php
require_once __DIR__ . '/includes/init.php';

// Get user's subscription if logged in and database is available
$subscription = null;
$remainingRequests = 0;
if ($user) {
    try {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            $userModel = new User();
            $userModel->id = $user['id']; // Set the user ID
            $subscription = $userModel->getCurrentSubscription();
            $remainingRequests = $userModel->getRemainingRequests();
        }
    } catch (Exception $e) {
        // Database not available - app can still work for data cleaning
        $subscription = null;
        $remainingRequests = 0;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/">
    <title>UK Data Cleaning Tool | Browser-Based & GDPR Compliant | Simple Data Cleaner</title>
    <meta name="description" content="Clean and validate UK phone numbers, NI numbers, postcodes, bank sort codes, email addresses, and split names in your browser. 100% private - your data never leaves your device. GDPR compliant data cleaning for UK businesses. Try free example page.">
    <meta name="keywords" content="UK data cleaning, UK data validation, GDPR compliant data cleaning, browser-based data cleaning, UK phone number cleaning, UK postcode validation, NI number validation, privacy-first data cleaning, UK data cleaning tool, browser data validation">
    <meta property="og:title" content="Simple Data Cleaner - 100% Private UK Data Validation | GDPR Compliant">
    <meta property="og:description" content="Clean and validate UK phone numbers, NI numbers, postcodes, bank sort codes, bank account numbers, email addresses, and split names in your browser. 100% private - your data never leaves your device.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simple-data-cleaner.com/">
    <meta property="og:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta property="og:image:alt" content="Simple Data Cleaner - UK Data Validation Tool">
    <meta property="og:site_name" content="Simple Data Cleaner">
    <meta property="og:locale" content="en_GB">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Simple Data Cleaner - 100% Private UK Data Validation">
    <meta name="twitter:description" content="Clean UK data in your browser. Your data never leaves your device. Perfect for sensitive PII.">
    <meta name="twitter:image" content="https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png">
    <meta name="twitter:image:alt" content="Simple Data Cleaner Logo">
    <meta name="google-site-verification" content="xNV1Ea4p8zh3UTiU_dspG9ii8-ppLxE4_VnbiVYU2G4" />
    <link rel="stylesheet" href="/assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">

    <!-- JSON-LD Structured Data for Rich Results -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Simple Data Cleaner",
      "description": "UK data cleaning and validation tool. Clean and validate UK phone numbers, NI numbers, postcodes, bank sort codes, bank account numbers, email addresses, and split names in your browser. 100% private, GDPR compliant - your data never leaves your device.",
      "url": "https://simple-data-cleaner.com",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Web Browser",
      "keywords": "UK data cleaning, UK data validation, GDPR compliant data cleaning, browser-based data cleaning, UK phone number cleaning, UK postcode validation",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "GBP",
        "availability": "https://schema.org/InStock"
      },
      "featureList": [
        "UK Phone Number Validation",
        "National Insurance Number Validation",
        "UK Postcode Validation",
        "Bank Sort Code Validation",
        "Bank Account Number Validation",
        "Email Address Validation and Cleaning",
        "Name Splitting (Title, First Name, Last Name)",
        "Browser-based Processing",
        "GDPR Compliant",
        "100% Private Data Processing",
        "Detailed Issues Report with Explanations"
      ],
      "browserRequirements": "Requires JavaScript. Requires HTML5.",
      "softwareVersion": "1.0"
    }
    </script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Simple Data Cleaner",
      "url": "https://simple-data-cleaner.com",
      "logo": "https://simple-data-cleaner.com/assets/images/Data Cleaning Icon 300.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "Customer Service",
        "availableLanguage": "English"
      }
    }
    </script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Is my data private when using Simple Data Cleaner?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, 100% private. All data processing happens in your browser - your files never leave your device. No servers, no databases, no third parties can access your data."
          }
        },
        {
          "@type": "Question",
          "name": "What UK data formats can I validate?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Simple Data Cleaner validates UK phone numbers (mobile and landline), National Insurance numbers, UK postcodes, bank sort codes, bank account numbers, email addresses, and can split full names into title, first name, and last name. All validation follows official UK standards."
          }
        },
        {
          "@type": "Question",
          "name": "Is Simple Data Cleaner GDPR compliant?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, because all processing happens in your browser, we are not a data processor under GDPR. Your data never leaves your device, making it fully GDPR compliant."
          }
        },
        {
          "@type": "Question",
          "name": "What file formats are supported?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We support CSV, Excel (XLSX/XLS), and JSON file formats for upload. You can export cleaned data in CSV, Excel, or JSON formats."
          }
        }
      ]
    }
    </script>
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen">
        <?php if (!$user): ?>
            <!-- Hero: Animated shader background with gradient headline -->
            <section id="hero-shader-section" class="relative w-full overflow-hidden bg-black" style="height: 100vh; min-height: 600px;">
                <canvas
                    class="hero-shader-canvas absolute inset-0 z-0 w-full h-full object-cover touch-none"
                    style="background: black"
                    aria-hidden="true"
                ></canvas>
                <!-- Hero Content Overlay -->
                <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-white -translate-y-10">
                    <!-- Trust Badge -->
                    <div class="mb-8 hero-animate-fade-in-down">
                        <p class="flex items-center justify-center gap-2 px-5 py-2.5 bg-yellow-500/15 border border-yellow-400/30 rounded-full text-sm text-yellow-100">
                            <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            Runs in your browser · Nothing is uploaded
                        </p>
                    </div>
                    <div class="text-center space-y-6 max-w-5xl mx-auto px-4">
                        <!-- Main Heading -->
                        <div class="space-y-3 hero-animate-fade-in-up hero-animation-delay-200">
                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                                Clean UK data in your browser
                            </h1>
                            <p class="text-xl md:text-2xl text-yellow-100/90 font-light max-w-2xl mx-auto">
                                Phone numbers, postcodes, NI numbers, sort codes — validated instantly. Your data never leaves your device.
                            </p>
                        </div>
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10 hero-animate-fade-in-up hero-animation-delay-600">
                            <a href="/register.php" class="px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-black rounded-full font-semibold text-lg transition-colors text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                                Start Free Trial
                            </a>
                            <a href="/example.php" class="px-8 py-4 bg-yellow-500/10 hover:bg-yellow-500/20 border border-yellow-400/30 text-yellow-100 rounded-full font-semibold text-lg transition-colors text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                                Try Example
                            </a>
                        </div>
                        <p class="text-sm text-neutral-400 hero-animate-fade-in-up hero-animation-delay-600">
                            <span>7-day free trial · No card required</span>
                            <span class="mx-2">·</span>
                            <a href="/pricing.php" class="text-yellow-400 hover:text-yellow-300 font-medium underline underline-offset-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black rounded">View pricing</a>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Pain points: prose + before/after data visuals -->
            <section class="ds-scroll-reveal pain-points-section max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 md:pt-16 pb-6 md:pb-8" aria-labelledby="pain-points-heading">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
                    <!-- Left: Prose -->
                    <div class="flex flex-col min-h-0">
                        <h2 id="pain-points-heading" class="ds-reveal-item pain-points-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight pl-8 border-l-[8px] border-yellow-400 mb-8 transition-colors duration-300 whitespace-nowrap">Sound familiar?</h2>
                        <div class="space-y-5 text-neutral-200 text-lg md:text-xl leading-relaxed flex-1 flex flex-col justify-start">
                            <p class="ds-reveal-item">Phone numbers in every format. Postcodes with no spaces. NI numbers in lowercase. One export from your CRM, another from a survey — same data, five different styles. Manually fixing it means find-and-replace, copy-paste, and hoping you didn&rsquo;t miss a typo.</p>
                            <div class="ds-reveal-item">
                                <div class="ds-vocab-card rounded-xl border border-neutral-600/50 overflow-hidden flex flex-col">
                                    <div class="ds-vocab-list !min-h-0 !p-4 flex flex-col">
                                        <div class="ds-vocab-item">
                                            <i data-lucide="cloud" class="w-5 h-5 text-amber-400/80 flex-shrink-0" aria-hidden="true"></i>
                                            <span class="ds-vocab-label">Another cloud tool?</span>
                                        </div>
                                        <div class="ds-vocab-item">
                                            <i data-lucide="file-text" class="w-5 h-5 text-amber-400/80 flex-shrink-0" aria-hidden="true"></i>
                                            <span class="ds-vocab-label">GDPR paperwork?</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="pain-points-callout inline-block mt-3">No thanks!</span>
                            </div>
                            <div class="ds-reveal-item mt-6 pt-4 border-t border-neutral-600/50 space-y-4">
                                <p>That&rsquo;s why we built Simple Data Cleaner. Select your information and it validates, normalises, and formats everything to UK standards.</p>
                                <div class="ds-vocab-card rounded-xl border border-neutral-600/50 overflow-hidden">
                                    <div class="ds-vocab-list min-h-0 !p-4">
                                        <div class="ds-vocab-item">
                                            <i data-lucide="list-checks" class="w-5 h-5 text-yellow-400/80 flex-shrink-0" aria-hidden="true"></i>
                                            <span class="ds-vocab-label">Phones, postcodes, NI numbers, sort codes, bank accounts, emails, names</span>
                                        </div>
                                        <div class="ds-vocab-item">
                                            <i data-lucide="file-search" class="w-5 h-5 text-yellow-400/80 flex-shrink-0" aria-hidden="true"></i>
                                            <span class="ds-vocab-label">Invalid rows flagged in a report</span>
                                        </div>
                                        <div class="ds-vocab-item">
                                            <i data-lucide="shield-check" class="w-5 h-5 text-yellow-400/80 flex-shrink-0" aria-hidden="true"></i>
                                            <span class="ds-vocab-label">Runs in your browser — no uploads, no cloud, no paperwork</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right: The Solution — before/after cards (mirrors problem section) -->
                    <div class="ds-reveal-item flex flex-col">
                        <h2 class="ds-reveal-item pain-points-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight pl-8 border-l-[8px] border-green-500 mb-8 transition-colors duration-300 whitespace-nowrap">The Solution</h2>
                        <div class="grid grid-rows-[auto_auto_auto] gap-2 items-stretch">
                        <div class="flex flex-col min-h-0">
                            <p class="text-sm font-bold uppercase tracking-widest text-amber-400 mb-3">Your data today</p>
                            <div class="before-after-card before-after-before rounded-xl border-2 border-amber-500/40 bg-neutral-900/95 shadow-lg shadow-amber-950/30 p-0 overflow-hidden flex flex-col before-after-excel-grid">
                                <div class="font-mono text-base before-after-excel-rows">
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-amber-400 font-medium"><span>07700900461</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Mobile</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-400"><span>sw1a1aa</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Postcode</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-500"><span>ab123456c</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">NI number</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-500"><span>1.2.3.4.5.6</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Sort code</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-500"><span>12345678</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Bank account</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-500"><span> user@example.com </span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Email</span></div>
                                    <div class="before-after-row-excel flex items-center justify-between gap-3 py-2.5 px-5 text-neutral-500"><span>dr  john   smith</span><span class="text-neutral-500 font-sans text-sm font-normal shrink-0">Name</span></div>
                                </div>
                            </div>
                        </div>
                        <p class="ds-reveal-item text-neutral-200 text-lg md:text-xl leading-relaxed mt-2 mb-1">And you can&rsquo;t just upload this anywhere. Postcodes, NI numbers, customer details — it&rsquo;s sensitive.</p>
                        <div class="before-after-arrow text-yellow-400 flex items-center justify-center py-2" aria-hidden="true">
                            <svg class="w-8 h-8 animate-bounce-slow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                        </div>
                        <div class="flex flex-col min-h-0">
                            <p class="text-sm font-bold uppercase tracking-widest text-green-400 mb-3">After Simple Data Cleaner</p>
                            <div class="before-after-card before-after-after rounded-xl border-2 border-green-500/50 bg-neutral-900/95 p-0 overflow-hidden flex flex-col before-after-excel-grid before-after-glow">
                                <div class="font-mono text-base before-after-excel-rows">
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-green-400 font-medium"><span>+44 7700 900461</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Mobile</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-200"><span>SW1A 1AA</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Postcode</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-200"><span>AB 12 34 56 C</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">NI number</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-200"><span>12-34-56</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Sort code</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-200"><span>12 34 56 78</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Bank account</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 border-b border-neutral-700/80 text-neutral-200"><span>user@example.com</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Email</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                    <div class="before-after-row flex items-center justify-between gap-3 py-2.5 px-5 text-neutral-200"><span>Dr John Smith</span><span class="flex items-center gap-2 shrink-0"><span class="text-neutral-500 font-sans text-sm font-normal">Name</span><span class="before-after-check text-green-500 w-6 h-6 flex items-center justify-center" aria-hidden="true"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span></span></div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="ds-reveal-item flex items-center justify-center mt-20 pt-12 pb-6 md:mt-20 md:pt-16 md:pb-8">
                    <div class="px-6 py-5 border-l-4 border-yellow-500 bg-yellow-500/5 max-w-2xl">
                        <p class="text-center text-white text-lg md:text-xl font-semibold flex items-center justify-center gap-3">
                            <svg class="w-7 h-7 text-yellow-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            <span>All in your browser. No uploads, no cloud, no risk.</span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- GDPR & Privacy banner: why we're different -->
            <section id="privacy-banner" class="ds-scroll-reveal max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 md:pt-8 pb-12 md:pb-16" aria-labelledby="privacy-banner-heading">
                <hr class="ds-section-hr ds-section-hr-section-top" aria-hidden="true">
                <div class="grid lg:grid-cols-[1fr,minmax(300px,420px)] gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 id="privacy-banner-heading" class="ds-reveal-item text-2xl md:text-3xl font-bold text-white mb-4">GDPR &amp; privacy done right</h2>
                        <p class="ds-reveal-item text-neutral-300 text-lg leading-relaxed mb-6">Other tools upload your data to their servers. That means data processing agreements, extra paperwork, and risk. Simple Data Cleaner runs entirely in your browser — your files never leave your device.</p>
                        <ul class="space-y-3">
                            <li class="ds-reveal-item privacy-bullet group flex items-start gap-3 text-neutral-200 rounded-lg px-3 py-2 -mx-3 -my-1 transition-colors duration-200 hover:bg-neutral-800/40">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5 transition-transform duration-200 group-hover:scale-110" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">We're not a data processor</strong> — no GDPR Article 28 paperwork</span>
                            </li>
                            <li class="ds-reveal-item privacy-bullet group flex items-start gap-3 text-neutral-200 rounded-lg px-3 py-2 -mx-3 -my-1 transition-colors duration-200 hover:bg-neutral-800/40">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5 transition-transform duration-200 group-hover:scale-110" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">Zero uploads</strong> — sensitive PII stays on your machine</span>
                            </li>
                            <li class="ds-reveal-item privacy-bullet group flex items-start gap-3 text-neutral-200 rounded-lg px-3 py-2 -mx-3 -my-1 transition-colors duration-200 hover:bg-neutral-800/40">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5 transition-transform duration-200 group-hover:scale-110" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">Full reports in-browser</strong> — audit trail without sending data anywhere</span>
                            </li>
                        </ul>
                    </div>
                    <div class="ds-reveal-item">
                        <button type="button" id="privacy-report-image-btn" class="privacy-report-card rounded-xl border border-neutral-700 overflow-hidden shadow-2xl shadow-black/40 ring-1 ring-white/5 bg-neutral-900 transition-all duration-300 hover:border-neutral-600 hover:shadow-2xl hover:shadow-green-500/5 cursor-zoom-in w-full text-left block" aria-label="Click to view larger">
                            <img src="/assets/images/cleaned-data-report.png" alt="Cleaned Data Report showing phone numbers, NI numbers, postcodes and more — all processed in your browser with original and cleaned values side by side" class="w-full h-auto block">
                        </button>
                        <p class="mt-4 text-center text-sm text-neutral-500">Click image to view larger</p>
                    </div>
                </div>
                <hr class="ds-section-hr ds-section-hr-section-bottom ds-section-hr-tight-top" aria-hidden="true">
            </section>

            <!-- Why a UK-specific data cleaner -->
            <section id="uk-data-cleaner" class="ds-scroll-reveal max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 md:pt-8 pb-12 md:pb-16" aria-labelledby="uk-data-cleaner-heading">
                <div class="text-center max-w-3xl mx-auto mb-10">
                    <h2 id="uk-data-cleaner-heading" class="ds-reveal-item text-2xl md:text-3xl font-bold text-white mb-4">A UK data cleaner built on official standards</h2>
                    <p class="ds-reveal-item text-neutral-300 text-lg leading-relaxed">
                        Generic data cleansing tools guess. Simple Data Cleaner checks every field against the exact rules HMRC, Royal Mail, and Ofcom actually use for UK phone numbers, National Insurance numbers, postcodes, and sort codes.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="ds-reveal-item border border-neutral-700 rounded-lg p-6 bg-neutral-900/40">
                        <h3 class="text-lg font-semibold text-white mb-3">UK-specific by design</h3>
                        <p class="text-neutral-400 text-sm leading-relaxed">Not a generic international data cleansing tool retrofitted for the UK - every rule is written against HMRC, Royal Mail, and Ofcom standards from the start.</p>
                    </div>
                    <div class="ds-reveal-item border border-neutral-700 rounded-lg p-6 bg-neutral-900/40">
                        <h3 class="text-lg font-semibold text-white mb-3">Deterministic, not probabilistic</h3>
                        <p class="text-neutral-400 text-sm leading-relaxed">Every check is an exact rule, not an AI guess - so results are consistent every time. <a href="/blog/ai-data-cleaning-limitations.php" class="text-yellow-400 hover:text-yellow-300 underline">Why this matters more than AI</a>.</p>
                    </div>
                    <div class="ds-reveal-item border border-neutral-700 rounded-lg p-6 bg-neutral-900/40">
                        <h3 class="text-lg font-semibold text-white mb-3">An alternative to a consultant</h3>
                        <p class="text-neutral-400 text-sm leading-relaxed">For standard UK formats, get accurate results in minutes instead of a scoped engagement. <a href="/blog/uk-data-cleansing-gdpr-guide.php" class="text-yellow-400 hover:text-yellow-300 underline">Consultant vs. self-serve tool</a>.</p>
                    </div>
                </div>
                <p class="ds-reveal-item mt-8 text-center text-neutral-400">
                    See the <a href="/validation-rules.php" class="text-yellow-400 hover:text-yellow-300 underline font-semibold">exact UK data cleansing rules</a> we validate against.
                </p>
            </section>

            <!-- How It Works + What You Get (merged) -->
            <section class="ds-scroll-reveal max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 md:pt-24 pb-12 md:pb-16" aria-labelledby="how-it-works-heading">
                <h2 id="how-it-works-heading" class="ds-reveal-item text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">How it works</h2>
                <p class="ds-reveal-item text-neutral-300 text-lg md:text-xl mb-2">Three steps. Your data never leaves your device.</p>
                <p class="ds-reveal-item flex items-center gap-2 text-neutral-500 text-sm mb-12">
                    <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <span class="font-medium text-neutral-400">100% in your browser</span>
                </p>
                <ol class="space-y-8" role="list">
                    <li class="ds-reveal-item">
                        <div class="hiw-step-card flex gap-6 group">
                            <span class="hiw-step-num flex-shrink-0 w-14 h-14 rounded-none bg-yellow-500/25 text-yellow-400 flex items-center justify-center font-bold text-xl ring-2 ring-yellow-500/40" aria-hidden="true">1</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2 tracking-tight">
                                    <i data-lucide="upload" class="w-6 h-6 text-yellow-400 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    Upload
                                </h3>
                                <p class="text-neutral-300 text-base md:text-lg mt-2 leading-relaxed">CSV, Excel, or JSON. <span class="text-yellow-400 font-semibold">Your file stays on your computer.</span></p>
                            </div>
                        </div>
                    </li>
                    <li class="ds-reveal-item">
                        <div class="hiw-step-card flex gap-6 group">
                            <span class="hiw-step-num flex-shrink-0 w-14 h-14 rounded-none bg-yellow-500/25 text-yellow-400 flex items-center justify-center font-bold text-xl ring-2 ring-yellow-500/40" aria-hidden="true">2</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2 tracking-tight">
                                    <i data-lucide="list-checks" class="w-6 h-6 text-yellow-400 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    Select &amp; clean
                                </h3>
                                <p class="text-neutral-300 text-base md:text-lg mt-2 leading-relaxed">Pick columns (phone, NI, postcode, sort code, email, names). <span class="text-yellow-400 font-semibold">Auto-detect available.</span></p>
                            </div>
                        </div>
                    </li>
                    <li class="ds-reveal-item">
                        <div class="hiw-step-card flex gap-6 group">
                            <span class="hiw-step-num flex-shrink-0 w-14 h-14 rounded-none bg-yellow-500/25 text-yellow-400 flex items-center justify-center font-bold text-xl ring-2 ring-yellow-500/40" aria-hidden="true">3</span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2 tracking-tight">
                                    <i data-lucide="download" class="w-6 h-6 text-yellow-400 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    Download
                                </h3>
                                <p class="text-neutral-300 text-base md:text-lg mt-2 leading-relaxed">Export CSV, Excel, or JSON. <span class="text-yellow-400 font-semibold">Full issues report included.</span></p>
                            </div>
                        </div>
                    </li>
                </ol>
                <hr class="ds-section-hr ds-reveal-item" aria-hidden="true">
                <div class="ds-reveal-item">
                    <div class="grid lg:grid-cols-2 gap-8 items-stretch">
                        <!-- Left: We validate data types -->
                        <div class="ds-vocab-card shadow-2xl shadow-black/40 ring-1 ring-white/10">
                            <div class="px-6 py-4 border-b border-white/5 flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center border border-green-500/20 mt-0.5" aria-hidden="true">
                                    <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                                </span>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <h3 class="text-lg font-semibold text-white">We validate</h3>
                                        <p class="text-sm text-neutral-500">7 UK data types</p>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-300 mt-2 flex items-center gap-1.5">
                                        <span>Click one</span>
                                        <span class="text-yellow-400" aria-hidden="true">→</span>
                                        <span class="text-yellow-400/95">cleaned instantly</span>
                                    </p>
                                </div>
                            </div>
                            <div class="ds-vocab-list">
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="07700 900 123" aria-label="Try phone number example">
                                    <i data-lucide="phone" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Phone numbers</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="  ab.12.34.56.c  " aria-label="Try NI number example">
                                    <i data-lucide="badge" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">NI numbers</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="  sw1a.1aa  " aria-label="Try postcode example">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Postcodes</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="1.2.3.4.5.6" aria-label="Try sort code example">
                                    <i data-lucide="hash" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Sort codes</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="12 34 56 78" aria-label="Try bank account example">
                                    <i data-lucide="landmark" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Bank accounts</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="user@gmial.com" aria-label="Try email example">
                                    <i data-lucide="mail" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Emails</span>
                                </div>
                                <div class="ds-reveal-item ds-vocab-item group cursor-pointer" role="button" tabindex="0" data-sample="  dr.  john   smith  " aria-label="Try name splitting example">
                                    <i data-lucide="type" class="w-5 h-5 text-yellow-400/80 flex-shrink-0 group-hover:text-yellow-300 transition-colors" aria-hidden="true"></i>
                                    <span class="ds-vocab-label">Name splitting</span>
                                </div>
                            </div>
                        </div>
                        <!-- Right: Try it - Interactive demo -->
                        <div class="ds-reveal-item flex flex-col">
                            <h3 id="try-demo-heading" class="text-xl md:text-2xl font-bold text-white mb-2 tracking-tight">Try it now</h3>
                            <p class="text-base md:text-lg font-medium text-neutral-300 mb-5">Messy data in. Clean data out. <span class="text-yellow-400 font-semibold">Instant.</span></p>
                            <div class="try-demo-card flex-1 flex flex-col bg-neutral-900/95 rounded-2xl border border-neutral-600/80 p-6 md:p-8 transition-all duration-300 focus-within:border-yellow-500/50 focus-within:shadow-[0_0_0_1px_rgba(234,179,8,0.2)] min-h-[280px]">
                                <label for="mini-demo-input" class="try-demo-label ds-reveal-item block text-sm font-semibold uppercase tracking-wider text-neutral-400 mb-3 transition-colors duration-200">Paste or type — we'll clean it</label>
                                <div class="ds-reveal-item flex flex-wrap gap-1.5 mb-3">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide bg-yellow-500/10 text-yellow-400/90 border border-yellow-500/20">Phone</span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide bg-yellow-500/10 text-yellow-400/90 border border-yellow-500/20">NI</span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide bg-yellow-500/10 text-yellow-400/90 border border-yellow-500/20">Postcode</span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide bg-yellow-500/10 text-yellow-400/90 border border-yellow-500/20">Sort code</span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wide bg-yellow-500/10 text-yellow-400/90 border border-yellow-500/20">Email</span>
                                </div>
                                <input type="text" id="mini-demo-input" placeholder="e.g. 07700900123, AB123456C, SW1A1AA..." class="ds-reveal-item w-full px-4 py-4 text-base md:text-lg bg-neutral-800/80 border-2 border-neutral-600 rounded-xl text-white placeholder-neutral-500 focus:outline-none focus:border-yellow-500/60 focus:bg-neutral-800 transition-colors duration-200" aria-describedby="mini-demo-output">
                                <div class="ds-reveal-item mt-5 p-5 bg-neutral-800/60 rounded-xl border border-neutral-700/80 flex-1 flex flex-col justify-center min-h-[4.5rem]">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2">Result</p>
                                    <div id="mini-demo-output" class="try-demo-result is-empty flex items-center gap-2 min-h-[1.75rem] text-lg md:text-xl font-mono" role="status" aria-live="polite">
                                        <span class="try-demo-check hidden flex-shrink-0 text-green-400" aria-hidden="true">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        </span>
                                        <span class="try-demo-text">—</span>
                                    </div>
                                </div>
                                <p class="mt-5 flex gap-2 text-sm font-semibold text-neutral-400">
                                    <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    <span class="flex flex-col">
                                        <span>100% in-browser.</span>
                                        <span>Nothing leaves your device.</span>
                                    </span>
                                </p>
                            </div>
                            <a href="/validation-rules.php" class="hiw-rules-link group mt-4 inline-flex items-center gap-1.5 text-yellow-400 hover:text-yellow-300 font-medium text-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black rounded relative pb-0.5" title="See every validation rule we support">
                                <span class="relative inline-block">Full rules
                                    <span class="hiw-rules-underline absolute bottom-0 left-0 h-px w-0 bg-yellow-400/80 group-hover:w-full" aria-hidden="true"></span>
                                </span>
                                <span class="hiw-arrow" aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Key info (always visible, no toggles) -->
            <section id="key-info" class="ds-scroll-reveal max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-0 md:pt-12" aria-labelledby="key-info-heading">
                <hr class="ds-section-hr ds-section-hr-section-top" aria-hidden="true">
                <h2 id="key-info-heading" class="ds-reveal-item text-2xl font-bold text-white mb-2">What you should know</h2>
                <p class="ds-reveal-item text-neutral-400 text-sm mb-6">Everything you need in one place.</p>
                <div class="space-y-6">
                    <article class="ds-reveal-item key-info-item group flex gap-4 transition-colors duration-200">
                        <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20 group-hover:border-yellow-500/40 transition-colors" aria-hidden="true">
                            <i data-lucide="lock" class="w-6 h-6 text-yellow-400 group-hover:text-yellow-300 transition-colors"></i>
                        </span>
                        <div>
                            <h3 class="font-semibold text-yellow-200 mb-1.5 transition-colors duration-200 group-hover:text-yellow-100">Is my data private?</h3>
                            <p class="text-neutral-300 text-base leading-relaxed">Yes, 100% private. All data processing happens in your browser — your files never leave your device. No servers, no databases, no third parties can access your data.</p>
                        </div>
                    </article>
                    <article class="ds-reveal-item key-info-item group flex gap-4 transition-colors duration-200">
                        <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20 group-hover:border-yellow-500/40 transition-colors" aria-hidden="true">
                            <i data-lucide="list" class="w-6 h-6 text-yellow-400 group-hover:text-yellow-300 transition-colors"></i>
                        </span>
                        <div>
                            <h3 class="font-semibold text-yellow-200 mb-1.5 transition-colors duration-200 group-hover:text-yellow-100">What UK data formats can I validate?</h3>
                            <p class="text-neutral-300 text-base leading-relaxed">UK phone numbers (mobile and landline), National Insurance numbers, postcodes, bank sort codes and account numbers, email addresses, and name splitting. All validation follows official UK standards.</p>
                        </div>
                    </article>
                    <article class="ds-reveal-item key-info-item group flex gap-4 transition-colors duration-200">
                        <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20 group-hover:border-yellow-500/40 transition-colors" aria-hidden="true">
                            <i data-lucide="shield-check" class="w-6 h-6 text-yellow-400 group-hover:text-yellow-300 transition-colors"></i>
                        </span>
                        <div>
                            <h3 class="font-semibold text-yellow-200 mb-1.5 transition-colors duration-200 group-hover:text-yellow-100">Is it GDPR compliant?</h3>
                            <p class="text-neutral-300 text-base leading-relaxed">Yes. Because all processing happens in your browser, we are not a data processor under GDPR. Your data never leaves your device.</p>
                        </div>
                    </article>
                    <article class="ds-reveal-item key-info-item group flex gap-4 transition-colors duration-200">
                        <span class="flex-shrink-0 w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20 group-hover:border-yellow-500/40 transition-colors" aria-hidden="true">
                            <i data-lucide="file-text" class="w-6 h-6 text-yellow-400 group-hover:text-yellow-300 transition-colors"></i>
                        </span>
                        <div>
                            <h3 class="font-semibold text-yellow-200 mb-1.5 transition-colors duration-200 group-hover:text-yellow-100">What file formats are supported?</h3>
                            <p class="text-neutral-300 text-base leading-relaxed">Upload CSV, Excel (XLSX/XLS), or JSON. Export cleaned data in CSV, Excel, or JSON.</p>
                        </div>
                    </article>
                </div>
                <hr class="ds-section-hr ds-section-hr-tight ds-reveal-item" aria-hidden="true">
                <div class="ds-reveal-item key-info-cta flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/register.php" class="key-cta-link group inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold shadow-lg shadow-black/20 transition-all duration-200 hover:shadow-xl hover:shadow-yellow-500/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        Start free trial
                        <span class="key-cta-arrow opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200" aria-hidden="true">→</span>
                    </a>
                    <a href="/pricing.php" class="key-pricing-link inline-flex items-center justify-center px-5 py-2.5 rounded-lg border-2 border-neutral-600 text-neutral-300 hover:border-yellow-500/60 hover:text-white transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        Pricing
                    </a>
                </div>
            </section>

        <?php endif; ?>

        <!-- File Upload Section -->
        <?php if ($user): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-4xl mx-auto bg-neutral-900 rounded-xl shadow-lg border border-neutral-700 p-8">
                <h2 class="text-2xl font-bold text-center text-white mb-2">Upload & Clean Your Data</h2>
                <p class="text-center text-neutral-400 mb-8 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Your files are processed in your browser - 100% private & secure
                </p>

                <?php if (!$subscription): ?>
                    <!-- Subscription Info Message -->
                    <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Start Your 7-Day Free Trial</h3>
                        <p class="text-neutral-400 mb-4">
                            New users get 7 days of full access — upload your own files, clean unlimited data, export results. No card required.
                        </p>
                        <a href="/register.php" class="inline-block ds-btn-primary px-6 py-2">
                            Sign Up Free
                        </a>
                        <span class="text-neutral-500 mx-3">or</span>
                        <a href="/pricing.php" class="inline-block text-yellow-400 hover:text-yellow-300 underline">
                            View Plans
                        </a>
                    </div>
                <?php else: ?>
                    <?php
                    // Check if current subscription is a trial
                    $subscriptionFeatures = json_decode($subscription['features'] ?? '{}', true) ?: [];
                    $isTrial = !empty($subscriptionFeatures['trial']);
                    if ($isTrial && isset($subscription['end_date'])) {
                        $endDate = new DateTime($subscription['end_date']);
                        $now = new DateTime();
                        $daysLeft = $now->diff($endDate)->days;
                        $hoursLeft = $now->diff($endDate)->h;
                        $isExpiringSoon = $daysLeft <= 2;
                    ?>
                        <!-- Trial Countdown Message -->
                        <div class="bg-gradient-to-r from-green-500/10 to-yellow-500/10 border border-green-500/30 rounded-lg p-6 mb-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-1 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Free Trial Active
                                    </h3>
                                    <p class="text-neutral-300 mb-2">
                                        <?php if ($daysLeft > 0): ?>
                                            You have <span class="font-bold text-green-400"><?php echo $daysLeft; ?> day<?php echo $daysLeft !== 1 ? 's' : ''; ?></span> left in your free trial.
                                        <?php else: ?>
                                            Your trial expires in <span class="font-bold text-green-400"><?php echo $hoursLeft; ?> hour<?php echo $hoursLeft !== 1 ? 's' : ''; ?></span>.
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-sm text-neutral-400">
                                        Full access to all features. Subscribe before it ends to continue cleaning your data.
                                    </p>
                                </div>
                                <a href="/pricing.php" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-lg font-semibold transition-colors whitespace-nowrap ml-4">
                                    <?php echo $isExpiringSoon ? 'Subscribe Now' : 'View Plans'; ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php endif; ?>

                <!-- File Upload Form (always visible to authenticated users) -->
                <form id="uploadForm" class="space-y-6 <?php echo !$subscription ? 'opacity-50 pointer-events-none' : ''; ?>">
                    <div id="fileDropZone" class="border-2 border-dashed border-neutral-500 rounded-2xl p-10 md:p-14 lg:p-16 text-center bg-yellow-500/[0.04] hover:bg-yellow-500/[0.06] hover:border-yellow-500/60 transition-all duration-300">
                        <input type="file" id="fileInput" class="hidden" accept=".csv,.xlsx,.xls,.txt,.json" <?php echo !$subscription ? 'disabled' : ''; ?>>
                        <label for="fileInput" class="cursor-pointer block">
                            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full ring-2 ring-yellow-500/25 ring-offset-4 ring-offset-neutral-900 mb-6">
                                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">Drop your file here or click to choose</h3>
                            <p class="text-base text-neutral-400 max-w-lg mx-auto mb-1">CSV, Excel (.xlsx, .xls), JSON, or text files</p>
                            <?php if ($subscription): ?><p class="text-sm text-neutral-500 mt-3">First time? <a href="/example.php" class="text-yellow-400 hover:text-yellow-300 underline">Try with sample data</a> to see how it works.</p><?php endif; ?>
                            <p id="fileSizeLimit" class="text-xs text-neutral-500 mt-2"></p>
                        </label>
                    </div>

                    <?php if ($subscription): ?>
                        <div class="bg-neutral-800/60 border border-neutral-700 rounded-xl p-4 mb-6">
                            <h3 class="font-semibold text-white mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Your Plan Benefits:
                            </h3>
                            <ul class="space-y-2 text-sm text-neutral-300">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Large files supported (processed in your browser)
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Unlimited files
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    All data types: Phone, NI, Postcodes, Sort Codes, Bank Accounts, Email, Name Splitting
                                </li>
                                <?php
                                $features = json_decode($subscription['features'], true);
                                ?>
                                <?php if ($features['priority_support']): ?>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Priority email support
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- File Selected State (hidden by default) -->
                    <div id="fileSelected" class="hidden mt-6 bg-green-500/10 border border-green-500/30 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-8 h-8 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-white"><span id="fileName"></span></p>
                                    <p class="text-sm text-neutral-400"><span id="fileSize"></span></p>
                                </div>
                            </div>
                            <button type="button" id="chooseDifferentBtn" class="text-neutral-400 hover:text-white transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 rounded px-2 py-1">
                                Change file
                            </button>
                        </div>
                    </div>

                    <!-- Field Selection (hidden by default) -->
                    <div id="fieldSelection" class="hidden mt-6 space-y-6">
                        <div class="ds-card-compact">
                            <h3 class="text-lg font-semibold text-white mb-1">Select columns to clean</h3>
                            <p class="text-sm text-neutral-400 mb-4">Pick which columns contain UK data to validate. Use Auto-Select to detect phone, NI, postcode, sort code, email, and name columns automatically.</p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <button type="button" id="selectAllBtn" class="px-4 py-2 bg-neutral-700 text-white rounded-lg hover:bg-neutral-600 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">Select All</button>
                                <button type="button" id="clearAllBtn" class="px-4 py-2 bg-neutral-700 text-white rounded-lg hover:bg-neutral-600 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">Clear All</button>
                                <button type="button" id="autoSelectBtn" class="px-4 py-2 ds-btn-primary text-sm">Auto-Select</button>
                            </div>
                            <div id="fieldCheckboxes"></div>
                        </div>
                        <div id="fieldSelectionStatus" class="mt-3 text-neutral-300"></div>

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
                    </div>

                    <!-- Preview Section (hidden by default) -->
                    <div id="previewSection" class="hidden mt-6 ds-preview-card ds-animate-fade-slide border border-neutral-600 bg-neutral-800/60 p-5">
                        <h4 class="font-semibold text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview: What will happen
                        </h4>
                        <div id="transformationSummary" class="mb-4 text-neutral-300">
                            <!-- Plain English descriptions will be inserted here -->
                        </div>
                        <div id="previewBeforeAfter" class="mt-4">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-sm font-semibold text-neutral-300">Data preview (first 5 rows)</h5>
                                <div class="flex items-center gap-2">
                                    <button type="button" id="previewToggleBefore" class="ds-preview-toggle-btn px-3 py-1.5 text-xs font-medium rounded-lg border-2 border-yellow-500 bg-yellow-500 text-black transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                                        Before
                                    </button>
                                    <button type="button" id="previewToggleAfter" class="ds-preview-toggle-btn px-3 py-1.5 text-xs font-medium rounded-lg border-2 border-neutral-600 bg-neutral-700 text-neutral-300 hover:border-neutral-500 hover:bg-neutral-600 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                                        After
                                    </button>
                                </div>
                            </div>
                            <div class="overflow-x-auto border border-neutral-600 bg-neutral-900">
                                <table class="min-w-full border-collapse text-xs" id="previewBeforeAfterTable">
                                    <thead id="previewBeforeAfterHeader">
                                        <!-- Headers will be inserted here -->
                                    </thead>
                                    <tbody id="previewBeforeAfterBody">
                                        <!-- Preview data will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Process Button (hidden by default) -->
                    <button type="button" id="processBtn" class="hidden w-full ds-btn-primary py-4 text-lg shadow-lg shadow-yellow-500/20 hover:shadow-yellow-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                        Clean My Data
                    </button>

                    <!-- Error Display (hidden by default) -->
                    <div id="errorDisplay" class="hidden bg-red-50 border-2 border-red-400 rounded p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-red-800" id="errorTitle">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p id="errorMessage"></p>
                                </div>
                                <div id="errorSuggestion" class="hidden mt-3 text-sm">
                                    <div class="bg-red-100 border border-red-200 rounded-md p-3">
                                        <p class="font-medium text-red-800 mb-1">What to try:</p>
                                        <p id="errorSuggestionText" class="text-red-700"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Overlay – upload-style progress card with animations -->
                    <div id="loadingOverlay" class="hidden fixed inset-0 flex items-center justify-center z-50 ds-loading-overlay-backdrop" style="background: rgba(0,0,0,0.75);">
                        <div id="loadingOverlayCard" class="ds-loading-overlay-card bg-neutral-900 rounded-2xl border border-neutral-700 shadow-2xl p-6 md:p-8 max-w-md w-full mx-4 overflow-hidden">
                            <!-- Processing state -->
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
                            <!-- Success state (hidden by default) -->
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

                    <!-- Duplicate Removal Confirmation Dialog (hidden by default) -->
                    <div id="duplicateConfirmDialog" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 overflow-y-auto">
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 w-full max-w-md md:max-w-lg">
                                <div class="mb-6">
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base md:text-lg font-bold text-gray-900">Confirm Duplicate Removal</h3>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-4">
                                        You're about to permanently remove <strong id="duplicateRemovalCount" class="text-amber-700">0</strong> duplicate row(s) from your export. This action cannot be undone.
                                    </p>

                                    <div class="bg-amber-50 border-l-4 border-yellow-500 p-3">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-xs md:text-sm text-amber-800">
                                                    The first occurrence of each duplicate will be kept. All subsequent duplicates will be removed.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <button id="cancelDuplicateRemoval" class="bg-gray-200 text-gray-700 px-4 py-2.5 md:px-6 md:py-3 rounded-lg hover:bg-gray-300 font-semibold transition-colors text-sm md:text-base">
                                        Cancel
                                    </button>
                                    <button id="confirmDuplicateRemoval" class="bg-amber-600 text-white px-4 py-2.5 md:px-6 md:py-3 rounded-lg hover:bg-amber-700 font-semibold transition-colors text-sm md:text-base">
                                        Remove Duplicates
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section (hidden by default) -->
                    <div id="resultsSection" class="hidden mt-8">
                        <h3 class="text-2xl font-bold text-white mb-4">Results</h3>
                        <!-- Data Profiling Section -->
                        <div id="dataProfilingSection" class="mb-8 hidden">
                            <h4 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                1. Data Profiling
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="ds-card-compact p-4 border-yellow-500/30">
                                    <p class="text-sm text-neutral-400 font-medium">Missing Values</p>
                                    <p class="text-2xl font-bold text-white" id="totalMissing">0</p>
                                    <button type="button" id="showMissingValuesBtn" class="hidden mt-2 text-xs text-yellow-400 hover:text-yellow-300 underline focus:outline-none">View details</button>
                                    <p class="text-xs text-neutral-500 mt-1">Empty, null, or N/A values</p>
                                </div>
                                <div class="ds-card-compact p-4 border-yellow-500/30">
                                    <p class="text-sm text-neutral-400 font-medium">Duplicate Rows</p>
                                    <p class="text-2xl font-bold text-white" id="totalDuplicates">0</p>
                                </div>
                                <div class="ds-card-compact p-4 border-green-500/30">
                                    <p class="text-sm text-neutral-400 font-medium">Unique Rows</p>
                                    <p class="text-2xl font-bold text-green-400" id="uniqueRows">0</p>
                                </div>
                            </div>

                            <!-- Missing Values by Column -->
                            <div id="missingValuesTable" class="hidden mb-6">
                                <h5 class="text-lg font-semibold mb-3 text-neutral-200">Missing Values by Column</h5>
                                <p class="text-sm text-neutral-500 mb-3">Columns with empty, null, or N/A values in your data</p>
                                <div class="border border-neutral-600 bg-neutral-800 overflow-hidden">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Column</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-neutral-300 bg-neutral-800">Missing Count</th>
                                            </tr>
                                        </thead>
                                        <tbody id="missingValuesTableBody" class="divide-y divide-neutral-700">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div id="summaryCards" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="ds-card-compact p-4">
                                <p class="text-sm text-neutral-400">Total Rows</p>
                                <p class="text-2xl font-bold text-white" id="totalRows">0</p>
                            </div>
                            <div class="ds-card-compact p-4">
                                <p class="text-sm text-neutral-400">Valid</p>
                                <p class="text-2xl font-bold text-green-400" id="totalValid">0</p>
                            </div>
                            <div class="ds-card-compact p-4">
                                <p class="text-sm text-neutral-400">Fixed</p>
                                <p class="text-2xl font-bold text-yellow-400" id="totalFixed">0</p>
                            </div>
                            <div class="ds-card-compact p-4">
                                <p class="text-sm text-neutral-400">Invalid</p>
                                <p class="text-2xl font-bold text-red-400" id="totalInvalid">0</p>
                            </div>
                        </div>

                        <!-- Tabs – segmented control, no gap, bordered separators -->
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
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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
                                        Your cleaned data is only available in your browser session. Once you close this tab or refresh the page, your cleaned data will be gone. We don't store files on our servers - <strong class="text-white">make sure to download and save your file immediately!</strong>
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
                                            <span class="text-sm text-neutral-400 block mt-1">When checked, you'll download <strong>only</strong> the rows that have validation issues (instead of the full file). Perfect for creating a focused review file to fix manually before merging back into your main dataset.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div id="nameSplitOptions" class="hidden bg-neutral-800/60 p-4 border border-neutral-600">
                                <h5 class="text-sm font-semibold text-white mb-3">Name Splitting Options:</h5>
                                <div class="space-y-4">
                                    <label class="flex items-start cursor-pointer group hover:bg-neutral-700/50 p-2 rounded -m-2 transition-colors">
                                        <input type="checkbox" id="removeOriginalNameColumns" class="mt-1 mr-3 h-4 w-4 text-yellow-500 focus:ring-pink-500 border-neutral-600 rounded bg-neutral-800">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-neutral-200 block">Remove Original Name Columns</span>
                                            <span class="text-sm text-neutral-400 block mt-1">When checked, the original name columns (e.g., <code class="bg-neutral-700 px-1 rounded text-yellow-400 font-mono text-xs">full_name</code>) will be removed from the export, keeping only the new <code class="bg-neutral-700 px-1 rounded text-yellow-400 font-mono text-xs">first_name</code> and <code class="bg-neutral-700 px-1 rounded text-yellow-400 font-mono text-xs">last_name</code> columns.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Download Confirmation Summary -->
                        <div id="downloadSummary" class="hidden mt-6 ds-card-compact p-6 border-yellow-500/40">
                            <h4 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ready to Download
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-neutral-800/60 p-4 border border-neutral-600">
                                    <div class="text-2xl font-bold text-white" id="summaryTotalRows">0</div>
                                    <div class="text-sm text-neutral-400">Total rows</div>
                                </div>
                                <div class="bg-neutral-800/60 p-4 border border-neutral-600">
                                    <div class="text-2xl font-bold text-green-400" id="summaryCleanedFields">0</div>
                                    <div class="text-sm text-neutral-400">Fields cleaned</div>
                                </div>
                                <div class="bg-neutral-800/60 p-4 border border-neutral-600">
                                    <div class="text-2xl font-bold text-amber-400" id="summaryIssueRows">0</div>
                                    <div class="text-sm text-neutral-400">Rows with issues</div>
                                </div>
                            </div>
                            <div class="bg-neutral-800/60 p-4 border border-neutral-600 space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-neutral-200">Row order:</span>
                                    <span class="text-neutral-400">Preserved as uploaded</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-neutral-200">Column structure:</span>
                                    <span class="text-neutral-400">All <span id="summaryTotalCols">0</span> columns preserved</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium text-neutral-200">Protected columns:</span>
                                    <span class="text-neutral-400" id="summaryProtectedCols">None detected</span>
                                </div>
                                <div class="flex items-center gap-2" id="summaryDuplicatesRow">
                                    <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-neutral-200">Duplicate rows:</span>
                                    <span class="text-neutral-400" id="summaryDuplicates">Checking...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Export Buttons -->
                        <div class="mt-8 flex flex-wrap gap-4">
                            <button type="button" id="exportBtn" class="ds-btn-primary px-8 py-3">
                                Download Cleaned File
                            </button>
                            <button type="button" id="processNewBtn" class="bg-neutral-600 hover:bg-neutral-500 text-white px-6 py-3 rounded-lg transition-colors font-semibold">
                                Upload New File
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!$user): ?>
        <!-- What you get when you upload - flows with dark theme -->
        <section class="ds-scroll-reveal max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-6 md:pt-16 md:pb-8">
            <hr class="ds-section-hr ds-section-hr-section-top" aria-hidden="true">
            <h2 class="ds-reveal-item text-2xl font-bold text-white mb-2">What you get when you upload</h2>
            <p class="ds-reveal-item text-neutral-400 max-w-2xl mb-10">Beyond UK validation — duplicates, whitespace, export formats, and detailed reports. All in your browser.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
                <div class="ds-animate-fade-slide ds-animate-delay-1 ds-hover-lift bg-neutral-900 rounded-xl border border-neutral-700 p-6 hover:border-neutral-600 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-1">Duplicate removal</h3>
                            <p class="text-neutral-400 text-sm">Detect exact duplicate rows, preview before export, optionally remove on download.</p>
                        </div>
                    </div>
                </div>
                <div class="ds-animate-fade-slide ds-animate-delay-2 ds-hover-lift bg-neutral-900 rounded-xl border border-neutral-700 p-6 hover:border-neutral-600 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-1">Whitespace cleaning</h3>
                            <p class="text-neutral-400 text-sm">Trim spaces, normalize formatting across all columns automatically.</p>
                        </div>
                    </div>
                </div>
                <div class="ds-animate-fade-slide ds-animate-delay-3 ds-hover-lift bg-neutral-900 rounded-xl border border-neutral-700 p-6 hover:border-neutral-600 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-1">Export your way</h3>
                            <p class="text-neutral-400 text-sm">CSV, Excel, or JSON — regardless of upload format. Include an issues column if you need it.</p>
                        </div>
                    </div>
                </div>
                <div class="ds-animate-fade-slide ds-animate-delay-4 ds-hover-lift bg-neutral-900 rounded-xl border border-neutral-700 p-6 hover:border-neutral-600 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-1">Detailed reports</h3>
                            <p class="text-neutral-400 text-sm mb-2">HTML reports for issues, cleaned data, and preview — exportable, shareable, UK-standard explanations.</p>
                            <a href="/sample-reports.php" class="text-sm font-medium text-yellow-400 hover:text-yellow-300 transition-colors inline-flex items-center gap-1">
                                View sample reports
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <!-- Try the example – sample data, reports, full workflow -->
            <section class="ds-scroll-reveal max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16" aria-labelledby="try-example-heading">
                <hr class="ds-section-hr ds-section-hr-section-top" aria-hidden="true">
                <div class="grid lg:grid-cols-[1fr,minmax(300px,420px)] gap-8 lg:gap-12 items-center">
                    <div>
                        <h2 id="try-example-heading" class="ds-reveal-item ds-section-title text-3xl font-bold text-white mb-4 text-left">Try it with sample data — no signup</h2>
                        <p class="ds-reveal-item text-neutral-300 text-lg leading-relaxed mb-6">Upload our pre-built test file and run through the full workflow. Validate UK data, see the issues report, preview cleaned results, and export — exactly what you'd get with your own files.</p>
                        <ul class="ds-reveal-item space-y-3">
                            <li class="flex items-start gap-3 text-neutral-200">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-yellow-500/20 flex items-center justify-center mt-0.5" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">Pre-loaded test file</strong> — phones, NI numbers, postcodes, and more</span>
                            </li>
                            <li class="flex items-start gap-3 text-neutral-200">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-yellow-500/20 flex items-center justify-center mt-0.5" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">Full HTML reports</strong> — issues, cleaned data preview, audit trail. <a href="/sample-reports.php" class="text-yellow-400 hover:text-yellow-300 underline underline-offset-2">See samples</a></span>
                            </li>
                            <li class="flex items-start gap-3 text-neutral-200">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-yellow-500/20 flex items-center justify-center mt-0.5" aria-hidden="true">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <span><strong class="text-white">Export CSV or Excel</strong> — same output you'd get with your own data</span>
                            </li>
                        </ul>
                        <a href="/example.php" class="ds-reveal-item mt-6 inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                            Open the example
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    </div>
                    <div class="ds-reveal-item">
                        <a href="/example.php" class="block group focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-950 rounded-xl">
                            <div class="rounded-xl border border-neutral-700 overflow-hidden shadow-2xl shadow-black/40 ring-1 ring-white/5 bg-neutral-900 transition-all duration-300 group-hover:border-neutral-600">
                                <img src="/assets/images/try-with-example-data.png" alt="Try with Example Data — load sample UK data to try the tool in your browser, 100% private &amp; secure" class="w-full h-auto block">
                            </div>
                            <p class="mt-4 text-center text-sm text-neutral-500 group-hover:text-neutral-400 transition-colors">What you'll see when you try the example</p>
                        </a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!$user): ?>
        <!-- Bespoke & Enterprise Services -->
        <section id="bespoke-services" class="ds-scroll-reveal max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12 md:pt-8 md:pb-16">
            <hr class="ds-section-hr ds-section-hr-section-top" aria-hidden="true">
            <div class="ds-animate-fade-slide ds-animate-delay-1 ds-hover-lift max-w-6xl mx-auto bg-neutral-900 rounded-2xl border border-neutral-700 p-8 md:p-12 lg:p-14">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
                    <div>
                        <span class="ds-reveal-item inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide bg-neutral-800 border border-neutral-700 text-yellow-400 mb-4">Bespoke Data Cleaning</span>
                        <h2 class="ds-reveal-item text-2xl md:text-3xl font-bold text-white leading-tight">Need specialist rules for internal data?</h2>
                        <p class="ds-reveal-item mt-4 text-neutral-400 text-base md:text-lg leading-relaxed">
                            We partner with compliance, ops, and data teams to build in-browser validation for bespoke fields — from <span class="font-semibold text-white">region_description</span> to <span class="font-semibold text-white">staff_employee_number</span> and beyond. Share your edge cases and we'll deliver tailor-made rules that run entirely in your users' browsers, keeping sensitive records on-premise and fully GDPR aligned.
                        </p>
                        <ul class="mt-6 space-y-3 text-neutral-300 text-sm md:text-base">
                            <li class="ds-reveal-item bespoke-benefit-item group flex items-start gap-3 transition-colors duration-200">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-yellow-400 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Custom validators for proprietary fields and internal reference codes</span>
                            </li>
                            <li class="ds-reveal-item bespoke-benefit-item group flex items-start gap-3 transition-colors duration-200">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-yellow-400 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Browser-based deployment ensures zero data leaves your environment</span>
                            </li>
                            <li class="ds-reveal-item bespoke-benefit-item group flex items-start gap-3 transition-colors duration-200">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-yellow-400 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Direct collaboration with your domain experts to codify complex rules</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bespoke-process-card bg-neutral-800/50 border border-neutral-700 rounded-xl p-6 md:p-8 transition-all duration-200">
                        <h3 class="ds-reveal-item text-lg font-semibold text-white">How the bespoke process works</h3>
                        <ol class="mt-4 space-y-4 text-sm md:text-base">
                            <li class="ds-reveal-item bespoke-process-step group rounded-lg px-3 py-2 -mx-3 -my-2 transition-colors duration-200 group-hover:bg-neutral-700/30">
                                <span class="block font-semibold text-yellow-400 transition-colors duration-200 group-hover:text-yellow-300">1. Discovery workshop</span>
                                <span class="block mt-1 text-neutral-400">Share the fields, sample data, and desired outcomes. We map the validation flow together.</span>
                            </li>
                            <li class="ds-reveal-item bespoke-process-step group rounded-lg px-3 py-2 -mx-3 -my-2 transition-colors duration-200 group-hover:bg-neutral-700/30">
                                <span class="block font-semibold text-yellow-400 transition-colors duration-200 group-hover:text-yellow-300">2. Prototype & testing</span>
                                <span class="block mt-1 text-neutral-400">We build tailored rules inside our client-side engine and iterate with your team.</span>
                            </li>
                            <li class="ds-reveal-item bespoke-process-step group rounded-lg px-3 py-2 -mx-3 -my-2 transition-colors duration-200 group-hover:bg-neutral-700/30">
                                <span class="block font-semibold text-yellow-400 transition-colors duration-200 group-hover:text-yellow-300">3. Deployment & handover</span>
                                <span class="block mt-1 text-neutral-400">Validated rules are shipped into your Simple Data Cleaner workspace with full documentation.</span>
                            </li>
                        </ol>
                        <div class="ds-reveal-item mt-6 flex flex-col sm:flex-row sm:items-center gap-4">
                            <a href="/bespoke.php" class="inline-flex items-center justify-center gap-2.5 ds-btn-primary px-6 py-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10a9 9 0 11-18 0 9 9 0 0118 0zm-9 3l-3-3m0 0l3-3m-3 3h8" /></svg>
                                <span>Book a discovery call</span>
                            </a>
                            <a href="/how-it-works.php" class="inline-flex items-center justify-center gap-2 text-neutral-400 hover:text-white font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-neutral-900 rounded">
                                Learn more about our approach
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <!-- Image lightbox for privacy report -->
    <div id="privacy-report-lightbox" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Enlarged report preview">
        <button type="button" id="privacy-lightbox-close" class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center rounded-full bg-neutral-800 hover:bg-neutral-700 text-white transition-colors z-10" aria-label="Close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <img src="/assets/images/cleaned-data-report.png" alt="Cleaned Data Report — enlarged view" class="max-w-[95vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl" onclick="event.stopPropagation()">
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Scripts: validators first, then fileProcessor/app for upload when logged in -->
    <script src="/validators.js?v=<?php echo time(); ?>" defer></script>
    <?php if ($user): ?>
    <!-- File upload (same as example.php) - requires validators, fileProcessor, app -->
    <script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js" integrity="sha384-7hwyYzxURfZMLwHgvEKrYEmM5tX+1DVWK5iDR4R69bOQeY90Q8B8n9Cobuyqybhw" crossorigin="anonymous" defer></script>
    <script src="/fileProcessor.js" defer></script>
    <script src="/app.js" defer></script>
    <?php endif; ?>
    <?php if (!$user): ?>
    <script src="/hero-shader.js?v=<?php echo time(); ?>" defer></script>
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
    <script <?php echo script_nonce(); ?>>
    if (typeof lucide !== 'undefined') lucide.createIcons();
    </script>
    <script <?php echo script_nonce(); ?>>
    (function() {
        var btn = document.getElementById('privacy-report-image-btn');
        var lb = document.getElementById('privacy-report-lightbox');
        if (!btn || !lb) return;
        btn.addEventListener('click', function() {
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        });
        function closeLb() {
            lb.classList.remove('is-open');
            lb.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        lb.addEventListener('click', function(e) { if (e.target === lb) closeLb(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && lb.classList.contains('is-open')) closeLb(); });
        var closeBtn = document.getElementById('privacy-lightbox-close');
        if (closeBtn) closeBtn.addEventListener('click', closeLb);
    })();
    </script>
    <?php endif; ?>
    <?php if (!$user): ?>
    <script <?php echo script_nonce(); ?>>
    document.addEventListener('DOMContentLoaded', function() {
        var inp = document.getElementById('mini-demo-input');
        var out = document.getElementById('mini-demo-output');
        if (!inp || !out || typeof autoValidate === 'undefined') return;
        var textEl = out.querySelector('.try-demo-text');
        var checkEl = out.querySelector('.try-demo-check');
        function update() {
            var val = inp.value.trim();
            out.classList.remove('is-valid', 'is-invalid', 'is-empty', 'is-updated');
            if (!val) {
                textEl.textContent = '\u2014';
                out.classList.add('is-empty');
                if (checkEl) checkEl.classList.add('hidden');
                return;
            }
            var r = autoValidate(val);
            var display;
            var rawVal = inp.value;
            var looksLikeName = /^[a-zA-Z\s\-'.]+$/.test(rawVal) && rawVal.replace(/\s+/g, ' ').trim().split(/\s+/).length >= 2 && rawVal.indexOf('@') === -1;
            if (looksLikeName && typeof getValidator === 'function') {
                var nameVal = getValidator('name_split');
                if (nameVal && nameVal.split) {
                    var splitResult = nameVal.split(rawVal);
                    if (!splitResult.error && (splitResult.first_name || splitResult.last_name)) {
                        var parts = [splitResult.last_name, splitResult.first_name, splitResult.title].filter(Boolean);
                        display = parts.length ? parts.join(' \u00B7 ') : null;
                        if (display) r = { fixed: display, isValid: true };
                    }
                }
            }
            if (!display && r.error === 'Could not determine data type' && typeof getValidator === 'function') {
                var nameVal2 = getValidator('name_split');
                if (nameVal2 && nameVal2.split) {
                    var splitResult2 = nameVal2.split(rawVal);
                    if (!splitResult2.error && (splitResult2.first_name || splitResult2.last_name)) {
                        var parts2 = [splitResult2.last_name, splitResult2.first_name, splitResult2.title].filter(Boolean);
                        display = parts2.length ? parts2.join(' \u00B7 ') : null;
                        if (display) r = { fixed: display, isValid: true };
                    }
                }
            }
            if (!display) display = r.fixed || r.value || (r.error ? 'Invalid: ' + r.error : '\u2014');
            textEl.textContent = display;
            if (r.fixed || (r.isValid && display !== '\u2014')) {
                out.classList.add('is-valid');
                if (checkEl) checkEl.classList.remove('hidden');
                var card = out.closest('.try-demo-card');
                if (card) {
                    card.classList.remove('is-celebrating');
                    card.offsetHeight;
                    card.classList.add('is-celebrating');
                    setTimeout(function() { card.classList.remove('is-celebrating'); }, 900);
                }
            } else {
                out.classList.add('is-invalid');
                if (checkEl) checkEl.classList.add('hidden');
            }
            out.classList.add('is-updated');
            setTimeout(function() { out.classList.remove('is-updated'); }, 400);
        }
        inp.addEventListener('input', update);
        inp.addEventListener('paste', function() { setTimeout(update, 10); });
        document.querySelectorAll('.ds-vocab-item[data-sample]').forEach(function(el) {
            function fillSample() {
                var sample = el.getAttribute('data-sample');
                if (sample && inp) {
                    document.querySelectorAll('.ds-vocab-item.is-just-selected').forEach(function(other) { other.classList.remove('is-just-selected'); });
                    el.classList.add('is-just-selected');
                    setTimeout(function() { el.classList.remove('is-just-selected'); }, 1400);
                    inp.value = sample;
                    inp.focus();
                    update();
                }
            }
            el.addEventListener('click', fillSample);
            el.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fillSample();
                }
            });
        });
    });
    </script>
    <?php endif; ?>

    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
    <?php include __DIR__ . '/includes/analytics.php'; ?>
</body>
</html>