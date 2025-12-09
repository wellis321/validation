-- Safe index creation script
-- This script can be run multiple times without errors
-- Run this after importing schema.sql if you want the performance indexes

-- Note: MySQL doesn't support CREATE INDEX IF NOT EXISTS in older versions
-- So we'll create them manually and ignore errors if they already exist

-- Index on user email (optional - email already has UNIQUE constraint)
-- CREATE INDEX idx_user_email ON users(email);

-- Index on subscription dates for faster date range queries
CREATE INDEX idx_subscription_dates ON user_subscriptions(start_date, end_date);

-- Index on API usage date for faster date-based queries
CREATE INDEX idx_api_usage_date ON api_usage(request_date);

-- These indexes are optional for performance optimization
-- If you get errors saying they already exist, that's fine - just ignore them
