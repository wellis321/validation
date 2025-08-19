# Privacy Policy - File Data Validator

## Privacy by Design

This application is built with **privacy by design** principles, ensuring your personal data never leaves your device.

## How Your Data is Protected

### 🔒 **Client-Side Only Processing**
- All file processing happens entirely in your web browser
- No data is uploaded to our servers
- No network requests are made with your data
- Your files and validation results stay on your device only

### 🚫 **No Data Storage**
- We do not store any of your data in databases
- No logs are kept of your files or validation results
- No cookies are used to track your activity
- No analytics or tracking scripts are installed

### 💾 **Memory Management**
- Data is held temporarily in browser memory during processing
- Use the "Clear Data" button to explicitly remove data from memory
- Closing the browser tab automatically clears all data
- No persistent storage is used

## GDPR Compliance

This application complies with the General Data Protection Regulation (GDPR) through:

### **Lawful Basis**
- Processing is based on your explicit consent when you upload files
- You maintain full control over your data at all times

### **Data Minimization**
- Only the data you choose to upload is processed
- No additional data is collected or processed
- Processing is limited to validation and formatting only

### **Your Rights**
- **Right to Access**: You have full access to your data as it remains on your device
- **Right to Rectification**: You can modify your data files before processing
- **Right to Erasure**: Use the "Clear Data" button or close the browser
- **Right to Portability**: Export results in CSV or JSON format
- **Right to Object**: Simply don't upload files if you object to processing

### **Security Measures**
- Content Security Policy prevents unauthorized external requests
- Security headers protect against common web vulnerabilities
- No third-party tracking or analytics
- Local processing eliminates data breach risks

## Supported Data Types

We validate the following UK data formats:
- Phone numbers (personal data under GDPR)
- National Insurance numbers (personal data under GDPR)
- Postcodes (may be personal data under GDPR)
- Bank sort codes (financial data)

## Technical Implementation

### **Browser-Only Architecture**
```
Your Device                    Our Server
┌─────────────────┐           ┌──────────────┐
│ File Upload     │           │              │
│ Data Processing │    NO     │  No Data     │
│ Validation      │  ◄────    │  Storage     │
│ Results Export  │  DATA     │              │
└─────────────────┘  SENT     └──────────────┘
```

### **Security Headers**
- `X-Frame-Options: DENY`
- `X-Content-Type-Options: nosniff`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Content-Security-Policy: default-src 'self'`

## Contact Information

If you have any questions about this privacy policy or data protection:

- **Data Controller**: [Your Company Name]
- **Contact**: [Your Contact Information]
- **DPO**: [Data Protection Officer Details if applicable]

## Changes to This Policy

This privacy policy may be updated to reflect changes in our practices or legal requirements. Any changes will be posted on this page.

**Last Updated**: [Current Date]

---

**Your privacy is our priority. Your data never leaves your device.**
