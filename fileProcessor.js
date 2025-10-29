// File Processing Library
// Converted from TypeScript to vanilla JavaScript for cPanel hosting

class FileProcessor {
    constructor(phoneFormat = 'international') {
        this.supportedTypes = [
            'text/csv',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'application/json'
        ];
        this.phoneFormat = phoneFormat;
    }

    setPhoneFormat(format) {
        this.phoneFormat = format;
    }

    async processFile(file, selectedColumns = null) {
        // Check MIME type and file extension as fallback
        const isValidType = this.supportedTypes.includes(file.type) ||
            file.name.endsWith('.csv') ||
            file.name.endsWith('.xlsx') ||
            file.name.endsWith('.xls') ||
            file.name.endsWith('.json') ||
            file.name.endsWith('.txt');

        if (!isValidType) {
            throw new Error(`Unsupported file type. Please upload a CSV, Excel (XLSX/XLS), JSON, or text file.`);
        }

        const content = await this.readFileContent(file);
        const rows = this.parseContent(content, file.type);

        return this.processRows(rows, file.name, selectedColumns);
    }

    async readFileContent(file) {
        return new Promise((resolve, reject) => {
            // Check if it's an Excel file (XLSX or XLS)
            const isExcel = file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                file.type === 'application/vnd.ms-excel' ||
                file.name.endsWith('.xlsx') ||
                file.name.endsWith('.xls');

            // Check if it's a JSON file
            const isJson = file.type === 'application/json' || file.name.endsWith('.json');

            if (isExcel && typeof XLSX !== 'undefined') {
                // Handle Excel files with SheetJS
                this.readExcelFile(file, resolve, reject);
            } else if (isJson) {
                // Handle JSON files
                this.readJsonFile(file, resolve, reject);
            } else {
                // Handle CSV and text files
                this.readTextFile(file, resolve, reject);
            }
        });
    }

    readTextFile(file, resolve, reject) {
        const reader = new FileReader();
        reader.onload = (e) => {
            let result = e.target?.result;
            if (typeof result === 'string') {
                // Fix scientific notation that Excel might have added
                result = result.replace(/([\d.]+[Ee][\+\-]?\d+)/gi, (match) => {
                    const num = parseFloat(match);
                    return num.toFixed(0);
                });
                resolve(result);
            } else {
                reject(new Error('Failed to read file content'));
            }
        };
        reader.onerror = () => reject(new Error('Failed to read file'));
        reader.readAsText(file);
    }

    readExcelFile(file, resolve, reject) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Get the first sheet
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Convert to JSON (array of objects)
                const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' });

                // Convert to our row-based format
                resolve({ type: 'excel', data: jsonData });
            } catch (error) {
                reject(new Error('Failed to parse Excel file: ' + error.message));
            }
        };
        reader.onerror = () => reject(new Error('Failed to read Excel file'));
        reader.readAsArrayBuffer(file);
    }

    readJsonFile(file, resolve, reject) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const jsonContent = e.target.result;
                const jsonData = JSON.parse(jsonContent);
                resolve({ type: 'json', data: jsonData });
            } catch (error) {
                reject(new Error('Failed to parse JSON file: ' + error.message));
            }
        };
        reader.onerror = () => reject(new Error('Failed to read JSON file'));
        reader.readAsText(file);
    }

    parseContent(content, fileType) {
        let rows;

        // Check if content is an object (from Excel or JSON)
        if (typeof content === 'object' && content !== null) {
            if (content.type === 'excel') {
                // Excel file already converted to row-based format
                rows = content.data;
            } else if (content.type === 'json') {
                // Parse JSON data
                rows = this.parseJSON(content.data);
            } else {
                throw new Error('Unknown content type');
            }
        } else if (fileType === 'text/csv') {
            rows = this.parseCSV(content);
        } else if (fileType === 'text/plain') {
            rows = this.parseTextFile(content);
        } else {
            // Default: treat as CSV
            rows = this.parseCSV(content);
        }

        // Fix any malformed CSV issues (like unquoted NI numbers with commas)
        return this.fixMalformedCSV(rows);
    }

    parseJSON(jsonData) {
        // Check if it's an array of objects or a single object
        if (Array.isArray(jsonData)) {
            if (jsonData.length === 0) {
                throw new Error('JSON file is empty');
            }

            // Check if first item is an object
            if (typeof jsonData[0] === 'object' && jsonData[0] !== null) {
                // Array of objects - convert to row-based format
                const headers = Object.keys(jsonData[0]);
                const rows = [headers];

                jsonData.forEach(obj => {
                    const row = headers.map(key => obj[key] ?? '');
                    rows.push(row);
                });

                return rows;
            } else {
                // Array of arrays - already in correct format
                return jsonData;
            }
        } else if (typeof jsonData === 'object' && jsonData !== null) {
            // Single object - treat keys as headers, values as single row
            const headers = Object.keys(jsonData);
            const row = headers.map(key => jsonData[key] ?? '');
            return [headers, row];
        } else {
            throw new Error('JSON file format not supported. Expected array of objects or array of arrays.');
        }
    }

    parseCSV(content) {
        const lines = content.split('\n').filter(line => line.trim());
        return lines.map(line => {
            // Simple CSV parsing - split by comma, handle quoted values
            const result = [];
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

    fixMalformedCSV(rows) {
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

    isSplitNINumber(parts) {
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

    parseTextFile(content) {
        const lines = content.split('\n').filter(line => line.trim());
        return lines.map(line => {
            // For text files, assume tab or space separated
            const columns = line.split(/\t|\s{2,}/).filter(col => col.trim());
            return columns.length > 0 ? columns : [line.trim()];
        });
    }

    processRows(rows, fileName, selectedColumns = null) {
        if (rows.length === 0) {
            throw new Error('File is empty');
        }

        const headerRow = rows[0];
        const dataRows = rows.slice(1);
        const errors = [];

        // Process all columns, not just phone numbers
        const processedRows = [];

        dataRows.forEach((row, index) => {
            const rowNumber = index + 2; // +2 because we start from row 2 (after header) and want 1-based indexing

            const validationResults = [];

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

    async exportResults(results, format, includeIssuesColumn = false, onlyRowsWithIssues = false) {
        switch (format) {
            case 'csv':
                return this.exportCleanedCSV(results, includeIssuesColumn, onlyRowsWithIssues);
            case 'json':
                return this.exportCleanedJSON(results, includeIssuesColumn, onlyRowsWithIssues);
            case 'excel':
                return await this.exportToExcel(results, includeIssuesColumn, onlyRowsWithIssues);
            case 'cleaned-csv':
                return this.exportCleanedCSV(results, includeIssuesColumn, onlyRowsWithIssues);
            default:
                throw new Error(`Unsupported export format: ${format}`);
        }
    }

    async exportToExcel(results, includeIssuesColumn = false, onlyRowsWithIssues = false) {
        // Check if SheetJS is available
        if (typeof XLSX === 'undefined') {
            // Fallback to CSV if SheetJS not loaded
            const csvContent = this.createExcelFriendlyCSV(results);
            return new Blob([csvContent], { type: 'text/csv; charset=utf-8' });
        }

        // Create headers with optional "Issues" column
        const cleanedHeaders = [...results.originalHeaders];
        if (includeIssuesColumn) {
            cleanedHeaders.push('Issues');
        }

        // Build worksheet data
        const worksheetData = [cleanedHeaders];

        // Process each original data row
        for (let i = 1; i < results.originalData.length; i++) {
            const originalRow = results.originalData[i];
            const processedRow = results.processedRows.find(p => p.rowNumber === i + 1);
            const issuesList = [];

            if (processedRow) {
                const cleanedRow = [...originalRow];

                processedRow.validationResults.forEach(result => {
                    const columnIndex = results.originalHeaders.indexOf(result.column);
                    if (columnIndex !== -1) {
                        if (result.fixed && result.isValid) {
                            cleanedRow[columnIndex] = result.fixed;
                        } else if (!result.isValid) {
                            issuesList.push(result.column);
                        }
                    }
                });

                if (!onlyRowsWithIssues || issuesList.length > 0) {
                    if (includeIssuesColumn) {
                        cleanedRow.push(issuesList.join(', '));
                    }
                    worksheetData.push(cleanedRow);
                }
            } else {
                if (!onlyRowsWithIssues) {
                    if (includeIssuesColumn) {
                        originalRow.push('');
                    }
                    worksheetData.push(originalRow);
                }
            }
        }

        // Create workbook and worksheet
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(worksheetData);

        // Set column widths
        const colWidths = cleanedHeaders.map((header, index) => {
            const maxLength = Math.max(
                header.length,
                ...worksheetData.slice(1).map(row => (row[index] || '').toString().length)
            );
            return { wch: Math.min(maxLength + 2, 50) };
        });
        ws['!cols'] = colWidths;

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Cleaned Data');

        // Generate Excel file
        const excelBuffer = XLSX.write(wb, { type: 'array', bookType: 'xlsx' });
        return new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    }

    createExcelFriendlyCSV(results) {
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

    exportCleanedCSV(results, includeIssuesColumn = false, onlyRowsWithIssues = false) {
        console.log('exportCleanedCSV - Starting export with results:', results);

        // Create headers with optional "Issues" column
        const cleanedHeaders = [...results.originalHeaders];
        if (includeIssuesColumn) {
            cleanedHeaders.push('Issues');
        }

        // Create cleaned version of original file with validated data
        const cleanedRows = [cleanedHeaders]; // Start with headers

        // Process each original data row
        for (let i = 1; i < results.originalData.length; i++) {
            const originalRow = results.originalData[i];
            const processedRow = results.processedRows.find(p => p.rowNumber === i + 1);

            if (processedRow) {
                // Create a copy of the original row
                const cleanedRow = [...originalRow];
                const issuesList = [];

                // Apply all validation results to the row and collect issues
                processedRow.validationResults.forEach(result => {
                    // Find the column index for this validation result
                    const columnIndex = results.originalHeaders.indexOf(result.column);
                    if (columnIndex !== -1) {
                        // Only replace if valid and has fixed value
                        if (result.fixed && result.isValid) {
                            console.log(`Exporting column "${result.column}": original="${originalRow[columnIndex]}" -> fixed="${result.fixed}"`);
                            // Replace the original value with the cleaned version
                            cleanedRow[columnIndex] = result.fixed;
                        } else if (!result.isValid) {
                            // Track fields that still have issues
                            issuesList.push(result.column);
                        }
                    }
                });

                // Only include this row if we're not filtering or if it has issues
                if (!onlyRowsWithIssues || issuesList.length > 0) {
                    // Add "Issues" column if requested
                    if (includeIssuesColumn) {
                        cleanedRow.push(issuesList.join(', '));
                    }

                    cleanedRows.push(cleanedRow);
                }
            } else {
                // If no processing result, keep original row
                if (!onlyRowsWithIssues) {
                    // Add empty issues if requested
                    if (includeIssuesColumn) {
                        originalRow.push('');
                    }
                    cleanedRows.push(originalRow);
                }
            }
        }

        console.log('exportCleanedCSV - Final cleaned rows:', cleanedRows);

        // Convert to CSV format
        const csvContent = cleanedRows.map(row =>
            row.map((cell, index) => {
                const columnName = cleanedHeaders[index];

                // Always quote phone number columns to prevent formatting issues
                if (columnName && this.isPhoneColumn(columnName)) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }

                // Always quote account number columns to prevent formatting issues
                if (columnName && this.isAccountColumn(columnName)) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }

                // Always quote Issues column (often contains commas)
                if (columnName === 'Issues') {
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

    exportToCSV(results) {
        const headers = ['Row', 'Column', 'Original Value', 'Is Valid', 'Detected Type', 'Fixed Value', 'Error', 'Compliance Standard'];
        const csvContent = [
            headers.join(','),
            ...results.processedRows.flatMap(row =>
                row.validationResults.map(result => [
                    row.rowNumber,
                    `"${result.column}"`,
                    // Always quote phone number and account number values to prevent formatting issues
                    (this.isPhoneColumn(result.column) || this.isAccountColumn(result.column)) ? `"${result.value}"` : result.value,
                    result.isValid ? 'Yes' : 'No',
                    result.detectedType,
                    result.fixed ? ((this.isPhoneColumn(result.column) || this.isAccountColumn(result.column)) ? `"${result.fixed}"` : result.fixed) : '',
                    result.error ? `"${result.error}"` : '',
                    this.getComplianceStandard(result.column, result.detectedType)
                ].join(','))
            )
        ].join('\n');

        return new Blob([csvContent], { type: 'text/csv' });
    }

    getComplianceStandard(columnName, detectedType) {
        const column = columnName.toLowerCase();

        if (column.includes('ni') || column.includes('insurance')) {
            return 'HMRC National Insurance Standards';
        } else if (column.includes('phone') || column.includes('mobile') || column.includes('tel')) {
            return 'UK Phone Number Standards';
        } else if (column.includes('postcode') || column.includes('post_code')) {
            return 'UK Postcode Standards';
        } else if (column.includes('account') && (column.includes('number') || column.includes('acc'))) {
            return 'UK Banking Standards';
        } else if (column.includes('sort') || column.includes('bank')) {
            return 'UK Banking Standards';
        } else {
            return 'Industry Standards';
        }
    }

    exportToJSON(results) {
        const jsonContent = JSON.stringify(results, null, 2);
        return new Blob([jsonContent], { type: 'application/json' });
    }

    exportCleanedJSON(results, includeIssuesColumn = false, onlyRowsWithIssues = false) {
        // Create headers with optional "Issues" column
        const cleanedHeaders = [...results.originalHeaders];
        if (includeIssuesColumn) {
            cleanedHeaders.push('Issues');
        }

        // Build array of objects
        const jsonData = [];

        // Process each original data row
        for (let i = 1; i < results.originalData.length; i++) {
            const originalRow = results.originalData[i];
            const processedRow = results.processedRows.find(p => p.rowNumber === i + 1);
            const rowObject = {};
            const issuesList = [];

            if (processedRow) {
                // Map each column
                results.originalHeaders.forEach((header, index) => {
                    const result = processedRow.validationResults.find(r => r.column === header);
                    if (result && result.fixed && result.isValid) {
                        rowObject[header] = result.fixed;
                    } else {
                        rowObject[header] = originalRow[index] || '';
                    }
                    if (result && !result.isValid) {
                        issuesList.push(header);
                    }
                });
            } else {
                // No processing, use original row
                results.originalHeaders.forEach((header, index) => {
                    rowObject[header] = originalRow[index] || '';
                });
            }

            // Only include this row if we're not filtering or if it has issues
            if (!onlyRowsWithIssues || issuesList.length > 0) {
                if (includeIssuesColumn) {
                    rowObject['Issues'] = issuesList.join(', ');
                }
                jsonData.push(rowObject);
            }
        }

        const jsonContent = JSON.stringify(jsonData, null, 2);
        return new Blob([jsonContent], { type: 'application/json' });
    }

    getSupportedFileTypes() {
        return this.supportedTypes;
    }

    getFileTypeDescription() {
        return 'Supported formats: CSV, Excel (.xlsx), and plain text files';
    }

    updatePhoneFormat(format) {
        this.phoneFormat = format;
    }

    isPhoneColumn(columnName) {
        const phoneColumnNames = [
            'phone', 'phone_number', 'mobile', 'mobile_number',
            'telephone', 'tel', 'cell', 'cellphone', 'contact_number'
        ];
        return phoneColumnNames.some(name =>
            columnName.toLowerCase().includes(name.toLowerCase())
        );
    }

    isAccountColumn(columnName) {
        const accountColumnNames = [
            'account_number', 'account', 'bank_account',
            'acc', 'bank_acc', 'acc_number'
        ];
        return accountColumnNames.some(name =>
            columnName.toLowerCase().includes(name.toLowerCase())
        );
    }
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { FileProcessor };
}
