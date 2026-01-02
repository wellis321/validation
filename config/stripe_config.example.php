<?php
/**
 * Stripe Configuration
 *
 * Copy this file to stripe_config.php and add your actual Stripe keys
 * Get your keys from: https://dashboard.stripe.com/apikeys
 */

// Stripe API Keys (get from Stripe Dashboard)
// IMPORTANT: Replace these with your actual keys from https://dashboard.stripe.com/apikeys
define('STRIPE_SECRET_KEY', 'sk_test_...');  // Your secret key (starts with sk_test_ or sk_live_)
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_...');  // Your publishable key (starts with pk_test_ or pk_live_)

// Stripe Price IDs (get from Stripe Dashboard > Products)
// Replace these with your actual Price IDs from Stripe
define('STRIPE_PRICE_PAY_PER_USE', 'price_xxxxxxxxxxxxx');  // £4.99 one-time
define('STRIPE_PRICE_MONTHLY', 'price_xxxxxxxxxxxxx');  // £29.99/month
define('STRIPE_PRICE_ANNUAL', 'price_xxxxxxxxxxxxx');  // £249.00/year

// Webhook secret (for handling subscription events)
// Get this from: https://dashboard.stripe.com/webhooks (click on your webhook endpoint)
define('STRIPE_WEBHOOK_SECRET', 'whsec_...');  // Your webhook signing secret (starts with whsec_)

// Settings
define('STRIPE_CURRENCY', 'gbp');
