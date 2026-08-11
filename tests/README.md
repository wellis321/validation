# Automated Validator Test Suite

Automated regression tests for the client-side validators (`validators.js`) and file
import handling (`fileProcessor.js`). Uses Node's built-in test runner - no dependencies
to install.

## Running the tests

```bash
npm test
```

This runs `node --test`, which auto-discovers every `*.test.js` file under `tests/`.
To run a single file:

```bash
node --test tests/validators.test.js
node --test tests/variations.test.js
node --test tests/file-processor.test.js
```

## What's here

### `validators.test.js` - hand-verified correctness tests
Explicit, known-correct `input -> expected output` assertions for every validator class
(`PhoneNumberValidator`, `NINumberValidator`, `PostcodeValidator`, `SortCodeValidator`,
`BankAccountValidator`, `EmailValidator`, `NameSplitter`, `autoValidate`). Also includes
regression guards for real bugs fixed in this codebase (a US number being misclassified
as a valid UK number, bank account letters being silently stripped instead of rejected,
NI numbers accepting any final letter instead of only A/B/C/D) - these exist specifically
so those bugs can't come back unnoticed.

**Add a test here when:** you know the exact expected result for a specific input and
want a hard, permanent assertion (e.g. "this exact postcode must format to exactly this
string"). Follow the existing `describe`/`test` pattern per validator.

### `variations.test.js` - full-corpus regression tests
Runs every real-world example in the `*-variations.txt` fixture files (phone, NI,
postcode, sort code, email - 780+ inputs total) through the real validator and compares
the result against a checked-in snapshot in `tests/snapshots/*.json`. This is a
*characterisation* test, not a hand-verified one: nobody manually confirmed every one of
those 780 inputs is "correct" - the point is that if a code change causes ANY of them to
start behaving differently, the diff shows up immediately with the exact input and what
changed, instead of drifting silently (which is how the three bugs above went unnoticed
before this suite existed).

**Add a test value here when:** you want broad coverage of a new formatting quirk without
writing an assertion by hand - just add a line to the relevant `*-variations.txt` file.
New lines need a blank line before and after their section header (see the parsing rules
in `tests/lib/parse-variations.js`) and must contain a digit (or `@` for email) so they
aren't mistaken for a section heading.

**To intentionally accept a behavior change:** delete the relevant file in
`tests/snapshots/`, re-run `npm test` (it regenerates from current behavior), and review
the diff in `git diff tests/snapshots/` before committing - that diff *is* the change log
for what the validator now does differently.

### `file-processor.test.js` - file import regression tests
Tests `fileProcessor.js`'s handling of a UTF-8 BOM on CSV/JSON import (a common artifact
when Excel users export via "CSV UTF-8"), using a small in-memory `FileReader` stub since
that's a browser-only API. Add tests here for other `fileProcessor.js` import/export
behavior as it's built out.

### `lib/parse-variations.js`
Shared parser for the `*-variations.txt` fixture format. Not a test file itself.

## Older, manual test files

The files below predate this automated suite and are separate from it - they're manual,
browser-based checks, not run by `npm test`:

- `email-validation-tests.js` - paste into browser DevTools console (superseded in
  coverage by `validators.test.js`, kept for manual spot-checking in a live page)
- `security-test.php`, `automated-security-tests.js`, `curl-security-tests.sh`,
  `manual-test-checklist.md`, `integration-test-suite.md` - production security/manual
  testing tools, described below.

---

# Testing Suite for Production Readiness

This directory also contains testing tools and checklists to verify your production site is ready.

## 📋 Testing Files

### 1. `security-test.php` - Automated Security Tests
**Purpose:** Server-side security verification  
**Usage:** 
1. Upload to your production server in `/tests/` directory
2. Visit: `https://your-site.com/tests/security-test.php`
3. Review results

**⚠️ IMPORTANT:** Remove or password-protect this file after testing!

### 2. `automated-security-tests.js` - Client-Side Security Tests
**Purpose:** Browser-based security checks  
**Usage:**
1. Open your production site
2. Open browser DevTools (F12)
3. Go to Console tab
4. Copy and paste the entire script
5. Press Enter to run

**Results:** Check console for test results

### 3. `email-validation-tests.js` - Email Validator Tests
**Purpose:** Automated tests for the EmailValidator (validators.js) — valid formats, trimming, domain typo fixes, invalid detection, empty/edge cases, and `getValidator('email')`.  
**Usage:**
1. Open a page that loads **validators.js** (e.g. the app homepage or dashboard)
2. Open browser DevTools (F12) → Console
3. Copy and paste the entire script from `tests/email-validation-tests.js`
4. Press Enter to run

**Results:** Check console for ✅/❌ and a summary. All tests should pass if the EmailValidator implementation is correct.

### 4. `manual-test-checklist.md` - Manual Testing Guide
**Purpose:** Comprehensive manual testing checklist  
**Usage:**
1. Open the checklist
2. Test each item on your production site
3. Check off completed tests
4. Document any failures

## 🔒 Security Testing Tools (External)

### Recommended Online Tools:

1. **Security Headers**
   - URL: https://securityheaders.com
   - Tests: Security headers, CSP, HSTS
   - Usage: Enter your site URL

2. **Mozilla Observatory**
   - URL: https://observatory.mozilla.org
   - Tests: Comprehensive security scan
   - Usage: Enter your site URL

3. **SSL Labs SSL Test**
   - URL: https://www.ssllabs.com/ssltest/
   - Tests: SSL/TLS configuration
   - Usage: Enter your domain

4. **Google Rich Results Test**
   - URL: https://search.google.com/test/rich-results
   - Tests: Structured data (SEO)
   - Usage: Enter your site URL

5. **Google Mobile-Friendly Test**
   - URL: https://search.google.com/test/mobile-friendly
   - Tests: Mobile responsiveness
   - Usage: Enter your site URL

6. **PageSpeed Insights**
   - URL: https://pagespeed.web.dev
   - Tests: Performance and Core Web Vitals
   - Usage: Enter your site URL

## 🧪 Testing Workflow

### Step 1: Automated Server Tests
```bash
# 1. Upload security-test.php to your server
# 2. Visit: https://your-site.com/tests/security-test.php
# 3. Review all test results
# 4. Fix any failures
# 5. Remove or protect the test file
```

### Step 2: Automated Client Tests
```bash
# 1. Open production site in browser
# 2. Open DevTools Console
# 3. Run automated-security-tests.js
# 4. Run email-validation-tests.js (on a page that loads validators.js)
# 5. Review console output
```

### Step 3: External Security Scans
```bash
# Run these online tools:
1. https://securityheaders.com → Check headers
2. https://observatory.mozilla.org → Full security scan
3. https://www.ssllabs.com/ssltest/ → SSL/TLS check
```

### Step 4: Manual Testing
```bash
# Follow manual-test-checklist.md
# Test each item systematically
# Document results
```

### Step 5: Functional Testing
```bash
# Test complete user workflows:
1. Registration → Email verification → Login
2. File upload → Processing → Download
3. Password reset flow
4. Subscription purchase (if applicable)
```

## 🎯 Quick Test Checklist

### Critical (Must Pass):
- [ ] Config files not accessible (403/404)
- [ ] CSRF tokens in all POST forms
- [ ] Security headers present
- [ ] HTTPS enforced
- [ ] SQL injection attempts fail
- [ ] XSS attempts are escaped
- [ ] Error messages don't expose system info

### Important (Should Pass):
- [ ] Mobile menu works
- [ ] All forms functional
- [ ] File upload/processing works
- [ ] Password reset works
- [ ] Email verification works

### Nice to Have:
- [ ] PageSpeed score > 70
- [ ] Accessibility score > 80
- [ ] Rich results detected
- [ ] Mobile-friendly verified

## 📊 Test Results Template

```
Date: _______________
Tester: _______________
Environment: Production

Automated Server Tests: ✅ PASS / ❌ FAIL
Automated Client Tests: ✅ PASS / ❌ FAIL
External Security Scan: ✅ PASS / ❌ FAIL
Manual Testing: ✅ PASS / ❌ FAIL

Issues Found:
1. _______________
2. _______________

Overall Status: ✅ READY / ⚠️ NEEDS FIXES / ❌ NOT READY
```

## 🔐 Protecting Test Files

After testing, protect or remove test files:

### Option 1: Password Protect
Add to `.htaccess`:
```apache
<FilesMatch "security-test\.php">
    AuthType Basic
    AuthName "Restricted Access"
    AuthUserFile /path/to/.htpasswd
    Require valid-user
</FilesMatch>
```

### Option 2: IP Restriction
Add to `.htaccess`:
```apache
<FilesMatch "security-test\.php">
    Order deny,allow
    Deny from all
    Allow from YOUR.IP.ADDRESS
</FilesMatch>
```

### Option 3: Remove Files
```bash
# After testing, delete:
rm tests/security-test.php
```

## 📝 Notes

- Run tests regularly (monthly recommended)
- Document all test results
- Fix critical issues immediately
- Keep test files updated with new security checks

