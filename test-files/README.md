# Test Files for Simple Data Cleaner

This folder contains test files for validating the Simple Data Cleaner workflow.

## Files Included

### 1. `sample-data.csv`
- **Purpose**: Basic CSV file with UK data
- **Contains**: 
  - Phone numbers (various formats: with/without spaces, international format)
  - Mobile numbers (different separators)
  - National Insurance numbers
  - Postcodes
  - Sort codes
  - Bank account numbers
  - Some invalid data for error testing
  - Missing data fields
  - Duplicate rows

### 2. `sample-data.json`
- **Purpose**: JSON format test file
- **Contains**: Same data as CSV but in JSON array format
- **Use case**: Test JSON file upload and processing

### 3. `sample-data-large.csv`
- **Purpose**: Larger dataset with more rows and additional columns
- **Contains**: 20 rows with ID, Name, Email, and all UK data fields
- **Use case**: Test performance with larger files and verify all columns are preserved

## Test Scenarios

### Scenario 1: Basic CSV Workflow
1. Upload `sample-data.csv`
2. Verify field selection shows all cleanable columns
3. Select "Phone Number", "Mobile", "National Insurance", "Postcode", "Sort Code"
4. Process and verify results
5. Download cleaned file

### Scenario 2: Excel File Workflow
**Important**: To test Excel file handling (which tests Hypothesis B - Excel file header reading):
1. Open `sample-data.csv` in Microsoft Excel, LibreOffice Calc, or Google Sheets
2. Save as `.xlsx` format (Excel Workbook)
3. Upload the `.xlsx` file to the application
4. **Critical Test**: Verify field selection shows the correct column headers (this is where Excel files may fail if `readFileAsText` is used instead of proper Excel parsing)
5. Process and download

**Note**: If you don't have Excel, you can still test with CSV files - the main difference is that Excel files use binary format and require SheetJS library parsing, while CSV files are plain text.

### Scenario 3: JSON File Workflow
1. Upload `sample-data.json`
2. Verify field selection
3. Process and verify JSON structure is maintained
4. Download in different formats (CSV, Excel, JSON)

### Scenario 4: Large File Workflow
1. Upload `sample-data-large.csv`
2. Test with all fields selected
3. Verify performance and data integrity
4. Test duplicate removal
5. Test export with issues column

### Scenario 5: Error Handling
- The files contain invalid data (invalid phone numbers, postcodes)
- Missing data fields
- Duplicate rows
- Verify these are properly identified in the Issues tab

## Expected Results

- **Valid data**: Should be cleaned and formatted correctly
- **Invalid data**: Should appear in Issues tab with error messages
- **Missing data**: Should be handled gracefully
- **Duplicates**: Should be identified and removable via checkbox
- **All columns**: Should be preserved in output regardless of cleaning

## Notes

- All phone numbers are UK format
- All NI numbers follow HMRC standards
- Postcodes are valid UK postcodes
- Sort codes are 6-digit UK bank sort codes
- Some test data intentionally contains errors to test validation

