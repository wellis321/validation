import { autoValidate } from './validators';

export interface ProcessedRow {
    rowNumber: number;
    originalData: string;
    validationResults: Array<{
        column: string;
        value: string;
        isValid: boolean;
        detectedType: string;
        fixed?: string;
        error?: string;
    }>;
}

export interface FileProcessingResult {
    fileName: string;
    totalRows: number;
    processedRows: ProcessedRow[];
    originalHeaders: string[]; // Store original column headers
    originalData: string[][]; // Store original data structure
    summary: {
        totalValid: number;
        totalInvalid: number;
        totalFixed: number;
        errors: string[];
    };
}

export class FileProcessor {
    private supportedTypes = ['text/csv', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    private phoneFormat: 'international' | 'uk' = 'international';

    constructor(phoneFormat: 'international' | 'uk' = 'international') {
        this.phoneFormat = phoneFormat;
    }

    setPhoneFormat(format: 'international' | 'uk') {
        this.phoneFormat = format;
    }

    async processFile(file: File, selectedColumns?: string[]): Promise<FileProcessingResult> {
        if (!this.supportedTypes.includes(file.type)) {
            throw new Error(`Unsupported file type: ${file.type}. Please upload a CSV, Excel, or text file.`);
        }

        const content = await this.readFileContent(file);
        const rows = this.parseContent(content, file.type);

        return this.processRows(rows, file.name, selectedColumns);
    }

    private async readFileContent(file: File): Promise<string> {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();

            reader.onload = (e) => {
                const result = e.target?.result;
                if (typeof result === 'string') {
                    resolve(result);
                } else {
                    reject(new Error('Failed to read file content'));
                }
            };

            reader.onerror = () => reject(new Error('Failed to read file'));

            if (file.type === 'text/csv' || file.type === 'text/plain') {
                reader.readAsText(file);
            } else {
                // For Excel files, we'll need to handle differently
                // For now, we'll read as text and let the user know
                reader.readAsText(file);
            }
        });
    }

    private parseContent(content: string, fileType: string): string[][] {
        let rows: string[][];

        if (fileType === 'text/csv') {
            rows = this.parseCSV(content);
        } else if (fileType === 'text/plain') {
            rows = this.parseTextFile(content);
        } else {
            // Excel files - for now, treat as CSV
            rows = this.parseCSV(content);
        }

        // Fix any malformed CSV issues (like unquoted NI numbers with commas)
        return this.fixMalformedCSV(rows);
    }

    private parseCSV(content: string): string[][] {
        const lines = content.split('\n').filter(line => line.trim());
        return lines.map(line => {
            // Simple CSV parsing - split by comma, handle quoted values
            const result: string[] = [];
            let current = '';
            let inQuotes = false;

            for (let i = 0; i < line.length; i++) {
                const char = line[i];

                if (char === '"') {
                    inQuotes = !inQuotes;
                } else if (char === ',' && !inQuotes) {
                    result.push(current.trim());
                    current = '';
                } else {
                    current += char;
                }
            }

            result.push(current.trim());
            return result;
        });
    }

    private fixMalformedCSV(rows: string[][]): string[][] {
        if (rows.length < 2) return rows; // Need at least header + 1 data row

        const headerRow = rows[0];
        const expectedColumns = headerRow.length;

        return rows.map((row, index) => {
            if (index === 0) return row; // Skip header row

            // If this row has more columns than expected, it might be due to unquoted commas in NI numbers
            if (row.length > expectedColumns) {
                // Look for patterns that suggest NI numbers were split
                const fixedRow = [...row];

                // Try to detect and fix split NI numbers (pattern: letter,letter,digit,digit,digit,digit,digit,digit,letter)
                for (let i = 0; i < fixedRow.length - 7; i++) {
                    const potentialNI = [
                        fixedRow[i],     // First letter
                        fixedRow[i + 1], // Second letter
                        fixedRow[i + 2], // First digit
                        fixedRow[i + 3], // Second digit
                        fixedRow[i + 4], // Third digit
                        fixedRow[i + 5], // Fourth digit
                        fixedRow[i + 6], // Fifth digit
                        fixedRow[i + 7]  // Sixth digit
                    ];

                    // Check if this looks like a split NI number
                    if (this.isSplitNINumber(potentialNI)) {
                        // Combine the split parts
                        const combinedNI = potentialNI.join('');

                        // Remove the split parts and insert the combined NI
                        fixedRow.splice(i, 8, combinedNI);

                        // Adjust the loop since we modified the array
                        i = i - 7;
                    }
                }

                // If we still have too many columns, try to merge the last few
                while (fixedRow.length > expectedColumns) {
                    const last = fixedRow.pop();
                    const secondLast = fixedRow.pop();
                    if (last && secondLast) {
                        fixedRow.push(secondLast + last);
                    }
                }

                return fixedRow;
            }

            return row;
        });
    }

    private isSplitNINumber(parts: string[]): boolean {
        if (parts.length !== 8) return false;

        // Check if it matches NI number pattern: 2 letters + 6 digits
        const firstTwo = parts[0] + parts[1];
        const lastSix = parts[2] + parts[3] + parts[4] + parts[5] + parts[6] + parts[7];

        // First two should be letters
        if (!/^[A-Za-z]{2}$/.test(firstTwo)) return false;

        // Last six should be digits
        if (!/^\d{6}$/.test(lastSix)) return false;

        return true;
    }

    private parseTextFile(content: string): string[][] {
        const lines = content.split('\n').filter(line => line.trim());
        return lines.map(line => {
            // For text files, assume tab or space separated
            const columns = line.split(/\t|\s{2,}/).filter(col => col.trim());
            return columns.length > 0 ? columns : [line.trim()];
        });
    }

    private processRows(rows: string[][], fileName: string, selectedColumns?: string[]): FileProcessingResult {
        if (rows.length === 0) {
            throw new Error('File is empty');
        }

        const headerRow = rows[0];
        const dataRows = rows.slice(1);
        const errors: string[] = [];

        // Process all columns, not just phone numbers
        const processedRows: ProcessedRow[] = [];

        dataRows.forEach((row, index) => {
            const rowNumber = index + 2; // +2 because we start from row 2 (after header) and want 1-based indexing

            const validationResults: Array<{
                column: string;
                value: string;
                isValid: boolean;
                detectedType: string;
                fixed?: string;
                error?: string;
            }> = [];

            // Process each column in the row (up to the number of columns the row actually has)
            const columnsToProcess = Math.min(headerRow.length, row.length);

            for (let colIndex = 0; colIndex < columnsToProcess; colIndex++) {
                const columnName = headerRow[colIndex];

                // If selectedColumns is specified, only process those columns
                if (selectedColumns && !selectedColumns.includes(columnName)) {
                    continue;
                }

                const cellValue = row[colIndex] || '';

                // Skip empty cells
                if (!cellValue.trim()) {
                    continue;
                }

                // Try to auto-detect the data type and validate
                const validation = autoValidate(cellValue, this.phoneFormat);

                validationResults.push({
                    column: columnName,
                    value: cellValue,
                    isValid: validation.isValid,
                    detectedType: validation.detectedType,
                    fixed: validation.fixed,
                    error: validation.error
                });
            }

            processedRows.push({
                rowNumber,
                originalData: row.join(', '),
                validationResults
            });
        });

        // Calculate summary from processed rows
        let totalValid = 0;
        let totalInvalid = 0;
        let totalFixed = 0;

        processedRows.forEach(row => {
            row.validationResults.forEach(result => {
                if (result.detectedType === 'header') return; // Skip header

                if (result.isValid) {
                    totalValid++;
                    if (result.fixed && result.fixed !== result.value) {
                        totalFixed++;
                    }
                } else {
                    totalInvalid++;
                }
            });
        });

        return {
            fileName,
            totalRows: rows.length,
            processedRows,
            originalHeaders: headerRow,
            originalData: rows,
            summary: {
                totalValid,
                totalInvalid,
                totalFixed,
                errors
            }
        };
    }

    async exportResults(results: FileProcessingResult, format: 'csv' | 'json' | 'cleaned-csv' | 'excel'): Promise<Blob> {
        switch (format) {
            case 'csv':
                return this.exportToCSV(results);
            case 'json':
                return this.exportToJSON(results);
            case 'cleaned-csv':
                return this.exportCleanedCSV(results);
            case 'excel':
                return this.exportToExcel(results);
            default:
                throw new Error(`Unsupported export format: ${format}`);
        }
    }

    private async exportToExcel(results: FileProcessingResult): Promise<Blob> {
        // For now, we'll use a simple approach with proper CSV formatting
        // that Excel can import correctly
        const csvContent = this.createExcelFriendlyCSV(results);
        return new Blob([csvContent], { type: 'text/csv; charset=utf-8' });
    }

    private createExcelFriendlyCSV(results: FileProcessingResult): string {
        // Create a CSV that Excel will import correctly with proper data types
        const cleanedRows = [results.originalHeaders];

        for (let i = 1; i < results.originalData.length; i++) {
            const originalRow = results.originalData[i];
            const processedRow = results.processedRows.find(p => p.rowNumber === i + 1);

            if (processedRow) {
                const cleanedRow = [...originalRow];

                processedRow.validationResults.forEach(result => {
                    const columnIndex = results.originalHeaders.indexOf(result.column);
                    if (columnIndex !== -1 && result.fixed && result.isValid) {
                        // For phone numbers, force text format by adding a space prefix
                        if (result.fixed.match(/^0\d{10}$/)) {
                            cleanedRow[columnIndex] = ` ${result.fixed}`; // Space prefix forces text
                        } else {
                            cleanedRow[columnIndex] = result.fixed;
                        }
                    }
                });

                cleanedRows.push(cleanedRow);
            } else {
                cleanedRows.push(originalRow);
            }
        }

        return cleanedRows.map(row =>
            row.map(cell => {
                if (cell.includes(',') || cell.includes('"') || cell.includes('\n')) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }
                return cell;
            }).join(',')
        ).join('\n');
    }

    private exportCleanedCSV(results: FileProcessingResult): Blob {
        console.log('exportCleanedCSV - Starting export with results:', results);

        // Create cleaned version of original file with validated data
        const cleanedRows = [results.originalHeaders]; // Start with headers

        // Process each original data row
        for (let i = 1; i < results.originalData.length; i++) {
            const originalRow = results.originalData[i];
            const processedRow = results.processedRows.find(p => p.rowNumber === i + 1);

            if (processedRow) {
                // Create a copy of the original row
                const cleanedRow = [...originalRow];

                // Apply all validation results to the row
                processedRow.validationResults.forEach(result => {
                    // Find the column index for this validation result
                    const columnIndex = results.originalHeaders.indexOf(result.column);
                    if (columnIndex !== -1 && result.fixed && result.isValid) {
                        console.log(`Exporting column "${result.column}": original="${originalRow[columnIndex]}" -> fixed="${result.fixed}"`);
                        // Replace the original value with the cleaned version
                        cleanedRow[columnIndex] = result.fixed;
                    }
                });

                cleanedRows.push(cleanedRow);
            } else {
                // If no processing result, keep original row
                cleanedRows.push(originalRow);
            }
        }

        console.log('exportCleanedCSV - Final cleaned rows:', cleanedRows);

        // Convert to CSV format
        const csvContent = cleanedRows.map(row =>
            row.map((cell, index) => {
                const columnName = results.originalHeaders[index];

                // Always quote phone number columns to prevent formatting issues
                if (columnName && this.isPhoneColumn(columnName)) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }

                // Handle cells that contain commas or quotes
                if (cell.includes(',') || cell.includes('"') || cell.includes('\n')) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }
                return cell;
            }).join(',')
        ).join('\n');

        console.log('exportCleanedCSV - Final CSV content:', csvContent);

        return new Blob([csvContent], { type: 'text/csv' });
    }

    private exportToCSV(results: FileProcessingResult): Blob {
        const headers = ['Row', 'Column', 'Original Value', 'Is Valid', 'Detected Type', 'Fixed Value', 'Error', 'Compliance Standard'];
        const csvContent = [
            headers.join(','),
            ...results.processedRows.flatMap(row =>
                row.validationResults.map(result => [
                    row.rowNumber,
                    `"${result.column}"`,
                    // Always quote phone number values to prevent formatting issues
                    this.isPhoneColumn(result.column) ? `"${result.value}"` : result.value,
                    result.isValid ? 'Yes' : 'No',
                    result.detectedType,
                    result.fixed ? (this.isPhoneColumn(result.column) ? `"${result.fixed}"` : result.fixed) : '',
                    result.error ? `"${result.error}"` : '',
                    this.getComplianceStandard(result.column, result.detectedType)
                ].join(','))
            )
        ].join('\n');

        return new Blob([csvContent], { type: 'text/csv' });
    }

    private getComplianceStandard(columnName: string, detectedType: string): string {
        const column = columnName.toLowerCase();

        if (column.includes('ni') || column.includes('insurance')) {
            return 'HMRC National Insurance Standards';
        } else if (column.includes('phone') || column.includes('mobile') || column.includes('tel')) {
            return 'UK Phone Number Standards';
        } else if (column.includes('postcode') || column.includes('post_code')) {
            return 'UK Postcode Standards';
        } else if (column.includes('sort') || column.includes('bank')) {
            return 'UK Banking Standards';
        } else {
            return 'Industry Standards';
        }
    }

    private exportToJSON(results: FileProcessingResult): Blob {
        const jsonContent = JSON.stringify(results, null, 2);
        return new Blob([jsonContent], { type: 'application/json' });
    }

    getSupportedFileTypes(): string[] {
        return this.supportedTypes;
    }

    getFileTypeDescription(): string {
        return 'Supported formats: CSV, Excel (.xlsx), and plain text files';
    }

    updatePhoneFormat(format: "international" | "uk"): void {
        this.phoneFormat = format;
    }

    private isPhoneColumn(columnName: string): boolean {
        const phoneColumnNames = [
            'phone', 'phone_number', 'mobile', 'mobile_number',
            'telephone', 'tel', 'cell', 'cellphone', 'contact_number'
        ];
        return phoneColumnNames.some(name =>
            columnName.toLowerCase().includes(name.toLowerCase())
        );
    }
}
