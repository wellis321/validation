# Test File: Validation Issues

This test file (`test-validation-issues.csv`) contains various validation issues to test the detailed issues report feature.

## File Structure

The file contains 25 rows with the following columns:
- ID
- Name
- Email
- Phone Number
- Mobile
- National Insurance
- Postcode
- Sort Code
- Bank Account
- Address

## Issues Included

### Valid Data (Rows 1-10)
These rows contain **valid** data for all fields to ensure the system correctly identifies valid vs invalid data.

### Invalid Phone Numbers (Rows 11-13)
- **Row 11:** `++44 7700 900123` - Multiple plus signs
- **Row 12:** `020 7946` - Too short (incomplete number)
- **Row 13:** Valid phone (this row is actually valid - included for comparison)

### Invalid Postcodes (Rows 14-16)
- **Row 14:** `INVALID1` - Invalid format (numbers in wrong place)
- **Row 15:** `SW1A1AA` - Missing space (should be SW1A 1AA)
- **Row 16:** `SW1` - Too short (incomplete postcode)

### Invalid Sort Codes (Rows 17-19)
- **Row 17:** `12-34-5` - Only 5 digits (need 6)
- **Row 18:** `12-34-567` - 7 digits (need exactly 6)
- **Row 19:** `AB-34-56` - Contains letters (sort codes must be numeric)

### Invalid Bank Account Numbers (Rows 20-22)
- **Row 20:** `123456` - Only 6 digits (need 7-12)
- **Row 21:** `1234567890123` - 13 digits (exceeds 12 digit limit)
- **Row 22:** `ABC12345` - Contains letters (account numbers must be numeric)

### Invalid NI Numbers (Rows 23-25)
- **Row 23:** `BG123456C` - Banned prefix (BG is banned by HMRC)
- **Row 24:** `AB12345` - Wrong format (only 5 digits, need 6)
- **Row 25:** `OO123456C` - Administrative prefix (OO is not a valid NI number)

## Expected Results

When you process this file and view the detailed issues report, you should see:

1. **Detailed explanations** for each invalid value
2. **Specific problem identification** (e.g., "Second letter 'D' is not allowed")
3. **Clear explanations** of why each value is invalid
4. **Actionable guidance** on what to do to fix each issue

## Testing Steps

1. Upload `test-validation-issues.csv` to the application
2. Select all cleanable fields (Phone Number, Mobile, National Insurance, Postcode, Sort Code, Bank Account)
3. Click "Clean My Data"
4. Go to the "Issues" tab
5. Click "View Detailed Issues Report"
6. Review the detailed explanations for each issue type

## What to Look For

✅ **Phone Numbers:** Should explain multiple plus signs, wrong length, etc.
✅ **Postcodes:** Should explain missing spaces, wrong format, etc.
✅ **Sort Codes:** Should explain wrong digit count, letters present, etc.
✅ **Bank Accounts:** Should explain wrong digit count, letters present, etc.
✅ **NI Numbers:** Should explain banned prefixes, wrong format, administrative prefixes, etc.

Each explanation should be in a clear table format showing:
- The invalid value
- The specific problem
- Why it's invalid
- What to do to fix it

