/**
 * Email Validation Tests (Client-Side)
 * Tests the EmailValidator class from validators.js
 *
 * Usage:
 * 1. Open the Simple Data Cleaner app (e.g. index or dashboard) so validators.js is loaded
 * 2. Open browser DevTools (F12) → Console
 * 3. Paste and run this entire script
 */

(function() {
    'use strict';

    if (typeof EmailValidator === 'undefined') {
        console.error('EmailValidator not found. Open a page that loads validators.js (e.g. index or dashboard) and run this script again.');
        return;
    }

    console.log('%c📧 Email Validation Test Suite', 'color: #3b82f6; font-size: 16px; font-weight: bold');

    let passed = 0;
    let failed = 0;

    function run(name, ok, message) {
        if (ok) {
            passed++;
            console.log(`  ✅ ${name}: ${message}`);
        } else {
            failed++;
            console.error(`  ❌ ${name}: ${message}`);
        }
    }

    const V = new EmailValidator(true); // default: normalizeCase = true

    // --- getType ---
    run('getType', V.getType() === 'email', "getType() === 'email'");

    // --- Valid formats (should pass, fixed = normalized) ---
    const validPairs = [
        ['user@example.com', 'user@example.com'],
        ['User@Example.COM', 'user@example.com'],
        ['first.last@company.co.uk', 'first.last@company.co.uk'],
        ['user+tag@gmail.com', 'user+tag@gmail.com'],
        ['name_123@domain.org', 'name_123@domain.org'],
        ['a@b.co', 'a@b.co']
    ];
    validPairs.forEach(function(pair) {
        const r = V.validate(pair[0]);
        const ok = r.isValid && r.fixed === pair[1];
        run('Valid: ' + JSON.stringify(pair[0]), ok, ok ? 'OK' : 'got isValid=' + r.isValid + ' fixed=' + JSON.stringify(r.fixed));
    });

    // --- Trimming (leading/trailing space) ---
    const trimPairs = [
        ['  user@example.com', 'user@example.com'],
        ['user@example.com  ', 'user@example.com'],
        ['  user@example.com  ', 'user@example.com']
    ];
    trimPairs.forEach(function(pair) {
        const r = V.validate(pair[0]);
        const ok = r.isValid && r.fixed === pair[1];
        run('Trim: ' + JSON.stringify(pair[0]), ok, ok ? 'OK' : 'got fixed=' + JSON.stringify(r.fixed));
    });

    // --- Domain typo fixes ---
    const typoPairs = [
        ['user@gmial.com', 'user@gmail.com'],
        ['user@gmai.com', 'user@gmail.com'],
        ['user@gmail.con', 'user@gmail.com'],
        ['user@gmail.cmo', 'user@gmail.com'],
        ['user@yaho.com', 'user@yahoo.com'],
        ['user@yahoo.con', 'user@yahoo.com'],
        ['user@hotmial.com', 'user@hotmail.com'],
        ['user@hotmail.con', 'user@hotmail.com'],
        ['user@outlok.com', 'user@outlook.com'],
        ['user@outlook.con', 'user@outlook.com'],
        ['user@icloud.con', 'user@icloud.com'],
        ['user@live.con', 'user@live.com'],
        ['user@msn.con', 'user@msn.com'],
        ['user@btinternet.con', 'user@btinternet.com']
    ];
    typoPairs.forEach(function(pair) {
        const r = V.validate(pair[0]);
        const ok = r.isValid && r.fixed === pair[1];
        run('Typo: ' + pair[0], ok, ok ? 'OK' : 'got fixed=' + (r.fixed || r.error));
    });

    // --- Invalid formats (should fail) ---
    const invalid = [
        'user@example',
        '@example.com',
        'user@',
        'user@.com',
        'user@domain',
        'no-at-sign',
        'user example@domain.com'
    ];
    invalid.forEach(function(input) {
        const r = V.validate(input);
        run('Invalid: ' + JSON.stringify(input), !r.isValid && r.error, r.isValid ? 'expected invalid' : 'correctly rejected');
    });

    // --- Empty / edge ---
    run('null', !V.validate(null).isValid, 'null rejected');
    run('undefined', !V.validate(undefined).isValid, 'undefined rejected');
    run('empty string', !V.validate('').isValid, 'empty string rejected');
    run('whitespace only', !V.validate('   ').isValid, 'whitespace rejected');

    // --- value preserved (original input in result.value) ---
    const rVal = V.validate('  User@Example.COM  ');
    run('value preserved', rVal.isValid && rVal.value === '  User@Example.COM  ', 'result.value is original input');

    // --- normalizeCase = false ---
    const VNoNorm = new EmailValidator(false);
    const rNoNorm = VNoNorm.validate('User@Example.COM');
    run('normalizeCase=false', rNoNorm.isValid && rNoNorm.fixed === 'User@Example.COM', 'case not lowercased when normalizeCase is false');

    // --- getValidator('email') / 'e-mail' / 'e_mail' ---
    if (typeof getValidator !== 'undefined') {
        const v1 = getValidator('email');
        const v2 = getValidator('e-mail');
        const v3 = getValidator('e_mail');
        run('getValidator(email)', v1 && v1.getType && v1.getType() === 'email', 'getValidator("email") returns EmailValidator');
        run('getValidator(e-mail)', v2 && v2.getType && v2.getType() === 'email', 'getValidator("e-mail") returns EmailValidator');
        run('getValidator(e_mail)', v3 && v3.getType && v3.getType() === 'email', 'getValidator("e_mail") returns EmailValidator');
    }

    // --- Custom domain typos (user-provided org domains) ---
    const customTypos = { 'my-orgcom': 'myorg.com', 'myorgcom': 'myorg.com' };
    const VCustom = new EmailValidator(true, customTypos);
    const rCustom1 = VCustom.validate('will@my-orgcom');
    const rCustom2 = VCustom.validate('william@myorgcom');
    run('custom typo: my-orgcom', rCustom1.isValid && rCustom1.fixed === 'will@myorg.com', 'user typo my-orgcom → myorg.com');
    run('custom typo: myorgcom', rCustom2.isValid && rCustom2.fixed === 'william@myorg.com', 'user typo myorgcom → myorg.com');

    // --- Summary ---
    const total = passed + failed;
    console.log('');
    console.log('%c📊 Summary', 'color: #10b981; font-size: 14px; font-weight: bold');
    console.log('  ✅ Passed: ' + passed);
    console.log('  ❌ Failed: ' + failed);
    console.log('  📝 Total:  ' + total);
    if (failed === 0) {
        console.log('%c✅ All email validation tests passed.', 'color: #10b981; font-size: 14px; font-weight: bold');
    } else {
        console.log('%c❌ Some tests failed. Review the errors above.', 'color: #ef4444; font-size: 14px; font-weight: bold');
    }

    return { passed, failed, total };
})();
