-- Update subscription plan prices
-- Run this in your phpMyAdmin SQL tab

UPDATE subscription_plans SET price = 4.99 WHERE name = 'Pay Per Use';
UPDATE subscription_plans SET price = 29.99 WHERE name = 'Monthly';
UPDATE subscription_plans SET price = 249.00 WHERE name = 'Annual';

-- Also update the Annual plan description to reflect new savings
UPDATE subscription_plans SET description = 'Best value - save £111 per year!' WHERE name = 'Annual';
