# Comprehensive Test Suite for Simple Data Cleaner

This document outlines comprehensive tests for all data types and features in Simple Data Cleaner.

## Test Data Types

### 1. Phone Numbers
**Validator**: `PhoneNumberValidator`
**Output Formats**: International (+44) and UK (0)

#### Valid Phone Number Formats (Should Clean Successfully)
- `020 7946 0958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `+44 20 7946 0958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `02079460958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `07700 900123` → `+447700900123` (international) or `07700 900123` (UK)
- `07700900123` → `+447700900123` (international) or `07700 900123` (UK)
- `+44 7700 900123` → `+447700900123` (international) or `07700 900123` (UK)
- `+447700900123` → `+447700900123` (international) or `07700 900123` (UK)
- `(020) 7946 0958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `020-7946-0958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `07700.900.123` → `+447700900123` (international) or `07700 900123` (UK)
- `07700-900-123` → `+447700900123` (international) or `07700 900123` (UK)
- `+44 (0) 20 7946 0958` → `+442079460958` (international) or `020 7946 0958` (UK)
- `0044 20 7946 0958` → `+442079460958` (international) or `020 7946 0958` (UK)

#### Invalid Phone Number Formats (Should Detect as Invalid)
- `++44 7700 900123` - Multiple plus signs
- `020 7946` - Incomplete (too short)
- `12345` - Too short, not a phone number
- `ABCD1234` - Contains letters
- `+44 7700 900123 456` - Too many digits
- `020 7946 0958 ext 123` - Extension should be removed but may be invalid if too long

#### Edge Cases
- Scientific notation from Excel: `4.47700900123E+10` → Should convert to `+447700900123`
- Numbers with labels: `Phone: 020 7946 0958` → Should extract `020 7946 0958`
- Numbers with icons/emojis: `📞 020 7946 0958` → Should extract `020 7946 0958`

### 2. National Insurance Numbers
**Validator**: `NINumberValidator`
**Format**: 2 letters + 6 digits + 1 letter (e.g., AB123456C)

#### Valid NI Number Formats (Should Clean Successfully)
- `AB123456C` → `AB 123456 C`
- `AB 123456 C` → `AB 123456 C` (already formatted)
- `AB-123-456-C` → `AB 123456 C`
- `AB.123.456.C` → `AB 123456 C`
- `AB123456C` (lowercase) → `AB 123456 C` (uppercase)
- `NI: AB123456C` → `AB 123456 C` (label removed)

#### Invalid NI Number Formats (Should Detect as Invalid)
- `BG123456C` - Banned prefix (BG, GB, KN, NK, NT, TN, ZZ)
- `AB12345` - Wrong format (only 7 characters, missing last letter)
- `AB1234567C` - Wrong format (7 digits instead of 6)
- `AB12345C` - Wrong format (5 digits instead of 6)
- `IJ567890G` - Invalid first letter 'I'
- `CD234567D` - Invalid second letter 'D'
- `EF345678E` - Invalid second letter 'F'
- `QR901234K` - Invalid first letter 'Q'
- `OO123456A` - Administrative prefix (OO, FY, NC, PZ)
- `PP999999P` - Special administrative reference

#### Edge Cases
- With labels: `NI Number: AB123456C` → Should extract `AB 123456 C`
- With spaces: `AB 123 456 C` → Should normalize to `AB 123456 C`
- With various separators: `AB-123.456/C` → Should normalize to `AB 123456 C`

### 3. Postcodes
**Validator**: `PostcodeValidator`
**Format**: [1-2 letters][1-2 digits][0-1 letter] [1 digit][2 letters]

#### Valid Postcode Formats (Should Clean Successfully)
- `SW1A 1AA` → `SW1A 1AA` (already formatted)
- `sw1a1aa` → `SW1A 1AA` (uppercase and space added)
- `SW1A1AA` → `SW1A 1AA` (space added)
- `M1 1AA` → `M1 1AA` (already formatted)
- `m1 1aa` → `M1 1AA` (uppercase)
- `M11AA` → `M1 1AA` (space added)
- `EC1A 1BB` → `EC1A 1BB` (already formatted)
- `ec1a1bb` → `EC1A 1BB` (uppercase and space added)
- `CR2 6XH` → `CR2 6XH` (already formatted)
- `cr2 6xh` → `CR2 6XH` (uppercase)
- `CR26XH` → `CR2 6XH` (space added)
- `M60 1AA` → `M60 1AA` (already formatted)
- `m60 1aa` → `M60 1AA` (uppercase)
- `W1A 1AA` → `W1A 1AA` (already formatted)
- `w1a1aa` → `W1A 1AA` (uppercase and space added)

#### Invalid Postcode Formats (Should Detect as Invalid)
- `SW1A1` - Too short, missing last part
- `SW1A` - Too short
- `12345` - Numeric only
- `LONDON` - Text only
- `SW1A 1AAA` - Too many letters in last part
- `SW1A 1` - Missing last part
- `SW1A1AA1` - Too many characters
- `SW1A 1A` - Missing last letter

#### Edge Cases
- With address: `10 Downing Street, SW1A 1AA` → Should extract `SW1A 1AA`
- With labels: `Postcode: SW1A 1AA` → Should extract `SW1A 1AA`
- With separators: `SW1A-1AA` → Should normalize to `SW1A 1AA`

### 4. Sort Codes
**Validator**: `SortCodeValidator`
**Format**: 6 digits (typically formatted as XX-XX-XX)

#### Valid Sort Code Formats (Should Clean Successfully)
- `123456` → `12-34-56`
- `12-34-56` → `12-34-56` (already formatted)
- `12 34 56` → `12-34-56`
- `12.34.56` → `12-34-56`
- `123456` (from Excel) → `12-34-56`

#### Invalid Sort Code Formats (Should Detect as Invalid)
- `12-34-5` - Only 5 digits
- `12-34` - Only 4 digits
- `AB-34-56` - Contains letters
- `1234567` - Too many digits (7 instead of 6)
- `12345` - Too few digits (5 instead of 6)

#### Edge Cases
- With labels: `Sort Code: 123456` → Should extract `12-34-56`
- With spaces: `12 34 56` → Should normalize to `12-34-56`
- Scientific notation: `1.23456E+5` → Should convert to `12-34-56`

### 5. Bank Account Numbers
**Validator**: `BankAccountValidator`
**Format**: 7-12 digits (most common is 8 digits)

#### Valid Bank Account Formats (Should Clean Successfully)
- `12345678` → `1234 5678` (8 digits, most common)
- `1234567` → `1234 567` (7 digits)
- `1234567890` → `1234 567890` (10 digits)
- `123456789012` → `1234 5678 9012` (12 digits)
- `1234 5678` → `1234 5678` (already formatted)
- `1234-5678` → `1234 5678` (normalize separator)

#### Invalid Bank Account Formats (Should Detect as Invalid)
- `123456` - Too short (6 digits, need 7-12)
- `12345` - Too short (5 digits)
- `AB123456` - Contains letters
- `1234567890123` - Too long (13 digits, max is 12)

#### Edge Cases
- With labels: `Account Number: 12345678` → Should extract `1234 5678`
- Scientific notation: `1.2345678E+7` → Should convert to `1234 5678`
- With spaces: `1234 5678` → Should format to `1234 5678`

### 6. Name Splitting
**Validator**: `NameSplitter`
**Output**: `title`, `first_name`, `last_name`

#### Valid Name Formats (Should Split Successfully)
- `Mr. John Smith` → `title: "Mr"`, `first_name: "John"`, `last_name: "Smith"`
- `Mrs. Jane Doe` → `title: "Mrs"`, `first_name: "Jane"`, `last_name: "Doe"`
- `Dr. Bob Johnson` → `title: "Dr"`, `first_name: "Bob"`, `last_name: "Johnson"`
- `Miss Emma Davis` → `title: "Miss"`, `first_name: "Emma"`, `last_name: "Davis"`
- `Ms. Grace Taylor` → `title: "Ms"`, `first_name: "Grace"`, `last_name: "Taylor"`
- `Prof. Charlie Wilson` → `title: "Prof"`, `first_name: "Charlie"`, `last_name: "Wilson"`
- `Alice Brown` → `title: ""`, `first_name: "Alice"`, `last_name: "Brown"`
- `David Lee` → `title: ""`, `first_name: "David"`, `last_name: "Lee"`
- `Robert Taylor III` → `title: ""`, `first_name: "Robert"`, `last_name: "Taylor"` (suffix removed)
- `John Smith Jr.` → `title: ""`, `first_name: "John"`, `last_name: "Smith"` (suffix removed)
- `Dr. Sarah Williams PhD` → `title: "Dr"`, `first_name: "Sarah"`, `last_name: "Williams"` (suffix removed)

#### Edge Cases
- Multiple spaces: `Mr.  John   Smith` → Should normalize to `Mr. John Smith`
- Lowercase titles: `mr. john smith` → Should extract `Mr` (uppercase)
- Titles without periods: `Mr John Smith` → Should extract `Mr`
- Complex names: `Mary Jane Watson` → `first_name: "Mary Jane"`, `last_name: "Watson"` (or may split differently)

## Feature Tests

### 1. Duplicate Row Detection
**Test Cases**:
- Two identical rows → Should detect both, mark one as duplicate (yellow), one as original (blue)
- Three identical rows → Should mark first as original (blue), others as duplicates (yellow)
- Rows with only some columns identical → Should NOT be marked as duplicates (exact match required)
- Duplicate rows with different formatting → Should detect if cleaned values are identical

### 2. Whitespace Cleaning
**Test Cases**:
- Leading spaces: `  John Smith` → `John Smith`
- Trailing spaces: `John Smith  ` → `John Smith`
- Multiple spaces: `John    Smith` → `John Smith`
- Tabs: `John\tSmith` → `John Smith`
- Mixed whitespace: `  John   Smith  ` → `John Smith`

### 3. Export Formats
**Test Cases**:
- CSV export → Should export as comma-separated values
- Excel export → Should export as .xlsx file
- JSON export → Should export as JSON array of objects
- All formats should preserve all columns
- All formats should include cleaned values

### 4. Export Options
**Test Cases**:
- "Include Issues Column" → Should add an "Issues" column listing invalid fields
- "Export Only Rows With Issues" → Should only export rows that have validation errors
- "Remove Duplicate Rows" → Should remove duplicate rows from export
- "Remove Original Name Columns" → Should remove original name column if name was split
- "Trim Whitespace" → Should trim all cells in export

### 5. Auto-Select Feature
**Test Cases**:
- Should auto-select columns matching: phone, mobile, tel, number, ni, insurance, postcode, sort, code, bank
- Should auto-detect name columns and suggest name splitting
- Should NOT select protected columns (ID, etc.)

### 6. Data Profiling
**Test Cases**:
- Missing values count → Should count empty, null, N/A values
- Missing values by column → Should show which columns have missing values
- Duplicate row count → Should count exact duplicate rows
- Should exclude malformed rows from missing value calculations

### 7. Reports
**Test Cases**:
- Full Preview Report → Should show all data with color coding
- Issues Report → Should show only invalid values with explanations
- Cleaned Report → Should show only cleaned values with before/after
- All reports should persist on page refresh
- All reports should be printable and downloadable

## Test Execution

### Manual Testing
1. Use the test files in `/test-files/` directory
2. Follow the test scenarios in `README.md`
3. Verify each data type cleans correctly
4. Verify invalid data is detected and highlighted
5. Verify all features work as expected

### Automated Testing (Future)
- Create unit tests for each validator
- Create integration tests for the full workflow
- Create end-to-end tests for the UI

## Expected Results Summary

| Data Type | Valid Input | Expected Output | Invalid Input | Expected Behavior |
|-----------|------------|----------------|---------------|-------------------|
| Phone | `020 7946 0958` | `+442079460958` (intl) or `020 7946 0958` (UK) | `++44 7700 900123` | Mark as invalid (red) |
| NI Number | `AB123456C` | `AB 123456 C` | `BG123456C` | Mark as invalid (red) |
| Postcode | `sw1a1aa` | `SW1A 1AA` | `SW1A1` | Mark as invalid (red) |
| Sort Code | `123456` | `12-34-56` | `12-34-5` | Mark as invalid (red) |
| Bank Account | `12345678` | `1234 5678` | `123456` | Mark as invalid (red) |
| Name | `Mr. John Smith` | `title: "Mr"`, `first_name: "John"`, `last_name: "Smith"` | N/A | Split into columns |

## Test Coverage Checklist

- [x] Phone number validation (valid formats)
- [x] Phone number validation (invalid formats)
- [x] Phone number formatting (international)
- [x] Phone number formatting (UK)
- [x] NI number validation (valid formats)
- [x] NI number validation (invalid formats - banned prefixes, invalid letters)
- [x] NI number formatting
- [x] Postcode validation (valid formats)
- [x] Postcode validation (invalid formats)
- [x] Postcode formatting
- [x] Sort code validation (valid formats)
- [x] Sort code validation (invalid formats)
- [x] Sort code formatting
- [x] Bank account validation (valid formats)
- [x] Bank account validation (invalid formats)
- [x] Bank account formatting
- [x] Name splitting (with titles)
- [x] Name splitting (without titles)
- [x] Name splitting (with suffixes)
- [x] Duplicate row detection
- [x] Whitespace cleaning
- [x] CSV export
- [x] Excel export
- [x] JSON export
- [x] Export options (issues column, only rows with issues, remove duplicates, etc.)
- [x] Auto-select feature
- [x] Data profiling
- [x] Full Preview Report
- [x] Issues Report
- [x] Cleaned Report

