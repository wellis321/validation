export interface ValidationResult {
    isValid: boolean;
    value: string;
    error?: string;
    fixed?: string;
}

export interface DataValidator {
    validate(value: string): ValidationResult;
    getType(): string;
}

// UK Phone Number Validator
export class PhoneNumberValidator implements DataValidator {
    private outputFormat: 'international' | 'uk' = 'international'; // +44 or 0

    constructor(outputFormat: 'international' | 'uk' = 'international') {
        this.outputFormat = outputFormat;
    }

    getType() {
        return 'phone_number';
    }

    setOutputFormat(format: 'international' | 'uk') {
        this.outputFormat = format;
    }

    validate(value: string): ValidationResult {
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
            return {
                ...validationResult,
                fixed: this.formatPhoneNumber(validationResult.value)
            };
        }

        // Step 8: Try to fix common issues
        const fixResult = this.attemptFixes(cleaned);
        if (fixResult.isValid) {
            return {
                ...fixResult,
                fixed: this.formatPhoneNumber(fixResult.value)
            };
        }

        // Step 9: Check if it's a case we can't handle yet
        const unhandledCase = this.checkUnhandledCases(value);
        if (unhandledCase) {
            return {
                isValid: false,
                value: value,
                error: unhandledCase
            };
        }

        return {
            isValid: false,
            value: value,
            error: 'Invalid UK phone number format'
        };
    }

    private removeLabelsAndIcons(value: string): string {
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

    private removeExtensions(value: string): string {
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

    private removeWrapping(value: string): string {
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

    private normalizePrefix(value: string): string {
        // Handle various international prefixes
        if (value.startsWith('0044') && value.length >= 14) {
            return value.replace(/^0044/, '44');
        }

        if (value.startsWith('44') && value.length >= 12) {
            return value;
        }

        // Handle cases where country code is duplicated or has stray zeros
        if (value.startsWith('440') && value.length >= 13) {
            return value.replace(/^440/, '44');
        }

        return value;
    }

    private validatePatterns(cleaned: string): ValidationResult {
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
                return {
                    isValid: true,
                    value: cleaned,
                    error: undefined
                };
            }
        }

        return {
            isValid: false,
            value: cleaned,
            error: 'Pattern validation failed'
        };
    }

    private attemptFixes(cleaned: string): ValidationResult {
        // Try to fix common issues

        // Handle numbers that might be valid but need cleaning
        if (cleaned.length === 10 && cleaned.startsWith('7')) {
            // Could be a mobile number without country code
            const fixed = `44${cleaned}`;
            if (/^44\d{10}$/.test(fixed)) {
                return {
                    isValid: true,
                    value: fixed,
                    error: 'Added country code'
                };
            }
        }

        // Handle numbers starting with 0 that need country code
        if (cleaned.length === 11 && cleaned.startsWith('0')) {
            const fixed = cleaned.replace(/^0/, '44');
            if (/^44\d{10}$/.test(fixed)) {
                return {
                    isValid: true,
                    value: fixed,
                    error: 'Added country code'
                };
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
                    return {
                        isValid: true,
                        value: fix,
                        error: 'Added missing digit/prefix'
                    };
                }
            }
        }

        return {
            isValid: false,
            value: cleaned,
            error: 'Could not fix number'
        };
    }

    private checkUnhandledCases(value: string): string | null {
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

    private formatPhoneNumber(phone: string): string {
        // Ensure all numbers are consistently formatted
        let formatted: string;

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
            // Convert to UK format (0xxxxxxxxx)
            if (formatted.startsWith('+44')) {
                return `0${formatted.slice(3)}`;
            } else if (formatted.startsWith('0')) {
                return formatted;
            } else if (formatted.startsWith('7') && formatted.length === 10) {
                return `0${formatted}`;
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
}

// UK National Insurance Number Validator
export class NINumberValidator implements DataValidator {
    getType() {
        return 'ni_number';
    }

    validate(value: string): ValidationResult {
        // Remove spaces and convert to uppercase
        const cleaned = value.replace(/\s/g, '').toUpperCase();

        // NI number format: 2 letters, 6-8 digits, 1 letter (optional)
        const pattern = /^[A-Z]{2}\d{6,8}[A-Z]?$/;

        if (pattern.test(cleaned)) {
            return {
                isValid: true,
                value: cleaned,
                fixed: this.formatNINumber(cleaned)
            };
        }

        // Try to fix common issues
        if (/^\d{8,9}$/.test(cleaned)) {
            // If it's just digits, try to add letters
            // For 8 digits: AB + 8 digits = 10 characters (valid)
            // For 9 digits: AB + 9 digits = 11 characters (invalid)
            if (cleaned.length === 8) {
                const fixed = `AB${cleaned}`;
                if (pattern.test(fixed)) {
                    return {
                        isValid: true,
                        value: fixed,
                        fixed: this.formatNINumber(fixed),
                        error: 'Added prefix letters'
                    };
                }
            }
        }

        return {
            isValid: false,
            value: value,
            error: 'Invalid NI number format (should be 2 letters + 6 digits + optional letter)'
        };
    }

    private formatNINumber(ni: string): string {
        if (ni.length === 9) {
            return `${ni.slice(0, 2)} ${ni.slice(2, 8)} ${ni.slice(8)}`;
        } else if (ni.length === 10) {
            // For 10 characters like "AB12345678", format as "AB 123456 78"
            return `${ni.slice(0, 2)} ${ni.slice(2, 8)} ${ni.slice(8)}`;
        }
        return `${ni.slice(0, 2)} ${ni.slice(2)}`;
    }
}

// UK Postcode Validator
export class PostcodeValidator implements DataValidator {
    getType() {
        return 'postcode';
    }

    validate(value: string): ValidationResult {
        // Remove extra spaces and convert to uppercase
        const cleaned = value.replace(/\s+/g, ' ').trim().toUpperCase();

        // UK postcode patterns
        const patterns = [
            /^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/,  // Standard format
            /^[A-Z]{1,2}\d{1,2}\s?\d[A-Z]{2}$/,      // Alternative format
        ];

        for (const pattern of patterns) {
            if (pattern.test(cleaned)) {
                return {
                    isValid: true,
                    value: cleaned,
                    fixed: this.formatPostcode(cleaned)
                };
            }
        }

        // Try to fix common issues
        const noSpaces = cleaned.replace(/\s/g, '');
        if (/^[A-Z]{1,2}\d{1,2}\d[A-Z]{2}$/.test(noSpaces)) {
            const fixed = this.formatPostcode(noSpaces);
            return {
                isValid: true,
                value: fixed,
                fixed: fixed,
                error: 'Added proper spacing'
            };
        }

        // Handle cases like "M11AA" -> "M1 1AA"
        if (/^[A-Z]\d\d[A-Z]{2}$/.test(noSpaces)) {
            const fixed = this.formatPostcode(noSpaces);
            return {
                isValid: true,
                value: fixed,
                fixed: fixed,
                error: 'Added proper spacing'
            };
        }

        return {
            isValid: false,
            value: value,
            error: 'Invalid UK postcode format'
        };
    }

    private formatPostcode(postcode: string): string {
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
export class SortCodeValidator implements DataValidator {
    getType() {
        return 'sort_code';
    }

    validate(value: string): ValidationResult {
        // Remove all non-digit characters
        const cleaned = value.replace(/\D/g, '');

        // Sort code should be exactly 6 digits
        if (/^\d{6}$/.test(cleaned)) {
            return {
                isValid: true,
                value: cleaned,
                fixed: this.formatSortCode(cleaned)
            };
        }

        // Try to fix common issues
        if (cleaned.length === 8 && cleaned.includes('00')) {
            // Sometimes sort codes are written as 00-00-00
            const fixed = cleaned.replace(/00/g, '');
            if (/^\d{6}$/.test(fixed)) {
                return {
                    isValid: true,
                    value: fixed,
                    fixed: this.formatSortCode(fixed),
                    error: 'Removed extra zeros'
                };
            }
        }

        return {
            isValid: false,
            value: value,
            error: 'Sort code must be exactly 6 digits'
        };
    }

    private formatSortCode(sortCode: string): string {
        return `${sortCode.slice(0, 2)}-${sortCode.slice(2, 4)}-${sortCode.slice(4)}`;
    }
}

// Factory function to get appropriate validator
export function getValidator(type: string): DataValidator | null {
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
export function autoValidate(value: string, phoneFormat: 'international' | 'uk' = 'international'): ValidationResult & { detectedType: string } {
    const validators = [
        new PhoneNumberValidator(phoneFormat),
        new NINumberValidator(),
        new PostcodeValidator(),
        new SortCodeValidator()
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
