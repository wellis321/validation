# Manual Testing Checklist for Production Readiness

Use this checklist to manually test your production site. Test each item and check it off.

## 🔒 Security Tests

### SQL Injection Protection
- [ ] **Test 1:** Try SQL injection in login form
  - Enter: `admin' OR '1'='1` in email field
  - Expected: Should fail with "User not found" or "Invalid email"
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 2:** Try SQL injection in search/input fields
  - Enter: `'; DROP TABLE users; --`
  - Expected: Should be sanitized or rejected
  - Status: ✅ PASS / ❌ FAIL

### XSS Protection
- [ ] **Test 3:** Try XSS in form fields
  - Enter: `<script>alert('XSS')</script>` in any text field
  - Expected: Should be escaped (shown as text, not executed)
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 4:** Try XSS in URL parameters
  - Visit: `https://your-site.com/?test=<script>alert('XSS')</script>`
  - Expected: Should not execute JavaScript
  - Status: ✅ PASS / ❌ FAIL

### CSRF Protection
- [ ] **Test 5:** Verify CSRF tokens in forms
  - Open login form, view page source
  - Check for: `<input type="hidden" name="csrf_token" value="...">`
  - Expected: CSRF token field present
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 6:** Test CSRF protection
  - Submit form without CSRF token (remove hidden field)
  - Expected: Should reject with "Invalid CSRF token"
  - Status: ✅ PASS / ❌ FAIL

### Authentication Security
- [ ] **Test 7:** Test password strength requirements
  - Try weak password: `password`
  - Expected: Should reject (needs uppercase, number)
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 8:** Test rate limiting on login
  - Try 6+ failed login attempts quickly
  - Expected: Should block with "Too many requests"
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 9:** Test session security
  - Login, check browser cookies
  - Verify: `HttpOnly` flag set, `Secure` flag set (if HTTPS)
  - Status: ✅ PASS / ❌ FAIL

### File Upload Security
- [ ] **Test 10:** Verify no server-side uploads
  - Upload file, check browser Network tab
  - Expected: No file upload requests to server
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 11:** Test large file handling
  - Upload very large file (100MB+)
  - Expected: Warning message, or graceful handling
  - Status: ✅ PASS / ❌ FAIL

### Security Headers
- [ ] **Test 12:** Check security headers
  - Use: https://securityheaders.com
  - Or: Browser DevTools > Network > Response Headers
  - Expected: X-Frame-Options, X-Content-Type-Options, etc.
  - Status: ✅ PASS / ❌ FAIL

### Config File Protection
- [ ] **Test 13:** Try accessing config files
  - Visit: `https://your-site.com/config/database.php`
  - Expected: 403 Forbidden or blank page
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 14:** Try accessing .env file
  - Visit: `https://your-site.com/.env`
  - Expected: 403 Forbidden or 404 Not Found
  - Status: ✅ PASS / ❌ FAIL

---

## 🎨 User Experience Tests

### Form Functionality
- [ ] **Test 15:** Test registration flow
  - Register new account
  - Check email verification
  - Expected: Smooth flow, clear messages
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 16:** Test login flow
  - Login with valid credentials
  - Expected: Successful redirect, session maintained
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 17:** Test password reset
  - Request password reset
  - Check email received
  - Reset password
  - Expected: Complete flow works
  - Status: ✅ PASS / ❌ FAIL

### Data Cleaning Workflow
- [ ] **Test 18:** Upload CSV file
  - Upload sample CSV
  - Select fields to clean
  - Process and download
  - Expected: Complete workflow works
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 19:** Upload Excel file
  - Upload .xlsx file
  - Verify field selection works
  - Expected: Excel files handled correctly
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 20:** Upload JSON file
  - Upload JSON file
  - Verify processing works
  - Expected: JSON files handled correctly
  - Status: ✅ PASS / ❌ FAIL

### Mobile Responsiveness
- [ ] **Test 21:** Test mobile menu
  - Open site on mobile/tablet
  - Click hamburger menu
  - Expected: Menu opens/closes smoothly
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 22:** Test mobile forms
  - Fill forms on mobile device
  - Expected: Forms are usable, buttons accessible
  - Status: ✅ PASS / ❌ FAIL

### Error Handling
- [ ] **Test 23:** Test error messages
  - Trigger various errors (invalid login, etc.)
  - Expected: User-friendly messages, no technical details
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 24:** Test 404 page
  - Visit: `https://your-site.com/nonexistent-page`
  - Expected: Custom 404 page shown
  - Status: ✅ PASS / ❌ FAIL

---

## ⚡ Performance Tests

- [ ] **Test 25:** Test page load times
  - Use: Google PageSpeed Insights
  - Expected: Good performance score (>70)
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 26:** Test with large files
  - Upload 10MB+ CSV file
  - Expected: Processes without crashing browser
  - Status: ✅ PASS / ❌ FAIL

---

## 🔍 SEO & Accessibility Tests

- [ ] **Test 27:** Test structured data
  - Use: https://search.google.com/test/rich-results
  - Expected: Rich results detected
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 28:** Test accessibility
  - Use: Browser DevTools > Lighthouse > Accessibility
  - Expected: Score > 80
  - Status: ✅ PASS / ❌ FAIL

- [ ] **Test 29:** Test mobile-friendliness
  - Use: https://search.google.com/test/mobile-friendly
  - Expected: Mobile-friendly
  - Status: ✅ PASS / ❌ FAIL

---

## 📝 Test Results Summary

**Date Tested:** _______________

**Total Tests:** 29
**Passed:** _______
**Failed:** _______
**Warnings:** _______

**Overall Status:** ✅ READY / ⚠️ NEEDS FIXES / ❌ NOT READY

**Notes:**
_________________________________________________
_________________________________________________
_________________________________________________

