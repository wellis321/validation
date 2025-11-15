<?php
/**
 * Stripe Configuration
 *
 * Copy this file to stripe_config.php and add your actual Stripe keys
 * Get your keys from: https://dashboard.stripe.com/apikeys
 */

// Stripe API Keys (get from Stripe Dashboard)
define('STRIPE_SECRET_KEY', 'sb_secret_qR-jQnIWqCXH3I78xTqUWw_7meAkOWh');  // Your secret key
define('STRIPE_PUBLISHABLE_KEY', 'pk_live_51SFF3xEMgRyvTqUXkOSrwNyQvtxdwM7qVzIGh3UGMaUKDXCeNZoLK0nlO4mjEt2D8SMY30OqlG7A4tuJl74cIPPg00KuJuq4HZ');  // Your publishable key

// Stripe Price IDs (get from Stripe Dashboard > Products)
// Replace these with your actual Price IDs from Stripe
define('STRIPE_PRICE_PAY_PER_USE', 'price_xxxxxxxxxxxxx');  // £4.99 one-time
define('STRIPE_PRICE_MONTHLY', 'price_xxxxxxxxxxxxx');  // £29.99/month
define('STRIPE_PRICE_ANNUAL', 'price_xxxxxxxxxxxxx');  // £249.00/year

// Webhook secret (for handling subscription events)
define('STRIPE_WEBHOOK_SECRET', 'whsec_...');

// Settings
define('STRIPE_CURRENCY', 'gbp');
