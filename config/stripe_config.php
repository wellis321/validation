<?php
/**
 * Stripe Configuration
 * Loads from environment variables (.env file)
 */

// Stripe API Keys (from .env file)
$stripeSecretKey = getenv('STRIPE_SECRET_KEY');
if (empty($stripeSecretKey)) {
    throw new RuntimeException('STRIPE_SECRET_KEY environment variable is required. Check your .env file.');
}
define('STRIPE_SECRET_KEY', $stripeSecretKey);
define('STRIPE_PUBLISHABLE_KEY', getenv('STRIPE_PUBLISHABLE_KEY') ?: '');

// Stripe Price IDs (from .env file - allows different IDs for test vs production)
define('STRIPE_PRICE_PAY_PER_USE', getenv('STRIPE_PRICE_PAY_PER_USE') ?: '');
define('STRIPE_PRICE_MONTHLY', getenv('STRIPE_PRICE_MONTHLY') ?: '');
define('STRIPE_PRICE_ANNUAL', getenv('STRIPE_PRICE_ANNUAL') ?: '');
define('STRIPE_PRICE_LIFETIME', getenv('STRIPE_PRICE_LIFETIME') ?: '');




// Webhook secret (from .env file)
define('STRIPE_WEBHOOK_SECRET', getenv('STRIPE_WEBHOOK_SECRET') ?: '');

// Settings
define('STRIPE_CURRENCY', 'gbp');
