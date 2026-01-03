# Detailed Issues Report Feature

The Detailed Issues Report provides comprehensive explanations for all validation errors found in your data files. This feature helps you understand exactly what's wrong with your data and how to fix it.

## Features

### 1. Comprehensive Error Reporting
- **Detailed Explanations**: Each validation error includes a clear explanation of what went wrong
- **Fix Suggestions**: Specific guidance on how to correct each type of error
- **Organized by Type**: Issues are grouped by data type (Phone Numbers, NI Numbers, Postcodes, etc.)
- **Row References**: Each error shows the exact row number where it occurred

### 2. Auto-Updating Reports
**Keep your report tab open** - it automatically updates when you process new files!

- Process multiple files in sequence
- The report tab automatically refreshes with new data
- No need to close and reopen - just keep the tab in the background
- Uses browser `storage` events to detect new reports

### 3. Persistent Storage
Reports survive page refreshes:
- **Refresh-Safe**: Hit refresh anytime - the report won't disappear
- **localStorage Storage**: Report data is stored in your browser's localStorage
- **Cross-Tab Access**: Open multiple report tabs if needed - they all show the same data

### 4. Export Options
Save your reports for permanent records:
- **Download as HTML**: Save the complete report to your computer
- **Print to PDF**: Use your browser's print function to create a PDF
- **Share**: Downloaded HTML files can be shared with team members

## How It Works

### Opening a Report

1. Upload and process a file with validation issues
2. Click the **"View Detailed Issues Report"** button (only appears if issues were found)
3. A new tab opens showing your detailed report

### Reading the Report

The report includes:
- **Summary**: Total issues found, file name, and rows processed
- **Navigation Sidebar**: Quick links to jump to each issue type
- **Issue Details**: For each problem:
  - Row number where it occurred
  - Column name
  - Invalid value
  - Error message
  - Detailed explanation with examples
  - What to do to fix it

### Auto-Update Workflow

**Scenario**: You're cleaning multiple files

1. Open report for File #1 - keep the tab open
2. Go back to the main app tab
3. Upload and process File #2
4. Click "View Detailed Issues Report" again
5. **Both tabs now show File #2's report** - the first tab auto-updated!

This is perfect for:
- Processing batches of files
- Comparing issues across multiple uploads
- Keeping a report visible while working on fixes

### Technical Implementation

The auto-update feature uses:
- **localStorage**: Stores report HTML (persists across refreshes)
- **storage Events**: Detects when localStorage changes in other tabs
- **Report IDs**: Unique timestamp-based IDs prevent unnecessary reloads
- **Smart Reloading**: Only reloads when the report actually changes

## Usage Examples

### Example 1: Single File Review
```
1. Upload customer-data.csv
2. Click "View Detailed Issues Report"
3. Review issues in the opened tab
4. Refresh the page if needed - report persists
5. Download report for records
```

### Example 2: Batch Processing
```
1. Upload file-1.csv and open report → Tab A
2. Keep Tab A open in background
3. Upload file-2.csv and open report → Tab B
4. Tab A automatically shows file-2 report
5. Upload file-3.csv and open report → Tab C
6. Both Tab A and Tab B now show file-3 report
```

### Example 3: Team Collaboration
```
1. Process your data file
2. Open the issues report
3. Download report as HTML
4. Share HTML file with team members
5. They can open it in any browser to see the same report
```

## Browser Compatibility

- **localStorage Required**: All modern browsers support this
- **storage Events**: Supported in Chrome, Firefox, Safari, Edge
- **No Special Permissions**: Works out of the box

## Privacy & Security

- **Client-Side Only**: Reports are generated and stored in your browser
- **No Server Upload**: Report data never leaves your device
- **localStorage Scope**: Reports are isolated to your browser and domain
- **Clear Anytime**: Clear your browser's localStorage to remove reports

## Limitations

- **Single Report Storage**: Only the most recent report is stored
- **Browser-Specific**: Reports don't sync between different browsers
- **Storage Limits**: Very large reports (100MB+) may exceed localStorage limits
- **Manual Cleanup**: Old reports aren't automatically deleted (but are overwritten)

## Tips & Best Practices

1. **Keep One Report Tab Open**: Reuse the same tab for multiple files
2. **Download Important Reports**: localStorage can be cleared by browser settings
3. **Use Print to PDF**: For permanent, shareable records
4. **Review Before Fixing**: Understand all issues before making changes to your data
5. **Group Similar Issues**: The report groups issues by type for easier review

## Troubleshooting

### Report Won't Load
- Check if localStorage is enabled in your browser
- Try clearing localStorage and generating a new report
- Ensure JavaScript is enabled

### Report Doesn't Auto-Update
- Make sure you're generating a NEW report (click "View Detailed Issues Report")
- Check that both tabs are from the same domain
- Try refreshing the old tab manually

### Report Disappeared After Refresh
- Check if localStorage was cleared
- Verify you're on the correct domain
- Generate a new report if needed

## Future Enhancements

Potential improvements being considered:
- Multiple report storage (keep last 5 reports)
- Export to Excel format
- Email report functionality
- Report comparison view
- Custom filtering and sorting
- Issue statistics and charts
