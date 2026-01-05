# New Features - Testing Guide

## Overview of New Features

The following features have been added to Simple Data Cleaner, inspired by Magic CSV and similar tools:

### 1. **Name Splitting Functionality** ✨
- Automatically detects columns containing full names
- Splits full names into `first_name` and `last_name` columns
- Handles titles (Mr, Mrs, Dr), suffixes (Jr, Sr), and edge cases

### 2. **Enhanced Field Selection UI** 🎨
- Auto-detects name columns using pattern matching and heuristics
- Shows name columns with special "Split" checkbox option
- Displays transformation type icons (phone, postcode, name split, etc.)
- Visual indicators for different field types

### 3. **Side-by-Side Before/After Comparison** 📊
- New "Before/After" tab in results section
- Shows original values on left, cleaned values on right
- Highlights changed cells in green
- Highlights name split columns appropriately

### 4. **Interactive Preview Sample** 👀
- Preview section appears before processing
- Shows plain English descriptions of transformations
- Displays sample data (first 5 rows) with selected fields highlighted
- Updates dynamically as selections change

### 5. **Plain English Descriptions** 📝
- Transformation summaries in plain English
- Examples:
  - "Split full_name into first_name and last_name"
  - "Format phone numbers as +44 7700 900123"
  - "Validate and format postcodes"

---

## How to Test the New Features

### Prerequisites
1. Start the local development server:
   ```bash
   ./start-local.sh
   ```
   Or manually:
   ```bash
   php -S localhost:8000 router.php
   ```

2. Open your browser to: `http://localhost:8000`

---

## Test Scenario 1: Name Splitting Feature

### Step 1: Create Test File with Names
Create a CSV file with a name column (or use the example below):

```csv
full_name,phone,email
John Smith,07700900123,john@example.com
Mrs. Jane Doe,07700900124,jane@example.com
Dr. Michael Johnson Jr.,07700900125,michael@example.com
Sarah Williams,07700900126,sarah@example.com
```

Save this as `test-names.csv` in the `test-files/` directory.

### Step 2: Upload and Test
1. **Upload the file** - Drag and drop or click to select `test-names.csv`
2. **Verify auto-detection**:
   - The `full_name` column should appear with a pink icon
   - It should show "Full Name (can split)" as the type
   - A checkbox should appear: "Split into first_name and last_name"

3. **Select name splitting**:
   - Check the "Split into first_name and last_name" checkbox
   - The preview section should update showing: "Split full_name into first_name and last_name"

4. **Process the file**:
   - Click "Clean My Data"
   - Wait for processing to complete

5. **Verify results**:
   - Go to the "Full Preview" tab
   - You should see new columns: `first_name` and `last_name`
   - Original `full_name` column should still be present
   - Check that names are split correctly:
     - "John Smith" → first_name: "John", last_name: "Smith"
     - "Mrs. Jane Doe" → first_name: "Jane", last_name: "Doe" (title removed)
     - "Dr. Michael Johnson Jr." → first_name: "Michael", last_name: "Johnson" (title and suffix removed)

6. **Check Before/After tab**:
   - Click the "Before/After" tab
   - Verify original `full_name` values on the left
   - Verify split `first_name` and `last_name` values on the right (highlighted in green)

7. **Export and verify**:
   - Download the cleaned file
   - Open in Excel/CSV viewer
   - Verify the new columns are present and correctly split

---

## Test Scenario 2: Preview Sample Feature

### Steps:
1. **Upload any CSV file** (e.g., `test-files/sample-data.csv`)
2. **Select fields to clean**:
   - Select phone number fields
   - Select name fields (if any) and check split option
   - Select other cleanable fields

3. **Check preview section** (appears above "Clean My Data" button):
   - Should show plain English descriptions:
     - "Split full_name into first_name and last_name"
     - "Format phone numbers as +44 7700 900123 in X column(s)"
     - "Validate and format postcodes"
   
4. **Check sample data table**:
   - Should show first 5 rows of data
   - Selected fields should be highlighted in blue
   - All columns should be visible

5. **Change selections**:
   - Uncheck some fields
   - Preview should update immediately
   - Descriptions should change accordingly

---

## Test Scenario 3: Before/After Comparison View

### Steps:
1. **Process a file** with various field types:
   - Upload `test-files/sample-data.csv`
   - Select phone numbers, postcodes, NI numbers, etc.
   - Process the file

2. **Navigate to Before/After tab**:
   - Click the "Before/After" tab in results section
   - Should see side-by-side comparison

3. **Verify display**:
   - Left column shows original values (red background if changed)
   - Right column shows cleaned values (green background if changed)
   - Name split columns should be highlighted in green
   - Changed validation fields should show checkmark (✓)

4. **Test scrolling**:
   - Scroll through multiple rows
   - Headers should remain sticky
   - Row numbers should remain visible

---

## Test Scenario 4: Enhanced Field Selection UI

### Steps:
1. **Upload a file with mixed field types**:
   - Create or use a file with: names, phones, postcodes, NI numbers

2. **Verify field detection**:
   - Name columns should show pink icon with "Full Name (can split)"
   - Phone columns should show blue icon with "Phone Number"
   - Postcode columns should show green icon with "Postcode"
   - NI columns should show purple icon with "NI Number"
   - Sort code columns should show yellow icon with "Sort Code"

3. **Test name column detection**:
   - Try columns named: `full_name`, `name`, `customer_name`, `contact_name`
   - All should be detected as name columns
   - Should show split option

4. **Test auto-select**:
   - Click "Auto-Select" button
   - Should select all cleanable fields
   - Name columns should be included but not auto-checked for splitting

---

## Test Scenario 5: Plain English Descriptions

### Steps:
1. **Select various field types**:
   - Name fields with split enabled
   - Phone number fields
   - Postcode fields
   - NI number fields
   - Sort code fields

2. **Check field selection status** (below field checkboxes):
   - Should show summary like: "Split full_name into first_name and last_name, Format phone numbers as +44 7700 900123 in 2 column(s)..."

3. **Check preview section**:
   - Should show detailed list of transformations
   - Each transformation in plain English
   - Easy to understand what will happen

---

## Test Scenario 6: End-to-End Workflow

### Complete Test:
1. **Create comprehensive test file**:
```csv
id,full_name,phone,mobile,postcode,ni_number,sort_code
1,Mr. John Smith,02079460958,07700900123,SW1A 1AA,AB123456C,12-34-56
2,Mrs. Jane Doe,02079460959,07700900124,EC1A 1BB,CD234567D,23-45-67
3,Dr. Michael Johnson Jr.,02079460960,07700900125,M1 1AA,EF345678E,34-56-78
```

2. **Upload and process**:
   - Upload the file
   - Verify all field types are detected
   - Select all fields for cleaning
   - Enable name splitting for `full_name`
   - Check preview shows all transformations
   - Process the file

3. **Verify all features**:
   - Check Summary tab shows correct counts
   - Check Full Preview shows all columns including split names
   - Check Before/After shows side-by-side comparison
   - Check Cleaned tab shows fixed values
   - Check Issues tab shows any invalid data

4. **Export and verify**:
   - Download cleaned file
   - Verify:
     - Name columns are split correctly
     - Phone numbers are formatted
     - Postcodes are formatted
     - All original columns preserved
     - New name columns added

---

## Expected Behaviors

### Name Splitting:
- ✅ Titles (Mr, Mrs, Dr, etc.) are removed
- ✅ Suffixes (Jr, Sr, II, III, etc.) are removed
- ✅ First word becomes first_name
- ✅ Remaining words become last_name (joined if multiple)
- ✅ Single names become last_name only
- ✅ Empty names handled gracefully

### Preview Sample:
- ✅ Shows first 5 rows only
- ✅ Updates when selections change
- ✅ Highlights selected fields
- ✅ Shows plain English descriptions

### Before/After View:
- ✅ Original values on left
- ✅ Cleaned values on right
- ✅ Changed cells highlighted in green
- ✅ Name split columns highlighted
- ✅ Sticky headers work correctly

### Field Selection:
- ✅ Name columns auto-detected
- ✅ Icons show field types
- ✅ Split option appears for names
- ✅ Status updates with descriptions

---

## Troubleshooting

### Name splitting not appearing:
- Check column name matches patterns: `full_name`, `name`, `customer_name`, etc.
- Check data actually contains names (multiple words)
- Try manually selecting the column for splitting

### Preview not showing:
- Ensure at least one field is selected
- Check browser console for errors
- Verify file was uploaded successfully

### Before/After tab empty:
- Ensure file was processed successfully
- Check that results exist
- Try refreshing the page

### Export missing name columns:
- Verify name splitting was selected before processing
- Check that processing completed successfully
- Verify in Full Preview tab that columns exist

---

## Files Modified

- `validators.js` - Added `NameSplitter` class
- `fileProcessor.js` - Integrated name splitting into processing pipeline
- `app.js` - Added UI methods for name splitting, preview, before/after view
- `index.php` - Added UI elements for new features
- `router.php` - Created for PHP built-in server routing

---

## Next Steps

After testing, you may want to:
1. Create more comprehensive test files with various name formats
2. Test with real-world data
3. Verify edge cases (single names, very long names, special characters)
4. Test performance with large files (1000+ rows)
5. Verify export formats (CSV, Excel, JSON) all work correctly

