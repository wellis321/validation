# CSV Export Output Improvements

## Overview
Enhanced the CSV export functionality to produce more user-friendly, Excel-compatible output files that display cleanly when opened in spreadsheet software.

## Key Improvements

### 1. **Normalized Empty Values**
- Converts `null`, `undefined`, `'nan'`, `'NaN'`, `'NULL'`, `'N/A'` to empty strings
- Ensures consistent empty cell representation
- Prevents confusion from various empty value representations

### 2. **Smart Quoting Strategy**
Automatically quotes cells that need protection:

**Always Quoted:**
- Phone numbers (prevents Excel from converting to scientific notation)
- NI numbers (preserves format)
- Account numbers (prevents Excel from converting to numbers)
- Sort codes (prevents Excel date conversion)
- Postcodes (preserves format)
- Issues column (contains multiple values)

**Conditionally Quoted:**
- Cells starting with `=`, `@`, `+`, `-` (prevents formula injection)
- Numbers starting with `0` (preserves leading zeros)
- Cells containing commas, quotes, or newlines

### 3. **Better Excel Compatibility**
- UTF-8 encoding specified in blob type
- Proper quote escaping (doubling quotes)
- Handles special characters correctly
- Prevents unwanted Excel auto-formatting

### 4. **Cleaner Data Presentation**
- Consistent value formatting
- No unexpected type conversions
- All cleaned values properly applied
- Empty cells are truly empty (not "null" or "nan")

## Example Output

### Before (Less Friendly)
```csv
Firstname,Lastname,Phone_Number
Alice,Smith,4.47701E+11
Bob,Johnson,7238554642
Charlie,Williams,07147596227
```

### After (More Friendly)
```csv
Firstname,Lastname,Phone_Number
Alice,Smith,"+44 7778 901234"
Bob,Johnson,"0723 855 4642"
Charlie,Williams,"0714 759 6227"
```

## Benefits

1. **Excel-Friendly**
   - Phone numbers stay as text (no scientific notation)
   - Leading zeros preserved
   - No unwanted date conversions
   - Formulas don't accidentally execute

2. **Cleaner Appearance**
   - Consistent formatting
   - Proper spacing in cleaned values
   - No confusing "null" or "nan" values
   - Professional appearance

3. **Better Data Integrity**
   - Preserves exact cleaned values
   - Prevents Excel auto-formatting issues
   - Maintains data type consistency

4. **User-Friendly**
   - Easy to read and verify
   - Clear column separation
   - Properly formatted values
   - Professional output

## Technical Details

### Normalization Function
```javascript
normalizeCellValue(value) {
    // Converts various empty representations to empty string
    // Handles: null, undefined, 'null', 'nan', 'NaN', 'NULL', 'N/A'
    // Returns clean empty string or trimmed value
}
```

### Formatting Function
```javascript
formatCSVCell(cell, columnName, isHeader) {
    // Determines if cell should be quoted
    // Escapes quotes properly
    // Handles special characters
    // Protects sensitive columns
}
```

### Quoting Logic
- Sensitive columns always quoted (phone, NI, account, sort code, etc.)
- Cells starting with formula characters quoted
- Leading zero numbers quoted
- Cells with special characters quoted

## Usage

The improved CSV export is automatically used when users download cleaned data. No changes needed in the UI - the output file quality is simply better.

## Future Enhancements (Optional)

1. **BOM (Byte Order Mark)** - Add UTF-8 BOM for better Excel compatibility
2. **Column Width Hints** - Include metadata for optimal column widths
3. **Format Preserving** - Better handling of number formats
4. **Conditional Formatting Hints** - Mark clean vs. issue rows
