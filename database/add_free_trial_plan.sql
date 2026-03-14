-- Add Free Trial plan to subscription_plans
-- This plan grants 7 days of full access to new users

INSERT INTO subscription_plans (name, description, price, duration_months, max_requests_per_day, max_file_size_mb, features, is_active) VALUES
('Free Trial', '7-day free trial - full access to all features. No card required.', 0.00, 0, 0, 0, '{"unlimited_files": true, "client_side_processing": true, "all_data_types": true, "priority_support": false, "trial": true}', 1)
ON DUPLICATE KEY UPDATE 
    description = '7-day free trial - full access to all features. No card required.',
    features = '{"unlimited_files": true, "client_side_processing": true, "all_data_types": true, "priority_support": false, "trial": true}',
    is_active = 1;
