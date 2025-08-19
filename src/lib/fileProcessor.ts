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

    async processFile(file: File): Promise<FileProcessingResult> {
        if (!this.supportedTypes.includes(file.type)) {
            throw new Error(`Unsupported file type: ${file.type}. Please upload a CSV, Excel, or text file.`);
        }

        const content = await this.readFileContent(file);
        const rows = this.parseContent(content, file.type);

        return this.processRows(rows, file.name);
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
        if (fileType === 'text/csv') {
            return this.parseCSV(content);
        } else if (fileType === 'text/plain') {
            return this.parseTextFile(content);
        } else {
            // Excel files - for now, treat as CSV
            return this.parseCSV(content);
        }
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

    private parseTextFile(content: string): string[][] {
        const lines = content.split('\n').filter(line => line.trim());
        return lines.map(line => {
            // For text files, assume tab or space separated
            const columns = line.split(/\t|\s{2,}/).filter(col => col.trim());
            return columns.length > 0 ? columns : [line.trim()];
        });
    }

    private processRows(rows: string[][], fileName: string): FileProcessingResult {
        const processedRows: ProcessedRow[] = [];
        const errors: string[] = [];

        // Process rows synchronously for now
        rows.forEach((row, index) => {
            const rowNumber = index + 1;

            // Skip header row
            if (index === 0) {
                const headerResults = row.map((value, colIndex) => ({
                    column: `Column ${colIndex + 1}`,
                    value,
                    isValid: false,
                    detectedType: 'header',
                    fixed: undefined,
                    error: 'Header row - not validated'
                }));

                processedRows.push({
                    rowNumber,
                    originalData: row.join(', '),
                    validationResults: headerResults
                });
                return;
            }

            // For data rows, only validate the phone number column (Column 2)
            // Column 1 is the ID, which we don't validate
            const phoneValidation = autoValidate(row[1], this.phoneFormat);
            const validationResults = [
                {
                    column: 'Phone Number',
                    value: row[1],
                    isValid: phoneValidation.isValid,
                    detectedType: phoneValidation.detectedType,
                    fixed: phoneValidation.fixed,
                    error: phoneValidation.error
                }
            ];

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
            summary: {
                totalValid,
                totalInvalid,
                totalFixed,
                errors
            }
        };
    }



    async exportResults(results: FileProcessingResult, format: 'csv' | 'json' = 'csv'): Promise<Blob> {
        if (format === 'csv') {
            return this.exportToCSV(results);
        } else {
            return this.exportToJSON(results);
        }
    }

    private exportToCSV(results: FileProcessingResult): Blob {
        const headers = ['Row', 'Phone Number', 'Is Valid', 'Detected Type', 'Fixed Value', 'Error'];
        const csvContent = [
            headers.join(','),
            ...results.processedRows.map(row => {
                // Skip header row
                if (row.validationResults[0]?.detectedType === 'header') {
                    return '';
                }

                // For data rows, we only have one validation result (the phone number)
                const result = row.validationResults[0];
                return [
                    row.rowNumber,
                    `"${result.value}"`,
                    result.isValid ? 'Yes' : 'No',
                    result.detectedType,
                    result.fixed ? `"${result.fixed}"` : '',
                    result.error ? `"${result.error}"` : ''
                ].join(',');
            }).filter(row => row !== '') // Remove empty header rows
        ].join('\n');

        return new Blob([csvContent], { type: 'text/csv' });
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
}
