# SMTP Email Setup Guide

## ✅ Configuration Updated

Your email system has been switched from Mailtrap to SMTP using your Hostinger mailbox.

## 🔧 Required Setup

### Step 1: Update Email Password
Edit `config/email.php` and replace `YOUR_EMAIL_PASSWORD` with your actual email password:

```php
'smtp' => [
    'host' => 'smtp.hostinger.com',
    'port' => 587,
    'username' => 'noreply@simple-data-cleaner.com',
    'password' => 'YOUR_ACTUAL_EMAIL_PASSWORD', // ← Update this
    'encryption' => 'tls'
],
```

### Step 2: Test Email Functionality
1. Run `test-new-email-config.php` to test the configuration
2. Try registering a new user account
3. Check if verification emails are sent successfully

## 📧 Current Configuration

- **Driver**: SMTP
- **Host**: smtp.hostinger.com
- **Port**: 587 (TLS)
- **Username**: noreply@simple-data-cleaner.com
- **From Email**: noreply@simple-data-cleaner.com
- **From Name**: Simple Data Cleaner

## 🚀 Benefits of SMTP Setup

✅ **Real emails** sent to actual recipients
✅ **Professional domain** (noreply@simple-data-cleaner.com)
✅ **No third-party dependencies** (no Mailtrap needed)
✅ **Direct control** over email delivery
✅ **Better deliverability** with your own domain

## 🔍 Troubleshooting

### If emails don't send:
1. **Check password**: Ensure the email password is correct
2. **Check logs**: Look at `/logs/email.log` for error messages
3. **Hostinger settings**: Verify SMTP is enabled in your Hostinger control panel
4. **Firewall**: Ensure port 587 is not blocked

### Common Hostinger SMTP Settings:
- **Host**: smtp.hostinger.com
- **Port**: 587 (TLS) or 465 (SSL)
- **Authentication**: Required
- **Encryption**: TLS or SSL

## 📋 Optional: Domain Authentication

For better email deliverability, consider setting up:

### SPF Record
Add to your DNS:
```
v=spf1 include:hostinger.com ~all
```

### DKIM Record
Configure DKIM in your Hostinger control panel

### DMARC Record
Add to your DNS:
```
v=DMARC1; p=quarantine; rua=mailto:dmarc@simple-data-cleaner.com
```

## ✅ Next Steps

1. **Update the password** in config/email.php
2. **Test the setup** with the test script
3. **Try user registration** to verify verification emails work
4. **Test password reset** functionality

Your login and registration systems are now ready to work with real email delivery!
