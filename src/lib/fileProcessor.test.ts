import { describe, it, expect, beforeEach } from 'vitest';
import { FileProcessor } from './fileProcessor';

describe('FileProcessor', () => {
    let fileProcessor: FileProcessor;

    beforeEach(() => {
        fileProcessor = new FileProcessor();
    });

    describe('CSV Parsing', () => {
        it('should parse simple CSV with phone column', () => {
            const csvContent = 'name,phone,email\nJohn,07123456789,john@example.com';
            const result = fileProcessor['parseCSV'](csvContent);

            expect(result).toHaveLength(2);
            expect(result[0]).toEqual(['name', 'phone', 'email']);
            expect(result[1]).toEqual(['John', '07123456789', 'john@example.com']);
        });

        it('should handle quoted values with commas', () => {
            const csvContent = 'name,address,phone\nJohn,"123 Main St, London",07123456789';
            const result = fileProcessor['parseCSV'](csvContent);

            expect(result).toHaveLength(2);
            expect(result[0]).toEqual(['name', 'address', 'phone']);
            expect(result[1]).toEqual(['John', '123 Main St, London', '07123456789']);
        });

        it('should handle multiple quoted values', () => {
            const csvContent = 'firstname,lastname,address,phone_number\nAlice,Smith,"114 2nd St, Houston, UK",+44 7782 250055';
            const result = fileProcessor['parseCSV'](csvContent);

            expect(result).toHaveLength(2);
            expect(result[0]).toEqual(['firstname', 'lastname', 'address', 'phone_number']);
            expect(result[1]).toEqual(['Alice', 'Smith', '114 2nd St, Houston, UK', '+44 7782 250055']);
        });
    });

    describe('Phone Column Detection', () => {
        it('should find phone column by exact name', () => {
            const headers = ['name', 'phone', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should find phone column by phone_number name', () => {
            const headers = ['firstname', 'lastname', 'phone_number', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(2);
        });

        it('should find phone column by mobile name', () => {
            const headers = ['name', 'mobile', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should find phone column by telephone name', () => {
            const headers = ['name', 'telephone', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should find phone column by tel name', () => {
            const headers = ['name', 'tel', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should find phone column by number name', () => {
            const headers = ['name', 'number', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should handle case variations', () => {
            const headers = ['Name', 'PHONE', 'Email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should handle special characters in column names', () => {
            const headers = ['name', 'phone-number', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });

        it('should return -1 when no phone column found', () => {
            const headers = ['name', 'email', 'address'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(-1);
        });

        it('should find phone column when it contains phone keyword', () => {
            const headers = ['name', 'customer_phone', 'email'];
            const result = fileProcessor['findPhoneColumn'](headers);
            expect(result).toBe(1);
        });
    });

    describe('Row Processing', () => {
        it('should process rows with correct phone column', () => {
            const rows = [
                ['name', 'phone', 'email'],
                ['John', '07123456789', 'john@example.com'],
                ['Jane', '07987654321', 'jane@example.com']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');

            expect(result.processedRows).toHaveLength(2);
            expect(result.processedRows[0].rowNumber).toBe(2);
            expect(result.processedRows[0].validationResults[0].column).toBe('phone');
            expect(result.processedRows[0].validationResults[0].value).toBe('07123456789');
        });

        it('should throw error when no phone column found', () => {
            const rows = [
                ['name', 'email', 'address'],
                ['John', 'john@example.com', '123 Main St']
            ];

            expect(() => {
                fileProcessor['processRows'](rows, 'test.csv');
            }).toThrow('No phone number column found');
        });

        it('should handle rows with insufficient columns', () => {
            const rows = [
                ['name', 'phone', 'email'],
                ['John', '07123456789'], // Missing email column but has phone
                ['Jane', '07987654321', 'jane@example.com']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');

            // Both rows should be processed since they both have the phone column
            expect(result.processedRows).toHaveLength(2);

            // John's row (row 2) should be processed
            expect(result.processedRows[0].rowNumber).toBe(2);
            expect(result.processedRows[0].validationResults[0].value).toBe('07123456789');

            // Jane's row (row 3) should also be processed
            expect(result.processedRows[1].rowNumber).toBe(3);
            expect(result.processedRows[1].validationResults[0].value).toBe('07987654321');

            // No errors should be logged since both rows have sufficient columns for phone validation
            expect(result.summary.errors).toHaveLength(0);
        });
    });

    describe('Integration Tests', () => {
        it('should process real CSV content correctly', () => {
            const csvContent = `firstname,lastname,address,phone_number
Alice,Smith,"114 2nd St, Houston, UK",+44 7782 250055
Bob,Johnson,"82 Maple Ave, Dallas, UK",0723 855 4642
Charlie,Williams,"47 Park Ave, New York, UK",(0714) 759 6227`;

            const rows = fileProcessor['parseCSV'](csvContent);
            const result = fileProcessor['processRows'](rows, 'test.csv');

            expect(result.processedRows).toHaveLength(3);
            expect(result.processedRows[0].validationResults[0].column).toBe('phone_number');
            expect(result.processedRows[0].validationResults[0].value).toBe('+44 7782 250055');
        });
    });
});
