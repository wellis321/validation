<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

// Get user's API key if logged in
$apiKey = $user ? "uk_dc_{$user['id']}" : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - UK Data Cleaner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css">
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-blue-600">UK Data Cleaner</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php if ($user): ?>
                        <a href="/dashboard.php" class="text-gray-700 hover:text-gray-900 mr-4">Dashboard</a>
                        <a href="/logout.php" class="text-gray-700 hover:text-gray-900">Logout</a>
                    <?php else: ?>
                        <a href="/login.php" class="text-gray-700 hover:text-gray-900">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">API Documentation</h1>
            <p class="mt-4 text-lg text-gray-600">Clean and validate UK data programmatically</p>
        </div>

        <?php if ($user): ?>
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your API Key</h2>
                <div class="bg-gray-50 rounded p-4 font-mono text-sm">
                    <?php echo htmlspecialchars($apiKey); ?>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    Keep this key secure and never share it publicly. Use it in the Authorization header of your API requests.
                </p>
            </div>
        <?php endif; ?>

        <div class="prose max-w-none">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Authentication</h2>
            <p class="text-gray-600 mb-4">
                All API requests must include your API key in the Authorization header:
            </p>
            <pre><code class="language-bash">Authorization: Bearer your_api_key</code></pre>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Endpoints</h2>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Clean Data</h3>
                <p class="text-gray-600 mb-4">
                    Clean and validate UK data including phone numbers, NI numbers, postcodes, and sort codes.
                </p>

                <div class="bg-gray-50 rounded p-4 mb-4">
                    <p class="font-mono text-sm">POST /api/clean.php</p>
                </div>

                <h4 class="font-semibold text-gray-900 mb-2">Request Body</h4>
                <pre><code class="language-json">{
    "data": [
        {
            "phone": "07700900123",
            "postcode": "SW1A1AA",
            "ni_number": "AB123456C"
        }
    ],
    "fields": ["phone", "postcode", "ni_number"],
    "phone_format": "international" // optional, defaults to "international"
}</code></pre>

                <h4 class="font-semibold text-gray-900 mt-4 mb-2">Response</h4>
                <pre><code class="language-json">{
    "status": "success",
    "data": {
        "results": [
            {
                "phone": {
                    "original": "07700900123",
                    "cleaned": "+44 7700 900 123",
                    "valid": true,
                    "error": null
                },
                "postcode": {
                    "original": "SW1A1AA",
                    "cleaned": "SW1A 1AA",
                    "valid": true,
                    "error": null
                },
                "ni_number": {
                    "original": "AB123456C",
                    "cleaned": "AB 123456 C",
                    "valid": true,
                    "error": null
                }
            }
        ],
        "summary": {
            "total_fields": 3,
            "valid_fields": 3,
            "cleaned_fields": 3,
            "errors": 0,
            "success_rate": 100
        }
    }
}</code></pre>

                <h4 class="font-semibold text-gray-900 mt-4 mb-2">Error Response</h4>
                <pre><code class="language-json">{
    "status": "error",
    "message": "Error message here"
}</code></pre>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Rate Limits</h2>
            <p class="text-gray-600 mb-4">
                Rate limits depend on your subscription plan:
            </p>
            <ul class="list-disc list-inside text-gray-600 mb-8">
                <li>Free: 50 requests per day</li>
                <li>Professional: 1,000 requests per day</li>
                <li>Enterprise: 5,000 requests per day</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Example Usage</h2>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-2">cURL</h4>
                <pre><code class="language-bash">curl -X POST \
  'https://your-domain.com/api/clean.php' \
  -H 'Authorization: Bearer your_api_key' \
  -H 'Content-Type: application/json' \
  -d '{
    "data": [
        {
            "phone": "07700900123",
            "postcode": "SW1A1AA"
        }
    ],
    "fields": ["phone", "postcode"]
}'</code></pre>

                <h4 class="font-semibold text-gray-900 mt-6 mb-2">JavaScript</h4>
                <pre><code class="language-javascript">fetch('https://your-domain.com/api/clean.php', {
    method: 'POST',
    headers: {
        'Authorization': 'Bearer your_api_key',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        data: [
            {
                phone: '07700900123',
                postcode: 'SW1A1AA'
            }
        ],
        fields: ['phone', 'postcode']
    })
})
.then(response => response.json())
.then(data => console.log(data));</code></pre>

                <h4 class="font-semibold text-gray-900 mt-6 mb-2">PHP</h4>
                <pre><code class="language-php">$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'https://your-domain.com/api/clean.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer your_api_key',
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'data' => [
            [
                'phone' => '07700900123',
                'postcode' => 'SW1A1AA'
            ]
        ],
        'fields' => ['phone', 'postcode']
    ])
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

curl_close($ch);</code></pre>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
</body>
</html>
