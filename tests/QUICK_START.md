# Quick Start: Testing Your Production Site

## 🚀 5-Minute Quick Test

### Step 1: Run Automated Server Test (2 minutes)
1. Upload `security-test.php` to your server: `/tests/security-test.php`
2. Visit: `https://your-site.com/tests/security-test.php`
3. Review results - all should be ✅

### Step 2: Run Browser Console Test (1 minute)
1. Open your production site
2. Press F12 (DevTools)
3. Go to Console tab
4. Copy entire contents of `automated-security-tests.js`
5. Paste and press Enter
6. Review console output

### Step 3: Run External Security Scan (2 minutes)
1. Visit: https://securityheaders.com
2. Enter your site URL
3. Check grade (should be A or B)
4. Fix any issues found

## ✅ Quick Checklist

- [ ] Config files return 403/404
- [ ] CSRF tokens in all POST forms
- [ ] Security headers present
- [ ] HTTPS enforced
- [ ] Mobile menu works
- [ ] File upload/processing works

## 📋 Full Testing

For comprehensive testing, see:
- `manual-test-checklist.md` - Complete manual testing guide
- `integration-test-suite.md` - Advanced testing tools
- `README.md` - Full documentation

## 🔐 After Testing

**IMPORTANT:** Remove or protect test files:
```bash
# Option 1: Delete
rm tests/security-test.php

# Option 2: Password protect (see README.md)
```

