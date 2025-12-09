# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Simple Data Cleaner is a PHP-based web application for cleaning and validating UK data formats (phone numbers, National Insurance numbers, postcodes, and bank sort codes). The application features **100% client-side data processing** for maximum privacy, combined with a PHP backend for user authentication, subscription management via Stripe, and email functionality.

## Architecture

### Dual Processing Model

The application has two distinct processing layers:

1. **Client-Side Data Validation** (Primary Feature)
   - All actual data cleaning happens in the browser via JavaScript
   - No user data is ever transmitted to the server
   - Implemented in: `validators.js`, `fileProcessor.js`, `app.js`
   - Supports CSV, JSON, and Excel file formats (using SheetJS library)

2. **Server-Side User Management** (Supporting Infrastructure)
   - PHP backend handles authentication, subscriptions, and access control
   - MySQL database stores user accounts and subscription status
   - Stripe integration for payment processing
   - Email verification and password reset functionality

### Key Design Principle

**Privacy-first architecture**: User data files are processed entirely in the browser. The server only knows *that* a user has access, not *what* data they're cleaning. This GDPR-compliant approach is a core selling point.

## Directory Structure

```
/
├── includes/           # Core PHP classes and initialization
│   ├── init.php       # Application bootstrap (loads all dependencies)
│   ├── Auth.php       # Authentication management (singleton)
│   ├── Database.php   # PDO database wrapper (singleton)
│   ├── Email.php      # SMTP email functionality
│   ├── ErrorHandler.php # Centralized error handling
│   ├── Security.php   # Security headers and session management
│   ├── header.php     # Common HTML header
│   └── footer.php     # Common HTML footer
├── config/            # Configuration files
│   ├── database.php   # Database connection settings
│   ├── email.php      # SMTP configuration
│   └── stripe_config.php # Stripe API keys and price IDs
├── models/            # Data models
│   ├── Model.php      # Base model class
│   └── User.php       # User model with subscription methods
├── database/          # SQL schema and migrations
│   └── schema.sql     # Complete database schema
├── validators.js      # Client-side UK data validation classes
├── fileProcessor.js   # Client-side file parsing and export
├── app.js            # Main client-side application logic
└── *.php             # Page templates (index, pricing, account, etc.)
```

## Common Development Commands

### Database Setup

```bash
# Import initial schema
mysql -u [username] -p [database_name] < database/schema.sql

# Apply price updates
mysql -u [username] -p [database_name] < database/update_prices.sql
```

### Configuration

Environment variables are loaded from `.env` file in the root directory. Required variables:

- `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` - Database credentials
- `MAIL_SMTP_*` - SMTP configuration for email
- Stripe keys are in `config/stripe_config.php`

### Testing Validators

Open `test-validators.html` in a browser to test validation logic against various input formats. Variations test files (`*-variations.txt`) contain edge cases for each validator type.

## Key Architectural Patterns

### PHP Backend

1. **Singleton Pattern**: Core services (`Auth`, `Database`, `Security`, `ErrorHandler`) use singletons accessed via `getInstance()`

2. **Initialization Chain**: Every page starts with:
   ```php
   require_once __DIR__ . '/includes/init.php';
   ```
   This loads environment variables, initializes database, security, error handling, and authentication in the correct order.

3. **Model-Based Data Access**: Extend `Model` class for database tables. See `User.php` for subscription-related queries.

4. **Authentication Flow**:
   - `Auth::requireAuth()` - Redirect if not logged in
   - `Auth::requireNoAuth()` - Redirect if already logged in
   - `$auth->getCurrentUser()` - Get current user data
   - User data available in `$user` variable after init.php

### Client-Side JavaScript

1. **Validator Classes**: Each data type has a dedicated validator class:
   - `PhoneNumberValidator` - UK mobile/landline numbers
   - `NINumberValidator` - National Insurance numbers
   - `PostcodeValidator` - UK postcodes
   - `SortCodeValidator` - Bank sort codes

2. **ValidationResult Object**: All validators return:
   ```javascript
   {
     isValid: boolean,
     value: string,      // Normalized value
     error: string|null, // Error message if invalid
     fixed: string|null  // Formatted output (e.g., "+44 7700 900461")
   }
   ```

3. **File Processing Pipeline**:
   - Parse CSV/JSON/Excel → Detect headers → User selects fields → Validate each row → Export results
   - Handles multiple file formats using SheetJS (XLSX library loaded from CDN)

### Subscription System

- Plans stored in `subscription_plans` table
- User subscriptions in `user_subscriptions` table with status tracking
- Stripe checkout creates sessions mapped to plan IDs
- Payment confirmation updates subscription status
- User model has `hasActiveSubscription()` and `getCurrentSubscription()` methods

### Security Considerations

- All database queries use prepared statements (PDO)
- Passwords hashed with `password_hash()` (bcrypt)
- Session handling via `Security` class with secure settings
- CSRF protection should be implemented for forms
- Rate limiting table exists but may need implementation in code
- Security headers set in `init.php`

## Important Implementation Notes

1. **Client-side processing is sacred**: Never add server-side data processing for user files. The entire value proposition is privacy.

2. **Validator extensibility**: When adding new UK data types, follow the existing validator pattern with multi-step cleaning and normalization.

3. **Database timezone**: Set to 'Europe/London' in `init.php`

4. **Email verification**: Users receive verification emails after registration. Unverified users may have limited access.

5. **Stripe webhook handling**: See `STRIPE_WEBHOOK_SETUP.md` for webhook event processing.

6. **File size limits**: Calculated client-side based on subscription tier. All processing is memory-bound by browser capabilities.

## Validation Coverage Pages

The `*-variations-coverage.php` files demonstrate test coverage for each validator type, showing which edge cases are handled. These are useful for understanding validator capabilities and identifying gaps.

## Stripe Integration

- Products and prices configured in Stripe dashboard
- Price IDs mapped in `config/stripe_config.php`
- Checkout flow: `pricing.php` → `checkout.php` → `checkout-success.php`
- One-time payments vs. subscriptions handled by plan `duration_months` field
- See `STRIPE_SETUP.md` for complete integration guide
