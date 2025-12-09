-- Remove duplicate subscription plans (keeps the one with highest ID for each plan name)
-- This fixes the issue where plans appear duplicated if schema was imported multiple times

DELETE sp1 FROM subscription_plans sp1
INNER JOIN subscription_plans sp2
WHERE sp1.name = sp2.name
  AND sp1.id < sp2.id;

-- Alternative: If you want to keep the oldest one (lowest ID) instead, use:
-- DELETE sp1 FROM subscription_plans sp1
-- INNER JOIN subscription_plans sp2
-- WHERE sp1.name = sp2.name
--   AND sp1.id > sp2.id;
