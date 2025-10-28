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
    error_log("No price mapping found for plan: " . $plan['name']);
    die('Invalid plan configuration. Please contact support.');
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
curl_close($ch);

if ($httpCode !== 200) {
    error_log("Stripe API Error: " . $response);
    die('Unable to create checkout session. Please try again later or contact support.');
}

$session = json_decode($response, true);

if (isset($session['error'])) {
    error_log("Stripe Error: " . $session['error']['message']);
    die('Error: ' . $session['error']['message']);
}

// Redirect to Stripe Checkout
header('Location: ' . $session['url']);
exit;
