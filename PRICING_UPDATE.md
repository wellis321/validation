# Pricing Model Update - Client-Side Processing

## Overview

The pricing model has been updated to reflect the reality that **all file processing happens client-side in the user's browser**. This means:

- ✅ User data **never leaves their device**
- ✅ No server bandwidth costs for file uploads
- ✅ No file storage requirements
- ✅ Complete privacy for sensitive data
- ✅ No file size limitations

## New Pricing Structure

### Previous Pricing (DEPRECATED)
- ❌ Free: £0/month (50 requests/day, 5MB files)
- ❌ Professional: £29.99/month (1000 requests/day, 25MB files)
- ❌ Enterprise: £99.99/month (5000 requests/day, 100MB files)

**Problem**: File size and request limits don't make sense when processing is client-side!

### New Pricing (ACTIVE)

1. **Pay Per Use - £0.99**
   - One-time payment
   - Perfect for quick jobs
   - All features included
   - Single use access

2. **Monthly - £4.99/month**
   - Unlimited files
   - Unlimited file sizes
   - All data types
   - Priority email support
   - API access
   - Cancel anytime

3. **Annual - £39.99/year**
   - Everything in Monthly
   - **Save £20 per year** (vs 12 monthly payments)
   - Best value option
   - Just £3.33/month

## What Changed

### Database Schema (`database/schema.sql`)
- ❌ Removed `max_file_size_mb` column
- ❌ Removed `max_requests_per_day` column
- ✅ Updated subscription plans with new pricing
- ✅ Added new feature flags for client-side processing

### Pricing Page (`pricing.php`)
- ✅ Updated to show new three-tier pricing
- ✅ Highlighted "MOST POPULAR" and "BEST VALUE" badges
- ✅ Emphasized client-side processing and privacy
- ✅ Updated FAQs to explain no file size limits
- ✅ Added privacy-focused messaging

### Homepage (`index.php`)
- ✅ Updated hero section to mention client-side processing
- ✅ Removed confusing "requests remaining" counter
- ✅ Changed subscription messaging to be less restrictive
- ✅ Added privacy badges and messaging
- ✅ Updated footer with client-side processing info

## Migration Instructions

### For Fresh Installations
1. Drop existing database (if any): `DROP DATABASE IF EXISTS your_database;`
2. Create new database: `CREATE DATABASE your_database;`
3. Run: `mysql -u username -p your_database < database/schema.sql`

### For Existing Installations
1. Backup your database first!
   ```bash
   mysqldump -u username -p your_database > backup_$(date +%Y%m%d).sql
   ```

2. Run the migration script:
   ```bash
   mysql -u username -p your_database < database/migrate_pricing.sql
   ```

3. Verify the migration:
   ```sql
   SELECT * FROM subscription_plans WHERE is_active = 1;
   ```

### Handling Existing Users
- Old plans are marked `is_active = 0` but existing subscriptions remain valid
- Users on old plans can continue until their subscription expires
- Consider sending a notification about the new, lower pricing
- Optionally migrate users to equivalent new plans:
  - Free → Monthly (as a courtesy upgrade)
  - Professional → Monthly (price reduction!)
  - Enterprise → Annual (price reduction!)

## Key Benefits

### For Users
1. 💰 **Much more affordable** - from £29.99 → £4.99/month
2. 🔒 **Complete privacy** - data never leaves their device
3. 📁 **No file size limits** - limited only by browser memory
4. ⚡ **Faster processing** - no upload/download time
5. 🎯 **Pay-per-use option** - for occasional users

### For Business
1. 💾 **No storage costs** - files aren't stored
2. 🌐 **No bandwidth costs** - no file uploads/downloads
3. 📈 **More scalable** - processing happens on client devices
4. 🔐 **Lower liability** - we never handle sensitive data
5. 💵 **Better conversion** - more affordable pricing

## Technical Notes

### Server Responsibilities
The server only handles:
- ✅ User authentication (login/register)
- ✅ Subscription management
- ✅ Payment processing
- ✅ API access control (optional)

### Client-Side Processing
All handled in browser:
- ✅ File reading (FileReader API)
- ✅ Data parsing (CSV/Excel/Text)
- ✅ Validation & cleaning (validators.js)
- ✅ Export generation (Blob API)

### Files Involved
- `fileProcessor.js` - Client-side file processing
- `validators.js` - Data validation logic
- `app.js` - Main application orchestration
- No PHP backend processing for files!

## Testing Checklist

- [ ] New subscriptions can be created with new pricing
- [ ] Existing subscriptions still work
- [ ] File upload works with subscription
- [ ] File processing happens client-side (check Network tab)
- [ ] No file data sent to server
- [ ] Export functionality works
- [ ] Pricing page displays correctly
- [ ] API access control works (if applicable)

## Rollback Plan

If issues occur, restore from backup:

```bash
# Stop application
# Restore database
mysql -u username -p your_database < backup_YYYYMMDD.sql

# Restore old PHP files from git
git checkout HEAD~1 pricing.php index.php database/schema.sql
```

## Support

For questions or issues with this migration:
1. Check the FAQs in `pricing.php`
2. Review `GDPR_COMPLIANCE.md` for privacy details
3. Consult `SETUP.md` for general setup instructions

---

**Migration Date**: October 9, 2025
**Version**: 2.0 (Client-Side Processing Model)
