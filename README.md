# File Data Validator

A powerful web application built with SvelteKit that validates UK data formats including phone numbers, National Insurance numbers, postcodes, and bank sort codes. Upload your CSV, Excel, or text files and get instant validation results with intelligent auto-fixing capabilities.

## ✨ Features

- **Smart Validation**: Automatically detects and validates multiple UK data formats
- **Auto-Fix**: Intelligently corrects common formatting issues
- **File Support**: Handles CSV, Excel (.xlsx), and plain text files
- **Real-time Processing**: Instant validation with detailed feedback
- **Export Results**: Download validation results in CSV or JSON format
- **No Data Storage**: Your data is processed locally and never stored
- **Modern UI**: Beautiful, responsive interface built with Tailwind CSS

## 🎯 Supported Data Types

### Phone Numbers
- UK mobile numbers (07xxxxxxxxx)
- UK landline numbers (02xxxxxxxxx)
- International format (+44xxxxxxxxx)
- Auto-fixes common formatting issues

### National Insurance Numbers
- Standard format (AB123456C)
- Auto-adds prefix letters when possible
- Handles various spacing formats

### Postcodes
- UK postcode validation (SW1A 1AA)
- Auto-corrects spacing issues
- Supports all standard UK postcode formats

### Bank Sort Codes
- 6-digit validation (12-34-56)
- Auto-formats with proper separators
- Handles various input formats

## 🚀 Getting Started

### Prerequisites

- Node.js 18+
- npm or pnpm

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd validation
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

4. Open your browser and navigate to `http://localhost:5173`

## 🧪 Testing

The project includes comprehensive testing with Vitest:

```bash
# Run all tests
npm run test:run

# Run tests in watch mode
npm run test

# Run tests with UI
npm run test:ui

# Generate coverage report
npm run test:coverage
```

## 📁 Project Structure

```
validation/
├── src/
│   ├── lib/
│   │   ├── validators.ts          # Core validation logic
│   │   ├── validators.test.ts     # Validation tests
│   │   └── fileProcessor.ts       # File processing utilities
│   ├── routes/
│   │   ├── +layout.svelte         # App layout
│   │   └── +page.svelte           # Main validator page
│   ├── app.css                    # Tailwind CSS
│   └── app.html                   # HTML template
├── static/                        # Static assets
├── tests/                         # Test files
├── package.json                   # Dependencies
├── tailwind.config.js            # Tailwind configuration
├── vitest.config.ts              # Test configuration
└── README.md                     # This file
```

## 🔧 Development

### Adding New Validators

To add support for new data types, extend the `DataValidator` interface:

```typescript
export class NewValidator implements DataValidator {
    getType() {
        return 'new_type';
    }

    validate(value: string): ValidationResult {
        // Your validation logic here
        return {
            isValid: true,
            value: value,
            fixed: formattedValue
        };
    }
}
```

### File Processing

The `FileProcessor` class handles:
- File type detection
- Content parsing (CSV, Excel, text)
- Row-by-row validation
- Result export (CSV/JSON)

## 🎨 UI Components

The application uses:
- **SvelteKit 2.22** for the framework
- **Svelte 5** with the latest runes
- **Tailwind CSS** for styling
- **TypeScript** for type safety

## 📊 Sample Data

Use the included `sample_data.csv` file to test the application:

```csv
Phone Number,NI Number,Postcode,Sort Code
07123456789,AB123456C,SW1A 1AA,123456
02012345678,CD789012,CR2 6XH,234567
```

## 🚀 Deployment

### Build for Production

```bash
npm run build
```

### Preview Production Build

```bash
npm run preview
```

### Deploy to Vercel

The project is configured for easy deployment to Vercel:

1. Push your code to GitHub
2. Connect your repository to Vercel
3. Deploy automatically on every push

## 🔮 Future Enhancements

- **AI Integration**: Machine learning for better data type detection
- **Custom Validators**: User-defined validation rules
- **Batch Processing**: Handle larger files more efficiently
- **API Endpoints**: RESTful API for programmatic access
- **User Authentication**: Multi-user support with data isolation
- **Advanced Analytics**: Detailed validation statistics and trends

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/your-username/validation/issues) page
2. Create a new issue with detailed information
3. Include sample data and error messages

## 🙏 Acknowledgments

- Built with [SvelteKit](https://kit.svelte.dev/)
- Styled with [Tailwind CSS](https://tailwindcss.com/)
- Tested with [Vitest](https://vitest.dev/)
- Icons from [Heroicons](https://heroicons.com/)

---

**Happy validating! 🎉**
