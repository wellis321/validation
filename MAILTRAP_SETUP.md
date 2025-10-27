# Mailtrap Email Setup Guide

## Current Issue
Your email configuration is failing because you're trying to use the production Mailtrap API without proper authorization. Here's how to fix it:

## Option 1: Use Mailtrap Sandbox (Recommended for Testing)

### Step 1: Get Your Inbox ID
1. Go to [Mailtrap.io](https://mailtrap.io) and log in
2. Navigate to your **Inboxes** section
3. Create a new inbox or use an existing one
4. Click on the inbox to open it
5. Look for the **Inbox ID** in the URL or settings (it looks like: `1234567`)

### Step 2: Update Configuration
Edit `config/email.php` and update the inbox_id:

```php
'mailtrap' => [
    'api_token' => 'eb2780eb1860feeb90e4352e21efb16f', // Your current token
    'inbox_id' => 'YOUR_ACTUAL_INBOX_ID' // Replace with your real inbox ID
],
```

### Step 3: Test
Run your test script again. Emails will be sent to your Mailtrap inbox instead of real recipients.

## Option 2: Use Production Email Service

If you want to send real emails to actual recipients, you need to:

### Step 1: Set up Domain Authentication
For `simple-data-cleaner.com`, you need:
- **SPF Record**: `v=spf1 include:mailtrap.io ~all`
- **DKIM Record**: Get from Mailtrap dashboard
- **DMARC Record**: `v=DMARC1; p=quarantine; rua=mailto:dmarc@simple-data-cleaner.com`

### Step 2: Use Production API Token
Get a production API token from Mailtrap and update your config:

```php
'mailtrap' => [
    'api_token' => 'YOUR_PRODUCTION_TOKEN', // Different from testing token
    'inbox_id' => null // Set to null for production
],
```

## Option 3: Switch to SMTP (Alternative)

If you prefer SMTP, update your config:

```php
'driver' => 'smtp',
'smtp' => [
    'host' => 'smtp.mailtrap.io',
    'port' => 2525,
    'username' => 'YOUR_MAILTRAP_USERNAME',
    'password' => 'YOUR_MAILTRAP_PASSWORD',
    'encryption' => 'tls'
],
```

## Quick Fix for Testing

**Immediate solution**: Set up a Mailtrap inbox and get the inbox ID, then update your config:

```php
'inbox_id' => '1234567', // Your actual inbox ID from Mailtrap
```

This will allow you to test email functionality immediately while keeping emails in the sandbox.

## Testing Steps

1. Update your `config/email.php` with the inbox ID
2. Run `test-new-email-config.php`
3. Check your Mailtrap inbox for the test email
4. Test user registration to verify verification emails work
5. Test password reset functionality

## Current Configuration Status

✅ **Working**: Email templates, branding, domain setup
❌ **Needs Fix**: Mailtrap inbox ID configuration
🔄 **Next**: Get inbox ID from Mailtrap and update config
