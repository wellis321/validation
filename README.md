# Simple Data Cleaner - PHP Application

A complete PHP application for cleaning and validating UK data formats including phone numbers, National Insurance numbers, postcodes, and bank sort codes. Features user authentication, subscription management, and 100% client-side data processing for maximum privacy.

## Features

- **Phone Number Validation**: Clean and format UK mobile and landline numbers
- **NI Number Validation**: HMRC compliant National Insurance number validation
- **Postcode Validation**: UK postcode formatting and validation
- **Sort Code Validation**: Bank sort code formatting
- **File Processing**: Upload CSV files and get cleaned data back
- **Multiple Export Formats**: CSV, JSON, and Excel-friendly formats
- **Local Processing**: All data processing happens in your browser - no server required

## Files

- `index.html` - Main application interface
- `validators.js` - Validation logic for all UK data formats
- `fileProcessor.js` - File processing and export functionality
- `app.js` - Main application logic and UI interactions
- `validation-rules.php` - Detailed validation rules documentation
- `privacy.html` - Privacy policy and GDPR compliance information

## Installation for cPanel

1. Upload all files to your cPanel public_html directory (or subdirectory)
2. Ensure the files are accessible via your domain
3. No server-side configuration required - works with standard HTML hosting

## Usage

1. Open `index.html` in your web browser
2. Upload a CSV file containing UK data
3. Select which columns to clean
4. Choose your preferred phone number format (International +44 or UK 0)
5. Click "Clean My Data" to process
6. Download your cleaned data in various formats

## Supported Data Types

### Phone Numbers
- UK mobile numbers (07xxx xxx xxx)
- UK landline numbers (0xxx xxx xxxx)
- International format (+44 xxx xxx xxxx)
- Automatic cleaning of labels, extensions, and formatting issues

### National Insurance Numbers
- HMRC compliant validation
- Format: 2 letters + 6 digits + optional letter
- Automatic detection of invalid prefixes and banned combinations

### Postcodes
- UK postcode validation and formatting
- Standard format (M1 1AA) and London format (SW1A 1AA)
- Automatic spacing correction

### Bank Sort Codes
- 6-digit sort code validation
- Format: xx-xx-xx with automatic formatting

## Privacy & Security

- **100% Local Processing**: All data processing happens in your browser
- **No Data Transmission**: Your files never leave your device
- **GDPR Compliant**: No data collection or storage
- **No Cookies**: Minimal browser storage for preferences only

## Browser Compatibility

- Modern browsers with JavaScript enabled
- File API support for file uploads
- Blob API support for file downloads

## Technical Details

- Vanilla JavaScript (no frameworks required)
- Tailwind CSS for styling (loaded from CDN)
- Client-side file processing
- No server-side dependencies

## Validation Standards

- **Phone Numbers**: UK telecommunications standards
- **NI Numbers**: HMRC National Insurance validation rules
- **Postcodes**: Royal Mail postcode standards
- **Sort Codes**: UK banking standards

## Support

This application is designed to work with standard cPanel hosting. All processing happens client-side, so no special server configuration is required.

## License

This application is provided as-is for data cleaning purposes. Please ensure you have the right to process any data you upload.