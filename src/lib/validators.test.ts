import { describe, it, expect } from 'vitest';
import {
    PhoneNumberValidator,
    NINumberValidator,
    PostcodeValidator,
    SortCodeValidator,
    getValidator,
    autoValidate,
    type ValidationResult
} from './validators';

describe('PhoneNumberValidator', () => {
    const validator = new PhoneNumberValidator('international');

    it('should validate UK mobile numbers', () => {
        const result = validator.validate('07123456789');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447123456789');
    });

    it('should validate UK landline numbers', () => {
        const result = validator.validate('02012345678');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+442012345678');
    });

    it('should validate international format', () => {
        const result = validator.validate('447123456789');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447123456789');
    });

    it('should fix numbers starting with 0', () => {
        const result = validator.validate('07123456789');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447123456789');
    });

    it('should handle formatted numbers', () => {
        const result = validator.validate('07123 456 789');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447123456789');
    });

    it('should reject invalid numbers', () => {
        const result = validator.validate('12345');
        expect(result.isValid).toBe(false);
        expect(result.error).toBe('Invalid UK phone number format');
    });



    it('should handle 0044 prefix', () => {
        const result = validator.validate('0044 7700 903234');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447700903234');
    });

    it('should handle 10-digit mobile numbers', () => {
        const result = validator.validate('7700901890');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447700901890');
        // No error message because it's already valid
        expect(result.error).toBeUndefined();
    });

    it('should handle +44 (0) format correctly', () => {
        const result = validator.validate('+44 (0)7700 902678');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447700902678');
        expect(result.error).toBeUndefined();
    });

    it('should format numbers consistently in international format', () => {
        const result = validator.validate('7700901890');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('+447700901890');
        expect(result.error).toBeUndefined();
    });
});

describe('PhoneNumberValidator UK Format', () => {
    const ukValidator = new PhoneNumberValidator('uk');

    it('should format numbers in UK format (0xxxxxxxxx)', () => {
        const result = ukValidator.validate('7700901890');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('07700901890');
        expect(result.error).toBeUndefined();
    });

    it('should convert international format to UK format', () => {
        const result = ukValidator.validate('+44 7700 902678');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('07700902678');
        expect(result.error).toBeUndefined();
    });
});

describe('NINumberValidator', () => {
    const validator = new NINumberValidator();

    it('should validate correct NI numbers', () => {
        const result = validator.validate('AB123456C');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('AB 123456 C');
    });

    it('should validate NI numbers without suffix', () => {
        const result = validator.validate('AB123456');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('AB 123456');
    });

    it('should handle spaces in input', () => {
        const result = validator.validate('AB 123 456 C');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('AB 123456 C');
    });

    it('should fix numbers with just digits', () => {
        const result = validator.validate('12345678');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('AB 123456 78');
        expect(result.error).toBe('Added prefix letters');
    });

    it('should reject invalid formats', () => {
        const result = validator.validate('ABC123');
        expect(result.isValid).toBe(false);
    });
});

describe('PostcodeValidator', () => {
    const validator = new PostcodeValidator();

    it('should validate standard postcodes', () => {
        const result = validator.validate('SW1A1AA');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('SW1A 1AA');
    });

    it('should validate postcodes with spaces', () => {
        const result = validator.validate('SW1A 1AA');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('SW1A 1AA');
    });

    it('should fix postcodes without spaces', () => {
        const result = validator.validate('M11AA');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('M1 1AA');
        // This postcode is actually valid as-is, so no error message
        expect(result.error).toBeUndefined();
    });

    it('should handle various formats', () => {
        expect(validator.validate('B33 8TH').isValid).toBe(true);
        expect(validator.validate('CR2 6XH').isValid).toBe(true);
        expect(validator.validate('DN55 1PT').isValid).toBe(true);
    });

    it('should reject invalid postcodes', () => {
        const result = validator.validate('INVALID');
        expect(result.isValid).toBe(false);
    });
});

describe('SortCodeValidator', () => {
    const validator = new SortCodeValidator();

    it('should validate correct sort codes', () => {
        const result = validator.validate('123456');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('12-34-56');
    });

    it('should handle formatted sort codes', () => {
        const result = validator.validate('12-34-56');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('12-34-56');
    });

    it('should fix sort codes with extra zeros', () => {
        const result = validator.validate('001234');
        expect(result.isValid).toBe(true);
        expect(result.fixed).toBe('00-12-34');
    });

    it('should reject invalid lengths', () => {
        const result = validator.validate('12345');
        expect(result.isValid).toBe(false);
        expect(result.error).toBe('Sort code must be exactly 6 digits');
    });

    it('should reject non-numeric input', () => {
        const result = validator.validate('12-34-5A');
        expect(result.isValid).toBe(false);
    });
});

describe('getValidator', () => {
    it('should return correct validator for phone numbers', () => {
        const validator = getValidator('phone_number');
        expect(validator).toBeInstanceOf(PhoneNumberValidator);
    });

    it('should return correct validator for NI numbers', () => {
        const validator = getValidator('ni_number');
        expect(validator).toBeInstanceOf(NINumberValidator);
    });

    it('should return correct validator for postcodes', () => {
        const validator = getValidator('postcode');
        expect(validator).toBeInstanceOf(PostcodeValidator);
    });

    it('should return correct validator for sort codes', () => {
        const validator = getValidator('sort_code');
        expect(validator).toBeInstanceOf(SortCodeValidator);
    });

    it('should handle case variations', () => {
        expect(getValidator('PHONE')).toBeInstanceOf(PhoneNumberValidator);
        expect(getValidator('PostCode')).toBeInstanceOf(PostcodeValidator);
    });

    it('should return null for unknown types', () => {
        expect(getValidator('unknown_type')).toBeNull();
    });
});

describe('autoValidate', () => {
    it('should auto-detect and validate phone numbers', () => {
        const result = autoValidate('07123456789');
        expect(result.isValid).toBe(true);
        expect(result.detectedType).toBe('phone_number');
    });

    it('should auto-detect and validate NI numbers', () => {
        const result = autoValidate('AB123456C');
        expect(result.isValid).toBe(true);
        expect(result.detectedType).toBe('ni_number');
    });

    it('should auto-detect and validate postcodes', () => {
        const result = autoValidate('SW1A1AA');
        expect(result.isValid).toBe(true);
        expect(result.detectedType).toBe('postcode');
    });

    it('should auto-detect and validate sort codes', () => {
        const result = autoValidate('123456');
        expect(result.isValid).toBe(true);
        expect(result.detectedType).toBe('sort_code');
    });

    it('should handle unrecognized data', () => {
        const result = autoValidate('unrecognized_data');
        expect(result.isValid).toBe(false);
        expect(result.detectedType).toBe('unknown');
        expect(result.error).toBe('Could not determine data type');
    });
});
