# Troubleshooting Guide

## Database Connection Issues

### Problem: "Access denied for user 'root'@'localhost'"

This means your database credentials in `.env` are incorrect or the database doesn't exist.

**Solutions:**

1. **Check your MySQL/MariaDB credentials:**
   ```bash
   # Test connection manually
   mysql -u root -p -h 127.0.0.1 -P 8889
   ```

2. **For MAMP (port 8889):**
   - Default user: `root`
   - Default password: `root`
   - Port: `8889`

3. **For XAMPP:**
   - Default user: `root`
   - Default password: `` (empty) or `root`
   - Port: `3306`

4. **Update `.env` file:**
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=8889        # MAMP uses 8889, XAMPP uses 3306
   DB_NAME=simple_data_cleaner
   DB_USER=root
   DB_PASS=your_actual_password
   ```

5. **Create the database if it doesn't exist:**
   ```sql
   CREATE DATABASE simple_data_cleaner;
   ```

### Problem: App Shows "An error occurred" But No Details

**Solution:** Enable debug mode in `.env`:
```env
APP_DEBUG=true
APP_ENV=local
```

This will show actual error messages instead of generic ones.

### Problem: App Works Without Database

**Good news!** The data cleaning features work 100% client-side, so the app will work even if the database isn't configured. You just won't be able to:
- Log in/register
- Manage subscriptions
- Track usage

But you CAN:
- ✅ Upload and clean CSV files
- ✅ Validate UK data formats
- ✅ Download cleaned results
- ✅ Use all validation features

## Testing Database Connection

1. **Check if MySQL is running:**
   ```bash
   # macOS (MAMP)
   /Applications/MAMP/bin/startMysql.sh

   # Check if port is listening
   lsof -i :8889   # MAMP
   lsof -i :3306   # Standard MySQL
   ```

2. **Test connection from command line:**
   ```bash
   mysql -u root -p -h 127.0.0.1 -P 8889 simple_data_cleaner
   ```

3. **Check `.env` file:**
   ```bash
   cat .env | grep DB_
   ```

## Quick Fix: Work Without Database

The app now gracefully handles database connection failures. If you just want to test data cleaning:

1. Start PHP server:
   ```bash
   php -S localhost:8000
   ```

2. Open browser: http://localhost:8000

3. The app will work without database - you'll see a message about authentication, but data cleaning will work perfectly!

## Common Errors

### Error: "Connection failed: SQLSTATE[HY000] [1045]"
- Wrong password or username
- Check `.env` file credentials

### Error: "Connection failed: SQLSTATE[HY000] [2002]"
- MySQL not running
- Wrong host or port
- Check if MySQL service is started

### Error: "Unknown database 'simple_data_cleaner'"
- Database doesn't exist
- Create it: `CREATE DATABASE simple_data_cleaner;`
- Then import schema: `mysql -u root -p simple_data_cleaner < database/schema.sql`
