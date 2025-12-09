-- Grant yourself a subscription
--
-- STEP 1: Replace 'your-email@example.com' below with your actual email address
-- STEP 2: Choose which plan you want (uncomment the INSERT you want)
-- STEP 3: Run the SQL

-- First, let's see your user ID and available plans:
-- SELECT id, email FROM users WHERE email = 'your-email@example.com';
-- SELECT id, name, price FROM subscription_plans WHERE is_active = 1;

-- ============================================
-- OPTION 1: Lifetime Beta (Recommended for testing)
-- ============================================
INSERT INTO user_subscriptions (
    user_id,
    plan_id,
    start_date,
    end_date,
    status,
    payment_status,
    license_scope,
    feature_set_version
) VALUES (
    (SELECT id FROM users WHERE email = 'your-email@example.com' LIMIT 1),  -- ⬅️ CHANGE THIS EMAIL
    (SELECT id FROM subscription_plans WHERE name = 'Lifetime Beta' LIMIT 1),
    NOW(),
    '2037-12-31 23:59:59',  -- Maximum valid TIMESTAMP (lifetime = ~13 years, effectively forever)
    'active',
    'completed',
    'lifetime',
    '2025-uk-validators'
);

-- ============================================
-- OPTION 2: Monthly Subscription
-- ============================================
-- INSERT INTO user_subscriptions (
--     user_id,
--     plan_id,
--     start_date,
--     end_date,
--     status,
--     payment_status
-- ) VALUES (
--     (SELECT id FROM users WHERE email = 'your-email@example.com' LIMIT 1),  -- ⬅️ CHANGE THIS EMAIL
--     (SELECT id FROM subscription_plans WHERE name = 'Monthly' LIMIT 1),
--     NOW(),
--     DATE_ADD(NOW(), INTERVAL 1 MONTH),
--     'active',
--     'completed'
-- );

-- ============================================
-- OPTION 3: Annual Subscription
-- ============================================
-- INSERT INTO user_subscriptions (
--     user_id,
--     plan_id,
--     start_date,
--     end_date,
--     status,
--     payment_status
-- ) VALUES (
--     (SELECT id FROM users WHERE email = 'your-email@example.com' LIMIT 1),  -- ⬅️ CHANGE THIS EMAIL
--     (SELECT id FROM subscription_plans WHERE name = 'Annual' LIMIT 1),
--     NOW(),
--     DATE_ADD(NOW(), INTERVAL 12 MONTH),
--     'active',
--     'completed'
-- );

-- ============================================
-- Verify your subscription was created:
-- ============================================
-- SELECT
--     us.*,
--     sp.name as plan_name,
--     sp.price,
--     u.email
-- FROM user_subscriptions us
-- JOIN subscription_plans sp ON us.plan_id = sp.id
-- JOIN users u ON us.user_id = u.id
-- WHERE u.email = 'your-email@example.com'  -- ⬅️ CHANGE THIS EMAIL
-- ORDER BY us.created_at DESC;
