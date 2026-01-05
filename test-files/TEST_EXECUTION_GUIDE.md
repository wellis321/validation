# Test Execution Guide

This guide provides step-by-step instructions for executing comprehensive tests of Simple Data Cleaner.

## Prerequisites

1. Application running locally (http://localhost:8000)
2. Test files available in `/test-files/` directory
3. Browser with developer console open (F12)

## Test Execution Workflow

### Phase 1: Individual Data Type Tests

#### Test 1.1: Phone Numbers
1. Upload `comprehensive-test-data.csv`
2. Select only "Phone Number" and "Mobile" columns
3. Test International format:
   - Select "International" radio button
   - Click "Clean My Data"
   - Verify: `020 7946 0958` → `+442079460958`
   - Verify: `07700 900123` → `+447700900123`
   - Verify invalid: Row 11 (`++44 7700 900123`) shows in red
   - Verify invalid: Row 12 (`020 7946`) shows in red
4. Test UK format:
   - Select "UK" radio button
   - Click "Clean My Data"
   - Verify: `020 7946 0958` → `020 7946 0958` (formatted with spaces)
   - Verify: `07700 900123` → `07700 900123` (formatted with spaces)

#### Test 1.2: National Insurance Numbers
1. Upload `comprehensive-test-data.csv`
2. Select only "National Insurance" column
3. Click "Clean My Data"
4. Verify valid NI numbers are formatted: `AB123456C` → `AB 123456 C`
5. Verify invalid NI numbers are highlighted in red:
   - Row 17: `BG123456C` (banned prefix)
   - Row 18: `AB12345` (wrong format)
6. Check Issues Report - should show specific error messages

#### Test 1.3: Postcodes
1. Upload `comprehensive-test-data.csv`
2. Select only "Postcode" column
3. Click "Clean My Data"
4. Verify valid postcodes are formatted: `sw1a1aa` → `SW1A 1AA`
5. Verify invalid postcodes are highlighted in red:
   - Row 13: `SW1A1` (too short)
   - Row 14: `SW1A1AA` (missing space)
6. Check Issues Report - should show postcode format errors

#### Test 1.4: Sort Codes
1. Upload `comprehensive-test-data.csv`
2. Select only "Sort Code" column
3. Click "Clean My Data"
4. Verify valid sort codes are formatted: `123456` → `12-34-56`
5. Verify invalid sort codes are highlighted in red:
   - Row 15: `12-34-5` (5 digits)
   - Row 16: `AB-34-56` (contains letters)
6. Check Issues Report - should show sort code errors

#### Test 1.5: Bank Account Numbers
1. Upload `comprehensive-test-data.csv`
2. Select only "Bank Account" column
3. Click "Clean My Data"
4. Verify valid bank accounts are formatted: `12345678` → `1234 5678`
5. Verify invalid bank accounts are highlighted in red (if any in test data)
6. Check Issues Report

#### Test 1.6: Name Splitting
1. Upload `comprehensive-test-data.csv`
2. Select "Name" column and check "Split into title, first_name and last_name"
3. Click "Clean My Data"
4. Verify name splitting:
   - `Mr. John Smith` → `title: "Mr"`, `first_name: "John"`, `last_name: "Smith"`
   - `Alice Brown` → `title: ""`, `first_name: "Alice"`, `last_name: "Brown"`
   - `Robert Taylor III` → `title: ""`, `first_name: "Robert"`, `last_name: "Taylor"` (suffix removed)
5. Check Cleaned Report - should show all name splits
6. Verify original "Name" column is preserved

### Phase 2: Feature Tests

#### Test 2.1: Duplicate Detection
1. Upload `comprehensive-test-data.csv`
2. Select all cleanable fields
3. Click "Clean My Data"
4. Check Full Preview Report
5. Verify:
   - Rows 21-23 are marked as duplicates (yellow background)
   - Rows 1-3 are marked as originals with duplicates (blue background)
6. Export with "Remove Duplicate Rows" checked
7. Verify exported file has fewer rows (duplicates removed)

#### Test 2.2: Whitespace Cleaning
1. Upload `comprehensive-test-data.csv`
2. Select all fields
3. Check "Clean Whitespace in All Cells"
4. Click "Clean My Data"
5. Verify:
   - Row 24: Leading/trailing spaces removed
   - Row 25: Multiple spaces collapsed to single spaces
6. Export and verify whitespace is cleaned

#### Test 2.3: Export Formats
1. Upload `comprehensive-test-data.csv`
2. Select all cleanable fields
3. Click "Clean My Data"
4. Test CSV export:
   - Select "CSV" format
   - Click "Download Cleaned File"
   - Verify file opens in Excel/CSV viewer
   - Verify all columns are present
   - Verify cleaned values are applied
5. Test Excel export:
   - Select "Excel (.xlsx)" format
   - Click "Download Cleaned File"
   - Verify file opens in Excel
   - Verify all columns are present
   - Verify cleaned values are applied
6. Test JSON export:
   - Select "JSON" format
   - Click "Download Cleaned File"
   - Verify file is valid JSON
   - Verify all columns are present
   - Verify cleaned values are applied

#### Test 2.4: Export Options
1. Upload `comprehensive-test-data.csv`
2. Select all cleanable fields
3. Click "Clean My Data"
4. Test "Include Issues Column":
   - Check "Include Issues Column"
   - Export CSV
   - Verify exported file has "Issues" column
   - Verify invalid fields are listed in Issues column
5. Test "Export Only Rows With Issues":
   - Check "Export Only Rows With Issues"
   - Export CSV
   - Verify exported file only contains rows 11-18 (rows with invalid data)
6. Test "Remove Duplicate Rows":
   - Check "Remove Duplicate Rows"
   - Export CSV
   - Verify exported file has fewer rows (duplicates removed)
7. Test "Remove Original Name Columns":
   - Select name column for splitting
   - Check "Remove Original Name Columns"
   - Export CSV
   - Verify exported file does NOT have original "Name" column
   - Verify exported file HAS `title`, `first_name`, `last_name` columns

#### Test 2.5: Auto-Select Feature
1. Upload `comprehensive-test-data.csv`
2. Click "Auto-Select" button
3. Verify:
   - Phone Number, Mobile, National Insurance, Postcode, Sort Code, Bank Account are selected
   - Name column is detected and name split checkbox is checked
   - ID, Email, Address, Notes are NOT selected (not cleanable)
4. Click "Clear All"
5. Verify all selections are cleared
6. Click "Select All"
7. Verify all cleanable fields are selected

#### Test 2.6: Data Profiling
1. Upload `comprehensive-test-data.csv`
2. Select all cleanable fields
3. Click "Clean My Data"
4. Check Summary tab:
   - Verify "Total Rows" count is correct
   - Verify "Valid" count matches valid fields
   - Verify "Cleaned" count matches cleaned fields
   - Verify "Issues" count matches invalid fields
5. Check Missing Values section:
   - Verify missing values count is correct
   - Click "View details" if missing values exist
   - Verify missing values table shows correct columns and counts
   - Verify rows 26-33 show missing values correctly

#### Test 2.7: Reports
1. Upload `comprehensive-test-data.csv`
2. Select all cleanable fields
3. Click "Clean My Data"
4. Test Full Preview Report:
   - Click "Open Full Preview Report"
   - Verify all rows and columns are displayed
   - Verify green cells = cleaned values
   - Verify red cells = invalid values
   - Verify blue rows = originals with duplicates
   - Verify yellow rows = duplicate rows
   - Refresh page - report should persist
5. Test Issues Report:
   - Click "Open Issues Report"
   - Verify only invalid values are shown
   - Verify error messages are specific and helpful
   - Verify explanations are provided
   - Refresh page - report should persist
6. Test Cleaned Report:
   - Click "Open Cleaned Data Report"
   - Verify only cleaned values are shown
   - Verify before/after values are displayed
   - Verify name splits are included
   - Refresh page - report should persist

### Phase 3: Edge Case Tests

#### Test 3.1: Scientific Notation (Excel)
1. Create Excel file with phone number `4.47700900123E+10`
2. Upload Excel file
3. Select phone column
4. Click "Clean My Data"
5. Verify: `4.47700900123E+10` → `+447700900123`

#### Test 3.2: Labels and Prefixes
1. Upload data with values like `Phone: 020 7946 0958`, `NI: AB123456C`, `Postcode: SW1A 1AA`
2. Select appropriate columns
3. Click "Clean My Data"
4. Verify labels are removed and values are cleaned correctly

#### Test 3.3: Mixed Case
1. Upload data with mixed case: `sw1a1aa`, `ab123456c`, `m1 1aa`
2. Select appropriate columns
3. Click "Clean My Data"
4. Verify values are uppercased where appropriate

#### Test 3.4: Various Separators
1. Upload data with various separators: `020-7946-0958`, `AB.123.456.C`, `12.34.56`
2. Select appropriate columns
3. Click "Clean My Data"
4. Verify separators are normalized correctly

#### Test 3.5: Empty File
1. Create empty CSV file (just headers)
2. Upload file
3. Verify appropriate message is shown

#### Test 3.6: Very Large File
1. Create CSV with 1000+ rows
2. Upload file
3. Verify processing completes
4. Verify all rows are processed
5. Verify performance is acceptable

## Test Results Documentation

For each test, document:
- **Test ID**: e.g., "Test 1.1"
- **Test Name**: e.g., "Phone Numbers - International Format"
- **Status**: PASS / FAIL / SKIP
- **Notes**: Any observations or issues
- **Screenshots**: If test fails, include screenshots

## Regression Testing

After any code changes, run the full test suite to ensure:
- No existing functionality is broken
- All data types still clean correctly
- All features still work as expected
- Performance has not degraded

## Automated Testing (Future Enhancement)

Consider implementing:
- Unit tests for each validator (using Jest or similar)
- Integration tests for the full workflow
- End-to-end tests using Playwright or Cypress
- Continuous Integration (CI) pipeline

