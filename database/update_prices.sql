-- Update subscription plan prices
-- Run this in your phpMyAdmin SQL tab

-- Ensure subscription metadata columns exist for feature gating
ALTER TABLE user_subscriptions
    ADD COLUMN IF NOT EXISTS stripe_price_id VARCHAR(255) NULL AFTER payment_status,
    ADD COLUMN IF NOT EXISTS feature_set_version VARCHAR(100) NULL AFTER stripe_price_id,
    ADD COLUMN IF NOT EXISTS license_scope VARCHAR(50) NULL AFTER feature_set_version;

UPDATE subscription_plans SET price = 4.99, duration_months = 0.033, description = '24-hour access - perfect for quick tasks. Clean and re-download as many times as needed!' WHERE name = 'Pay Per Use';
UPDATE subscription_plans SET price = 29.99 WHERE name = 'Monthly';
UPDATE subscription_plans SET price = 249.99 WHERE name = 'Annual';

-- Also update the Annual plan description to reflect new savings
UPDATE subscription_plans SET description = 'Best value - save £109.89 per year!' WHERE name = 'Annual';

-- Insert Lifetime Beta plan if it does not exist
INSERT INTO subscription_plans (name, description, price, duration_months, max_requests_per_day, max_file_size_mb, features, is_active)
SELECT 'Lifetime Beta', 'One-time £99.99 payment for lifetime access to today''s validators during beta.', 99.99, 0, 0, 0, '{"unlimited_files": true, "client_side_processing": true, "all_data_types": true, "priority_support": false, "lifetime_access": true}', 1
WHERE NOT EXISTS (SELECT 1 FROM subscription_plans WHERE name = 'Lifetime Beta');

-- Ensure Lifetime Beta pricing and messaging stays in sync
UPDATE subscription_plans
SET price = 99.99,
    duration_months = 0,
    max_requests_per_day = 0,
    max_file_size_mb = 0,
    description = 'One-time £99.99 payment for lifetime access to today''s validators during beta.',
    features = '{"unlimited_files": true, "client_side_processing": true, "all_data_types": true, "priority_support": false, "lifetime_access": true}'
WHERE name = 'Lifetime Beta';
