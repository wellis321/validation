-- QUICK GRANT SUBSCRIPTION
-- Copy and paste this, replacing YOUR_EMAIL@example.com with your actual email

-- Lifetime Beta (recommended for testing)
-- Note: Using '2037-12-31 23:59:59' as end_date (MySQL TIMESTAMP max is 2038-01-19)
INSERT INTO user_subscriptions (user_id, plan_id, start_date, end_date, status, payment_status, license_scope, feature_set_version)
SELECT
    u.id,
    sp.id,
    NOW(),
    '2037-12-31 23:59:59',  -- Maximum valid TIMESTAMP (lifetime = ~13 years, but effectively forever)
    'active',
    'completed',
    'lifetime',
    '2025-uk-validators'
FROM users u
CROSS JOIN subscription_plans sp
WHERE u.email = 'YOUR_EMAIL@example.com'  -- ⬅️ CHANGE THIS
  AND sp.name = 'Lifetime Beta'
LIMIT 1;

-- Verify it worked:
-- SELECT us.*, sp.name, u.email
-- FROM user_subscriptions us
-- JOIN subscription_plans sp ON us.plan_id = sp.id
-- JOIN users u ON us.user_id = u.id
-- WHERE u.email = 'YOUR_EMAIL@example.com';
