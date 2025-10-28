<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'Bank Sort Code Format Support';
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
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Bank Sort Code Format Support</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We clean UK bank sort codes from many different input formats. See what we support below.
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
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12 34 56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">123 456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12 3456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">1234 56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">123456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">  12  34  56</code></div>
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
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12.34.56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12/34/56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12:34:56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12;34;56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12,34,56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12|34|56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12_34_56</code></div>
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
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Sort Code: 12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SC: 123456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Bank: 12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">12-34-56 (sort code)</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">SC - 123456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">UK 12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">Barclays 12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">HSBC: 12-34-56</code></div>
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
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">"12-34-56"</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'123456'</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">*12-34-56</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">#123456</code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm"> 12-34-56 </code></div>
                    <div class="bg-green-50 p-3 rounded"><code class="text-sm">'12-34-56</code></div>
                </div>
            </div>

            <!-- Special Cases -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Special Cases Handled
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>Excel Scientific Notation:</strong><br>
                        <code class="text-sm">1.23456E+5</code> → <code class="text-sm">12-34-56</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>Leading Zeros:</strong><br>
                        <code class="text-sm">012345</code> → <code class="text-sm">12-34-56</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>Extra Leading Zeros:</strong><br>
                        <code class="text-sm">00-12-34-56</code> → <code class="text-sm">12-34-56</code>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <strong>With Account Number:</strong><br>
                        <code class="text-sm">12-34-56 / 12345678</code> → <code class="text-sm">12-34-56</code>
                    </div>
                </div>
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
                    <p class="mb-2">All sort codes are formatted consistently as:</p>
                    <code class="text-2xl font-mono bg-white px-4 py-2 rounded block text-center">12-34-56</code>
                    <p class="text-sm text-gray-600 mt-3">Two digits, hyphen, two digits, hyphen, two digits.</p>
                </div>
            </div>
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
                If you have sort code data in a format we don't currently handle, please
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
