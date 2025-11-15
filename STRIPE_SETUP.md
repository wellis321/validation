# Stripe Integration Setup Guide

## Step 1: Create Products in Stripe

1. Log into [Stripe Dashboard](https://dashboard.stripe.com)
2. Go to **Products** → **Create product**

### Create these 3 products:

**Pay Per Use**
- Name: Pay Per Use
- Description: One-time payment for quick data cleaning tasks
- Add a price: £4.99 one-time
- Copy the Price ID (starts with `price_`)

**Monthly Subscription**
- Name: Monthly
- Description: Unlimited data cleaning, billed monthly
- Add a price: £29.99, recurring monthly
- Copy the Price ID

**Annual Subscription**
- Name: Annual
- Description: Best value - save £111 per year!
- Add a price: £249.00, recurring yearly
- Copy the Price ID

## Step 2: Get Your API Keys

1. Go to [API Keys](https://dashboard.stripe.com/apikeys)
2. Copy your **Publishable key** (starts with `pk_test_...`)
3. Copy your **Secret key** (starts with `sk_test_...`)

⚠️ **Important**: When you go live, switch to your Live keys!

## Step 3: Configure Your Application

1. Copy `config/stripe_config.example.php` to `config/stripe_config.php`
2. Add your API keys and Price IDs
3. Upload to your server

## Step 4: Set Up Stripe Checkout

You'll need to create a checkout page that:
1. Collects user information
2. Redirects to Stripe Checkout
3. Handles the payment success/failure

## Step 5: Set Up Webhooks (for subscriptions)

1. Go to [Webhooks](https://dashboard.stripe.com/webhooks)
2. Add endpoint: `https://simple-data-cleaner.com/webhooks/stripe.php`
3. Select events to listen to:
   - `checkout.session.completed`
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
   - `invoice.payment_succeeded`
   - `invoice.payment_failed`
4. Copy the webhook signing secret

## Step 6: Test

Use Stripe's test cards:
- **Success**: `4242 4242 4242 4242`
- **Decline**: `4000 0000 0000 0002`
- **3D Secure**: `4000 0025 0000 3155`

Use any future expiry date, any 3-digit CVC, and any postal code.

## Next Steps

You'll need to create:
- A checkout page (`checkout.php`)
- A success page (`success.php`)
- A webhook handler (`webhooks/stripe.php`)
- Update your database to store Stripe customer IDs

I can help you build these integration files!
