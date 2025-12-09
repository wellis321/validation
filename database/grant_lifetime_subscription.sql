-- Grant Lifetime Beta Subscription (Fixed for TIMESTAMP limit)
-- Replace 'williamjamesellis@outlook.com' with your email if different

INSERT INTO user_subscriptions (user_id, plan_id, start_date, end_date, status, payment_status, license_scope, feature_set_version)
SELECT
    u.id,
    sp.id,
    NOW(),
    '2037-12-31 23:59:59',  -- Maximum valid TIMESTAMP (effectively lifetime)
    'active',
    'completed',
    'lifetime',
    '2025-uk-validators'
FROM users u
CROSS JOIN subscription_plans sp
WHERE u.email = 'williamjamesellis@outlook.com'
  AND sp.name = 'Lifetime Beta'
LIMIT 1;
