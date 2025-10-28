-- Update subscription plan prices
-- Run this in your phpMyAdmin SQL tab

UPDATE subscription_plans SET price = 4.99, duration_months = 0.033, description = '24-hour access - perfect for quick tasks. Clean and re-download as many times as needed!' WHERE name = 'Pay Per Use';
UPDATE subscription_plans SET price = 29.99 WHERE name = 'Monthly';
UPDATE subscription_plans SET price = 249.00 WHERE name = 'Annual';

-- Also update the Annual plan description to reflect new savings
UPDATE subscription_plans SET description = 'Best value - save £111 per year!' WHERE name = 'Annual';
