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
            const csvContent = 'name,phone,address\nJohn,07123456789,"123 Main St, London"';
            const result = fileProcessor['parseCSV'](csvContent);

            expect(result[1][2]).toBe('123 Main St, London');
        });

        it('should handle multiple quoted values', () => {
            const csvContent = 'name,phone,address\n"John, Jr.",07123456789,"123 Main St, London"';
            const result = fileProcessor['parseCSV'](csvContent);

            expect(result[1][0]).toBe('John, Jr.');
            expect(result[1][2]).toBe('123 Main St, London');
        });
    });

    describe('Multi-Column Processing', () => {
        it('should process all columns in a row', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789', 'AB123456C'],
                ['Jane', '07987654321', 'CD789012E']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');

            expect(result.processedRows).toHaveLength(2);
            expect(result.processedRows[0].validationResults).toHaveLength(3); // name, phone, ni_number
            expect(result.processedRows[1].validationResults).toHaveLength(3);
        });

        it('should detect different data types correctly', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789', 'AB123456C']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');
            const validationResults = result.processedRows[0].validationResults;

            // Find the phone validation result
            const phoneResult = validationResults.find(r => r.column === 'phone');
            const niResult = validationResults.find(r => r.column === 'ni_number');

            expect(phoneResult?.detectedType).toBe('phone_number');
            expect(niResult?.detectedType).toBe('ni_number');
        });

        it('should handle rows with insufficient columns', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789'], // Missing ni_number
                ['Jane', '07987654321', 'CD789012E']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');

            // Should process both rows, but John's row will have fewer validation results
            expect(result.processedRows).toHaveLength(2);
            expect(result.processedRows[0].validationResults).toHaveLength(2); // name, phone
            expect(result.processedRows[1].validationResults).toHaveLength(3); // name, phone, ni_number
        });

        it('should skip empty cells', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789', ''], // Empty ni_number
                ['Jane', '', 'CD789012E']    // Empty phone
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');

            expect(result.processedRows).toHaveLength(2);
            expect(result.processedRows[0].validationResults).toHaveLength(2); // name, phone
            expect(result.processedRows[1].validationResults).toHaveLength(2); // name, ni_number
        });
    });

    describe('Integration Tests', () => {
        it('should process real CSV content correctly', () => {
            const csvContent = `firstname,lastname,phone_number,national_insurance
Alice,Smith,+44 7782 250055,AB123456C
Bob,Johnson,0723 855 4642,ab 123 456 c`;

            const rows = fileProcessor['parseCSV'](csvContent);
            const result = fileProcessor['processRows'](rows, 'test.csv');

            expect(result.processedRows).toHaveLength(2);

            // Check first row
            const aliceRow = result.processedRows[0];
            expect(aliceRow.validationResults).toHaveLength(4); // firstname, lastname, phone_number, national_insurance

            const phoneResult = aliceRow.validationResults.find(r => r.column === 'phone_number');
            const niResult = aliceRow.validationResults.find(r => r.column === 'national_insurance');

            expect(phoneResult?.detectedType).toBe('phone_number');
            expect(niResult?.detectedType).toBe('ni_number');
            expect(phoneResult?.value).toBe('+44 7782 250055');
            expect(niResult?.value).toBe('AB123456C');
        });
    });

    describe('Export Functions', () => {
        it('should export cleaned CSV with all columns', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789', 'AB123456C']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');
            const cleanedCsv = fileProcessor['exportCleanedCSV'](result);

            // Should contain both original and cleaned data
            expect(cleanedCsv).toBeInstanceOf(Blob);
        });

        it('should export validation report with all columns', () => {
            const rows = [
                ['name', 'phone', 'ni_number'],
                ['John', '07123456789', 'AB123456C']
            ];

            const result = fileProcessor['processRows'](rows, 'test.csv');
            const validationCsv = fileProcessor['exportToCSV'](result);

            // Should contain validation results for all columns
            expect(validationCsv).toBeInstanceOf(Blob);
        });
    });
});
