<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'National Insurance Number Format Support';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">National Insurance Number Format Support</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We clean National Insurance numbers from many different input formats. See what we support below.
            </p>
        </header>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Supported Format Variations
            </h2>

            <!-- Spacing Variations -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Spacing Variations
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 123456 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 12 3456 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 1234 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB123 456 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">A B 12 34 56 C</code></div>
                </div>
            </div>

            <!-- Separator Types -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Separator Types Handled
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB-12-34-56-C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB.12.34.56.C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB/12/34/56/C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB_12_34_56_C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB:12:34:56:C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB;12;34;56;C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB,12,34,56,C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB|12|34|56|C</code></div>
                </div>
                <p class="text-sm text-gray-600 mt-3">We handle dashes, dots, slashes, underscores, colons, semicolons, commas, pipes, and more.</p>
            </div>

            <!-- Parentheses & Brackets -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Parentheses & Brackets
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">(AB)12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB(12)34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 12 34 56(C)</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">(AB123456C)</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">[AB]12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">{AB}12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB[123456]C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB{123456}C</code></div>
                </div>
            </div>

            <!-- Mixed Formatting -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Mixed Formatting
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 12-34-56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB-12 34 56-C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB.12-34.56-C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB 12.34.56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB-123456 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB12-34 56-C</code></div>
                </div>
            </div>

            <!-- Labels & Prefixes -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Labels & Prefixes Removed
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">NI: AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">NI Number: AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">NINO: AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">National Insurance: AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB123456C (NI)</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">NI - AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">UK AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">GB: AB123456C</code></div>
                </div>
            </div>

            <!-- Wrapping Characters -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Wrapping Characters
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">"AB123456C"</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'AB123456C'</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">*AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">#AB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm"> AB123456C </code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'AB123456C</code></div>
                </div>
            </div>

            <!-- Lowercase Variations -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Lowercase & Case Variations
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">ab123456c</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">ab 12 34 56 c</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Ab123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">aB123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">AB123456c</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">ab123456C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Ab 12 34 56 C</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">aB 12 34 56 C</code></div>
                </div>
                <p class="text-sm text-gray-600 mt-3">All NI numbers are normalized to uppercase during validation.</p>
            </div>

            <!-- Output Format -->
            <div class="mb-8 border-t pt-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Output Format
                </h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="mb-2">All National Insurance numbers are formatted consistently as:</p>
                    <code class="text-2xl font-mono bg-white px-4 py-2 rounded block text-center">AB 123456 C</code>
                    <p class="text-sm text-gray-600 mt-3">Two letters, six digits, one letter, with appropriate spacing.</p>
                </div>
            </div>
        </div>

        <!-- Validation Rules -->
        <div class="bg-blue-50 rounded-lg p-8 mb-8">
            <h3 class="text-2xl font-semibold text-blue-900 mb-4">✓ Validation Rules</h3>
            <ul class="space-y-2 text-blue-800">
                <li>• Must contain exactly 2 letters, 6 digits, and 1 letter</li>
                <li>• Banned prefixes (BG, GB, KN, NK, NT, TN, ZZ) are rejected</li>
                <li>• Administrative prefixes (OO, FY, NC, PZ) are rejected</li>
                <li>• Invalid characters (D, F, I, O, Q, U, V) in specific positions are rejected</li>
                <li>• TRN (Temporary Reference Number) format is detected and rejected</li>
                <li>• PP999999P is specifically rejected</li>
            </ul>
        </div>

        <!-- Get in Touch -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Have a Format We Don't Support?
            </h2>
            <p class="text-blue-800 mb-4">
                If you have National Insurance number data in a format we don't currently handle, please
                <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:underline">contact us</a>
                with examples and we'll add support!
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="validation-rules.php" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Validation Rules
            </a>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
