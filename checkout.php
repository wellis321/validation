<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/config/stripe_config.php';

$auth = Auth::getInstance();
$planId = $_GET['plan'] ?? null;
$auth->requireAuth($planId ? '/checkout.php?plan=' . $planId : null, true);

$user = $auth->getCurrentUser();

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
    'Annual' => STRIPE_PRICE_ANNUAL,
    'Lifetime Beta' => STRIPE_PRICE_LIFETIME
];

$priceId = $priceMapping[$plan['name']] ?? null;

if (!$priceId) {
    error_log("Checkout: No price mapping for plan ID: " . $plan['id'] . ", name: " . $plan['name']);
    die('Invalid plan configuration. Plan: ' . htmlspecialchars($plan['name']) . '. Please contact support.');
}

// Base URL from config (works for staging and production)
$config = require __DIR__ . '/config/config.php';
$baseUrl = rtrim($config['app']['url'], '/');
$successUrl = $baseUrl . '/checkout-success.php?session_id={CHECKOUT_SESSION_ID}';
$cancelUrl = $baseUrl . '/pricing.php';

// Stripe SDK: create Checkout Session
if (!class_exists(\Stripe\Stripe::class)) {
    error_log('Checkout: Stripe SDK not loaded. Run: composer install');
    die('Payment system unavailable. Please try again later or contact support.');
}

try {
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

    $sessionParams = [
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => $priceId,
            'quantity' => 1,
        ]],
        'mode' => $plan['duration_months'] === 0 ? 'payment' : 'subscription',
        'success_url' => $successUrl,
        'cancel_url' => $cancelUrl,
        'customer_email' => $user['email'],
        'client_reference_id' => (string) $user['id'],
        'metadata' => [
            'app' => 'simple_data_cleaner',
            'user_id' => $user['id'],
            'plan_id' => $plan['id'],
            'plan_name' => $plan['name'],
        ],
    ];

    $session = \Stripe\Checkout\Session::create($sessionParams);

    if (empty($session->url)) {
        error_log('Checkout: Stripe session created but no URL returned');
        die('Unable to start checkout. Please try again or contact support.');
    }

    header('Location: ' . $session->url);
    exit;
} catch (\Stripe\Exception\ApiErrorException $e) {
    error_log('Checkout: Stripe API error - ' . $e->getMessage());
    die('Unable to create checkout session. Please try again or contact support.');
} catch (Exception $e) {
    error_log('Checkout: Error - ' . $e->getMessage());
    die('Something went wrong. Please try again or contact support.');
}
