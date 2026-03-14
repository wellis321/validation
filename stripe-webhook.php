<?php
/**
 * Stripe Webhook Handler
 *
 * This endpoint receives and processes Stripe webhook events.
 * CRITICAL: All events are verified using the webhook signature before processing.
 *
 * Setup in Stripe Dashboard:
 * 1. Go to Developers > Webhooks
 * 2. Add endpoint: https://yourdomain.com/stripe-webhook.php
 * 3. Select events: checkout.session.completed, customer.subscription.updated,
 *    customer.subscription.deleted, invoice.paid, invoice.payment_failed
 * 4. Copy the signing secret to STRIPE_WEBHOOK_SECRET in your .env file
 */

// Don't load full init.php to avoid session/auth overhead for webhooks
require_once __DIR__ . '/includes/env_loader.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/config/stripe_config.php';

// Set headers for webhook response
header('Content-Type: application/json');

// Get the raw POST body
$payload = file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

// Verify webhook secret is configured
if (empty(STRIPE_WEBHOOK_SECRET)) {
    http_response_code(500);
    error_log('Stripe webhook error: STRIPE_WEBHOOK_SECRET not configured');
    echo json_encode(['error' => 'Webhook not configured']);
    exit;
}

// Verify the webhook signature
$event = verifyWebhookSignature($payload, $sigHeader, STRIPE_WEBHOOK_SECRET);

if (!$event) {
    http_response_code(400);
    error_log('Stripe webhook error: Invalid signature');
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

// Log the event type for debugging (but not sensitive data)
error_log("Stripe webhook received: {$event['type']} (ID: {$event['id']})");

// Handle the event
try {
    $db = Database::getInstance();

    switch ($event['type']) {
        case 'checkout.session.completed':
            handleCheckoutSessionCompleted($event['data']['object'], $db);
            break;

        case 'customer.subscription.updated':
            handleSubscriptionUpdated($event['data']['object'], $db);
            break;

        case 'customer.subscription.deleted':
            handleSubscriptionDeleted($event['data']['object'], $db);
            break;

        case 'invoice.paid':
            handleInvoicePaid($event['data']['object'], $db);
            break;

        case 'invoice.payment_failed':
            handleInvoicePaymentFailed($event['data']['object'], $db);
            break;

        default:
            // Log unhandled events but don't fail
            error_log("Stripe webhook: Unhandled event type {$event['type']}");
    }

    http_response_code(200);
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    error_log("Stripe webhook error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal error']);
}

/**
 * Verify Stripe webhook signature
 * Implementation based on Stripe's signature verification algorithm
 */
function verifyWebhookSignature($payload, $sigHeader, $secret) {
    if (empty($sigHeader)) {
        return null;
    }

    // Parse the signature header
    $parts = explode(',', $sigHeader);
    $timestamp = null;
    $signatures = [];

    foreach ($parts as $part) {
        $kv = explode('=', trim($part), 2);
        if (count($kv) !== 2) continue;

        if ($kv[0] === 't') {
            $timestamp = $kv[1];
        } elseif ($kv[0] === 'v1') {
            $signatures[] = $kv[1];
        }
    }

    if (!$timestamp || empty($signatures)) {
        error_log('Stripe webhook: Missing timestamp or signature');
        return null;
    }

    // Check timestamp tolerance (5 minutes)
    $tolerance = 300;
    if (abs(time() - intval($timestamp)) > $tolerance) {
        error_log('Stripe webhook: Timestamp outside tolerance');
        return null;
    }

    // Compute expected signature
    $signedPayload = $timestamp . '.' . $payload;
    $expectedSig = hash_hmac('sha256', $signedPayload, $secret);

    // Compare signatures using timing-safe comparison
    $valid = false;
    foreach ($signatures as $sig) {
        if (hash_equals($expectedSig, $sig)) {
            $valid = true;
            break;
        }
    }

    if (!$valid) {
        error_log('Stripe webhook: Signature mismatch');
        return null;
    }

    // Parse and return the event
    $event = json_decode($payload, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Stripe webhook: Invalid JSON payload');
        return null;
    }

    return $event;
}

/**
 * Handle checkout.session.completed event
 * This is the primary event for creating subscriptions after successful payment
 */
function handleCheckoutSessionCompleted($session, $db) {
    $userId = $session['client_reference_id'] ?? null;
    $paymentStatus = $session['payment_status'] ?? 'unpaid';
    $metadata = $session['metadata'] ?? [];
    $planId = $metadata['plan_id'] ?? null;

    if (!$userId || !$planId) {
        error_log("Stripe webhook: Missing user_id ({$userId}) or plan_id ({$planId}) in checkout session");
        return;
    }

    if ($paymentStatus !== 'paid') {
        error_log("Stripe webhook: Payment not completed for session {$session['id']}");
        return;
    }

    // Get plan details
    $stmt = $db->query("SELECT * FROM subscription_plans WHERE id = ?", [$planId]);
    $plan = $stmt->fetch();

    if (!$plan) {
        error_log("Stripe webhook: Plan not found: {$planId}");
        return;
    }

    // Get price metadata if available
    $lineItems = $session['line_items']['data'] ?? [];
    $primaryLineItem = $lineItems[0] ?? null;
    $stripePriceId = $primaryLineItem['price']['id'] ?? ($metadata['stripe_price_id'] ?? null);
    $priceMetadata = $primaryLineItem['price']['metadata'] ?? [];

    // Calculate subscription dates
    $startDate = date('Y-m-d H:i:s');
    $durationMonths = floatval($plan['duration_months'] ?? 1);
    $features = json_decode($plan['features'] ?? '{}', true) ?: [];
    $hasLifetimeAccess = !empty($features['lifetime_access']);

    // Feature set version and license scope
    $featureSetVersion = $priceMetadata['feature_set_version']
        ?? $features['feature_set_version']
        ?? ($hasLifetimeAccess ? '2025-uk-validators' : 'current');

    $licenseScope = $priceMetadata['license_scope']
        ?? ($hasLifetimeAccess ? 'lifetime' : 'subscription');

    // Calculate end date
    if ($hasLifetimeAccess) {
        $endDate = '2037-12-31 23:59:59';
    } elseif ($durationMonths === 0) {
        $endDate = $startDate;
    } elseif ($durationMonths < 1) {
        $endDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($startDate)));
    } else {
        $endDate = date('Y-m-d H:i:s', strtotime("+{$durationMonths} months"));
    }

    // Check for existing active subscription
    $existingSub = $db->query(
        "SELECT * FROM user_subscriptions
         WHERE user_id = ? AND plan_id = ? AND status = 'active'
         ORDER BY created_at DESC LIMIT 1",
        [$userId, $plan['id']]
    )->fetch();

    if ($existingSub) {
        // Update existing subscription
        $db->query(
            "UPDATE user_subscriptions SET
                start_date = ?,
                end_date = ?,
                payment_status = 'completed',
                stripe_session_id = ?,
                stripe_price_id = ?,
                feature_set_version = ?,
                license_scope = ?,
                updated_at = NOW()
            WHERE id = ?",
            [$startDate, $endDate, $session['id'], $stripePriceId, $featureSetVersion, $licenseScope, $existingSub['id']]
        );
        error_log("Stripe webhook: Updated subscription {$existingSub['id']} for user {$userId}");
    } else {
        // Create new subscription
        $db->insert('user_subscriptions', [
            'user_id' => $userId,
            'plan_id' => $plan['id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'payment_status' => 'completed',
            'stripe_session_id' => $session['id'],
            'stripe_price_id' => $stripePriceId,
            'feature_set_version' => $featureSetVersion,
            'license_scope' => $licenseScope
        ]);
        error_log("Stripe webhook: Created subscription for user {$userId}, plan {$planId}");
    }
}

/**
 * Handle subscription update events (for recurring subscriptions)
 */
function handleSubscriptionUpdated($subscription, $db) {
    $stripeSubscriptionId = $subscription['id'] ?? null;
    $status = $subscription['status'] ?? null;

    if (!$stripeSubscriptionId) {
        return;
    }

    // Map Stripe status to our status
    $ourStatus = 'active';
    if (in_array($status, ['canceled', 'unpaid', 'incomplete_expired'])) {
        $ourStatus = 'cancelled';
    } elseif ($status === 'past_due') {
        $ourStatus = 'past_due';
    }

    // Update subscription in database if we track by Stripe subscription ID
    $db->query(
        "UPDATE user_subscriptions SET status = ?, updated_at = NOW()
         WHERE stripe_subscription_id = ?",
        [$ourStatus, $stripeSubscriptionId]
    );

    error_log("Stripe webhook: Subscription {$stripeSubscriptionId} updated to status {$ourStatus}");
}

/**
 * Handle subscription deletion
 */
function handleSubscriptionDeleted($subscription, $db) {
    $stripeSubscriptionId = $subscription['id'] ?? null;

    if (!$stripeSubscriptionId) {
        return;
    }

    $db->query(
        "UPDATE user_subscriptions SET status = 'cancelled', updated_at = NOW()
         WHERE stripe_subscription_id = ?",
        [$stripeSubscriptionId]
    );

    error_log("Stripe webhook: Subscription {$stripeSubscriptionId} cancelled");
}

/**
 * Handle successful invoice payment (for subscription renewals)
 */
function handleInvoicePaid($invoice, $db) {
    $subscriptionId = $invoice['subscription'] ?? null;

    if (!$subscriptionId) {
        return;
    }

    // Extend subscription end date
    $periodEnd = $invoice['lines']['data'][0]['period']['end'] ?? null;
    if ($periodEnd) {
        $newEndDate = date('Y-m-d H:i:s', $periodEnd);
        $db->query(
            "UPDATE user_subscriptions SET end_date = ?, payment_status = 'completed', updated_at = NOW()
             WHERE stripe_subscription_id = ?",
            [$newEndDate, $subscriptionId]
        );
        error_log("Stripe webhook: Extended subscription {$subscriptionId} to {$newEndDate}");
    }
}

/**
 * Handle failed invoice payment
 */
function handleInvoicePaymentFailed($invoice, $db) {
    $subscriptionId = $invoice['subscription'] ?? null;

    if (!$subscriptionId) {
        return;
    }

    $db->query(
        "UPDATE user_subscriptions SET payment_status = 'failed', updated_at = NOW()
         WHERE stripe_subscription_id = ?",
        [$subscriptionId]
    );

    error_log("Stripe webhook: Payment failed for subscription {$subscriptionId}");
}
