-- Migration: Add created_at column to rate_limits table if missing
-- This fixes the "Column not found: 1054 Unknown column 'created_at'" error

-- Check if column exists and add it if it doesn't
ALTER TABLE rate_limits
ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Add index for performance if it doesn't exist
CREATE INDEX IF NOT EXISTS idx_created_at ON rate_limits(created_at);

-- Clean up old rate limit entries (older than 1 hour)
DELETE FROM rate_limits WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR);
