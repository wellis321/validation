<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/config/stripe_config.php';

$auth = Auth::getInstance();
$auth->requireAuth();

$user = $auth->getCurrentUser();
$sessionId = $_GET['session_id'] ?? null;

if (!$sessionId) {
    header('Location: /pricing.php');
    exit;
}

// Retrieve the checkout session from Stripe to verify payment
$ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => STRIPE_SECRET_KEY . ':'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    error_log("Failed to retrieve Stripe session: " . $response);
    $_SESSION['error'] = 'Unable to verify payment. Please contact support with your order details.';
    header('Location: /account.php');
    exit;
}

$session = json_decode($response, true);

// Verify the user ID matches
if ($session['client_reference_id'] != $user['id']) {
    error_log("User ID mismatch in Stripe session");
    $_SESSION['error'] = 'Payment verification failed.';
    header('Location: /account.php');
    exit;
}

// Get plan details from metadata
$metadata = $session['metadata'] ?? [];
$planId = $metadata['plan_id'] ?? null;

if (!$planId) {
    error_log("No plan_id in session metadata");
    $_SESSION['error'] = 'Unable to identify subscription plan.';
    header('Location: /account.php');
    exit;
}

// Get plan details
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM subscription_plans WHERE id = ?", [$planId]);
$plan = $stmt->fetch();

if (!$plan) {
    error_log("Plan not found: " . $planId);
    $_SESSION['error'] = 'Subscription plan not found.';
    header('Location: /account.php');
    exit;
}

// Check if payment was successful
$paymentStatus = $session['payment_status'] ?? 'unpaid';

if ($paymentStatus === 'paid') {
    // Calculate subscription dates
    $startDate = date('Y-m-d H:i:s');
    $durationMonths = floatval($plan['duration_months'] ?? 1);

    if ($durationMonths === 0) {
        // One-time payment - expires immediately after use
        $endDate = $startDate;
    } elseif ($durationMonths < 1) {
        // For durations less than 1 month (24 hours = 1 day)
        $endDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($startDate)));
    } else {
        $endDate = date('Y-m-d H:i:s', strtotime("+{$durationMonths} months"));
    }

    // Create or update subscription
    try {
        // Check if user already has an active subscription for this plan
        $existingSub = $db->query(
            "SELECT * FROM user_subscriptions WHERE user_id = ? AND plan_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1",
            [$user['id'], $plan['id']]
        )->fetch();

        if ($existingSub) {
            // Update existing subscription
            $db->query(
                "UPDATE user_subscriptions SET
                    start_date = ?,
                    end_date = ?,
                    payment_status = 'completed',
                    updated_at = NOW()
                WHERE id = ?",
                [$startDate, $endDate, $existingSub['id']]
            );
        } else {
            // Create new subscription
            $db->insert('user_subscriptions', [
                'user_id' => $user['id'],
                'plan_id' => $plan['id'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'payment_status' => 'completed'
            ]);
        }

        $_SESSION['success'] = "Successfully subscribed to {$plan['name']}!";
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = 'Payment processed but subscription could not be activated. Please contact support.';
    }
} else {
    $_SESSION['error'] = 'Payment was not successful. Please try again.';
}

// Redirect to dashboard or account page
header('Location: /dashboard.php');
exit;
