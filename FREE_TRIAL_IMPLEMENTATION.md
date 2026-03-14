# 7-Day Free Trial Implementation

## Summary

A 7-day free trial has been implemented for new users. When users register, they automatically receive full access to all features for 7 days. No credit card is required.

## What Was Changed

### 1. Database
- **File**: `database/add_free_trial_plan.sql`
- Adds a "Free Trial" subscription plan to the database
- **Action Required**: Run this SQL file on your database:
  ```bash
  mysql -u root -p simple_data_cleaner < database/add_free_trial_plan.sql
  ```

### 2. Registration Flow (`includes/Auth.php`)
- Added `grantFreeTrial()` method that:
  - Checks if user has ever had a subscription (prevents re-granting trials)
  - Creates a 7-day trial subscription automatically after registration
  - Trial starts immediately and expires 7 days later

### 3. UI Updates

#### Pricing Page (`pricing.php`)
- Added prominent "7-day free trial" messaging at the top
- Green banner highlighting "No card required"
- Free Trial plan excluded from purchasable plans (it's auto-granted)

#### Index/Upload Page (`index.php`)
- Shows trial countdown banner when user is on trial
- Displays days/hours remaining
- Prominent "Subscribe Now" button when trial is expiring soon
- Updated messaging for non-subscribers to encourage signup

#### Account Page (`account.php`)
- Shows trial status with green highlight box
- Displays days/hours remaining
- Clear call-to-action to subscribe before trial ends

#### Register Page (`register.php`)
- Updated heading: "Start Your 7-Day Free Trial"
- Added benefits list (full access, upload own files, etc.)
- Success message mentions trial has started

## How It Works

1. **User registers** → Account created
2. **Trial automatically granted** → 7-day subscription created (if user has never had a subscription)
3. **User can use app** → Full access to upload, clean, and export
4. **Trial countdown shown** → Days/hours remaining displayed throughout app
5. **Trial expires** → User sees paywall, can subscribe to continue

## Eligibility

- **Eligible**: Users who have never had any subscription (including expired/cancelled)
- **Not Eligible**: Users who have previously had a subscription (prevents abuse)

## Testing

1. Create a new test account
2. Verify trial subscription is created in `user_subscriptions` table
3. Check that trial countdown appears on index page
4. Verify account page shows trial status
5. Test that trial plan doesn't appear on pricing page

## Next Steps

1. **Run the SQL migration**:
   ```bash
   mysql -u root -p simple_data_cleaner < database/add_free_trial_plan.sql
   ```

2. **Test registration flow**:
   - Register a new account
   - Verify trial is granted
   - Check UI shows trial countdown

3. **Monitor conversions**:
   - Track how many trial users convert to paid
   - Consider email reminders 2 days before trial ends
   - A/B test trial duration (7 days vs 14 days)

## Future Enhancements (Optional)

- Email reminder 2 days before trial expires
- Extend trial to 14 days for better conversion
- Show trial usage stats (files cleaned, rows processed)
- Allow trial extension for users who engage heavily
