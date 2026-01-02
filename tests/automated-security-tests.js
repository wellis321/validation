/**
 * Automated Security Tests (Client-Side)
 * Run these in browser console on your production site
 * 
 * Usage:
 * 1. Open your production site
 * 2. Open browser DevTools (F12)
 * 3. Go to Console tab
 * 4. Paste and run this entire script
 */

(function() {
    console.log('%c🔒 Security Test Suite Starting...', 'color: #3b82f6; font-size: 16px; font-weight: bold');
    
    const tests = [];
    let passed = 0;
    let failed = 0;
    let warnings = 0;

    function addTest(name, passed, message, isWarning = false) {
        tests.push({ name, passed, message, isWarning });
        if (passed) {
            passed++;
            console.log(`✅ ${name}: ${message}`);
        } else if (isWarning) {
            warnings++;
            console.warn(`⚠️ ${name}: ${message}`);
        } else {
            failed++;
            console.error(`❌ ${name}: ${message}`);
        }
    }

    // Test 1: Check for CSRF tokens in forms
    const forms = document.querySelectorAll('form[method="POST"]');
    let csrfFound = 0;
    forms.forEach(form => {
        if (form.querySelector('input[name="csrf_token"]')) {
            csrfFound++;
        }
    });
    addTest(
        'CSRF Protection',
        csrfFound === forms.length,
        `Found CSRF tokens in ${csrfFound}/${forms.length} POST forms`,
        csrfFound > 0 && csrfFound < forms.length
    );

    // Test 2: Check for security headers (via meta tags or CSP)
    const cspMeta = document.querySelector('meta[http-equiv="Content-Security-Policy"]');
    addTest(
        'Content Security Policy',
        cspMeta !== null,
        cspMeta ? 'CSP meta tag found' : 'CSP meta tag not found (may be set via headers)',
        true
    );

    // Test 3: Check for HTTPS
    addTest(
        'HTTPS Usage',
        window.location.protocol === 'https:',
        window.location.protocol === 'https:' ? 'Site uses HTTPS' : 'WARNING: Site not using HTTPS',
        window.location.protocol !== 'https:'
    );

    // Test 4: Check for inline scripts (security concern)
    const inlineScripts = document.querySelectorAll('script:not([src])');
    addTest(
        'Inline Scripts',
        inlineScripts.length === 0,
        `Found ${inlineScripts.length} inline scripts (may reduce CSP effectiveness)`,
        true
    );

    // Test 5: Check for external scripts from CDN
    const externalScripts = Array.from(document.querySelectorAll('script[src]'))
        .filter(s => s.src && !s.src.startsWith(window.location.origin));
    addTest(
        'External Scripts',
        externalScripts.length === 0,
        `Found ${externalScripts.length} external scripts`,
        true
    );

    // Test 6: Check form validation
    const requiredInputs = document.querySelectorAll('input[required], textarea[required]');
    addTest(
        'Form Validation',
        requiredInputs.length > 0,
        `Found ${requiredInputs.length} required form fields`,
        false
    );

    // Test 7: Check for password fields (should be type="password")
    const passwordFields = document.querySelectorAll('input[type="password"]');
    const textFieldsNamedPassword = document.querySelectorAll('input[name*="password"][type="text"]');
    addTest(
        'Password Field Security',
        textFieldsNamedPassword.length === 0,
        textFieldsNamedPassword.length === 0 
            ? 'All password fields use type="password"' 
            : `WARNING: ${textFieldsNamedPassword.length} password fields use type="text"`,
        textFieldsNamedPassword.length > 0
    );

    // Test 8: Check for autocomplete on sensitive fields
    const sensitiveFields = document.querySelectorAll('input[name*="password"], input[name*="email"]');
    let autocompleteIssues = 0;
    sensitiveFields.forEach(field => {
        if (field.getAttribute('autocomplete') === 'off' && field.type === 'password') {
            autocompleteIssues++;
        }
    });
    addTest(
        'Autocomplete Security',
        autocompleteIssues === 0,
        autocompleteIssues === 0 
            ? 'Password fields have appropriate autocomplete settings' 
            : `${autocompleteIssues} password fields may have autocomplete issues`,
        true
    );

    // Test 9: Check for error message display (should not expose system info)
    const errorMessages = document.querySelectorAll('.error, [class*="error"], [id*="error"]');
    let exposedInfo = 0;
    errorMessages.forEach(el => {
        const text = el.textContent || el.innerText;
        if (text.includes('SQL') || text.includes('database') || text.includes('PDO') || text.includes('Exception')) {
            exposedInfo++;
        }
    });
    addTest(
        'Error Message Security',
        exposedInfo === 0,
        exposedInfo === 0 
            ? 'No system information exposed in error messages' 
            : `WARNING: ${exposedInfo} error messages may expose system information`,
        exposedInfo > 0
    );

    // Test 10: Check mobile menu functionality
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    addTest(
        'Mobile Menu',
        mobileMenuButton !== null && mobileMenu !== null,
        mobileMenuButton && mobileMenu 
            ? 'Mobile menu elements found' 
            : 'Mobile menu not found',
        true
    );

    // Summary
    console.log('\n%c📊 Test Summary', 'color: #10b981; font-size: 14px; font-weight: bold');
    console.log(`✅ Passed: ${passed}`);
    console.log(`❌ Failed: ${failed}`);
    console.log(`⚠️ Warnings: ${warnings}`);
    console.log(`📝 Total: ${tests.length}`);

    if (failed === 0) {
        console.log('%c✅ All critical tests passed!', 'color: #10b981; font-size: 14px; font-weight: bold');
    } else {
        console.log('%c❌ Some tests failed. Please review the results above.', 'color: #ef4444; font-size: 14px; font-weight: bold');
    }

    return {
        tests,
        summary: {
            passed,
            failed,
            warnings,
            total: tests.length
        }
    };
})();

