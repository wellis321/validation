-- Deactivate Lifetime Beta plan (don't delete to preserve existing subscriptions)
UPDATE subscription_plans
SET is_active = 0
WHERE name = 'Lifetime Beta';

-- Note: Existing Lifetime Beta subscriptions will remain active
-- This only prevents new purchases of the Lifetime Beta plan
