# Stripe Webhook Setup Guide

## Direct Link
Go directly to: https://dashboard.stripe.com/webhooks

## What You'll See
You should see a list of webhooks (or an empty list if none exist) with a button that says:
- **"+ Add endpoint"** (top right)
- Or **"Add endpoint"** button

## Step-by-Step Setup

### Step 1: Click "Add endpoint"
You'll see a form asking for:
- **Endpoint URL**
- **Description** (optional)

### Step 2: Enter Your Webhook URL
```
https://simple-data-cleaner.com/webhooks/stripe.php
```

### Step 3: Select Events
Click "Select events" and check these boxes:
- ✅ checkout.session.completed
- ✅ customer.subscription.created
- ✅ customer.subscription.updated
- ✅ customer.subscription.deleted
- ✅ invoice.payment_succeeded
- ✅ invoice.payment_failed

### Step 4: Save
Click "Add endpoint"

### Step 5: Get the Secret
After creating the endpoint, you'll see:
- The endpoint URL
- Events it listens to
- A **"Signing secret"** (starts with `whsec_`)

**Click "Reveal"** next to the signing secret to show it, then copy it.

## Troubleshooting

If you still can't see it:
1. Make sure you're logged into the correct Stripe account
2. Check the URL: https://dashboard.stripe.com/webhooks
3. You might be in "Test mode" - webhooks work in both test and live mode
4. Try a different browser or clear cache

Let me know if you still can't find it!
