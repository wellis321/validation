# Integration Testing Guide

## Recommended Testing Tools

### 1. **OWASP ZAP (Zed Attack Proxy)**
**Best for:** Automated security scanning  
**Download:** https://www.zaproxy.org/download/  
**Usage:**
1. Install OWASP ZAP
2. Start ZAP
3. Enter your site URL
4. Run "Quick Start" scan
5. Review results

**What it tests:**
- SQL Injection
- XSS vulnerabilities
- CSRF issues
- Security headers
- Authentication flaws
- Session management

### 2. **Burp Suite Community Edition**
**Best for:** Manual security testing  
**Download:** https://portswigger.net/burp/communitydownload  
**Usage:**
1. Install Burp Suite
2. Configure browser proxy
3. Browse your site
4. Use Burp to intercept and modify requests
5. Test for vulnerabilities

**What it tests:**
- Request/response manipulation
- Authentication bypass
- Session hijacking
- Parameter tampering

### 3. **Selenium WebDriver**
**Best for:** Automated functional testing  
**Install:** `npm install selenium-webdriver`  
**Usage:** Create automated browser tests

**Example Test:**
```javascript
const {Builder, By, until} = require('selenium-webdriver');

async function testLogin() {
    let driver = await new Builder().forBrowser('chrome').build();
    try {
        await driver.get('https://your-site.com/login.php');
        await driver.findElement(By.name('email')).sendKeys('test@example.com');
        await driver.findElement(By.name('password')).sendKeys('Test123!');
        await driver.findElement(By.css('button[type="submit"]')).click();
        await driver.wait(until.urlContains('index.php'), 5000);
        console.log('✅ Login test passed');
    } finally {
        await driver.quit();
    }
}
```

### 4. **Playwright**
**Best for:** Modern browser automation  
**Install:** `npm install playwright`  
**Usage:** Cross-browser testing

**Example Test:**
```javascript
const { test, expect } = require('@playwright/test');

test('CSRF protection test', async ({ page }) => {
    await page.goto('https://your-site.com/login.php');
    
    // Try to submit form without CSRF token
    await page.evaluate(() => {
        const form = document.querySelector('form');
        const csrfInput = form.querySelector('input[name="csrf_token"]');
        if (csrfInput) csrfInput.remove();
    });
    
    await page.click('button[type="submit"]');
    
    // Should show error
    await expect(page.locator('text=Invalid CSRF token')).toBeVisible();
});
```

### 5. **PHPUnit** (for PHP backend tests)
**Best for:** Server-side unit testing  
**Install:** `composer require phpunit/phpunit`  
**Usage:** Test PHP classes and functions

**Example Test:**
```php
<?php
use PHPUnit\Framework\TestCase;

class SecurityTest extends TestCase {
    public function testCsrfTokenGeneration() {
        $security = Security::getInstance();
        $token = $security->generateCsrfToken();
        $this->assertNotEmpty($token);
        $this->assertGreaterThanOrEqual(32, strlen($token));
    }
    
    public function testSqlInjectionProtection() {
        $db = Database::getInstance();
        // Test that prepared statements work
        $stmt = $db->query("SELECT * FROM users WHERE email = ?", ["test' OR '1'='1"]);
        $result = $stmt->fetch();
        $this->assertFalse($result); // Should not find user
    }
}
```

## Quick Security Scan Commands

### Using cURL (from tests/curl-security-tests.sh)
```bash
./tests/curl-security-tests.sh https://your-site.com
```

### Using OWASP ZAP CLI
```bash
# Install ZAP
# Run automated scan
zap-cli quick-scan --self-contained --start-options '-config api.disablekey=true' https://your-site.com
```

### Using nmap (Network Security Scanner)
```bash
# Check for open ports and services
nmap -sV -sC your-site.com

# Check SSL/TLS configuration
nmap --script ssl-enum-ciphers -p 443 your-site.com
```

## Continuous Testing Setup

### GitHub Actions Example
Create `.github/workflows/security-tests.yml`:

```yaml
name: Security Tests

on:
  schedule:
    - cron: '0 0 * * 0'  # Weekly
  workflow_dispatch:

jobs:
  security-scan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Run OWASP ZAP Scan
        uses: zaproxy/action-full-scan@v0.4.0
        with:
          target: 'https://your-site.com'
          
      - name: Upload Results
        uses: actions/upload-artifact@v2
        with:
          name: zap-results
          path: report_html.html
```

## Testing Checklist by Category

### Authentication & Authorization
- [ ] Login with valid credentials
- [ ] Login with invalid credentials
- [ ] Login rate limiting (5+ attempts)
- [ ] Session timeout (2 hours)
- [ ] Logout functionality
- [ ] Password reset flow
- [ ] Email verification required

### Input Validation
- [ ] SQL injection attempts fail
- [ ] XSS attempts are escaped
- [ ] Email format validation
- [ ] Password strength requirements
- [ ] File type validation (client-side)
- [ ] File size limits

### CSRF Protection
- [ ] All POST forms have CSRF tokens
- [ ] CSRF token validation works
- [ ] Token regeneration on login

### Security Headers
- [ ] X-Frame-Options: DENY
- [ ] X-Content-Type-Options: nosniff
- [ ] X-XSS-Protection: 1; mode=block
- [ ] Strict-Transport-Security
- [ ] Content-Security-Policy

### File Processing
- [ ] CSV files process correctly
- [ ] Excel files process correctly
- [ ] JSON files process correctly
- [ ] Large files show warnings
- [ ] No server-side file uploads

### Error Handling
- [ ] Errors don't expose system info
- [ ] 404 page works correctly
- [ ] Error messages are user-friendly

## Automated Test Results Template

```
Test Run Date: _______________
Environment: Production
URL: _______________

Tool: OWASP ZAP
Results: ✅ PASS / ❌ FAIL
Issues Found: _______

Tool: Security Headers
Score: _______
Grade: _______

Tool: SSL Labs
Grade: _______

Tool: PageSpeed Insights
Score: _______

Overall Status: ✅ READY / ⚠️ NEEDS FIXES
```

