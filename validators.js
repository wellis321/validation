// UK Data Validation Library
// Converted from TypeScript to vanilla JavaScript for cPanel hosting

class ValidationResult {
    constructor(isValid, value, error = null, fixed = null) {
        this.isValid = isValid;
        this.value = value;
        this.error = error;
        this.fixed = fixed;
    }
}

// UK Phone Number Validator
class PhoneNumberValidator {
    constructor(outputFormat = 'international') {
        this.outputFormat = outputFormat;
    }

    getType() {
        return 'phone_number';
    }

    setOutputFormat(format) {
        this.outputFormat = format;
    }

    validate(value) {
        // Step 0: Handle scientific notation (e.g., 4.47701E+11 from Excel)
        if (typeof value === 'number') {
            // Convert number to string
            value = value.toString();
        }
        if (/^[\d.]+[Ee]\+?\d+$/.test(value)) {
            // It's in scientific notation, convert it
            const num = parseFloat(value);
            value = num.toFixed(0); // Convert to integer string
        }

        // Step 1: Remove labels, icons, and descriptive text
        let cleaned = this.removeLabelsAndIcons(value);

        // Step 2: Remove extension-style clutter
        cleaned = this.removeExtensions(cleaned);

        // Step 3: Remove quotes and wrapping characters
        cleaned = this.removeWrapping(cleaned);

        // Step 4: Handle the specific case of +44 (0) format first
        if (cleaned.includes('(0)')) {
            cleaned = cleaned.replace(/\(0\)/g, '');
        }

        // Step 5: Remove all non-digit characters (including weird separators)
        cleaned = cleaned.replace(/\D/g, '');

        // Step 6: Handle various prefixes and formats
        cleaned = this.normalizePrefix(cleaned);

        // Step 7: Validate against UK phone number patterns
        const validationResult = this.validatePatterns(cleaned);
        if (validationResult.isValid) {
            const formatted = this.formatPhoneNumber(validationResult.value);
            return new ValidationResult(true, cleaned, null, formatted);
        }

        // Step 8: Try to fix common issues
        const fixResult = this.attemptFixes(cleaned);
        if (fixResult.isValid) {
            const formatted = this.formatPhoneNumber(fixResult.value);
            return new ValidationResult(true, fixResult.value, fixResult.error, formatted);
        }

        // Step 9: Check if it's a case we can't handle yet
        const unhandledCase = this.checkUnhandledCases(value);
        if (unhandledCase) {
            return new ValidationResult(false, value, unhandledCase);
        }

        return new ValidationResult(false, value, 'Invalid UK phone number format');
    }

    removeLabelsAndIcons(value) {
        // Remove common labels and prefixes
        const labels = [
            /^Mobile:\s*/i,
            /^Mob\s*/i,
            /^M\.\s*/i,
            /^m\/\s*/i,
            /^Tel\s*\(mob\):\s*/i,
            /^Cell:\s*/i,
            /^WhatsApp:\s*/i,
            /^UK\s+/i,
            /^GBR\s+/i,
            /^☎️\s*/,
            /^📱\s*/,
            /^\(mobile\)\s*$/i,
            /^\(UK\)\s*$/i,
            /^\(m\)\s*$/i,
            /^\(M\)\s*$/i
        ];

        let cleaned = value;
        for (const label of labels) {
            cleaned = cleaned.replace(label, '');
        }

        return cleaned.trim();
    }

    removeExtensions(value) {
        // Remove extension-style clutter
        const extensions = [
            /\s*x\d+\s*$/i,           // x12
            /\s*ext\s*\d+\s*$/i,      // ext 12
            /\s*\(ext\.\s*\d+\)\s*$/i, // (ext. 12)
            /\s*#\d+\s*$/i,           // #12
            /\s*;ext=\d+\s*$/i,       // ;ext=12
            /\s*,\s*ext\s*\d+\s*$/i,  // , ext 12
        ];

        let cleaned = value;
        for (const ext of extensions) {
            cleaned = cleaned.replace(ext, '');
        }

        return cleaned.trim();
    }

    removeWrapping(value) {
        // Remove quotes and wrapping characters
        const wrappers = [
            /^["'`]/,                 // Leading quotes
            /["'`]$/,                 // Trailing quotes
            /^[«»]/,                  // Leading guillemets
            /[«»]$/,                  // Trailing guillemets
            /^\(["'`]/,               // Leading ("
            /["'`]\)$/,               // Trailing ")
        ];

        let cleaned = value;
        for (const wrapper of wrappers) {
            cleaned = cleaned.replace(wrapper, '');
        }

        return cleaned.trim();
    }

    normalizePrefix(value) {
        // Handle various international prefixes
        if (value.startsWith('0044') && value.length >= 14) {
            const result = value.replace(/^0044/, '44');
            return result;
        }

        if (value.startsWith('44') && value.length >= 12) {
            return value;
        }

        // Handle cases where country code is duplicated or has stray zeros
        if (value.startsWith('440') && value.length >= 13) {
            const result = value.replace(/^440/, '44');
            return result;
        }

        return value;
    }

    validatePatterns(cleaned) {
        // UK phone number patterns
        const patterns = [
            { pattern: /^7\d{9}$/, type: 'Mobile' },           // Mobile: 7xxxxxxxxx
            { pattern: /^1\d{10}$/, type: 'UK Number' },       // UK numbers: 1xxxxxxxxxx
            { pattern: /^44\d{10}$/, type: 'International' },  // International: 44xxxxxxxxxx
            { pattern: /^0\d{10}$/, type: 'UK Landline' },     // UK landline: 0xxxxxxxxx
            { pattern: /^0\d{4}\d{6}$/, type: 'UK Landline' }, // UK landline with area code: 0xxx xxxxxx
        ];

        for (const { pattern, type } of patterns) {
            if (pattern.test(cleaned)) {
                return new ValidationResult(true, cleaned);
            }
        }

        return new ValidationResult(false, cleaned, 'Pattern validation failed');
    }

    attemptFixes(cleaned) {
        // Try to fix common issues

        // Handle numbers that might be valid but need cleaning
        if (cleaned.length === 10 && cleaned.startsWith('7')) {
            // Could be a mobile number without country code
            const fixed = `44${cleaned}`;
            if (/^44\d{10}$/.test(fixed)) {
                return new ValidationResult(true, fixed, 'Added country code');
            }
        }

        // Handle numbers starting with 0 that need country code
        if (cleaned.length === 11 && cleaned.startsWith('0')) {
            const fixed = cleaned.replace(/^0/, '44');
            if (/^44\d{10}$/.test(fixed)) {
                return new ValidationResult(true, fixed, 'Added country code');
            }
        }

        // Handle 9-digit numbers (might be missing a digit)
        if (cleaned.length === 9 && cleaned.startsWith('7')) {
            // Could be missing a digit, try adding one
            const possibleFixes = [
                `44${cleaned}`,      // Add country code
                `0${cleaned}`,       // Add UK prefix
            ];

            for (const fix of possibleFixes) {
                if (this.validatePatterns(fix).isValid) {
                    return new ValidationResult(true, fix, 'Added missing digit/prefix');
                }
            }
        }

        return new ValidationResult(false, cleaned, 'Could not fix number');
    }

    checkUnhandledCases(value) {
        // Check for cases we can't handle yet

        // Look-alike characters (O for 0, I for 1, l for 1)
        if (/[OIl]/.test(value)) {
            return "Contains look-alike characters (O, I, l) that need manual correction";
        }

        // Non-ASCII digits
        if (/[０-９]/.test(value)) {
            return "Contains full-width digits that need manual conversion";
        }

        // Arabic-Indic digits
        if (/[٠-٩]/.test(value)) {
            return "Contains Arabic-Indic digits that need manual conversion";
        }

        // Eastern Arabic-Indic digits
        if (/[۰-۹]/.test(value)) {
            return "Contains Eastern Arabic-Indic digits that need manual conversion";
        }

        // Protocol links
        if (/^(tel:|callto:|https?:\/\/)/.test(value)) {
            return "Contains protocol links that need manual extraction";
        }

        // Random groupings that don't make sense - check before cleaning
        const digitGroups = value.match(/\d+/g);
        if (digitGroups && digitGroups.length > 4) {
            // Check if the total length makes sense for a phone number
            const totalDigits = digitGroups.join('').length;
            if (totalDigits < 10 || totalDigits > 15) {
                return "Contains unusual digit groupings that need manual review";
            }
        }

        // Check for specific problematic patterns
        if (value.includes('+44 0') || value.includes('+44(0')) {
            return "Contains incorrect +44 (0) format that needs manual correction";
        }

        if (value.includes('+44(0')) {
            return "Contains malformed country code that needs manual correction";
        }

        return null;
    }

    formatPhoneNumber(phone) {
        // Ensure all numbers are consistently formatted
        let formatted;

        if (phone.startsWith('44')) {
            // International format starting with 44
            formatted = `+${phone}`;
        } else if (phone.startsWith('0')) {
            // UK format starting with 0
            formatted = `+44${phone.slice(1)}`;
        } else if (phone.startsWith('7') && phone.length === 10) {
            // 10-digit mobile number without prefix - add 0
            formatted = `0${phone}`;
        } else {
            // Fallback - return as is
            formatted = phone;
        }

        // Convert to user's preferred format
        if (this.outputFormat === 'uk') {
            // Convert to UK format with spaces (0xxxx xxxxxx)
            if (formatted.startsWith('+44')) {
                const ukNumber = `0${formatted.slice(3)}`;
                return this.addUKPhoneSpacing(ukNumber);
            } else if (formatted.startsWith('0')) {
                return this.addUKPhoneSpacing(formatted);
            } else if (formatted.startsWith('7') && formatted.length === 10) {
                const ukNumber = `0${formatted}`;
                return this.addUKPhoneSpacing(ukNumber);
            }
        } else {
            // International format (+44xxxxxxxxx)
            if (formatted.startsWith('+44')) {
                return formatted;
            } else if (formatted.startsWith('0')) {
                return `+44${formatted.slice(1)}`;
            } else if (formatted.startsWith('7') && formatted.length === 10) {
                return `+44${formatted}`;
            }
        }

        return formatted;
    }

    addUKPhoneSpacing(phone) {
        // UK mobile numbers: 07734 728 744 (5 digits, space, 3 digits, space, 3 digits)
        if (phone.startsWith('07') && phone.length === 11) {
            return `${phone.slice(0, 5)} ${phone.slice(5, 8)} ${phone.slice(8)}`;
        }

        // UK landline numbers: 020 7946 0958 (3 digits, space, 4 digits, space, 4 digits)
        if (phone.startsWith('01') || phone.startsWith('02') || phone.startsWith('03')) {
            if (phone.length === 11) {
                return `${phone.slice(0, 3)} ${phone.slice(3, 7)} ${phone.slice(7)}`;
            }
        }

        // For other formats, return as is
        return phone;
    }
}

// UK National Insurance Number Validator
class NINumberValidator {
    getType() {
        return 'ni_number';
    }

    validate(value) {
        // Remove common separators but preserve letters and digits
        // Include Unicode separators: bullet points (•), middle dots (·), colons (:), semicolons (;), etc.
        let cleaned = value.replace(/[-._\/•·:;]/g, '').replace(/\s/g, '').toUpperCase();

        // Check for TRN (Temporary Reference Number) format: 11 a1 11 11
        if (/^11[A-Z]\d{1}\d{2}\d{2}$/.test(cleaned)) {
            return new ValidationResult(false, value, 'This is a TRN (Temporary Reference Number), not a valid NI number');
        }

        // NI number format: 2 letters, 6 digits, 1 letter (required)
        const pattern = /^[A-Z]{2}\d{6}[A-Z]$/;

        if (pattern.test(cleaned)) {
            // Check for invalid prefixes according to HMRC standards
            const prefix = cleaned.slice(0, 2);
            const invalidPrefixes = ['BG', 'GB', 'KN', 'NK', 'NT', 'TN', 'ZZ'];
            const invalidFirstLetters = ['D', 'F', 'I', 'Q', 'U', 'V'];
            const invalidSecondLetters = ['D', 'F', 'I', 'O', 'Q', 'U', 'V'];

            if (invalidPrefixes.includes(prefix)) {
                return new ValidationResult(false, value, `Invalid prefix '${prefix}' - banned by HMRC standards`);
            }

            if (invalidFirstLetters.includes(prefix[0])) {
                return new ValidationResult(false, value, `Invalid first letter '${prefix[0]}' - not used in NI number prefixes`);
            }

            if (invalidSecondLetters.includes(prefix[1])) {
                return new ValidationResult(false, value, `Invalid second letter '${prefix[1]}' - not used in NI number prefixes`);
            }

            // Check for administrative prefixes that are not valid NI numbers
            const adminPrefixes = ['OO', 'FY', 'NC', 'PZ'];
            if (adminPrefixes.includes(prefix)) {
                return new ValidationResult(false, value, `'${prefix}' is an administrative prefix, not a valid NI number`);
            }

            // Special case: PP999999P is not valid despite PP being a valid prefix
            if (prefix === 'PP' && cleaned === 'PP999999P') {
                return new ValidationResult(false, value, 'PP999999P is not a valid NI number (administrative reference only)');
            }

            return new ValidationResult(true, cleaned, null, this.formatNINumber(cleaned));
        }

        // Check if it looks like an NI number with separators but wrong format
        // This helps catch cases like "AB-123-456-C" that might be misclassified as sort codes
        const hasLetters = /[A-Z]/i.test(value);
        const hasDigits = /\d/.test(value);
        const hasSeparators = /[-._\/•·:;]/.test(value);

        if (hasLetters && hasDigits && hasSeparators) {
            // Try to extract just the alphanumeric characters
            const extracted = value.replace(/[-._\/•·:;\s]/g, '').toUpperCase();
            if (pattern.test(extracted)) {
                return new ValidationResult(true, extracted, 'Removed separators and formatted', this.formatNINumber(extracted));
            }
        }

        return new ValidationResult(false, value, 'Invalid NI number format (should be 2 letters + 6 digits + 1 letter)');
    }

    formatNINumber(ni) {
        if (ni.length === 9) {
            // Standard format: AB123456C -> AB 123456 C
            return `${ni.slice(0, 2)} ${ni.slice(2, 8)} ${ni.slice(8)}`;
        }
        return `${ni.slice(0, 2)} ${ni.slice(2)}`;
    }
}

// UK Postcode Validator
class PostcodeValidator {
    getType() {
        return 'postcode';
    }

    validate(value) {
        // Replace dashes with spaces and convert to uppercase
        let cleaned = value.replace(/-/g, ' ').replace(/\s+/g, ' ').trim().toUpperCase();

        // UK postcode patterns
        const patterns = [
            /^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/,  // Standard format
            /^[A-Z]{1,2}\d{1,2}\s?\d[A-Z]{2}$/,      // Alternative format
        ];

        for (const pattern of patterns) {
            if (pattern.test(cleaned)) {
                return new ValidationResult(true, cleaned, null, this.formatPostcode(cleaned));
            }
        }

        // Try to fix common issues (no spaces at all)
        const noSpaces = cleaned.replace(/\s/g, '');
        if (/^[A-Z]{1,2}\d{1,2}\d[A-Z]{2}$/.test(noSpaces)) {
            const fixed = this.formatPostcode(noSpaces);
            return new ValidationResult(true, fixed, 'Added proper spacing', fixed);
        }

        // Handle cases like "M11AA" -> "M1 1AA"
        if (/^[A-Z]\d\d[A-Z]{2}$/.test(noSpaces)) {
            const fixed = this.formatPostcode(noSpaces);
            return new ValidationResult(true, fixed, 'Added proper spacing', fixed);
        }

        return new ValidationResult(false, value, 'Invalid UK postcode format');
    }

    formatPostcode(postcode) {
        // Insert space before the last 3 characters
        if (postcode.length >= 5) {
            const formatted = `${postcode.slice(0, -3)} ${postcode.slice(-3)}`;
            // Normalize any multiple spaces to single spaces
            return formatted.replace(/\s+/g, ' ');
        }
        return postcode;
    }
}

// UK Bank Sort Code Validator
class SortCodeValidator {
    getType() {
        return 'sort_code';
    }

    validate(value) {
        // If the value contains letters, it's definitely not a sort code
        if (/[A-Za-z]/.test(value)) {
            return new ValidationResult(false, value, 'Sort codes cannot contain letters');
        }

        // Handle scientific notation
        if (typeof value === 'number') {
            value = value.toString();
        }
        if (/^[\d.]+[Ee]\+?\d+$/.test(value)) {
            const num = parseFloat(value);
            value = num.toFixed(0);
        }

        // Remove all non-digit characters to get just the digits
        const digits = value.replace(/\D/g, '');

        // Sort code must be exactly 6 digits
        if (digits.length === 6) {
            // Validate it's a valid UK sort code format
            if (/^[0-9]{6}$/.test(digits)) {
                return new ValidationResult(true, digits, null, this.formatSortCode(digits));
            }
        }

        // If it's 7 digits, might have an extra leading zero
        if (digits.length === 7 && digits.startsWith('0')) {
            const fixed = digits.slice(1); // Remove leading zero
            if (/^[0-9]{6}$/.test(fixed)) {
                return new ValidationResult(true, fixed, 'Removed leading zero', this.formatSortCode(fixed));
            }
        }

        // If it's 8 digits with leading zeros like 00-00-12-34-56
        if (digits.length >= 8 && digits.startsWith('00')) {
            // Try to extract the last 6 digits
            const fixed = digits.slice(-6);
            if (/^[0-9]{6}$/.test(fixed)) {
                return new ValidationResult(true, fixed, 'Extracted last 6 digits', this.formatSortCode(fixed));
            }
        }

        return new ValidationResult(false, value, `Sort code must be exactly 6 digits (found ${digits.length} digits)`);
    }

    formatSortCode(sortCode) {
        // Sort code should be exactly 6 digits
        if (sortCode.length !== 6) {
            return sortCode; // Don't format if not 6 digits
        }
        // Format as XX-XX-XX
        return `${sortCode.slice(0, 2)}-${sortCode.slice(2, 4)}-${sortCode.slice(4)}`;
    }
}

// Factory function to get appropriate validator
function getValidator(type) {
    switch (type.toLowerCase()) {
        case 'phone_number':
        case 'phone':
        case 'mobile':
            return new PhoneNumberValidator();
        case 'ni_number':
        case 'ni':
        case 'national_insurance':
            return new NINumberValidator();
        case 'postcode':
        case 'post_code':
            return new PostcodeValidator();
        case 'sort_code':
        case 'sortcode':
        case 'bank':
            return new SortCodeValidator();
        default:
            return null;
    }
}

// Auto-detect data type and validate
function autoValidate(value, phoneFormat = 'international') {
    const validators = [
        new PhoneNumberValidator(phoneFormat),
        new NINumberValidator(),        // Check NI numbers before sort codes
        new PostcodeValidator(),
        new SortCodeValidator()         // Sort codes last since they're more generic
    ];

    for (const validator of validators) {
        const result = validator.validate(value);
        if (result.isValid) {
            return { ...result, detectedType: validator.getType() };
        }
    }

    return {
        isValid: false,
        value: value,
        error: 'Could not determine data type',
        detectedType: 'unknown'
    };
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ValidationResult,
        PhoneNumberValidator,
        NINumberValidator,
        PostcodeValidator,
        SortCodeValidator,
        getValidator,
        autoValidate
    };
}
