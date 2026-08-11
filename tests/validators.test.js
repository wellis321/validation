// Hand-verified correctness tests for validators.js.
// These are explicit, known-correct input -> output assertions (not the
// full *-variations.txt corpus - see variations.test.js for that).
// Run with: node --test tests/

const { test, describe } = require('node:test');
const assert = require('node:assert/strict');
const {
    PhoneNumberValidator,
    NINumberValidator,
    PostcodeValidator,
    BankAccountValidator,
    SortCodeValidator,
    EmailValidator,
    NameSplitter,
    autoValidate
} = require('../validators.js');

describe('PhoneNumberValidator', () => {
    test('getType', () => {
        assert.equal(new PhoneNumberValidator().getType(), 'phone_number');
    });

    test('valid UK mobile, international output (default)', () => {
        const r = new PhoneNumberValidator().validate('07700 900461');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '+447700900461');
    });

    test('valid UK mobile, uk output format', () => {
        const r = new PhoneNumberValidator('uk').validate('+44 7700 900461');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '07700 900 461');
    });

    test('valid UK landline with area code', () => {
        const r = new PhoneNumberValidator().validate('020 7946 0958');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '+442079460958');
    });

    test('strips labels and extensions', () => {
        const r = new PhoneNumberValidator().validate('Mobile: 07700 900461 ext 12');
        assert.equal(r.isValid, true);
    });

    test('rejects garbage', () => {
        const r = new PhoneNumberValidator().validate('not a phone number');
        assert.equal(r.isValid, false);
    });

    // Regression: a bare "1" + 10 digits (e.g. a US number) must not be
    // accepted as a valid UK number. Fixed by removing the over-broad
    // /^1\d{10}$/ "UK Number" pattern.
    test('regression: US-style 1-prefixed 11-digit number is rejected, not misclassified as UK', () => {
        const r = new PhoneNumberValidator().validate('1 800 555 0199');
        assert.equal(r.isValid, false);
    });
});

describe('NINumberValidator', () => {
    test('getType', () => {
        assert.equal(new NINumberValidator().getType(), 'ni_number');
    });

    test('valid NI number', () => {
        const r = new NINumberValidator().validate('AB123456C');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'AB 123456 C');
    });

    test('valid NI number with separators gets cleaned', () => {
        const r = new NINumberValidator().validate('AB-12-34-56-C');
        assert.equal(r.isValid, true);
        assert.equal(r.value, 'AB123456C');
    });

    test('rejects banned prefix', () => {
        const r = new NINumberValidator().validate('BG123456C');
        assert.equal(r.isValid, false);
        assert.match(r.error, /Invalid prefix/);
    });

    test('rejects TRN format', () => {
        const r = new NINumberValidator().validate('11A11111');
        assert.equal(r.isValid, false);
        assert.match(r.error, /TRN/);
    });

    // Regression: HMRC only ever issues A, B, C, or D as the final letter.
    // Fixed by tightening the pattern from [A-Z] to [ABCD].
    test('regression: invalid final letter (e.g. Z) is rejected', () => {
        const r = new NINumberValidator().validate('AB123456Z');
        assert.equal(r.isValid, false);
    });

    test('final letters A, B, C, D all remain valid', () => {
        for (const letter of ['A', 'B', 'C', 'D']) {
            const r = new NINumberValidator().validate(`AB123456${letter}`);
            assert.equal(r.isValid, true, `AB123456${letter} should be valid`);
        }
    });
});

describe('PostcodeValidator', () => {
    test('getType', () => {
        assert.equal(new PostcodeValidator().getType(), 'postcode');
    });

    test('valid postcode, already spaced', () => {
        const r = new PostcodeValidator().validate('SW1A 1AA');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'SW1A 1AA');
    });

    test('valid postcode, no space gets fixed', () => {
        const r = new PostcodeValidator().validate('sw1a1aa');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'SW1A 1AA');
    });

    test('extracts postcode from a full address', () => {
        const r = new PostcodeValidator().validate('10 Downing Street, SW1A 1AA');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'SW1A 1AA');
    });

    test('rejects non-postcode text', () => {
        const r = new PostcodeValidator().validate('not a postcode');
        assert.equal(r.isValid, false);
    });
});

describe('SortCodeValidator', () => {
    test('getType', () => {
        assert.equal(new SortCodeValidator().getType(), 'sort_code');
    });

    test('valid sort code, already formatted', () => {
        const r = new SortCodeValidator().validate('12-34-56');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '12-34-56');
    });

    test('valid sort code, no separators gets formatted', () => {
        const r = new SortCodeValidator().validate('123456');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '12-34-56');
    });

    test('rejects letters', () => {
        const r = new SortCodeValidator().validate('AB-34-56');
        assert.equal(r.isValid, false);
        assert.match(r.error, /cannot contain letters/);
    });

    test('rejects wrong digit count', () => {
        const r = new SortCodeValidator().validate('12-34');
        assert.equal(r.isValid, false);
    });
});

describe('BankAccountValidator', () => {
    test('getType', () => {
        assert.equal(new BankAccountValidator().getType(), 'bank_account');
    });

    test('valid 8-digit account number', () => {
        const r = new BankAccountValidator().validate('12345678');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, '1234 5678');
    });

    test('valid labeled account number', () => {
        const r = new BankAccountValidator().validate('Account: 12345678');
        assert.equal(r.isValid, true);
        assert.equal(r.value, '12345678');
    });

    test('rejects too short', () => {
        const r = new BankAccountValidator().validate('123456');
        assert.equal(r.isValid, false);
    });

    test('rejects truncated-looking UK mobile number', () => {
        const r = new BankAccountValidator().validate('0770090012');
        assert.equal(r.isValid, false);
        assert.match(r.error, /mobile number/);
    });

    // Regression: letters mixed with digits must be rejected outright,
    // not silently stripped and accepted as if the letters weren't there.
    test('regression: letters mixed with digits are rejected, not silently stripped', () => {
        assert.equal(new BankAccountValidator().validate('1234567A').isValid, false);
        assert.equal(new BankAccountValidator().validate('AB1234567CD').isValid, false);
    });
});

describe('EmailValidator', () => {
    test('getType', () => {
        assert.equal(new EmailValidator().getType(), 'email');
    });

    test('valid email, lowercased by default', () => {
        const r = new EmailValidator().validate('User@Example.COM');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'user@example.com');
    });

    test('fixes common domain typo', () => {
        const r = new EmailValidator().validate('user@gmial.com');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'user@gmail.com');
    });

    test('trims whitespace', () => {
        const r = new EmailValidator().validate('  user@example.com  ');
        assert.equal(r.isValid, true);
        assert.equal(r.fixed, 'user@example.com');
    });

    test('rejects missing @', () => {
        const r = new EmailValidator().validate('user.example.com');
        assert.equal(r.isValid, false);
    });

    test('rejects empty string', () => {
        const r = new EmailValidator().validate('');
        assert.equal(r.isValid, false);
    });
});

describe('NameSplitter', () => {
    test('getType', () => {
        assert.equal(new NameSplitter().getType(), 'name_split');
    });

    test('splits first and last name', () => {
        const r = new NameSplitter().split('John Smith');
        assert.equal(r.first_name, 'John');
        assert.equal(r.last_name, 'Smith');
        assert.equal(r.error, null);
    });

    test('extracts title', () => {
        const r = new NameSplitter().split('Dr John Smith');
        assert.equal(r.title, 'Dr');
        assert.equal(r.first_name, 'John');
        assert.equal(r.last_name, 'Smith');
    });

    test('handles single-word name as last name only', () => {
        const r = new NameSplitter().split('Smith');
        assert.equal(r.first_name, '');
        assert.equal(r.last_name, 'Smith');
    });

    test('isNameColumn recognises common headers', () => {
        assert.equal(new NameSplitter().isNameColumn('full_name'), true);
        assert.equal(new NameSplitter().isNameColumn('phone_number'), false);
    });

    test('looksLikeName rejects postcodes', () => {
        assert.equal(new NameSplitter().looksLikeName('SW1A 1AA'), false);
    });
});

describe('autoValidate', () => {
    test('detects email before phone', () => {
        const r = autoValidate('user@example.com');
        assert.equal(r.detectedType, 'email');
        assert.equal(r.isValid, true);
    });

    test('detects NI number before sort code', () => {
        const r = autoValidate('AB123456C');
        assert.equal(r.detectedType, 'ni_number');
    });

    test('unrecognisable input is invalid', () => {
        const r = autoValidate('###garbage###');
        assert.equal(r.isValid, false);
    });
});
