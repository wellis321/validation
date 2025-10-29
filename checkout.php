<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/config/stripe_config.php';

$auth = Auth::getInstance();
$auth->requireAuth();

$user = $auth->getCurrentUser();
$planId = $_GET['plan'] ?? null;

if (!$planId) {
    header('Location: /pricing.php');
    exit;
}

// Get plan details from database
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM subscription_plans WHERE id = ? AND is_active = 1", [$planId]);
$plan = $stmt->fetch();

if (!$plan) {
    header('Location: /pricing.php');
    exit;
}

// Map plan name to Stripe Price ID
$priceMapping = [
    'Pay Per Use' => STRIPE_PRICE_PAY_PER_USE,
    'Monthly' => STRIPE_PRICE_MONTHLY,
    'Annual' => STRIPE_PRICE_ANNUAL
];

$priceId = $priceMapping[$plan['name']] ?? null;

if (!$priceId) {
    error_log("No price mapping found for plan ID: " . $plan['id'] . ", name: " . $plan['name']);
    error_log("Available plans: " . json_encode(array_keys($priceMapping)));
    error_log("Plan data: " . json_encode($plan));
    die('Invalid plan configuration. Plan: ' . htmlspecialchars($plan['name']) . '. Please contact support.');
}

// Create Stripe Checkout Session
$successUrl = 'https://simple-data-cleaner.com/checkout-success.php?session_id={CHECKOUT_SESSION_ID}';
$cancelUrl = 'https://simple-data-cleaner.com/pricing.php';

$sessionData = [
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price' => $priceId,
        'quantity' => 1,
    ]],
    'mode' => $plan['duration_months'] === 0 ? 'payment' : 'subscription',  // payment for one-time, subscription for recurring
    'success_url' => $successUrl,
    'cancel_url' => $cancelUrl,
    'customer_email' => $user['email'],
    'client_reference_id' => $user['id'],  // To identify user in success page
    'metadata' => [
        'user_id' => $user['id'],
        'plan_id' => $plan['id'],
        'plan_name' => $plan['name']
    ]
];

// Create checkout session via Stripe API
$ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => STRIPE_SECRET_KEY . ':',
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    CURLOPT_POSTFIELDS => http_build_query($sessionData)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200) {
    error_log("Stripe API HTTP Code: " . $httpCode);
    error_log("Stripe API Response: " . $response);
    error_log("cURL Error: " . $curlError);
    error_log("Stripe Secret Key (first 10 chars): " . substr(STRIPE_SECRET_KEY, 0, 10));

    $errorData = json_decode($response, true);
    $errorMessage = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';

    die('Unable to create checkout session. Error: ' . htmlspecialchars($errorMessage) . '. Please contact support.');
}

$session = json_decode($response, true);

if (isset($session['error'])) {
    error_log("Stripe Error: " . $session['error']['message']);
    die('Error: ' . $session['error']['message']);
}

// Redirect to Stripe Checkout
header('Location: ' . $session['url']);
exit;
